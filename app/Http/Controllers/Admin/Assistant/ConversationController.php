<?php

namespace App\Http\Controllers\Admin\Assistant;

use App\Http\Controllers\Controller;
use App\Models\AssistantConversation;

/*
| Threads, as opposed to individual questions.
|
| The Questions screen answers "what is being asked and what does it cost". This
| one answers a different question that the per-row view cannot: whether the
| assistant actually held up across a conversation - whether a follow-up was
| understood, where a thread gave up, and whether a visitor who switched language
| mid-thread was followed.
*/
class ConversationController extends Controller
{
    public function index()
    {
        $pageTitle = 'Conversations';

        $conversations = AssistantConversation::withCount('messages')
            ->searchable(['uuid', 'session_uid'])
            ->dateFilter()
            ->latest('last_message_at')
            ->paginate(getPaginate());

        $emptyMessage = 'No conversations yet';

        return view('admin.assistant.conversations.index', compact('pageTitle', 'conversations', 'emptyMessage'));
    }

    public function show($id)
    {
        $pageTitle = 'Conversation Transcript';

        // The query row on each turn carries what it cost, which model answered
        // and whether the visitor rated it - eager-loaded so a long transcript
        // does not fire a query per message.
        $conversation = AssistantConversation::with(['messages' => function ($query) {
            $query->orderBy('id')->with('queryLog');
        }])->findOrFail($id);

        return view('admin.assistant.conversations.show', compact('pageTitle', 'conversation'));
    }

    public function destroy($id)
    {
        // Messages cascade from the conversation row.
        AssistantConversation::findOrFail($id)->delete();

        $notify[] = ['success', 'Conversation removed successfully'];

        return back()->withNotify($notify);
    }
}
