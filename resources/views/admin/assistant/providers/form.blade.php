@extends('admin.layouts.app', ['title' => $pageTitle])

@php
    use App\Services\Assistant\ProviderCatalog;
    use App\Services\Assistant\ProviderManager;

    $drivers = ProviderManager::availableDrivers();

    /*
    | Model ids are offered as a datalist rather than a locked select: vendors
    | rename and retire models constantly, and staff must be able to move to a
    | new one without waiting on a deploy. The small script at the bottom only
    | points the input at the datalist for whichever driver is selected.
    */
    $modelSuggestions = [];

    foreach ($drivers as $driverKey) {
        foreach (['chat', 'embedding'] as $role) {
            $modelSuggestions[$driverKey . '_' . $role] = ProviderCatalog::models($driverKey, $role);
        }
    }

    $currentDriver = old('driver', $provider->driver) ?: ($drivers[0] ?? 'gemini');
    $keyUrls       = collect($drivers)->mapWithKeys(fn ($d) => [$d => ProviderCatalog::keyUrl($d)]);
    $pricingUrls   = collect($drivers)->mapWithKeys(fn ($d) => [$d => ProviderCatalog::pricingUrl($d)]);
@endphp

@section('panel')
    <div class="row justify-content-center">
        <div class="col-lg-9">
            <div class="card">
                <div class="card-body">

                    <form method="POST"
                        action="{{ $provider->exists
                            ? route('admin.assistant.providers.update', $provider->id)
                            : route('admin.assistant.providers.store') }}">
                        @csrf

                        <div class="row gy-4">

                            <div class="col-md-6">
                                <label class="form-label">@lang('Name') <span class="text-danger">*</span></label>
                                <input class="form-control" type="text" name="name"
                                    value="{{ old('name', $provider->name) }}" required
                                    placeholder="{{ __('Gemini (answers)') }}">
                            </div>

                            <div class="col-md-3">
                                <label class="form-label">@lang('Driver') <span class="text-danger">*</span></label>
                                <select class="form-control" name="driver" required data-provider-driver>
                                    @foreach ($drivers as $driver)
                                        <option value="{{ $driver }}" @selected($currentDriver == $driver)>
                                            {{ ProviderCatalog::label($driver) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-3">
                                <label class="form-label">@lang('Role') <span class="text-danger">*</span></label>
                                <select class="form-control" name="purpose" required data-provider-purpose>
                                    <option value="chat" @selected(old('purpose', $provider->purpose) == 'chat')>@lang('Answers (chat)')</option>
                                    <option value="embedding" @selected(old('purpose', $provider->purpose) == 'embedding')>@lang('Embeddings')</option>
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">@lang('Model') <span class="text-danger">*</span></label>
                                <input class="form-control" type="text" name="model" data-provider-model
                                    value="{{ old('model', $provider->model) }}" required
                                    placeholder="gemini-3.6-flash" autocomplete="off">

                                @foreach ($modelSuggestions as $listKey => $models)
                                    <datalist id="models-{{ $listKey }}">
                                        @foreach ($models as $suggestion)
                                            <option value="{{ $suggestion }}"></option>
                                        @endforeach
                                    </datalist>
                                @endforeach

                                <small class="text-muted">
                                    @lang('Exactly as the vendor names it. Suggestions are a starting point, not a limit.')
                                    <a href="{{ ProviderCatalog::pricingUrl($currentDriver) }}" target="_blank"
                                        rel="noopener" data-provider-pricing>@lang('Vendor pricing')</a>
                                </small>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">@lang('API key')
                                    @unless ($provider->exists)
                                        <span class="text-danger">*</span>
                                    @endunless
                                </label>
                                <input class="form-control" type="password" name="api_key" autocomplete="new-password"
                                    placeholder="{{ $provider->exists ? __('Leave blank to keep the current key') : __('Paste the API key') }}">
                                <small class="text-muted">
                                    @lang('Stored encrypted and never shown again.')
                                    <a href="{{ ProviderCatalog::keyUrl($currentDriver) }}" target="_blank"
                                        rel="noopener" data-provider-keyurl>@lang('Get a key')</a>
                                    @if ($provider->exists && !$provider->hasKey())
                                        <span class="text-danger d-block">
                                            @lang('No usable key is stored right now - the assistant cannot answer until one is saved.')
                                        </span>
                                    @endif
                                </small>
                            </div>

                            <div class="col-md-8">
                                <label class="form-label">@lang('Base URL')</label>
                                <input class="form-control" type="url" name="base_url"
                                    value="{{ old('base_url', $provider->base_url) }}"
                                    placeholder="https://generativelanguage.googleapis.com/v1beta">
                                <small class="text-muted">@lang('Only needed for a proxy or a self-hosted endpoint.')</small>
                            </div>

                            <div class="col-md-2">
                                <label class="form-label">@lang('Priority') <span class="text-danger">*</span></label>
                                <input class="form-control" type="number" name="priority" min="1" max="99"
                                    value="{{ old('priority', $provider->priority ?: 1) }}" required>
                                <small class="text-muted">@lang('Lowest first')</small>
                            </div>

                            <div class="col-md-2">
                                <label class="form-label d-block">@lang('Status')</label>
                                <input type="checkbox" data-width="100%" data-height="45" data-onstyle="-success"
                                    data-offstyle="-danger" data-toggle="toggle" data-on="@lang('Enabled')"
                                    data-off="@lang('Disabled')" name="status" @checked(old('status', $provider->status ?? 1))>
                            </div>

                            <div class="col-12">
                                <hr>
                                <h6 class="mb-3">@lang('Advanced')</h6>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">@lang('Embedding model')</label>
                                <input class="form-control" type="text" name="embedding_model"
                                    value="{{ old('embedding_model', $provider->param('embedding_model')) }}"
                                    placeholder="gemini-embedding-001">
                                <small class="text-muted">@lang('Chat providers only.')</small>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">@lang('Dimensions')</label>
                                <input class="form-control" type="number" name="dimensions"
                                    value="{{ old('dimensions', $provider->param('dimensions')) }}"
                                    placeholder="{{ config('assistant.dimensions') }}">
                                <small class="text-muted">
                                    @lang('Changing this requires a full reindex - stored vectors of a different width cannot be compared.')
                                </small>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">@lang('Reasoning effort')</label>
                                <select class="form-control" name="effort">
                                    <option value="low" @selected(old('effort', $provider->param('effort', 'low')) == 'low')>
                                        @lang('Low - cheapest, and right for a grounded answer')
                                    </option>
                                    <option value="medium" @selected(old('effort', $provider->param('effort', 'low')) == 'medium')>
                                        @lang('Medium')
                                    </option>
                                    <option value="high" @selected(old('effort', $provider->param('effort', 'low')) == 'high')>
                                        @lang('High')
                                    </option>
                                    <option value="default" @selected(old('effort', $provider->param('effort', 'low')) == 'default')>
                                        @lang('Vendor default - send nothing')
                                    </option>
                                </select>
                                <small class="text-muted">
                                    @lang('Anthropic and OpenAI only. Gemini ignores this and uses its own thinking level.')
                                </small>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">@lang('Timeout (seconds)')</label>
                                <input class="form-control" type="number" name="timeout"
                                    value="{{ old('timeout', $provider->param('timeout')) }}" placeholder="45">
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">@lang('Price per 1M input tokens (USD)')</label>
                                <input class="form-control" type="number" step="0.000001" name="price_in"
                                    value="{{ old('price_in', $provider->param('price_in')) }}" placeholder="0">
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">@lang('Price per 1M output tokens (USD)')</label>
                                <input class="form-control" type="number" step="0.000001" name="price_out"
                                    value="{{ old('price_out', $provider->param('price_out')) }}" placeholder="0">
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">@lang('Price per 1M cached tokens (USD)')</label>
                                <input class="form-control" type="number" step="0.000001" name="price_cached"
                                    value="{{ old('price_cached', $provider->param('price_cached')) }}" placeholder="0">
                                <small class="text-muted">@lang('Leave prices at 0 to skip cost tracking.')</small>
                            </div>

                            <div class="col-12">
                                <button type="submit" class="btn btn-primary w-100 h-45">@lang('Save Provider')</button>
                            </div>

                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        /* Points the model field at the right suggestion list, and the two help
           links at the right vendor, whenever driver or role changes. Purely a
           convenience - the field stays free text either way. */
        (function () {
            var driver = document.querySelector('[data-provider-driver]');
            var purpose = document.querySelector('[data-provider-purpose]');
            var model = document.querySelector('[data-provider-model]');
            var keyLink = document.querySelector('[data-provider-keyurl]');
            var pricingLink = document.querySelector('[data-provider-pricing]');

            if (!driver || !purpose || !model) {
                return;
            }

            var keyUrls = {!! $keyUrls->toJson() !!};
            var pricingUrls = {!! $pricingUrls->toJson() !!};

            function sync() {
                var listId = 'models-' + driver.value + '_' + purpose.value;

                if (document.getElementById(listId)) {
                    model.setAttribute('list', listId);
                } else {
                    model.removeAttribute('list');
                }

                if (keyLink && keyUrls[driver.value]) {
                    keyLink.href = keyUrls[driver.value];
                }

                if (pricingLink && pricingUrls[driver.value]) {
                    pricingLink.href = pricingUrls[driver.value];
                }
            }

            driver.addEventListener('change', sync);
            purpose.addEventListener('change', sync);
            sync();
        })();
    </script>
@endpush

@push('breadcrumb-plugins')
    <x-back route="{{ route('admin.assistant.providers.index') }}" />
@endpush
