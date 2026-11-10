<?php

namespace App\Lib;

use App\Constants\Status;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

/*
|--------------------------------------------------------------------------
| Dashboard Statistics
|--------------------------------------------------------------------------
|
| The admin dashboard reports across ~18 separate request tables. Counting them
| one table at a time would be dozens of queries per page load, so each block
| (totals, 30 day trend, oldest pending) is collected with a single UNION ALL
| round trip and the whole result is cached.
|
*/

class DashboardStats
{
    public const CACHE_KEY = 'admin.dashboard.stats';
    public const CACHE_MINUTES = 5;

    /**
     * Every request type on the dashboard.
     *
     * table   - database table
     * label   - untranslated label (translated in the view)
     * route   - admin listing route name
     * show    - detail route name, null when there is none
     * name    - column holding the requester name
     * email   - column holding the email
     * pending - value that means "needs action", null when the table has no status
     */
    public static function sources(): array
    {
        return [
            'quote_request' => ['quote_requests', 'Healthcare Quotes', 'admin.quote_request.index', 'admin.quote_request.detail', 'name', 'email', 'pending'],
            'request_order' => ['request_orders', 'Sector Requests', 'admin.request_order.index', null, null, null, 'pending'],
        ];
    }

    public static function all(): array
    {
        return Cache::remember(self::CACHE_KEY, now()->addMinutes(self::CACHE_MINUTES), function () {
            $usable = self::usableTables();

            $byType = self::totalsByType($usable);
            $trend = self::trend($usable);
            $attention = self::oldestPending($usable);
            $people = self::peopleCounts($usable);

            $kpi = [
                'today' => array_sum(array_column($byType, 'today')),
                'week' => array_sum(array_column($byType, 'week')),
                'month' => array_sum(array_column($byType, 'month')),
                'total' => array_sum(array_column($byType, 'total')),
                'pending' => array_sum(array_column($byType, 'pending')),
            ];

            return compact('kpi', 'byType', 'trend', 'attention', 'people');
        });
    }

    /**
     * Which of our tables actually exist, resolved in one information_schema query.
     *
     * @return array<string,array<int,string>>  table => its columns
     */
    protected static function usableTables(): array
    {
        $wanted = array_column(self::sources(), 0);
        $wanted[] = 'users';
        $wanted[] = 'support_tickets';
        $wanted[] = 'subscribers';

        $rows = DB::table('information_schema.columns')
            ->where('table_schema', DB::getDatabaseName())
            ->whereIn('table_name', array_unique($wanted))
            ->get(['table_name', 'column_name']);

        $map = [];
        foreach ($rows as $row) {
            $table = strtolower($row->table_name ?? $row->TABLE_NAME);
            $map[$table][] = strtolower($row->column_name ?? $row->COLUMN_NAME);
        }

        return $map;
    }

    protected static function has(array $usable, string $table, ?string $column = null): bool
    {
        if (!isset($usable[$table])) {
            return false;
        }

        return $column === null || in_array(strtolower($column), $usable[$table], true);
    }

    /**
     * One UNION ALL pass: per type totals, pending, today, this week, this month.
     */
    protected static function totalsByType(array $usable): array
    {
        $today = Carbon::today()->toDateTimeString();
        $week = Carbon::now()->startOfWeek()->toDateTimeString();
        $month = Carbon::now()->startOfMonth()->toDateTimeString();

        $result = [];
        $query = null;

        foreach (self::sources() as $slug => [$table, $label, $route, $show, $name, $email, $pending]) {
            $result[$slug] = [
                'slug' => $slug, 'label' => $label, 'route' => $route,
                'total' => 0, 'pending' => 0, 'today' => 0, 'week' => 0, 'month' => 0,
            ];

            if (!self::has($usable, $table)) {
                continue;
            }

            $hasCreated = self::has($usable, $table, 'created_at');
            $hasStatus = $pending !== null && self::has($usable, $table, 'status');

            $part = DB::table($table)->selectRaw('? as src', [$slug])
                ->selectRaw('count(*) as total');

            $part = $hasStatus
                ? $part->selectRaw('sum(case when status = ? then 1 else 0 end) as pending', [$pending])
                : $part->selectRaw('0 as pending');

            if ($hasCreated) {
                $part = $part
                    ->selectRaw('sum(case when created_at >= ? then 1 else 0 end) as today', [$today])
                    ->selectRaw('sum(case when created_at >= ? then 1 else 0 end) as week', [$week])
                    ->selectRaw('sum(case when created_at >= ? then 1 else 0 end) as month', [$month]);
            } else {
                $part = $part->selectRaw('0 as today')->selectRaw('0 as week')->selectRaw('0 as month');
            }

            $query = $query === null ? $part : $query->unionAll($part);
        }

        if ($query !== null) {
            foreach ($query->get() as $row) {
                if (!isset($result[$row->src])) {
                    continue;
                }
                $result[$row->src]['total'] = (int) $row->total;
                $result[$row->src]['pending'] = (int) $row->pending;
                $result[$row->src]['today'] = (int) $row->today;
                $result[$row->src]['week'] = (int) $row->week;
                $result[$row->src]['month'] = (int) $row->month;
            }
        }

        uasort($result, fn($a, $b) => $b['total'] <=> $a['total']);

        return $result;
    }

    /**
     * Requests per day for the last 30 days, all types combined. One query.
     *
     * @return array<string,int>  'Y-m-d' => count, every day present
     */
    protected static function trend(array $usable): array
    {
        $from = Carbon::today()->subDays(29);

        $days = [];
        for ($d = $from->copy(); $d->lte(Carbon::today()); $d->addDay()) {
            $days[$d->toDateString()] = 0;
        }

        $query = null;
        foreach (self::sources() as [$table]) {
            if (!self::has($usable, $table, 'created_at')) {
                continue;
            }

            $part = DB::table($table)
                ->selectRaw('date(created_at) as d, count(*) as c')
                ->where('created_at', '>=', $from->toDateTimeString())
                ->groupBy(DB::raw('date(created_at)'));

            $query = $query === null ? $part : $query->unionAll($part);
        }

        if ($query === null) {
            return $days;
        }

        foreach ($query->get() as $row) {
            $key = (string) $row->d;
            if (array_key_exists($key, $days)) {
                $days[$key] += (int) $row->c;
            }
        }

        return $days;
    }

    /**
     * The oldest still-pending requests across every type. One query.
     */
    protected static function oldestPending(array $usable, int $limit = 10): array
    {
        $query = null;

        foreach (self::sources() as $slug => [$table, $label, $route, $show, $name, $email, $pending]) {
            if ($pending === null || $name === null || $show === null) {
                continue;
            }
            if (!self::has($usable, $table, 'status') || !self::has($usable, $table, $name)) {
                continue;
            }
            if (!self::has($usable, $table, 'created_at')) {
                continue;
            }

            $emailCol = self::has($usable, $table, (string) $email) ? $email : null;

            $part = DB::table($table)
                ->selectRaw('? as src', [$slug])
                ->selectRaw('id')
                ->selectRaw("$name as requester")
                ->selectRaw($emailCol ? "$emailCol as email" : "null as email")
                ->selectRaw('created_at')
                ->where('status', $pending);

            $query = $query === null ? $part : $query->unionAll($part);
        }

        if ($query === null) {
            return [];
        }

        $rows = $query->orderBy('created_at')->limit($limit)->get();

        $sources = self::sources();
        $out = [];
        foreach ($rows as $row) {
            [, $label, , $show] = $sources[$row->src];
            $out[] = [
                'slug' => $row->src,
                'label' => $label,
                'id' => $row->id,
                'requester' => $row->requester,
                'email' => $row->email,
                'created_at' => $row->created_at,
                'show' => $show,
            ];
        }

        return $out;
    }

    /**
     * Users, subscribers and support in one aggregate each.
     */
    protected static function peopleCounts(array $usable): array
    {
        $users = ['total' => 0, 'active' => 0, 'email_unverified' => 0, 'mobile_unverified' => 0];

        if (self::has($usable, 'users')) {
            $row = DB::table('users')
                ->selectRaw('count(*) as total')
                ->selectRaw('sum(case when status = ? and ev = ? and sv = ? then 1 else 0 end) as active', [Status::USER_ACTIVE, Status::VERIFIED, Status::VERIFIED])
                ->selectRaw('sum(case when ev = ? then 1 else 0 end) as email_unverified', [Status::UNVERIFIED])
                ->selectRaw('sum(case when sv = ? then 1 else 0 end) as mobile_unverified', [Status::UNVERIFIED])
                ->first();

            $users = [
                'total' => (int) ($row->total ?? 0),
                'active' => (int) ($row->active ?? 0),
                'email_unverified' => (int) ($row->email_unverified ?? 0),
                'mobile_unverified' => (int) ($row->mobile_unverified ?? 0),
            ];
        }

        $support = 0;
        if (self::has($usable, 'support_tickets')) {
            $support = DB::table('support_tickets')
                ->whereIn('status', [Status::TICKET_OPEN, Status::TICKET_REPLY])
                ->count();
        }

        $subscribers = ['total' => 0, 'month' => 0];
        if (self::has($usable, 'subscribers')) {
            $row = DB::table('subscribers')
                ->selectRaw('count(*) as total')
                ->selectRaw('sum(case when created_at >= ? then 1 else 0 end) as month', [Carbon::now()->startOfMonth()->toDateTimeString()])
                ->first();

            $subscribers = [
                'total' => (int) ($row->total ?? 0),
                'month' => (int) ($row->month ?? 0),
            ];
        }

        return compact('users', 'support', 'subscribers');
    }

    public static function forget(): void
    {
        Cache::forget(self::CACHE_KEY);
    }
}
