<?php

namespace App\Http\Controllers\Admin\Assistant;

use App\Http\Controllers\Controller;
use App\Models\AssistantQuery;

class QueryController extends Controller
{
    public function index()
    {
        $pageTitle = 'Visitor Questions';

        $queries = AssistantQuery::with('provider')
            ->searchable(['query', 'answer'])
            ->filter(['lang', 'status', 'cache_layer', 'feedback'])
            ->dateFilter()
            ->latest('id')
            ->paginate(getPaginate());

        $emptyMessage = 'No questions asked yet';

        return view('admin.assistant.queries.index', compact('pageTitle', 'queries', 'emptyMessage'));
    }

    public function show($id)
    {
        $pageTitle = 'Question Detail';
        $query     = AssistantQuery::with('provider')->findOrFail($id);

        return view('admin.assistant.queries.show', compact('pageTitle', 'query'));
    }

    /** Questions with no good answer - the content roadmap. */
    public function unanswered()
    {
        $pageTitle = 'Unanswered Questions';

        $queries = AssistantQuery::with('provider')
            ->unanswered()
            ->searchable(['query'])
            ->dateFilter()
            ->latest('id')
            ->paginate(getPaginate());

        $emptyMessage = 'Every question so far has been answered';

        return view('admin.assistant.queries.index', compact('pageTitle', 'queries', 'emptyMessage'));
    }

    public function destroy($id)
    {
        AssistantQuery::findOrFail($id)->delete();

        $notify[] = ['success', 'Question log removed successfully'];

        return back()->withNotify($notify);
    }
}
