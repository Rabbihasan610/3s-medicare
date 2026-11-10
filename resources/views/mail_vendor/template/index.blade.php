@extends('admin.layouts.app', ['title' => 'Mail Templates'])
@section('panel')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body p-0">
                    <div class="table-responsive--md table-responsive">
                        <table class="table table--light style--two">
                            <thead>
                                <tr>
                                    <th>@lang('Template')</th>
                                    <th>@lang('Title')</th>
                                    <th>@lang('Subject')</th>
                                    <th>@lang('Status')</th>
                                    <th>@lang('Action')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($templates as $template)
                                    <tr>
                                        <td>
                                            <span class="fw-bold">{{ $template->code }}</span>
                                        </td>
                                        <td>{{ $template->title }}</td>
                                        <td>{{ $template->subject }}</td>
                                        <td>
                                            @if($template->status == 1)
                                                <span class="badge bg-success">@lang('Active')</span>
                                            @else
                                                <span class="badge bg-danger">@lang('Inactive')</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.template.edit', ['id' => $template->id]) }}" class="btn btn-sm btn-outline-primary">
                                                <i class="las la-pen"></i> @lang('Edit')
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td class="text-muted text-center" colspan="100%">{{ __($emptyMessage ?? 'No templates found') }}</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
