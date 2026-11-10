{{--
    Extensions that must render inside <head>: search engine verification meta tags,
    tag managers and marketing pixels. Manage the keys and the on/off switch from
    Admin > Extensions. Disabled extensions render nothing.
--}}
@php echo loadExtension('google-site-verification') @endphp
@php echo loadExtension('bing-site-verification') @endphp
@php echo loadExtension('yandex-site-verification') @endphp
@php echo loadExtension('google-tag-manager') @endphp
@php echo loadExtension('google-analytics') @endphp
@php echo loadExtension('facebook-pixel') @endphp
@php echo loadExtension('linkedin-insight') @endphp
@php echo loadExtension('tiktok-pixel') @endphp
