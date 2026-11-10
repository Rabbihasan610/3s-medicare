@extends('admin.layouts.app', ['title' => 'Robots.txt Editor'])

@section('panel')
<div class="row gy-4">
    <div class="col-12">
        <div class="card border-0 shadow-sm" style="border-radius: 14px;">
            <div class="card-body p-4">
                <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
                    <div>
                        <h5 class="card-title fw-bold text-dark mb-1 d-flex align-items-center gap-2">
                            <i class="bi bi-robot text-primary fs-4"></i>
                            <span>{{ __('Robots.txt Configuration') }}</span>
                            <span class="badge bg-success-subtle text-success px-2 py-1 fs-7 rounded-pill">{{ __('Live & Active') }}</span>
                        </h5>
                        <p class="text-muted small mb-0">
                            {{ __('Robots.txt instructs web crawlers (Googlebot, Bingbot, etc.) which pages or directories on your website they can or cannot crawl.') }}
                        </p>
                    </div>
                    <div class="d-flex gap-2">
                        <a href="{{ url('robots.txt') }}" target="_blank" class="btn btn-outline-primary btn-sm px-3 d-inline-flex align-items-center gap-1">
                            <i class="bi bi-box-arrow-up-right"></i> {{ __('View Live robots.txt') }}
                        </a>
                        <button type="button" class="btn btn-outline-secondary btn-sm px-3" onclick="resetRobotsDefault()">
                            <i class="bi bi-arrow-counterclockwise"></i> {{ __('Reset Default') }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-8">
        <div class="card border-0 shadow-sm h-100" style="border-radius: 14px;">
            <div class="card-header bg-white border-bottom py-3 d-flex align-items-center justify-content-between">
                <strong class="text-dark"><i class="bi bi-code-slash text-primary me-2"></i>{{ __('robots.txt Content') }}</strong>
                <span class="badge bg-light text-secondary border">{{ public_path('robots.txt') }}</span>
            </div>
            <form action="{{ route('admin.setting.robots') }}" method="POST">
                @csrf
                <div class="card-body p-4">
                    <div class="form-group mb-3">
                        <textarea class="form-control font-monospace p-3" id="robotsEditor" name="robots" rows="14" style="font-size: 0.92rem; line-height: 1.6; background: #0f172a; color: #38bdf8; border-radius: 10px; border: 1px solid #1e293b;" required>{{ $fileContent }}</textarea>
                    </div>
                    <div class="d-flex align-items-center justify-content-between">
                        <small class="text-muted"><i class="bi bi-info-circle me-1"></i>{{ __('Changes take effect immediately on public web crawlers.') }}</small>
                        <button type="submit" class="btn btn-primary px-4 py-2 fw-semibold">
                            <i class="bi bi-check2-circle me-1"></i> {{ __('Save robots.txt') }}
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card border-0 shadow-sm mb-4" style="border-radius: 14px;">
            <div class="card-header bg-white border-bottom py-3">
                <strong class="text-dark"><i class="bi bi-lightbulb text-warning me-2"></i>{{ __('Crawler Directives Cheatsheet') }}</strong>
            </div>
            <div class="card-body p-4 small text-secondary">
                <div class="mb-3">
                    <strong class="text-dark d-block mb-1">User-agent: *</strong>
                    <span>Applies the following rules to all web search engines and bots.</span>
                </div>
                <div class="mb-3">
                    <strong class="text-dark d-block mb-1">Disallow: /admin/</strong>
                    <span>Prevents search engines from indexing the administrative panel and login.</span>
                </div>
                <div class="mb-3">
                    <strong class="text-dark d-block mb-1">Allow: /</strong>
                    <span>Allows public crawl of the homepage, services, about, and quote request pages.</span>
                </div>
                <div class="mb-0">
                    <strong class="text-dark d-block mb-1">Sitemap: {{ url('sitemap.xml') }}</strong>
                    <span>Directs search engines directly to your XML sitemap for automated indexing.</span>
                </div>
            </div>
        </div>

        <div class="card border-0 shadow-sm" style="border-radius: 14px; background: #f8fafc;">
            <div class="card-body p-4">
                <h6 class="fw-bold text-dark mb-2"><i class="bi bi-shield-check text-success me-2"></i>{{ __('Healthcare Best Practice') }}</h6>
                <p class="small text-muted mb-0">
                    Keep patient management and administrative URLs private by keeping <code>/admin/</code> and <code>/user/</code> in Disallow, while keeping all public healthcare service pages indexed.
                </p>
            </div>
        </div>
    </div>
</div>
@endsection

@push('script')
<script>
function resetRobotsDefault() {
    if (confirm("{{ __('Reset robots.txt to recommended healthcare default rules?') }}")) {
        const defaultRules = "User-agent: *\nDisallow: /admin/\nDisallow: /user/\nDisallow: /api/\nDisallow: /clear\nDisallow: /change/\nAllow: /\n\nSitemap: {{ url('sitemap.xml') }}";
        document.getElementById('robotsEditor').value = defaultRules;
    }
}
</script>
@endpush

