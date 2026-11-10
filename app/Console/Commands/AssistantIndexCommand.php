<?php

namespace App\Console\Commands;

use App\Services\Assistant\Indexing\Indexer;
use Illuminate\Console\Command;

class AssistantIndexCommand extends Command
{
    protected $signature = 'assistant:index
                            {--fresh : Rebuild every document from scratch}';

    protected $description = 'Index site content into the AI help centre knowledge base';

    public function handle(Indexer $indexer): int
    {
        $fresh = (bool) $this->option('fresh');

        if ($fresh) {
            $this->warn('Rebuilding the whole knowledge base - every chunk will be re-embedded.');
        }

        $indexer->onProgress(fn (string $line) => $this->line('  ' . $line));

        $stats = $indexer->run($fresh);

        $this->newLine();
        $this->table(['Metric', 'Count'], [
            ['Documents indexed', $stats['documents']],
            ['Unchanged (skipped)', $stats['skipped']],
            ['Chunks written', $stats['chunks']],
            ['Chunks embedded', $stats['embedded']],
            ['Documents removed', $stats['removed']],
        ]);

        foreach ($stats['errors'] as $error) {
            $this->error($error);
        }

        /*
        | Translation gaps. Not failures - the content is indexed and answerable -
        | but each one means a visitor gets an answer built from source material in
        | the wrong language, so the team needs to see them without reading logs.
        */
        if ($stats['gaps'] !== []) {
            $this->newLine();
            $this->warn(count($stats['gaps']) . ' translation gap(s) found:');

            foreach ($stats['gaps'] as $gap) {
                $this->line('  - ' . $gap);
            }
        }

        // Chunks without vectors still answer through FULLTEXT, just less well.
        if ($stats['chunks'] > 0 && $stats['embedded'] < $stats['chunks']) {
            $missing = $stats['chunks'] - $stats['embedded'];
            $this->warn("{$missing} chunk(s) have no embedding. Retrieval falls back to keyword search for those. Check the embedding provider and run this again.");
        }

        return $stats['errors'] === [] ? self::SUCCESS : self::FAILURE;
    }
}
