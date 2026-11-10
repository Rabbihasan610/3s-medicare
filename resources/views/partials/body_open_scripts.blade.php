@php
    /*
    | Google Tag Manager needs a <noscript> iframe as the first element inside <body>,
    | using the same container id as the <head> snippet. Rather than asking the admin
    | to paste the id twice we read it back from the google-tag-manager extension.
    */
    $gtmContainer = extensionShortcode('google-tag-manager', 'container_id');
@endphp

@if ($gtmContainer)
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id={{ $gtmContainer }}" height="0" width="0"
            style="display:none;visibility:hidden"></iframe></noscript>
@endif
