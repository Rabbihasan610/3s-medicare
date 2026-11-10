<?php

namespace App\Http\Controllers;

use App\Models\AssistantQuery;
use App\Services\Assistant\Answerer;
use Illuminate\Http\Request;

/*
| The public face of the AI help centre.
|
| Two entry points on purpose. The hero search bar submits normally and lands on
| a real, shareable, indexable URL; the floating widget posts the same question
| over AJAX and stays on the page. Both go through the identical pipeline, so an
| answer never differs depending on where it was asked from.
*/
class AssistantController extends Controller
{
    public function __construct(private Answerer $answerer) {}

    /** GET /ask?q=... - the full answer page. */
    public function answer(Request $request)
    {
        $question = trim((string) $request->get('q', ''));
        $result   = null;

        if ($question !== '') {
            $request->validate(['q' => 'string|max:500']);
            $result = $this->answerer->ask($question, $this->context($request));
        }

        $pageTitle = __('Ask 3S Medi Care');

        return view('web.assistant.answer', compact('question', 'result', 'pageTitle'));
    }

    /** POST /ask - same pipeline, JSON out, for the widget. */
    public function ask(Request $request)
    {
        $request->validate([
            'question' => 'required|string|max:500',
            // The thread handle the widget is holding. Unknown or malformed
            // values are not an error - ConversationStore simply starts a new
            // thread, which is also what a first message looks like.
            'conversation' => 'nullable|uuid',
            // Set by the floating widget only. The hero bar and the /ask page
            // stay single-shot so their answers remain cacheable and shareable.
            'thread' => 'nullable|boolean',
        ]);

        $result = $this->answerer->ask($request->question, $this->context($request));

        return response()->json([
            'status'     => $result['status'],
            'answer'     => $result['answer'],
            'sources'    => $result['sources'],
            'route_url'  => $result['route_url'],
            'query_id'   => $result['query_id'],
            'confidence' => $result['confidence'],
            // Echoed back so the widget can continue this thread on the next
            // message. Null when threading was unavailable.
            'conversation' => $result['conversation'] ?? null,
            // Follow-up chips, already clipped and capped server-side.
            'suggested_replies' => $result['suggested_replies'] ?? [],
            /*
            | The language the answer was actually written in, which is not
            | necessarily the language of the page the widget is sitting on -
            | the Answerer follows the question's own script. The widget needs
            | it to set dir/lang on the bubble, or an Arabic answer renders
            | left-to-right inside an English page.
            */
            'lang' => $result['lang'],
            'dir'  => $result['lang'] === 'ar' ? 'rtl' : 'ltr',
            // Rendered server-side so the refusal wording stays translatable -
            // and in the answer's language, not the interface's.
            'message' => $result['status'] === 'ok'
                ? null
                : $this->inLang($result['lang'], 'We could not find an answer for that on this site. Our team can help you directly.'),
        ]);
    }

    /** POST /ask/feedback - was the answer useful? */
    public function feedback(Request $request)
    {
        $request->validate([
            'query_id' => 'required|integer',
            'helpful'  => 'required|boolean',
        ]);

        // Scoped to the asking session so one visitor cannot rate another's answer.
        AssistantQuery::where('id', $request->query_id)
            ->where('session_uid', $this->sessionUid())
            ->update(['feedback' => (int) $request->boolean('helpful')]);

        return response()->json(['status' => 'ok']);
    }

    /**
     * Translate a string into a specific language rather than the interface one.
     *
     * A visitor who types Arabic into the English site gets an Arabic answer, so
     * the refusal and the surrounding chrome have to follow it. The locale is
     * restored immediately - this must not leak into the rest of the response.
     */
    private function inLang(string $lang, string $key): string
    {
        $previous = app()->getLocale();

        app()->setLocale($lang);
        $text = __($key);
        app()->setLocale($previous);

        return $text;
    }

    private function context(Request $request): array
    {
        return [
            'conversation' => $request->input('conversation'),
            'thread'       => $request->boolean('thread'),
            'lang'         => session('lang') === 'ar' ? 'ar' : 'en',
            'session_uid' => $this->sessionUid(),
            'user_id'     => auth()->id(),
            'ip'          => $request->ip(),
            'user_agent'  => $request->userAgent(),
            'page_url'    => $request->headers->get('referer'),
        ];
    }

    /**
     * A per-visitor id that is not the raw session id.
     *
     * Keeps query rows linkable to one another for the conversion report without
     * storing a value that could be replayed as a session token.
     */
    private function sessionUid(): string
    {
        if (! session()->has('assistant_uid')) {
            session()->put('assistant_uid', bin2hex(random_bytes(16)));
        }

        return session('assistant_uid');
    }
}
