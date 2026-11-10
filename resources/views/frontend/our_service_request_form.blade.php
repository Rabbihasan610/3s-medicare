@extends('web.layouts.frontend', ['title' => $title])

@section('content')
	<section class="relative overflow-hidden bg-cover bg-center py-14 sm:py-20"
		style="background-image: url({{ asset('assets/images/ai.jpg') }});">
		<div class="absolute inset-0 bg-slate-900/55"></div>
		<div class="relative mx-auto w-full max-w-7xl px-4 sm:px-6 lg:px-8">
			<div class="mx-auto max-w-3xl text-center">
				<h2 class="text-3xl font-extrabold tracking-tight sm:text-4xl">{{ $title }}</h2>
			</div>
		</div>
	</section>

	<section class="bg-slate-50 py-12 sm:py-16">
		<div class="mx-auto w-full max-w-5xl px-4 sm:px-6 lg:px-8">
			<div class="mx-auto max-w-4xl rounded-2xl border border-slate-200 bg-white p-5 shadow-sm sm:p-8">
				<div class="mb-6 rounded-xl bg-[#0d47a1] px-4 py-3 text-center">
					<h5 class="text-base font-semibold text-white">{{ $title }} {{ __('Form') }}</h5>
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
						{{ __('Submit Request') }}
					</button>
				</form>
			</div>
		</div>
	</section>
@endsection
