@php
    $searchableServices = class_exists(\App\Models\HealthcareService::class)
        ? \App\Models\HealthcareService::active()->get(['title', 'short_description', 'slug', 'group_name'])
        : collect();

    $searchablePages = [
        ['title' => __('Get a Custom Quote'), 'desc' => __('Fast 24H estimate for your medical practice website and digital growth.'), 'url' => url('get-quote'), 'icon' => 'bi-calculator', 'badge' => 'Instant Quote'],
        ['title' => __('Our Healthcare Services'), 'desc' => __('Explore all specialized digital solutions designed for medical practices.'), 'url' => url('services'), 'icon' => 'bi-grid-fill', 'badge' => 'Services'],
        ['title' => __('About 3S Medi Care'), 'desc' => __('Learn about our mission, medical expertise, and digital approach.'), 'url' => url('about-us'), 'icon' => 'bi-info-circle', 'badge' => 'About'],
        ['title' => __('Contact Consultation'), 'desc' => __('Direct healthcare line, practice review, and office location.'), 'url' => url('contact'), 'icon' => 'bi-telephone', 'badge' => 'Contact'],
        ['title' => __('Privacy Policy'), 'desc' => __('Healthcare ethical privacy standards and patient data guidelines.'), 'url' => url('privacy-policy'), 'icon' => 'bi-shield-check', 'badge' => 'Policy'],
        ['title' => __('Cookie Policy'), 'desc' => __('Strict consent management and transparency notices.'), 'url' => url('cookie-policy'), 'icon' => 'bi-cookie', 'badge' => 'Policy'],
    ];
@endphp

<!-- SEARCH & QUERY MODAL BACKDROP (DESKTOP + MOBILE) -->
<div id="searchModalBackdrop"
     class="search-modal-backdrop position-fixed top-0 start-0 w-100 h-100 align-items-start justify-content-center p-3 p-md-4"
     style="display: none; z-index: 99999; background: rgba(8, 28, 54, 0.82); backdrop-filter: blur(12px); -webkit-backdrop-filter: blur(12px);"
     onclick="if (event.target === this) window.closeSearchModal();">

    <div class="search-modal-dialog bg-white rounded-4 shadow-lg w-100 overflow-hidden"
         style="max-width: 680px; margin-top: 3.5rem; border: 1px solid rgba(226, 232, 240, 0.9);"
         x-data="searchModalData()">

        {{-- SEARCH INPUT HEADER --}}
        <div class="p-3 p-md-4 border-bottom d-flex align-items-center gap-3 bg-light">
            <i class="bi bi-search text-primary fs-5"></i>
            <input type="text"
                   id="globalSearchInput"
                   x-model="searchQuery"
                   class="form-control form-control-lg border-0 bg-transparent p-0 shadow-none fw-medium text-dark"
                   style="font-size: 1.05rem;"
                   placeholder="{{ __('Search services, clinics, SEO, or ask a question...') }}">
            
            <button type="button" x-show="searchQuery" @click="searchQuery = ''" class="btn btn-sm btn-link text-muted p-0 border-0 me-1">
                <i class="bi bi-x-circle-fill fs-5"></i>
            </button>

            <button type="button" onclick="window.closeSearchModal()" class="btn btn-sm btn-outline-secondary rounded-pill px-2 py-1" style="font-size: 0.75rem;">
                <span class="d-none d-md-inline">ESC</span>
                <i class="bi bi-x-lg d-md-none"></i>
            </button>
        </div>

        {{-- SEARCH RESULTS & SUGGESTIONS CONTAINER --}}
        <div class="search-modal-body p-3 p-md-4 overflow-y-auto" style="max-height: 480px;">

            {{-- QUICK SUGGESTION PILLS (WHEN INPUT IS EMPTY) --}}
            <div x-show="!searchQuery.trim()" class="mb-4">
                <span class="text-uppercase text-muted fw-bold small d-block mb-2" style="font-size: 0.72rem; letter-spacing: 0.06em;">
                    {{ __('Popular Healthcare Topics') }}
                </span>
                <div class="d-flex flex-wrap gap-2">
                    <button type="button" @click="searchQuery = 'Website Design'" class="btn btn-sm btn-outline-secondary rounded-pill py-1 px-3" style="font-size: 0.82rem;">
                        <i class="bi bi-window-fullscreen text-accent me-1"></i> {{ __('Website Design') }}
                    </button>
                    <button type="button" @click="searchQuery = 'Doctor SEO'" class="btn btn-sm btn-outline-secondary rounded-pill py-1 px-3" style="font-size: 0.82rem;">
                        <i class="bi bi-graph-up-arrow text-accent me-1"></i> {{ __('Doctor SEO Ranking') }}
                    </button>
                    <button type="button" @click="searchQuery = 'Patient Appointment'" class="btn btn-sm btn-outline-secondary rounded-pill py-1 px-3" style="font-size: 0.82rem;">
                        <i class="bi bi-calendar2-check text-accent me-1"></i> {{ __('Appointment Systems') }}
                    </button>
                    <button type="button" @click="searchQuery = 'HIPAA Hosting'" class="btn btn-sm btn-outline-secondary rounded-pill py-1 px-3" style="font-size: 0.82rem;">
                        <i class="bi bi-shield-check text-accent me-1"></i> {{ __('HIPAA Hosting') }}
                    </button>
                </div>
            </div>

            {{-- INSTANT QUERY ACTION (WHEN USER HAS TYPED SOMETHING) --}}
            <div x-show="searchQuery.trim().length > 1" class="mb-3 p-3 rounded-3 border bg-teal-subtle d-flex align-items-center justify-content-between gap-3 flex-wrap">
                <div class="d-flex align-items-center gap-2">
                    <div class="rounded-circle d-flex align-items-center justify-content-center text-white flex-shrink-0" style="width: 32px; height: 32px; background: #19b5a5;">
                        <i class="bi bi-chat-heart-fill small"></i>
                    </div>
                    <div>
                        <strong class="d-block text-dark small">{{ __('Have a specific question about your practice?') }}</strong>
                        <span class="text-muted small">{{ __('Ask our medical digital consultant assistant') }} "<span class="text-dark fw-semibold" x-text="searchQuery"></span>"</span>
                    </div>
                </div>
                <button type="button" @click="askAssistant(searchQuery)" class="btn btn-sm btn-dark text-white rounded-pill px-3 py-1">
                    <i class="bi bi-send-fill me-1"></i> {{ __('Ask Assistant') }}
                </button>
            </div>

            {{-- HEALTHCARE SERVICES RESULTS --}}
            <div class="mb-4" x-show="filteredServices.length > 0">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <span class="text-uppercase text-muted fw-bold small" style="font-size: 0.72rem; letter-spacing: 0.06em;">
                        {{ __('Healthcare Digital Services') }}
                    </span>
                    <a href="{{ url('services') }}" class="small text-primary text-decoration-none fw-semibold">
                        {{ __('View All') }} &rarr;
                    </a>
                </div>

                <div class="d-flex flex-column gap-2">
                    <template x-for="svc in filteredServices" :key="svc.slug || svc.title">
                        <a :href="'{{ url('get-quote') }}?service=' + encodeURIComponent(svc.title)"
                           class="p-3 rounded-3 border border-light-subtle d-flex align-items-center justify-content-between text-decoration-none bg-white hover-bg-light transition-all shadow-none">
                            <div class="d-flex align-items-center gap-3 overflow-hidden">
                                <div class="rounded-circle d-flex align-items-center justify-content-center flex-shrink-0" style="width: 36px; height: 36px; background: #081C36; color: #19b5a5;">
                                    <i class="bi bi-heart-pulse-fill"></i>
                                </div>
                                <div class="overflow-hidden">
                                    <strong class="text-dark d-block text-truncate small" x-text="svc.title"></strong>
                                    <span class="text-muted small d-block text-truncate" style="font-size: 0.78rem;" x-text="svc.short_description || svc.group_name"></span>
                                </div>
                            </div>
                            <span class="badge bg-light text-dark border ms-2 flex-shrink-0 small py-1 px-2">
                                {{ __('Get Quote') }} <i class="bi bi-arrow-up-right small"></i>
                            </span>
                        </a>
                    </template>
                </div>
            </div>

            {{-- PAGES & ACTIONS RESULTS --}}
            <div x-show="filteredPages.length > 0">
                <span class="text-uppercase text-muted fw-bold small d-block mb-2" style="font-size: 0.72rem; letter-spacing: 0.06em;">
                    {{ __('Pages & Shortcuts') }}
                </span>
                <div class="d-flex flex-column gap-2">
                    <template x-for="page in filteredPages" :key="page.url">
                        <a :href="page.url" class="p-2 px-3 rounded-3 border border-light-subtle d-flex align-items-center justify-content-between text-decoration-none text-dark bg-white hover-bg-light transition-all">
                            <div class="d-flex align-items-center gap-2">
                                <i class="bi text-primary" :class="page.icon"></i>
                                <span class="small fw-semibold" x-text="page.title"></span>
                            </div>
                            <span class="badge bg-light text-secondary border small" x-text="page.badge"></span>
                        </a>
                    </template>
                </div>
            </div>

            {{-- NO RESULTS STATE --}}
            <div x-show="filteredServices.length === 0 && filteredPages.length === 0" class="text-center py-5">
                <i class="bi bi-search text-muted fs-1 mb-2 d-block"></i>
                <h6 class="text-dark fw-bold mb-1">{{ __('No matching services found') }}</h6>
                <p class="text-muted small mb-3">{{ __('Try searching for general terms like website, SEO, clinic, or ask for a custom quote.') }}</p>
                <a href="{{ url('get-quote') }}" class="btn btn-sm btn-primary rounded-pill px-3">
                    {{ __('Request Custom Scope & Quote') }}
                </a>
            </div>

        </div>

        {{-- FOOTER BAR --}}
        <div class="p-3 bg-light border-top d-flex align-items-center justify-content-between text-muted small">
            <span>
                <i class="bi bi-command me-1"></i>
                <span class="d-none d-md-inline">{{ __('Press') }} <kbd class="bg-white border text-dark">Ctrl</kbd> + <kbd class="bg-white border text-dark">K</kbd> {{ __('to search anywhere') }}</span>
                <span class="d-md-none">{{ __('3S Medi Care Search') }}</span>
            </span>
            <a href="{{ url('contact') }}" class="text-decoration-none text-muted small hover-primary">
                <i class="bi bi-headset me-1"></i>{{ __('Talk to Specialist') }}
            </a>
        </div>
    </div>
</div>

<!-- FLOATING AI SEARCH TRIGGER BUTTON (BOTTOM RIGHT) -->
<button type="button"
        onclick="window.openSearchModal()"
        class="floating-ai-search-btn"
        title="{{ __('Search & Ask Assistant (Ctrl + K)') }}"
        aria-label="{{ __('AI Search & Query') }}">
    <span class="floating-ai-search-ripple"></span>
    <span class="floating-ai-search-icon">
        <i class="bi bi-search"></i>
    </span>
    <span class="floating-ai-search-badge">AI</span>
</button>

<script>
window.openSearchModal = function() {
    var modal = document.getElementById('searchModalBackdrop');
    if (modal) {
        modal.style.setProperty('display', 'flex', 'important');
        document.body.style.overflow = 'hidden';
        setTimeout(function() {
            var input = document.getElementById('globalSearchInput');
            if (input) input.focus();
        }, 80);
    }
};

window.closeSearchModal = function() {
    var modal = document.getElementById('searchModalBackdrop');
    if (modal) {
        modal.style.setProperty('display', 'none', 'important');
        document.body.style.overflow = '';
    }
};

document.addEventListener('keydown', function(e) {
    if ((e.ctrlKey || e.metaKey) && (e.key === 'k' || e.key === 'K')) {
        e.preventDefault();
        window.openSearchModal();
    }
    if (e.key === 'Escape') {
        window.closeSearchModal();
    }
});

function searchModalData() {
    return {
        searchQuery: '',
        allServices: @json($searchableServices),
        allPages: @json($searchablePages),
        
        get filteredServices() {
            if (!this.searchQuery.trim()) return this.allServices.slice(0, 4);
            const q = this.searchQuery.toLowerCase();
            return this.allServices.filter(s => 
                (s.title && s.title.toLowerCase().includes(q)) || 
                (s.short_description && s.short_description.toLowerCase().includes(q)) ||
                (s.group_name && s.group_name.toLowerCase().includes(q))
            );
        },

        get filteredPages() {
            if (!this.searchQuery.trim()) return this.allPages.slice(0, 3);
            const q = this.searchQuery.toLowerCase();
            return this.allPages.filter(p => 
                (p.title && p.title.toLowerCase().includes(q)) || 
                (p.desc && p.desc.toLowerCase().includes(q))
            );
        },

        askAssistant(queryText) {
            window.closeSearchModal();
            const q = queryText || this.searchQuery;
            const launcher = document.querySelector('[data-amlk-open]');
            if (launcher) {
                launcher.click();
                const input = document.querySelector('[data-amlk-widget-input]');
                if (input && q) {
                    input.value = q;
                    input.dispatchEvent(new Event('input', { bubbles: true }));
                }
            } else {
                window.location.href = '{{ url("get-quote") }}?service=' + encodeURIComponent(q);
            }
        }
    };
}
</script>

<style>
.search-modal-backdrop {
    display: none;
    align-items: flex-start;
    justify-content: center;
    animation: fadeInModal 0.15s ease-out;
}

@keyframes fadeInModal {
    from { opacity: 0; }
    to { opacity: 1; }
}

.hover-bg-light:hover {
    background-color: #f8fafc !important;
    border-color: #cbd5e1 !important;
}
.transition-all {
    transition: all 0.18s ease;
}

/* Floating AI Search FAB (Right Bottom) */
.floating-ai-search-btn {
    position: fixed;
    bottom: 26px;
    right: 26px;
    width: 58px;
    height: 58px;
    border-radius: 50%;
    background: linear-gradient(135deg, #19b5a5 0%, #081C36 100%);
    color: #ffffff;
    border: 2px solid rgba(255, 255, 255, 0.25);
    box-shadow: 0 8px 24px rgba(25, 181, 165, 0.45);
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    z-index: 1040;
    transition: all 0.25s cubic-bezier(0.34, 1.56, 0.64, 1);
    outline: none;
    padding: 0;
}

.floating-ai-search-btn:hover {
    transform: translateY(-4px) scale(1.08);
    box-shadow: 0 14px 30px rgba(25, 181, 165, 0.6);
    color: #ffffff;
}

.floating-ai-search-btn:active {
    transform: scale(0.94);
}

.floating-ai-search-icon {
    font-size: 1.35rem;
    display: flex;
    align-items: center;
    justify-content: center;
}

.floating-ai-search-badge {
    position: absolute;
    top: -3px;
    right: -3px;
    background: #081C36;
    color: #19b5a5;
    border: 1.5px solid #19b5a5;
    border-radius: 999px;
    font-size: 0.65rem;
    font-weight: 800;
    padding: 1px 5px;
    line-height: 1.1;
    letter-spacing: 0.04em;
}

.floating-ai-search-ripple {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    border-radius: 50%;
    border: 2px solid #19b5a5;
    opacity: 0.7;
    animation: floatingPulse 2.8s infinite;
    pointer-events: none;
}

@keyframes floatingPulse {
    0% {
        transform: scale(1);
        opacity: 0.7;
    }
    70% {
        transform: scale(1.4);
        opacity: 0;
    }
    100% {
        transform: scale(1.4);
        opacity: 0;
    }
}

/* Hide legacy launcher button if present so there is no duplicate clutter */
.amlk-launcher {
    display: none !important;
}

@media (max-width: 576px) {
    .floating-ai-search-btn {
        bottom: 20px;
        right: 18px;
        width: 52px;
        height: 52px;
    }
    .floating-ai-search-icon {
        font-size: 1.2rem;
    }
}
</style>
