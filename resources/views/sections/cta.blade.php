@php
    $ctaContent = getContent('cta.content', true);
    $values = @$ctaContent->data_values;
@endphp

<!-- SECTION 08 · CALL TO ACTION -->
<section class="section cta" id="contact-cta">
    <div class="container reveal reveal--zoom">
        <h2 class="fs-64" style="color: white;">
            {{ __(@$values->heading ?? 'Ready to Strengthen Your Healthcare Online?') }}</h2>
        <p style="color: white;">
            {{ __(@$values->subheading ?? 'Tell us about your practice and the digital services you need.') }}</p>
        <div class="d-flex justify-content-center gap-3 flex-wrap">
            <a href="{{ url(@$values->btn_1_url ?? 'get-quote') }}"
                class="btn-3s btn-3s--primary">{{ __(@$values->btn_1_text ?? 'Get a Quote') }} <i
                    class="bi bi-arrow-up-right"></i></a>
            <a href="{{ url(@$values->btn_2_url ?? 'contact') }}"
                class="btn-3s btn-3s--outline">{{ __(@$values->btn_2_text ?? 'Contact Us') }} <i
                    class="bi bi-arrow-up-right"></i></a>
        </div>
    </div>
</section>
