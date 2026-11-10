@php
    $quoteContent = getContent('get_quote.content', true);
    $values = @$quoteContent->data_values;

    $categoriesStr = @$values->categories ?? 'Doctor / Specialist, Hospital / Health System, Private Clinic, Diagnostic & Imaging, Dental Practice, HealthTech & Startup, Other';
    $categories = array_values(array_filter(array_map('trim', explode(',', $categoriesStr))));

    $servicesStr = @$values->services_list ?? 'Website Design & Development, Healthcare SEO & Google Ranking, Social Media & Marketing, Patient Appointment & Queue, Branding & Identity, HIPAA Compliant Hosting';
    $servicesList = array_values(array_filter(array_map('trim', explode(',', $servicesStr))));

    $reqService = trim((string) request('service', ''));
    $selectedServices = [];
    if ($reqService !== '') {
        $found = false;
        foreach ($servicesList as $s) {
            if (strcasecmp($s, $reqService) === 0) {
                $selectedServices[] = $s;
                $found = true;
                break;
            }
        }
        if (!$found) {
            foreach ($servicesList as $s) {
                if (stripos($s, 'SEO') !== false && stripos($reqService, 'SEO') !== false) {
                    $selectedServices[] = $s;
                    $found = true;
                    break;
                }
                if (stripos($s, 'Website') !== false && stripos($reqService, 'Website') !== false) {
                    $selectedServices[] = $s;
                    $found = true;
                    break;
                }
            }
        }
        if (!$found) {
            array_unshift($servicesList, $reqService);
            $selectedServices[] = $reqService;
        }
    }

    $sidePointsStr = @$values->side_points ?? 'Fast 24-hour turnaround on custom proposals, 100% HIPAA & Medical Compliance focused, Specialized healthcare UI/UX design, Dedicated account manager and ongoing support';
    $sidePoints = array_filter(array_map('trim', explode(',', $sidePointsStr)));

    // Mapping icons to common medical categories
    $categoryIcons = [
        'Doctor' => 'bi-person-badge',
        'Hospital' => 'bi-hospital',
        'Clinic' => 'bi-heart-pulse',
        'Diagnostic' => 'bi-radioactive',
        'Dental' => 'bi-emoji-smile',
        'HealthTech' => 'bi-cpu',
        'Other' => 'bi-grid-fill',
    ];

    $serviceIcons = [
        'Website' => 'bi-window-fullscreen',
        'SEO' => 'bi-search',
        'Marketing' => 'bi-megaphone',
        'Appointment' => 'bi-calendar2-check',
        'Branding' => 'bi-palette',
        'Hosting' => 'bi-shield-check',
    ];
@endphp

<!-- GET A QUOTE HERO BANNER -->
<section class="page-banner pb-5" style="background: radial-gradient(1200px 480px at 85% 0%, rgba(25, 181, 165, 0.20), transparent 65%), #081C36; padding-top: 3.8rem; padding-bottom: 6rem; position: relative;">
  <div class="container position-relative z-1">
    <nav aria-label="breadcrumb" class="mb-3">
      <ol class="breadcrumb mb-0" style="font-size: 0.85rem;">
        <li class="breadcrumb-item"><a href="{{ url('/') }}" class="text-white-50 text-decoration-none"><i class="bi bi-house-door me-1"></i>{{ __('Home') }}</a></li>
        <li class="breadcrumb-item"><a href="{{ url('services') }}" class="text-white-50 text-decoration-none">{{ __('Services') }}</a></li>
        <li class="breadcrumb-item active text-white" aria-current="page">{{ __('Get a Quote') }}</li>
      </ol>
    </nav>

    <div class="row align-items-center g-4">
      <div class="col-lg-8">
        <div class="d-inline-flex align-items-center gap-2 px-3 py-1 rounded-pill mb-3 border border-white border-opacity-15 shadow-sm" style="background: rgba(255, 255, 255, 0.08); backdrop-filter: blur(8px);">
          <span class="rounded-circle" style="width: 8px; height: 8px; background: #19b5a5; display: inline-block;"></span>
          <span class="text-white fw-semibold" style="font-size: 0.78rem; letter-spacing: 0.08em; text-transform: uppercase;">
            {{ __(@$values->eyebrow ?? 'Fast 24H Healthcare Digital Estimate') }}
          </span>
        </div>
        <h1 class="display-5 fw-bold text-white mb-3" style="letter-spacing: -0.02em; line-height: 1.15;">
          {{ __(@$values->title ?? 'Request a Tailored Quote for Your Practice') }}
        </h1>
        <p class="lead text-white-50 mb-0" style="max-width: 680px; font-size: 1.05rem; line-height: 1.6;">
          {{ __(@$values->subheading ?? 'Tell us about your medical organization, select your requirements, and our healthcare growth strategists will prepare an actionable scope of work and transparent estimate.') }}
        </p>
      </div>

      <div class="col-lg-4 text-lg-end d-none d-lg-block">
        <div class="d-inline-flex flex-column gap-2 text-start p-3 rounded-4 border border-white border-opacity-10" style="background: rgba(8, 28, 54, 0.55); backdrop-filter: blur(10px); min-width: 260px;">
          <div class="d-flex align-items-center gap-2 text-white small">
            <i class="bi bi-shield-lock-fill text-accent fs-5"></i>
            <div>
              <strong class="d-block">{{ __('100% HIPAA Aware') }}</strong>
              <span class="text-white-50" style="font-size: 0.76rem;">{{ __('Medical data privacy strict') }}</span>
            </div>
          </div>
          <div class="d-flex align-items-center gap-2 text-white small pt-2 border-top border-white border-opacity-10">
            <i class="bi bi-clock-history text-accent fs-5"></i>
            <div>
              <strong class="d-block">{{ __('24-Hour Delivery') }}</strong>
              <span class="text-white-50" style="font-size: 0.76rem;">{{ __('Customized strategy & quote') }}</span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- MAIN FORM & TRUST SECTION (FLOATING ELEVATION) -->
<section class="section py-0" id="get-quote-section" style="margin-top: -3.8rem; padding-bottom: 5.5rem; position: relative; z-index: 10;"
  x-data="quoteFormData()">

  <div class="container">
    <div class="row g-4 g-xl-5 align-items-start">

      {{-- FORM CARD (LEFT COLUMN) --}}
      <div class="col-lg-8 reveal reveal--left">
        <div class="card border border-light-subtle shadow-lg p-4 p-md-5" style="border-radius: 20px; background: #ffffff;">

          {{-- SUCCESS SCREEN --}}
          <div x-show="isSuccess" x-cloak class="text-center py-5">
            <div class="rounded-circle d-inline-flex align-items-center justify-content-center mb-4 shadow-sm" style="width: 84px; height: 84px; background: #e8f7f5; color: #19b5a5; border: 2px solid rgba(25, 181, 165, 0.3);">
              <i class="bi bi-check-lg display-4 fw-bold"></i>
            </div>
            <h2 class="h3 fw-bold text-dark mb-2">{{ __('Quote Request Submitted Successfully!') }}</h2>
            <p class="text-secondary mb-4 mx-auto" style="max-width: 500px; font-size: 1rem; line-height: 1.6;">
              {{ __('Thank you,') }} <strong class="text-dark" x-text="name"></strong>. {{ __('We have registered your project requirements. One of our healthcare digital consultants will review your scope and contact you at') }} <strong class="text-dark" x-text="phone"></strong> {{ __('within 24 hours.') }}
            </p>

            <div class="card bg-light border-0 p-3 mb-4 mx-auto text-start" style="max-width: 500px; border-radius: 12px;">
              <div class="d-flex justify-content-between mb-2 small">
                <span class="text-muted">{{ __('Practice Type:') }}</span>
                <strong class="text-dark" x-text="category || 'General Practice'"></strong>
              </div>
            <template x-if="services.length > 0">
              <div class="d-flex justify-content-between small">
                <span class="text-muted">{{ __('Selected Services:') }}</span>
                <span class="text-end fw-semibold text-primary" x-text="services.join(', ')"></span>
              </div>
            </template>
            </div>

            <button type="button" @click="resetForm()" class="btn-3s btn-3s--primary px-4 py-2">
              <i class="bi bi-plus-circle me-1"></i> {{ __('Submit Another Request') }}
            </button>
          </div>

          {{-- MAIN FORM --}}
          <form x-show="!isSuccess" @submit.prevent="submitQuote" novalidate>

            {{-- Error Message Alert --}}
            <template x-if="errorMessage">
              <div class="alert alert-danger d-flex align-items-center gap-3 p-3 mb-4 rounded-3 border-danger-subtle shadow-sm" role="alert">
                <i class="bi bi-exclamation-triangle-fill fs-4 flex-shrink-0 text-danger"></i>
                <div class="small fw-medium" x-text="errorMessage"></div>
              </div>
            </template>

            {{-- STEP 1: CONTACT DETAILS --}}
            <div class="mb-5">
              <div class="d-flex align-items-center gap-2 mb-3">
                <span class="d-inline-flex align-items-center justify-content-center rounded-circle fw-bold text-white shadow-sm" style="width: 28px; height: 28px; background: #081C36; font-size: 0.82rem;">1</span>
                <h5 class="fw-bold text-dark mb-0" style="letter-spacing: -0.01em;">{{ __('Your Contact & Practice Information') }}</h5>
              </div>

              <div class="row g-3">
                {{-- Full Name --}}
                <div class="col-md-6">
                  <label class="form-label fw-semibold text-dark small mb-1">
                    {{ __('Full Name') }} <span class="text-danger">*</span>
                  </label>
                  <div class="input-group">
                    <span class="input-group-text bg-light border-end-0 text-muted"><i class="bi bi-person-fill"></i></span>
                    <input type="text" x-model="name" class="form-control border-start-0 py-2" placeholder="{{ __('e.g. Dr. Robert Davies') }}" required>
                  </div>
                </div>

                {{-- Phone Number (Required) --}}
                <div class="col-md-6">
                  <label class="form-label fw-semibold text-dark small mb-1">
                    {{ __('Direct Phone / WhatsApp') }} <span class="text-danger">*</span>
                  </label>
                  <div class="input-group">
                    <span class="input-group-text bg-light border-end-0 text-muted"><i class="bi bi-telephone-fill"></i></span>
                    <input type="tel" x-model="phone" class="form-control border-start-0 py-2" placeholder="{{ __('e.g. +1 (555) 345-6789') }}" required>
                  </div>
                </div>

                {{-- Email Address (Optional) --}}
                <div class="col-12">
                  <label class="form-label fw-semibold text-dark small mb-1 d-flex justify-content-between align-items-center">
                    <span>{{ __('Email Address') }}</span>
                    <span class="badge bg-light text-muted border px-2 py-1" style="font-size: 0.72rem;">{{ __('Optional') }}</span>
                  </label>
                  <div class="input-group">
                    <span class="input-group-text bg-light border-end-0 text-muted"><i class="bi bi-envelope-fill"></i></span>
                    <input type="email" x-model="email" class="form-control border-start-0 py-2" placeholder="{{ __('doctor@practice.com (Optional for formal written proposal)') }}">
                  </div>
                </div>
              </div>
            </div>

            {{-- STEP 2: CATEGORY SELECTOR & AUTO-FILL --}}
            <div class="mb-5 pt-3 border-top border-light-subtle">
              <div class="d-flex align-items-center gap-2 mb-2">
                <span class="d-inline-flex align-items-center justify-content-center rounded-circle fw-bold text-white shadow-sm" style="width: 28px; height: 28px; background: #081C36; font-size: 0.82rem;">2</span>
                <h5 class="fw-bold text-dark mb-0">{{ __('Healthcare Specialty / Practice Type') }}</h5>
              </div>
              <p class="text-muted small mb-3">{{ __('Click any pre-set category below to auto-fill, or type your custom clinic/hospital specialty:') }}</p>

              {{-- Interactive Category Badges --}}
              <div class="d-flex flex-wrap gap-2 mb-3">
                @foreach($categories as $cat)
                  @php
                      $icon = 'bi-check2';
                      foreach ($categoryIcons as $k => $ico) {
                          if (stripos($cat, $k) !== false) {
                              $icon = $ico;
                              break;
                          }
                      }
                  @endphp
                  <button type="button"
                    @click="selectCategory('{{ addslashes($cat) }}')"
                    :class="category === '{{ addslashes($cat) }}'
                      ? 'btn-dark text-white border-dark shadow-sm'
                      : 'btn-outline-secondary text-dark bg-white border-light-subtle'"
                    class="btn btn-sm py-2 px-3 rounded-pill d-inline-flex align-items-center gap-2"
                    style="font-size: 0.84rem; transition: all 0.2s cubic-bezier(0.2, 0.8, 0.2, 1);">
                    <i class="bi {{ $icon }}" :class="category === '{{ addslashes($cat) }}' ? 'text-accent' : 'text-primary'"></i>
                    <span>{{ __($cat) }}</span>
                    <i class="bi bi-check-lg" x-show="category === '{{ addslashes($cat) }}'" x-cloak></i>
                  </button>
                @endforeach
              </div>

              {{-- Auto-filled / Editable Input Box --}}
              <div class="input-group">
                <span class="input-group-text bg-light border-end-0 text-muted"><i class="bi bi-tag-fill"></i></span>
                <input type="text" x-model="category" class="form-control border-start-0 py-2 fw-medium" placeholder="{{ __('Select above or type custom practice...') }}">
              </div>
            </div>

            {{-- STEP 3: SERVICES SELECTION --}}
            @if(count($servicesList) > 0)
              <div class="mb-5 pt-3 border-top border-light-subtle">
                <div class="d-flex align-items-center gap-2 mb-2">
                  <span class="d-inline-flex align-items-center justify-content-center rounded-circle fw-bold text-white shadow-sm" style="width: 28px; height: 28px; background: #081C36; font-size: 0.82rem;">3</span>
                  <h5 class="fw-bold text-dark mb-0">{{ __('Services Required') }}</h5>
                </div>
                <p class="text-muted small mb-3">{{ __('Select all services you would like included in your estimate (optional):') }}</p>

                <div class="row g-2">
                  @foreach($servicesList as $svc)
                    @php
                        $sIcon = 'bi-stars';
                        foreach ($serviceIcons as $sk => $sIco) {
                            if (stripos($svc, $sk) !== false) {
                                $sIcon = $sIco;
                                break;
                            }
                        }
                    @endphp
                    <div class="col-md-6">
                      <div @click="toggleService('{{ addslashes($svc) }}')"
                        :class="services.includes('{{ addslashes($svc) }}')
                          ? 'border-teal bg-teal-subtle text-dark shadow-sm'
                          : 'border-light-subtle bg-white text-secondary'"
                        class="p-3 border rounded-3 d-flex align-items-center gap-3 cursor-pointer user-select-none"
                        style="cursor: pointer; transition: all 0.2s ease;">
                        <div class="rounded-circle d-flex align-items-center justify-content-center flex-shrink-0"
                          :style="services.includes('{{ addslashes($svc) }}') ? 'background: #19b5a5; color: #fff;' : 'background: #f1f5f9; color: #64748b;'"
                          style="width: 34px; height: 34px; transition: all 0.2s ease;">
                          <i class="bi {{ $sIcon }}" style="font-size: 0.95rem;"></i>
                        </div>
                        <div class="flex-grow-1">
                          <span class="fw-semibold d-block small" :class="services.includes('{{ addslashes($svc) }}') ? 'text-dark' : 'text-secondary'">
                            {{ __($svc) }}
                          </span>
                        </div>
                        <div class="form-check mb-0">
                          <input class="form-check-input" type="checkbox" :checked="services.includes('{{ addslashes($svc) }}')" style="pointer-events: none;">
                        </div>
                      </div>
                    </div>
                  @endforeach
                </div>
              </div>
            @endif

            {{-- STEP 4: DESCRIPTION & REQUIREMENTS --}}
            <div class="mb-4 pt-3 border-top border-light-subtle">
              <div class="d-flex align-items-center gap-2 mb-2">
                <span class="d-inline-flex align-items-center justify-content-center rounded-circle fw-bold text-white shadow-sm" style="width: 28px; height: 28px; background: #081C36; font-size: 0.82rem;">4</span>
                <h5 class="fw-bold text-dark mb-0">{{ __('Project Scope & Goals') }} <span class="text-danger">*</span></h5>
              </div>
              <p class="text-muted small mb-2">{{ __('Tell us about your current website/challenges, what you want to achieve, or any specific timeline:') }}</p>

              <textarea x-model="description" class="form-control p-3" rows="4" placeholder="{{ __('e.g. We are a specialized cardiology clinic with 4 doctors. We need a modern, patient-friendly website with online appointment booking, SEO ranking in our local city, and Google profile optimization. Target launch is within 6 weeks.') }}" required style="font-size: 0.92rem; line-height: 1.6;"></textarea>
            </div>

            {{-- SUBMIT BUTTON --}}
            <div class="pt-2">
              <button type="submit" :disabled="isSubmitting" class="btn-3s btn-3s--primary w-100 justify-content-center py-3 fs-6 shadow-sm">
                <template x-if="!isSubmitting">
                  <span class="d-inline-flex align-items-center gap-2">
                    <i class="bi bi-send-fill"></i>
                    <span>{{ __(@$values->btn_text ?? 'Submit Quote Request') }}</span>
                    <i class="bi bi-arrow-right"></i>
                  </span>
                </template>
                <template x-if="isSubmitting">
                  <span class="d-inline-flex align-items-center gap-2">
                    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                    <span>{{ __('Preparing & Submitting Your Request...') }}</span>
                  </span>
                </template>
              </button>

              <div class="d-flex align-items-center justify-content-center gap-3 text-muted small mt-3">
                <span><i class="bi bi-check-circle-fill text-success me-1"></i>{{ __('Zero Obligation') }}</span>
                <span>•</span>
                <span><i class="bi bi-clock-fill text-primary me-1"></i>{{ __('24H Response') }}</span>
                <span>•</span>
                <span><i class="bi bi-shield-fill-check text-info me-1"></i>{{ __('Data Strictly Confidential') }}</span>
              </div>
            </div>

          </form>
        </div>
      </div>

      {{-- TRUST & ROADMAP SIDEBAR (RIGHT COLUMN) --}}
      <div class="col-lg-4 reveal reveal--right" style="--d:.15s">
        <div class="position-sticky" style="top: 90px;">

          {{-- CARD 1: WHAT HAPPENS NEXT (TIMELINE) --}}
          <div class="card border border-light-subtle shadow-sm p-4 mb-4" style="border-radius: 18px; background: #ffffff;">
            <h5 class="fw-bold text-dark mb-1">
              <i class="bi bi-lightning-charge-fill text-warning me-1"></i> {{ __('What Happens Next?') }}
            </h5>
            <p class="text-muted small mb-4">{{ __('Our clear 3-step proposal process:') }}</p>

            <div class="timeline-steps d-flex flex-column gap-3 position-relative">
              <div class="d-flex gap-3">
                <div class="d-flex flex-column align-items-center">
                  <span class="rounded-circle d-flex align-items-center justify-content-center fw-bold text-white shadow-sm" style="width: 32px; height: 32px; background: #081C36; font-size: 0.8rem;">01</span>
                  <div class="w-100 flex-grow-1" style="width: 2px !important; background: #e2e8f0; min-height: 28px;"></div>
                </div>
                <div class="pb-2">
                  <strong class="d-block text-dark small">{{ __('Requirement Review') }}</strong>
                  <span class="text-muted small">{{ __('Our medical strategists analyze your specialty and digital presence goals within 4 hours.') }}</span>
                </div>
              </div>

              <div class="d-flex gap-3">
                <div class="d-flex flex-column align-items-center">
                  <span class="rounded-circle d-flex align-items-center justify-content-center fw-bold text-white shadow-sm" style="width: 32px; height: 32px; background: #19b5a5; font-size: 0.8rem;">02</span>
                  <div class="w-100 flex-grow-1" style="width: 2px !important; background: #e2e8f0; min-height: 28px;"></div>
                </div>
                <div class="pb-2">
                  <strong class="d-block text-dark small">{{ __('Discovery & Strategy Call') }}</strong>
                  <span class="text-muted small">{{ __('A brief 15-minute consultation to clarify custom features, timeline, and ROI.') }}</span>
                </div>
              </div>

              <div class="d-flex gap-3">
                <div class="d-flex flex-column align-items-center">
                  <span class="rounded-circle d-flex align-items-center justify-content-center fw-bold text-white shadow-sm" style="width: 32px; height: 32px; background: #0b5cad; font-size: 0.8rem;">03</span>
                </div>
                <div>
                  <strong class="d-block text-dark small">{{ __('Fixed Proposal & Quote') }}</strong>
                  <span class="text-muted small">{{ __('You receive a comprehensive project roadmap with transparent fixed milestones.') }}</span>
                </div>
              </div>
            </div>
          </div>

          {{-- CARD 2: DIRECT CONSULTATION HELP --}}
          @php
              $contactInfo = getContent('contact_form.content', true);
              $cVal = @$contactInfo->data_values;
          @endphp
          <div class="card border border-light-subtle shadow-sm p-4 mb-4 text-white" style="border-radius: 18px; background: #081C36;">
            <span class="eyebrow text-accent mb-2" style="font-size: 0.72rem;">{{ __('Direct Healthcare Line') }}</span>
            <h5 class="fw-bold text-white mb-2">{{ __('Prefer to Talk to a Specialist Directly?') }}</h5>
            <p class="text-white-50 small mb-3">{{ __('Call or message our medical digital consultants for an immediate evaluation:') }}</p>

            <div class="d-flex flex-column gap-2">
              <a href="tel:{{ @$cVal->phone ?? '+1 (555) 234-5678' }}" class="btn btn-sm btn-outline-light d-flex align-items-center justify-content-between p-2 px-3 rounded-3 text-decoration-none">
                <span class="d-flex align-items-center gap-2">
                  <i class="bi bi-telephone-outbound text-accent"></i>
                  <span>{{ @$cVal->phone ?? '+1 (555) 234-5678' }}</span>
                </span>
                <i class="bi bi-arrow-right small"></i>
              </a>

              <a href="mailto:{{ @$cVal->email ?? 'info@3smedicare.com' }}" class="btn btn-sm btn-outline-light d-flex align-items-center justify-content-between p-2 px-3 rounded-3 text-decoration-none">
                <span class="d-flex align-items-center gap-2">
                  <i class="bi bi-envelope text-accent"></i>
                  <span>{{ @$cVal->email ?? 'info@3smedicare.com' }}</span>
                </span>
                <i class="bi bi-arrow-right small"></i>
              </a>
            </div>
          </div>

          {{-- CARD 3: CONFIDENTIALITY BADGE --}}
          <div class="p-3 rounded-4 border border-light-subtle bg-white shadow-sm d-flex align-items-start gap-3">
            <i class="bi bi-shield-check text-success fs-3 flex-shrink-0 mt-n1"></i>
            <div>
              <strong class="d-block text-dark small">{{ __('100% Client Privacy Guarantee') }}</strong>
              <p class="text-muted small mb-0" style="font-size: 0.78rem;">
                {{ __('All information submitted is strictly confidential under healthcare digital ethics. We will never share your contact details.') }}
              </p>
            </div>
          </div>

        </div>
      </div>

    </div>
  </div>
</section>

<script>
function quoteFormData() {
  return {
    name: '',
    phone: '',
    email: '',
    category: @json(request('category') ?? ($categories[0] ?? 'Doctor / Specialist')),
    services: @json($selectedServices),
    description: '',
    isSubmitting: false,
    isSuccess: false,
    errorMessage: '',

    selectCategory(cat) {
      this.category = cat;
    },

    toggleService(svc) {
      const idx = this.services.indexOf(svc);
      if (idx > -1) {
        this.services.splice(idx, 1);
      } else {
        this.services.push(svc);
      }
    },

    async submitQuote() {
      if (!this.name.trim()) {
        this.errorMessage = @json(__('Please enter your full name.'));
        return;
      }
      if (!this.phone.trim()) {
        this.errorMessage = @json(__('Phone number is required so our team can reach you.'));
        return;
      }
      if (!this.description.trim()) {
        this.errorMessage = @json(__('Please provide a brief description of your requirements.'));
        return;
      }

      this.isSubmitting = true;
      this.errorMessage = '';

      try {
        const response = await fetch(@json(route('quote.submit')), {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': @json(csrf_token()),
            'Accept': 'application/json'
          },
          body: JSON.stringify({
            name: this.name,
            phone: this.phone,
            email: this.email,
            category: this.category,
            services: this.services,
            description: this.description
          })
        });

        const result = await response.json();

        if (response.ok && result.success) {
          this.isSuccess = true;
          const sectionEl = document.getElementById('get-quote-section');
          if (sectionEl) {
            window.scrollTo({ top: sectionEl.offsetTop - 60, behavior: 'smooth' });
          }
        } else {
          this.errorMessage = result.message || @json(__('Submission failed. Please check your information and try again.'));
        }
      } catch (err) {
        this.errorMessage = @json(__('A network error occurred. Please try again or call us directly.'));
      } finally {
        this.isSubmitting = false;
      }
    },

    resetForm() {
      this.name = '';
      this.phone = '';
      this.email = '';
      this.category = @json($categories[0] ?? 'Doctor / Specialist');
      this.services = [];
      this.description = '';
      this.isSuccess = false;
      this.errorMessage = '';
    }
  };
}
</script>

@push('style')
<style>
  .border-teal {
    border-color: #19b5a5 !important;
  }
  .bg-teal-subtle {
    background-color: rgba(25, 181, 165, 0.08) !important;
  }
</style>
@endpush
