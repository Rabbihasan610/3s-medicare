<?php

namespace App\Console\Commands;

use App\Models\AssistantQuery;
use App\Services\Assistant\AnswerCache;
use Illuminate\Console\Command;

/*
| Retention.
|
| Visitors type personal data into search boxes - phone numbers, email addresses,
| commercial registration numbers. TextNormalizer masks the analytics copy, but the
| raw question is kept for a while so the team can read what people actually asked.
| This drops that raw text once it is past its usefulness, keeping the masked copy
| and all the aggregate columns so the Insights reports stay intact.
*/
class AssistantPurgeCommand extends Command
{
    protected $signature = 'assistant:purge
                            {--days= : Override config("assistant.retention_days")}';

    protected $description = 'Redact raw visitor questions past the retention window and sweep expired answer cache';

    public function handle(AnswerCache $cache): int
    {
        $days   = (int) ($this->option('days') ?: config('assistant.retention_days', 90));
        $cutoff = now()->subDays($days);

        $redacted = AssistantQuery::where('created_at', '<', $cutoff)
            ->where('query', '!=', '[redacted]')
            ->update(['query' => '[redacted]']);

        $swept = $cache->sweep();

        $this->info("Redacted {$redacted} question(s) older than {$days} days.");
        $this->info("Removed {$swept} stale answer cache row(s).");

        return self::SUCCESS;
    }
}
