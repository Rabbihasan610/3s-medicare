@extends('admin.layouts.app', ['title' => $pageTitle])
@section('panel')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body p-0">
                    <div class="table-responsive--md table-responsive">
                        <table class="table table--light style--two">
                            <thead>
                                <tr>
                                    <th>@lang('Opening Question')</th>
                                    <th>@lang('Turns')</th>
                                    <th>@lang('Languages')</th>
                                    <th>@lang('Started')</th>
                                    <th>@lang('Last Message')</th>
                                    <th>@lang('Action')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($conversations as $conversation)
                                    @php
                                        /*
                                        | The first thing the visitor typed - far more use as a
                                        | row label than the uuid, which means nothing to a person.
                                        */
                                        $opening = $conversation->messages()->where('role', 'user')->orderBy('id')->value('content');

                                        // A thread can switch language mid-way; show every language it used.
                                        $languages = $conversation->messages()->distinct()->pluck('lang')->filter()->all();
                                    @endphp

                                    <tr>
                                        <td style="max-width:340px">
                                            <a href="{{ route('admin.assistant.conversations.show', $conversation->id) }}">
                                                {{ $opening ? str()->limit($opening, 90) : __('(empty)') }}
                                            </a>
                                            <br><small class="text-muted">{{ str()->limit($conversation->uuid, 13, '…') }}</small>
                                        </td>

                                        <td>{{ $conversation->messages_count }}</td>

                                        <td>
                                            @forelse ($languages as $language)
                                                <span class="badge bg-secondary text-uppercase">{{ $language }}</span>
                                            @empty
                                                <span class="text-muted">&mdash;</span>
                                            @endforelse
                                        </td>

                                        <td>{{ showDateTime($conversation->created_at) }}</td>

                                        <td>
                                            @if ($conversation->last_message_at)
                                                {{ showDateTime($conversation->last_message_at) }}
                                                <br><small class="text-muted">{{ diffForHumans($conversation->last_message_at) }}</small>
                                            @else
                                                <span class="text-muted">&mdash;</span>
                                            @endif
                                        </td>

                                        <td>
                                            <a href="{{ route('admin.assistant.conversations.show', $conversation->id) }}"
                                                class="btn btn-sm btn-outline--primary">
                                                <i class="las la-comments"></i> @lang('Transcript')
                                            </a>

                                            <button class="btn btn-sm btn-outline--danger confirmationBtn"
                                                data-question="@lang('Delete this conversation and every message in it?')"
                                                data-action="{{ route('admin.assistant.conversations.destroy', $conversation->id) }}">
                                                <i class="las la-trash"></i> @lang('Delete')
                                            </button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td class="text-muted text-center" colspan="100%">{{ __($emptyMessage) }}</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                @if ($conversations->hasPages())
                    <div class="card-footer py-4">
                        {{ paginateLinks($conversations) }}
                    </div>
                @endif
            </div>
        </div>
    </div>

    <x-confirmation-modal />
@endsection

@push('breadcrumb-plugins')
    <x-search-form dateSearch="yes" placeholder="{{ __('Search by thread or session id') }}" />
@endpush
