<?php

namespace App\Http\Controllers\Admin\Assistant;

use App\Http\Controllers\Controller;
use App\Models\AssistantQuery;
use Illuminate\Support\Facades\DB;

/*
| What visitors actually want, and what the help centre costs to give it to them.
|
| The report that earns its keep is "unanswered" - questions people asked that the
| site could not answer. That list is a content roadmap written by the audience.
*/
class InsightController extends Controller
{
    public function index()
    {
        $pageTitle = 'AI Help Center Insights';

        $since = now()->subDays(30);
        $base  = fn () => AssistantQuery::where('created_at', '>=', $since);

        $total = $base()->count();

        $summary = [
            'total'      => $total,
            'answered'   => $base()->where('status', 'ok')->count(),
            'unanswered' => $base()->where('status', 'no_answer')->count(),
            'errors'     => $base()->where('status', 'error')->count(),
            'cost'       => (float) $base()->sum('cost_usd'),
            'latency'    => (int) $base()->where('status', 'ok')->avg('latency_ms'),
            'helpful'    => $base()->where('feedback', 1)->count(),
            'unhelpful'  => $base()->where('feedback', 0)->count(),
        ];

        // Share of questions served without touching the model at all.
        $summary['cache_rate'] = $total > 0
            ? round($base()->where('cache_layer', 'answer')->count() / $total * 100, 1)
            : 0.0;

        // Grouped on the masked, normalised text so spelling and punctuation
        // variants of the same question collapse into one row.
        $topQuestions = $base()
            ->select('query_norm', DB::raw('COUNT(*) as hits'), DB::raw('MAX(query) as sample'))
            ->whereNotNull('query_norm')
            ->groupBy('query_norm')
            ->orderByDesc('hits')
            ->limit(15)
            ->get();

        $gaps = $base()
            ->where('status', 'no_answer')
            ->select('query_norm', DB::raw('COUNT(*) as hits'), DB::raw('MAX(query) as sample'), DB::raw('MAX(id) as last_id'))
            ->whereNotNull('query_norm')
            ->groupBy('query_norm')
            ->orderByDesc('hits')
            ->limit(15)
            ->get();

        $daily = $base()
            ->select(DB::raw('DATE(created_at) as day'), DB::raw('COUNT(*) as hits'), DB::raw('SUM(cost_usd) as cost'))
            ->groupBy('day')
            ->orderBy('day')
            ->get();

        $negative = AssistantQuery::where('feedback', 0)->latest('id')->limit(10)->get();

        return view('admin.assistant.insights', compact(
            'pageTitle', 'summary', 'topQuestions', 'gaps', 'daily', 'negative'
        ));
    }
}
