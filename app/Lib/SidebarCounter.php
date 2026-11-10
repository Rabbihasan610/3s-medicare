<?php

namespace App\Lib;

use App\Constants\Status;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/*
|--------------------------------------------------------------------------
| Sidebar Counters
|--------------------------------------------------------------------------
|
| The admin sidebar shows a "needs attention" dot next to every request type,
| support and unverified users. Counting those one menu item at a time would be
| ~20 queries on every admin page load, so they are collected with a single
| UNION ALL round trip and cached for a few minutes.
|
*/

class SidebarCounter
{
    public const CACHE_KEY = 'admin.sidebar.counts';
    public const CACHE_MINUTES = 5;

    /**
     * Request tables keyed by the slug the sidebar uses.
     * Most tables store status as the string 'pending'; strategic procurement
     * stores an integer, so each entry carries its own pending value.
     */
    protected static function requestSources(): array
    {
        return [
            'quote_request' => ['quote_requests', 'pending'],
            'request_order' => ['request_orders', 'pending'],
        ];
    }

    /**
     * Menu groups and the request slugs that roll up into them.
     */
    public static function groups(): array
    {
        return [];
    }

    /**
     * All sidebar counters. Slug => count.
     */
    public static function counts(): array
    {
        return Cache::remember(self::CACHE_KEY, now()->addMinutes(self::CACHE_MINUTES), function () {
            $counts = self::pendingRequestCounts();

            foreach (self::groups() as $group => $slugs) {
                $counts['group_' . $group] = array_sum(array_map(
                    fn($slug) => $counts[$slug] ?? 0,
                    $slugs
                ));
            }

            $counts['requests_total'] = array_sum(array_map(
                fn($slug) => $counts[$slug] ?? 0,
                array_keys(self::requestSources())
            ));

            return $counts + self::assistantCounts();
        });
    }

    /**
     * One UNION ALL query across every request table that still exists.
     *
     * Table existence is resolved with a single information_schema lookup rather
     * than Schema::hasTable() per table, which would add a query each.
     */
    protected static function pendingRequestCounts(): array
    {
        $sources = self::requestSources();
        $counts = array_fill_keys(array_keys($sources), 0);

        $usable = self::tablesWithStatusColumn(array_column($sources, 0));

        $query = null;
        foreach ($sources as $slug => [$table, $pending]) {
            if (!in_array($table, $usable, true)) {
                continue;
            }

            $part = DB::table($table)
                ->selectRaw('? as source, count(*) as total', [$slug])
                ->where('status', $pending);

            $query = $query === null ? $part : $query->unionAll($part);
        }

        if ($query !== null) {
            foreach ($query->get() as $row) {
                $counts[$row->source] = (int) $row->total;
            }
        }

        return $counts + self::otherCounts($usable);
    }

    /**
     * AI help centre attention counters.
     *
     * Unanswered questions are the content roadmap and thumbs-down answers are
     * quality regressions - both want a badge. Guarded on table existence so the
     * sidebar keeps working on an install where the migration has not run yet.
     */
    protected static function assistantCounts(): array
    {
        $counts = ['assistant_unanswered' => 0, 'assistant_attention' => 0];

        if (!Schema::hasTable('assistant_queries')) {
            return $counts;
        }

        $row = DB::table('assistant_queries')
            ->where('created_at', '>=', now()->subDays(30))
            ->selectRaw("sum(case when status = 'no_answer' then 1 else 0 end) as unanswered")
            ->selectRaw('sum(case when feedback = 0 then 1 else 0 end) as unhelpful')
            ->first();

        $counts['assistant_unanswered'] = (int) ($row->unanswered ?? 0);
        $counts['assistant_attention']  = $counts['assistant_unanswered'] + (int) ($row->unhelpful ?? 0);

        return $counts;
    }

    /**
     * @param  array<int,string>  $tables
     * @return array<int,string>  the subset that exists and has a status column
     */
    protected static function tablesWithStatusColumn(array $tables): array
    {
        $tables = array_values(array_unique(array_merge($tables, ['support_tickets', 'users'])));

        $rows = DB::table('information_schema.columns')
            ->where('table_schema', DB::getDatabaseName())
            ->whereIn('table_name', $tables)
            ->where('column_name', 'status')
            ->get(['table_name']);

        return $rows->map(fn($r) => strtolower($r->table_name ?? $r->TABLE_NAME))->all();
    }

    /**
     * Support tickets and unverified users, kept separate because they use
     * different tables and status constants.
     */
    protected static function otherCounts(array $usable = []): array
    {
        $support = 0;
        if (in_array('support_tickets', $usable, true)) {
            $support = DB::table('support_tickets')
                ->whereIn('status', [Status::TICKET_OPEN, Status::TICKET_REPLY])
                ->count();
        }

        $emailUnverified = 0;
        $mobileUnverified = 0;
        if (in_array('users', $usable, true)) {
            $row = DB::table('users')
                ->selectRaw('sum(case when ev = ? then 1 else 0 end) as email_unverified', [Status::UNVERIFIED])
                ->selectRaw('sum(case when sv = ? then 1 else 0 end) as mobile_unverified', [Status::UNVERIFIED])
                ->first();

            $emailUnverified = (int) ($row->email_unverified ?? 0);
            $mobileUnverified = (int) ($row->mobile_unverified ?? 0);
        }

        return [
            'support' => $support,
            'users_email_unverified' => $emailUnverified,
            'users_mobile_unverified' => $mobileUnverified,
        ];
    }

    public static function forget(): void
    {
        Cache::forget(self::CACHE_KEY);
    }
}
