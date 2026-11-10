@php
    $title = isset($title) ? $title : __('Get Started with Your Service Request'); // Section title
    $route = isset($route) ? $route : 'our-service-request.store'; // Form submission route
    $service_id = isset($service_id) ? $service_id : 1; // Service ID
    $type =  isset($type) ? $type : "OurService"; // Service Type
    $model = isset($model) ? $model : "OurServiceForm";; // Model instance if editing
    $field = isset($field) ? $field : 'service_id'; // Additional fields if needed
    $button_text = isset($button_text) ?  $button_text : __('Submit Request'); // Button text
@endphp

<section class="py-5">
    <div class="mx-auto w-full max-w-5xl px-4 sm:px-6 lg:px-8">
        <div class="mx-auto max-w-3xl rounded-2xl border border-slate-200 bg-white p-5 shadow-sm sm:p-8">
            <div class="mb-6 rounded-xl bg-[#0d47a1] px-4 py-3 text-center">
                <h5 class="text-base font-semibold text-white">{{ $title }}</h5>
            </div>

            @if ($errors->any())
                <div class="mb-4 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
                    <ul class="list-disc space-y-1 ps-4">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route($route) }}" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="service_id" value="{{ $service_id }}">
                <input type="hidden" name="type" value="{{ $type }}">
                {!! getForm($service_id, $model, $field) !!}

                <button type="submit"
                    class="mt-8 inline-flex items-center justify-center rounded-lg bg-[#0d47a1] px-6 py-2.5 text-sm font-semibold text-white transition hover:bg-[#0b3f91] focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-offset-2">
                    {{ $button_text }}
                </button>
            </form>
        </div>
    </div>
</section>
