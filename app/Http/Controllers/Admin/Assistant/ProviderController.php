<?php

namespace App\Http\Controllers\Admin\Assistant;

use App\Http\Controllers\Controller;
use App\Models\AssistantProvider;
use App\Services\Assistant\ProviderManager;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ProviderController extends Controller
{
    public function index()
    {
        $pageTitle = 'AI Providers';
        $providers = AssistantProvider::orderBy('purpose')->orderBy('priority')->get();
        $emptyMessage = 'No provider registered yet';

        return view('admin.assistant.providers.index', compact('pageTitle', 'providers', 'emptyMessage'));
    }

    public function create()
    {
        $pageTitle = 'Add Provider';
        $provider  = new AssistantProvider(['priority' => 1, 'status' => 1]);

        return view('admin.assistant.providers.form', compact('pageTitle', 'provider'));
    }

    public function edit($id)
    {
        $pageTitle = 'Edit Provider';
        $provider  = AssistantProvider::findOrFail($id);

        return view('admin.assistant.providers.form', compact('pageTitle', 'provider'));
    }

    public function store(Request $request, $id = null)
    {
        $request->validate([
            'name'     => 'required|string|max:100',
            'driver'   => ['required', Rule::in(ProviderManager::availableDrivers())],
            'purpose'  => ['required', Rule::in([AssistantProvider::PURPOSE_CHAT, AssistantProvider::PURPOSE_EMBEDDING])],
            'model'    => 'required|string|max:100',
            'base_url' => 'nullable|url|max:191',
            'priority' => 'required|integer|min:1|max:99',
            'api_key'  => $id ? 'nullable|string' : 'required|string',
            'effort'   => ['nullable', Rule::in(['default', 'low', 'medium', 'high'])],
        ]);

        /*
        | Anthropic answers only - it has no embeddings endpoint. Caught here so
        | the operator is told at save time rather than discovering it when the
        | next reindex fails halfway through.
        */
        if ($request->driver === 'anthropic' && $request->purpose === AssistantProvider::PURPOSE_EMBEDDING) {
            $notify[] = ['error', 'Anthropic has no embeddings endpoint. Use Gemini or OpenAI for the embedding role.'];

            return back()->withInput()->withNotify($notify);
        }

        $provider = $id ? AssistantProvider::findOrFail($id) : new AssistantProvider();

        $provider->fill($request->only(['name', 'driver', 'purpose', 'model', 'base_url', 'priority']));
        $provider->status = $request->boolean('status') ? 1 : 0;

        // Blank means "leave the stored key alone" - the form never renders it back.
        if (filled($request->api_key)) {
            $provider->api_key  = trim($request->api_key);
            $provider->last_error = null;
        }

        $provider->params = array_filter([
            'embedding_model' => $request->embedding_model ?: null,
            // Anthropic maps this to output_config.effort and OpenAI to
            // reasoning_effort; Gemini ignores it and uses thinking_level.
            'effort'          => $request->effort ?: null,
            'dimensions'      => $request->dimensions ? (int) $request->dimensions : null,
            'timeout'         => $request->timeout ? (int) $request->timeout : null,
            'price_in'        => is_numeric($request->price_in) ? (float) $request->price_in : null,
            'price_out'       => is_numeric($request->price_out) ? (float) $request->price_out : null,
            'price_cached'    => is_numeric($request->price_cached) ? (float) $request->price_cached : null,
        ], fn ($value) => $value !== null);

        $provider->save();

        $notify[] = ['success', $id ? 'Provider updated successfully' : 'Provider added successfully'];

        return to_route('admin.assistant.providers.index')->withNotify($notify);
    }

    /*
    | Round-trips the vendor with the stored credentials. The result is written to
    | the row so the list screen shows which provider is unhealthy without anyone
    | having to open a log file.
    */
    public function test($id, ProviderManager $manager)
    {
        $provider = AssistantProvider::findOrFail($id);

        try {
            $manager->make($provider)->ping();

            $provider->forceFill(['last_check_at' => now(), 'last_error' => null])->save();
            $notify[] = ['success', $provider->name . ' responded successfully'];
        } catch (\Throwable $e) {
            $provider->forceFill(['last_check_at' => now(), 'last_error' => $e->getMessage()])->save();
            $notify[] = ['error', $provider->name . ': ' . $e->getMessage()];
        }

        return back()->withNotify($notify);
    }

    public function status($id)
    {
        return AssistantProvider::changeStatus($id);
    }

    public function destroy($id)
    {
        AssistantProvider::findOrFail($id)->delete();

        $notify[] = ['success', 'Provider removed successfully'];

        return back()->withNotify($notify);
    }
}
