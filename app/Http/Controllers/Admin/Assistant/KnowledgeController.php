<?php

namespace App\Http\Controllers\Admin\Assistant;

use App\Http\Controllers\Controller;
use App\Models\AssistantDocument;
use App\Services\Assistant\Indexing\Indexer;
use App\Services\Assistant\KnowledgeBase;
use Illuminate\Http\Request;

class KnowledgeController extends Controller
{
    public function index(KnowledgeBase $kb)
    {
        $pageTitle = 'Knowledge Base';
        $stats     = $kb->stats();

        $documents = AssistantDocument::withCount('chunks')
            ->searchable(['title', 'title_ar', 'source_key'])
            ->filter(['source_type'])
            ->orderBy('source_type')
            ->orderBy('title')
            ->paginate(getPaginate());

        $emptyMessage = 'Nothing indexed yet - run a reindex';

        return view('admin.assistant.knowledge', compact('pageTitle', 'stats', 'documents', 'emptyMessage'));
    }

    /*
    | Runs the indexer in the request.
    |
    | Deliberately synchronous: QUEUE_CONNECTION is `sync` on this install and no
    | worker runs, so dispatching a job would execute here anyway - just without
    | the admin seeing the result. Incremental runs touch only changed content and
    | finish in seconds; a --fresh rebuild is the slow one, which is why the time
    | limit is lifted.
    */
    public function reindex(Request $request, Indexer $indexer)
    {
        @set_time_limit(600);

        try {
            $stats = $indexer->run($request->boolean('fresh'));
        } catch (\Throwable $e) {
            $notify[] = ['error', 'Reindex failed: ' . $e->getMessage()];

            return back()->withNotify($notify);
        }

        $notify[] = ['success', sprintf(
            'Indexed %d document(s), %d unchanged, %d chunk(s) written, %d embedded.',
            $stats['documents'], $stats['skipped'], $stats['chunks'], $stats['embedded']
        )];

        foreach (array_slice($stats['errors'], 0, 3) as $error) {
            $notify[] = ['error', $error];
        }

        if ($stats['chunks'] > $stats['embedded'] && $stats['errors'] === []) {
            $notify[] = ['warning', 'Some chunks have no embedding - check the embedding provider, then reindex.'];
        }

        return back()->withNotify($notify);
    }
}
