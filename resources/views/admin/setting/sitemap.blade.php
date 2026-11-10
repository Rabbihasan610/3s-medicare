@extends('admin.layouts.app', ['title' => 'Sitemap Manager'])

@section('panel')
<div class="row gy-4">
    {{-- TOP BANNER & ACTION BAR --}}
    <div class="col-12">
        <div class="card border-0 shadow-sm" style="border-radius: 14px;">
            <div class="card-body p-4">
                <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
                    <div>
                        <div class="d-flex align-items-center gap-2 mb-1">
                            <h5 class="card-title fw-bold text-dark mb-0">{{ __('XML Sitemap Manager') }}</h5>
                            <span class="badge bg-success-subtle text-success px-2 py-1 fs-7 rounded-pill">
                                <i class="bi bi-broadcast me-1"></i>{{ __('Auto-Generated') }}
                            </span>
                        </div>
                        <p class="text-muted small mb-0">
                            {{ __('Your XML sitemap is dynamically updated to help Google, Bing, and other search engines discover all pages, services, and policies.') }}
                        </p>
                    </div>

                    <div class="d-flex align-items-center gap-2 flex-wrap">
                        <form action="{{ route('admin.setting.sitemap.refresh') }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-outline-primary btn-sm px-3 d-inline-flex align-items-center gap-1">
                                <i class="bi bi-arrow-clockwise"></i> {{ __('Regenerate Cache') }}
                            </button>
                        </form>
                        <a href="{{ url('sitemap.xml') }}" target="_blank" class="btn btn-primary btn-sm px-3 d-inline-flex align-items-center gap-1">
                            <i class="bi bi-box-arrow-up-right"></i> {{ __('View Live XML') }}
                        </a>
                    </div>
                </div>

                {{-- LIVE SITEMAP URL BOX --}}
                <div class="mt-4 p-3 bg-light rounded-3 border d-flex align-items-center justify-content-between flex-wrap gap-2">
                    <div class="d-flex align-items-center gap-2 flex-grow-1 overflow-hidden">
                        <i class="bi bi-link-45deg text-primary fs-4"></i>
                        <span class="text-muted small me-2">{{ __('Public Sitemap URL:') }}</span>
                        <code class="text-dark fw-bold text-truncate" id="sitemapUrlText">{{ url('sitemap.xml') }}</code>
                    </div>
                    <button type="button" class="btn btn-sm btn-white border shadow-sm px-3" onclick="copySitemapUrl()">
                        <i class="bi bi-clipboard me-1 text-primary"></i> <span id="copyBtnText">{{ __('Copy URL') }}</span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- METRIC SUMMARY CARDS --}}
    <div class="col-md-4">
        <div class="card border-0 shadow-sm p-3" style="border-radius: 12px; background: #ffffff;">
            <div class="d-flex align-items-center gap-3">
                <div class="rounded-3 d-flex align-items-center justify-content-center text-white" style="width: 48px; height: 48px; background: #081C36;">
                    <i class="bi bi-diagram-3 fs-4"></i>
                </div>
                <div>
                    <span class="text-muted small d-block">{{ __('Total Indexed URLs') }}</span>
                    <h4 class="fw-bold text-dark mb-0">{{ count($urls) }}</h4>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card border-0 shadow-sm p-3" style="border-radius: 12px; background: #ffffff;">
            <div class="d-flex align-items-center gap-3">
                <div class="rounded-3 d-flex align-items-center justify-content-center text-white" style="width: 48px; height: 48px; background: #19b5a5;">
                    <i class="bi bi-hospital fs-4"></i>
                </div>
                <div>
                    <span class="text-muted small d-block">{{ __('Protocol Standard') }}</span>
                    <h5 class="fw-bold text-dark mb-0">sitemaps.org 0.9</h5>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card border-0 shadow-sm p-3" style="border-radius: 12px; background: #ffffff;">
            <div class="d-flex align-items-center gap-3">
                <div class="rounded-3 d-flex align-items-center justify-content-center text-white" style="width: 48px; height: 48px; background: #0b5cad;">
                    <i class="bi bi-google fs-4"></i>
                </div>
                <div>
                    <span class="text-muted small d-block">{{ __('Search Engine Status') }}</span>
                    <span class="badge bg-success-subtle text-success fw-semibold mt-1">{{ __('Ready for Submission') }}</span>
                </div>
            </div>
        </div>
    </div>

    {{-- SITEMAP ENTRIES TABLE --}}
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm" style="border-radius: 14px;">
            <div class="card-header bg-white border-bottom py-3 d-flex align-items-center justify-content-between">
                <strong class="text-dark">{{ __('Indexed Entries in Sitemap') }} ({{ count($urls) }})</strong>
                <span class="text-muted small">{{ __('Auto-updates when services or pages change') }}</span>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr class="small text-uppercase text-muted" style="letter-spacing: 0.04em;">
                                <th>{{ __('Page / URL') }}</th>
                                <th>{{ __('Type') }}</th>
                                <th class="text-center">{{ __('Priority') }}</th>
                                <th class="text-center">{{ __('Changefreq') }}</th>
                                <th class="text-end">{{ __('Action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($urls as $item)
                                <tr>
                                    <td>
                                        <a href="{{ $item['loc'] }}" target="_blank" class="fw-semibold text-dark text-decoration-none d-block text-truncate" style="max-width: 320px;">
                                            {{ $item['loc'] }}
                                        </a>
                                        <small class="text-muted">{{ __('Lastmod:') }} {{ $item['lastmod'] ?? date('Y-m-d') }}</small>
                                    </td>
                                    <td>
                                        <span class="badge bg-light text-secondary border px-2 py-1">
                                            {{ $item['type'] ?? 'Page' }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge bg-primary-subtle text-primary fw-bold">
                                            {{ $item['priority'] }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge bg-secondary-subtle text-secondary small">
                                            {{ $item['changefreq'] }}
                                        </span>
                                    </td>
                                    <td class="text-end">
                                        <a href="{{ $item['loc'] }}" target="_blank" class="btn btn-sm btn-outline-secondary py-1 px-2" title="{{ __('Open link') }}">
                                            <i class="bi bi-box-arrow-up-right"></i>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-4 text-muted">
                                        {{ __('No URLs currently in sitemap.') }}
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- SUBMISSION GUIDE SIDEBAR --}}
    <div class="col-lg-4">
        <div class="card border-0 shadow-sm mb-4" style="border-radius: 14px;">
            <div class="card-header bg-white border-bottom py-3">
                <strong class="text-dark"><i class="bi bi-google text-danger me-2"></i>{{ __('Submit to Google Search Console') }}</strong>
            </div>
            <div class="card-body p-4">
                <ol class="small text-muted ps-3 mb-4 d-flex flex-column gap-2">
                    <li>{{ __('Go to') }} <a href="https://search.google.com/search-console" target="_blank" class="text-primary fw-semibold">{{ __('Google Search Console') }} <i class="bi bi-box-arrow-up-right small"></i></a>.</li>
                    <li>{{ __('Select your domain property or add your website URL.') }}</li>
                    <li>{{ __('Click on') }} <strong>{{ __('Sitemaps') }}</strong> {{ __('in the left navigation.') }}</li>
                    <li>{{ __('Enter') }} <code>sitemap.xml</code> {{ __('under "Add a new sitemap" and click') }} <strong>{{ __('Submit') }}</strong>.</li>
                </ol>

                <div class="p-3 rounded-3 border bg-light small mb-3">
                    <strong class="text-dark d-block mb-1"><i class="bi bi-info-circle text-info me-1"></i>{{ __('Automated Discovery') }}</strong>
                    <span class="text-muted">
                        {{ __('Googlebot also automatically detects this sitemap because it is linked inside your') }}
                        <a href="{{ route('admin.setting.robots') }}" class="text-decoration-none fw-semibold">robots.txt</a>.
                    </span>
                </div>

                <a href="https://search.google.com/search-console" target="_blank" class="btn btn-outline-danger btn-sm w-100 py-2 fw-semibold">
                    <i class="bi bi-google me-1"></i> {{ __('Open Google Search Console') }}
                </a>
            </div>
        </div>

        <div class="card border-0 shadow-sm" style="border-radius: 14px; background: #081C36; color: #ffffff;">
            <div class="card-body p-4">
                <h6 class="fw-bold text-white mb-2"><i class="bi bi-microsoft text-primary me-2"></i>{{ __('Bing Webmaster Tools') }}</h6>
                <p class="small text-white-50 mb-3">
                    {{ __('Bing powers Yahoo, DuckDuckGo, and Copilot. Submit your sitemap directly to Bing Webmaster Tools for fast indexing.') }}
                </p>
                <a href="https://www.bing.com/webmasters" target="_blank" class="btn btn-sm btn-outline-light w-100">
                    <i class="bi bi-microsoft me-1"></i> {{ __('Open Bing Webmaster') }}
                </a>
            </div>
        </div>
    </div>
</div>
@endsection

@push('script')
<script>
function copySitemapUrl() {
    const text = document.getElementById('sitemapUrlText').innerText;
    navigator.clipboard.writeText(text).then(() => {
        const btnText = document.getElementById('copyBtnText');
        const orig = btnText.innerText;
        btnText.innerText = "{{ __('Copied!') }}";
        setTimeout(() => { btnText.innerText = orig; }, 2000);
    });
}
</script>
@endpush

