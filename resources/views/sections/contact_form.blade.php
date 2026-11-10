@php
    $formContent = getContent('contact_form.content', true);
    $values = @$formContent->data_values;
@endphp

<!-- CONTACT · 02 INFO + REACTIVE ALFINE.JS FORM -->
<section class="section" id="contact-form" 
  x-data="{
    name: '',
    email: '',
    phone: '',
    client_type: '',
    services: [],
    message: '',
    isSubmitting: false,
    isSuccess: false,
    errorMessage: '',
    async submitQuote() {
      if (!this.name || !this.phone || !this.client_type || !this.message) {
        this.errorMessage = '{{ __("Please fill in all required fields.") }}';
        return;
      }
      this.isSubmitting = true;
      this.errorMessage = '';
      try {
        const response = await fetch('{{ route("quote.submit") }}', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json'
          },
          body: JSON.stringify({
            name: this.name,
            email: this.email,
            phone: this.phone,
            client_type: this.client_type,
            services: this.services,
            message: this.message
          })
        });
        const result = await response.json();
        if (response.ok && result.success) {
          this.isSuccess = true;
        } else {
          this.errorMessage = result.message || '{{ __("Submission failed. Please try again.") }}';
        }
      } catch (err) {
        this.errorMessage = '{{ __("Network error. Please try again.") }}';
      } finally {
        this.isSubmitting = false;
      }
    }
  }">
  <div class="container">
    <div class="row g-4 g-lg-5">
      <div class="col-lg-5 reveal reveal--left">
        <aside class="contact-info-card">
          <h2>{{ __(@$values->card_title ?? 'Get in Touch') }}</h2>
          <p class="mb-0">{{ __(@$values->card_subtitle ?? 'We help doctors, clinics, hospitals and diagnostic centers build a stronger online presence.') }}</p>
          <div class="contact-item">
            <span class="ico"><i class="bi bi-envelope"></i></span>
            <div>
              <strong>{{ __('Email') }}</strong>
              <span>{{ @$values->email ?? 'info@3smedicare.com' }}</span>
            </div>
          </div>
          <div class="contact-item">
            <span class="ico"><i class="bi bi-telephone"></i></span>
            <div>
              <strong>{{ __('Phone') }}</strong>
              <span>{{ @$values->phone ?? '+1 (555) 234-5678' }}</span>
            </div>
          </div>
          <div class="contact-item">
            <span class="ico"><i class="bi bi-clock"></i></span>
            <div>
              <strong>{{ __('Business Hours') }}</strong>
              <span>{{ @$values->hours ?? 'Mon - Fri: 9:00 AM - 6:00 PM' }}</span>
            </div>
          </div>
          <div class="contact-item">
            <span class="ico"><i class="bi bi-geo-alt"></i></span>
            <div>
              <strong>{{ __('Location') }}</strong>
              <span>{{ @$values->location ?? 'Medical Arts Plaza, Suite 400' }}</span>
            </div>
          </div>
        </aside>
      </div>

      <div class="col-lg-7 reveal reveal--right" style="--d:.12s">
        <div class="form-card" id="quoteCard">
          <h2 class="h4 mb-1">{{ __('Get a Quote') }}</h2>
          <p class="text-secondary small mb-4">{{ __('Fields marked * are required.') }}</p>

          <template x-if="errorMessage">
            <div class="alert alert-danger py-2 mb-3 small" x-text="errorMessage"></div>
          </template>

          <form id="quoteForm" @submit.prevent="submitQuote" x-show="!isSuccess">
            <div class="row g-3">
              <div class="col-md-6">
                <label class="form-label" for="quote_name">{{ __('Full name *') }}</label>
                <input class="form-control" id="quote_name" x-model="name" required placeholder="{{ __('e.g. Dr. John Doe') }}">
              </div>
              <div class="col-md-6">
                <label class="form-label" for="quote_email">{{ __('Email') }}</label>
                <input type="email" class="form-control" id="quote_email" x-model="email" placeholder="{{ __('e.g. doctor@clinic.com') }}">
              </div>
              <div class="col-md-6">
                <label class="form-label" for="quote_phone">{{ __('Phone *') }}</label>
                <input type="tel" class="form-control" id="quote_phone" x-model="phone" required placeholder="{{ __('e.g. +1 234 567 8900') }}">
              </div>
              <div class="col-md-6">
                <label class="form-label" for="quote_type">{{ __('I am a *') }}</label>
                <select class="form-select" id="quote_type" x-model="client_type" required>
                  <option value="" disabled>{{ __('Select one') }}</option>
                  <option value="Doctor">{{ __('Doctor') }}</option>
                  <option value="Hospital">{{ __('Hospital') }}</option>
                  <option value="Clinic">{{ __('Clinic') }}</option>
                  <option value="Diagnostic Center">{{ __('Diagnostic Center') }}</option>
                </select>
              </div>
              <div class="col-12">
                <span class="form-label d-block">{{ __('Services needed') }}</span>
                <div class="service-check">
                  <span><input type="checkbox" id="s1" value="Website Development" x-model="services"><label for="s1">{{ __('Website Development') }}</label></span>
                  <span><input type="checkbox" id="s2" value="SEO Services" x-model="services"><label for="s2">{{ __('SEO Services') }}</label></span>
                  <span><input type="checkbox" id="s3" value="Digital Marketing" x-model="services"><label for="s3">{{ __('Digital Marketing') }}</label></span>
                  <span><input type="checkbox" id="s4" value="Social Media" x-model="services"><label for="s4">{{ __('Social Media') }}</label></span>
                  <span><input type="checkbox" id="s5" value="Facebook / Google Ads" x-model="services"><label for="s5">{{ __('Facebook / Google Ads') }}</label></span>
                  <span><input type="checkbox" id="s6" value="Patient Appointment & Queue" x-model="services"><label for="s6">{{ __('Patient Appointment & Queue') }}</label></span>
                </div>
              </div>
              <div class="col-12">
                <label class="form-label" for="quote_message">{{ __('Message *') }}</label>
                <textarea class="form-control" id="quote_message" x-model="message" rows="4" required placeholder="{{ __('Tell us a little about your practice and goals...') }}"></textarea>
              </div>
              <div class="col-12">
                <button type="submit" class="btn-3s btn-3s--primary border-0" :disabled="isSubmitting">
                  <template x-if="!isSubmitting">
                    <span>{{ __('Send Request') }} <i class="bi bi-arrow-up-right"></i></span>
                  </template>
                  <template x-if="isSubmitting">
                    <span><span class="spinner-border spinner-border-sm me-1"></span> {{ __('Sending...') }}</span>
                  </template>
                </button>
              </div>
            </div>
          </form>

          <div class="form-success text-center py-4" role="status" x-show="isSuccess" x-cloak>
            <i class="bi bi-check-circle-fill text-success" style="font-size: 3rem;"></i>
            <h3 class="h4 mt-3">{{ __('Thank you!') }}</h3>
            <p class="text-secondary mb-3">{{ __('We have received your quote request and will get back to you shortly.') }}</p>
            <button type="button" class="btn-3s btn-3s--outline btn-sm" @click="isSuccess = false; name = ''; email = ''; phone = ''; message = ''; services = [];">
              {{ __('Send Another Request') }}
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

