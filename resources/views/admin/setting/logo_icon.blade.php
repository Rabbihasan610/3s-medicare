@extends('admin.layouts.app', ['title' => 'Logo & Favicon'])

@section('panel')
	<div class="row mb-none-30">
		<div class="col-md-12 mb-30">
			<div class="card">
				<div class="card-body">
					<form action="" method="POST" enctype="multipart/form-data">
						@csrf

						<div class="mb-4 row justify-content-center">
							<div class="mb-3 form-group col-md-4">
								<label class="form-label">@lang('Logo Dark')</label>
								<x-image-uploader name="logo_dark" :imagePath="siteLogo('dark')" :size="false" class="w-100"
									id="uploadLogoDark" :required="false" :darkMode="true" />
								<small class="text-muted d-block mt-1">@lang('Used on light backgrounds. PNG or JPG, up to 2 MB.')</small>
							</div>

							<div class="mb-3 form-group col-md-4">
								<label class="form-label">@lang('Logo White')</label>
								<x-image-uploader name="logo" :imagePath="siteLogo()" :size="false" class="w-100"
									id="uploadLogoWhite" :required="false" />
								<small class="text-muted d-block mt-1">@lang('Used on dark backgrounds. PNG or JPG, up to 2 MB.')</small>
							</div>

							<div class="mb-3 form-group col-md-4">
								<label class="form-label">@lang('Favicon')</label>
								<x-image-uploader name="favicon" :imagePath="siteFavicon()" :size="false" class="w-100"
									id="uploadFavicon" :required="false" />
								<small class="text-muted d-block mt-1">
									@lang('PNG only. Resized to') {{ getFileSize('favicon') }}.
								</small>
							</div>
						</div>

						<hr class="my-4">

						<div class="mb-4 row justify-content-center">
							<div class="mb-3 form-group col-md-4">
								<label class="form-label">@lang('Email Header Logo')</label>
								<x-image-uploader name="logo_email" :imagePath="siteEmailLogo()" :size="false" class="w-100"
									id="uploadLogoEmail" :required="false" />
								<small class="text-muted d-block mt-1">
									@lang('Shown at the top of notification emails. Falls back to the dark logo when not set.')
									<br>
									@lang('Use the short code') <code>@{{ site_logo }}</code> @lang('in the global email template.')
								</small>
							</div>

							<div class="mb-3 form-group col-md-4">
								<label class="form-label">@lang('Social Share Image')</label>
								<div class="border rounded p-2 text-center bg-light">
									<img src="{{ seoImage() }}" alt="{{ __('Social Share Image') }}"
										class="img-fluid" style="max-height: 120px">
								</div>
								<small class="text-muted d-block mt-1">
									@lang('Used for Facebook, X and LinkedIn previews.')
									@lang('Recommended size') {{ getFileSize('seo') }}.
									<br>
									<a href="{{ route('admin.seo') }}">@lang('Change it in SEO Manager')</a>
									@lang('so there is only one place to edit it.')
								</small>
							</div>
						</div>

						<button type="submit" class="btn btn-primary w-100 h-45">
							@lang('Submit')
						</button>
					</form>
				</div>
			</div>
		</div>
	</div>
@endsection
