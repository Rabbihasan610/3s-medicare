@php
    /*
    |--------------------------------------------------------------------------
    | Organization + WebSite structured data
    |--------------------------------------------------------------------------
    |
    | Rendered on every public page. Page specific schema (BlogPosting,
    | BreadcrumbList, ...) is pushed from the individual views onto the
    | 'seo' stack instead of being added here.
    |
    */

    $ldSiteName = __(gs('site_name'));
    $ldFooter = getContent('footer.content', true);
    $ldSocials = getContent('social_media.element', false, null, true)
        ->map(fn($item) => $item->data_values->url ?? ($item->data_values->link ?? null))
        ->filter()
        ->values()
        ->all();

    $ldOrganization = array_filter([
        '@type' => 'Organization',
        '@id' => url('/') . '#organization',
        'name' => $ldSiteName,
        'url' => url('/'),
        'logo' => siteLogo(),
        'image' => seoImage(),
        'description' => trim(strip_tags(seoValue('description', ''))) ?: null,
        'email' => @$ldFooter->data_values->email ?: null,
        'telephone' => @$ldFooter->data_values->mobile ?: null,
        'sameAs' => $ldSocials ?: null,
    ]);

    $ldAddressKey = app()->getLocale() === 'ar' ? 'address_ar' : 'address';
    $ldAddress = @$ldFooter->data_values->$ldAddressKey ?: @$ldFooter->data_values->address;
    if ($ldAddress) {
        $ldOrganization['address'] = [
            '@type' => 'PostalAddress',
            'streetAddress' => strip_tags($ldAddress),
        ];
    }

    $ldWebSite = [
        '@type' => 'WebSite',
        '@id' => url('/') . '#website',
        'name' => $ldSiteName,
        'url' => url('/'),
        'inLanguage' => app()->getLocale() === 'ar' ? 'ar' : 'en',
        'publisher' => ['@id' => url('/') . '#organization'],
    ];

    $ldGraph = [
        '@context' => 'https://schema.org',
        '@graph' => [$ldOrganization, $ldWebSite],
    ];

    $ldFlags = JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT;
@endphp

<script type="application/ld+json">{!! json_encode($ldGraph, $ldFlags) !!}</script>
