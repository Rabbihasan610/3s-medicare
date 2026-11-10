<?php

namespace App\Services\Assistant\Indexing;

use App\Services\Assistant\Support\TextNormalizer;
use Illuminate\Support\Facades\Route as RouteFacade;
use Illuminate\Support\Facades\View;

/*
| Pulls the real prose off a public page.
|
| Amlaek's service pages carry their copy in `@lang()` keys, not in the CMS and
| not in the database: the English sentence IS the translation key, and
| resources/lang/ar.json holds its Arabic. Sixty-odd keys per service page - the
| descriptions, the "what this sector covers" lists, the value propositions -
| none of which was reachable by the assistant, because ServiceRouteSource only
| ever indexed a four-line stub naming the page and its form.
|
| That is why a question had to be phrased almost exactly like a service's title
| to find it, and why anything asked about what a service actually *does* fell
| through to a refusal.
|
| Read straight from the Blade file rather than by rendering it. Rendering would
| need each page's controller data, would drag the nav and footer into every
| document, and would fail in the scheduler where there is no request. Reading
| the keys gets the copy and nothing else.
*/
class PageCopy
{
    /** Below this a page is chrome, not content - a redirect stub or a bare form. */
    private const MIN_KEYS = 5;

    /** @var array<string, array<string, string>> lang => key => translation */
    private static array $translations = [];

    /**
     * The page's own copy in both languages.
     *
     * @return array{en: string, ar: string}
     */
    public static function forRoute(string $routeName, ?string $viewOverride = null): array
    {
        $view = $viewOverride ?: self::viewFromRoute($routeName);

        if (!$view || !View::exists($view)) {
            return ['en' => '', 'ar' => ''];
        }

        $keys = self::keys($view);

        if (count($keys) < self::MIN_KEYS) {
            return ['en' => '', 'ar' => ''];
        }

        $arabic = self::translations('ar');

        $en = [];
        $ar = [];

        foreach ($keys as $key) {
            $en[] = $key;

            /*
            | Untranslated keys fall back to the English string rather than being
            | dropped. The Arabic body is then partly English, which is worse
            | than a translation but far better than a hole - and LanguageGuard
            | reports it as a translation gap on the next index run, so it shows
            | up in the report instead of being silently absorbed.
            */
            $ar[] = $arabic[$key] ?? $key;
        }

        return [
            'en' => implode("\n", $en),
            'ar' => implode("\n", $ar),
        ];
    }

    /**
     * Translation keys used by a Blade view, in document order and deduplicated.
     *
     * @return array<int, string>
     */
    private static function keys(string $view): array
    {
        $path = View::getFinder()->find($view);

        $blade = @file_get_contents($path);

        if ($blade === false) {
            return [];
        }

        // @lang('...') and __('...'), single or double quoted. Anything built
        // from a variable is skipped - there is no static string to index.
        preg_match_all(
            '/@lang\(\s*([\'"])(.+?)\1\s*[,)]|__\(\s*([\'"])(.+?)\3\s*[,)]/su',
            $blade,
            $matches
        );

        $keys = [];

        foreach (array_merge($matches[2], $matches[4]) as $key) {
            $key = trim(stripcslashes($key));

            // Single words are labels and buttons - "Send", "Home", "Read more".
            // They add noise to retrieval without adding anything answerable.
            if ($key === '' || !str_contains($key, ' ')) {
                continue;
            }

            $text = TextNormalizer::plain($key);

            if ($text !== '' && !in_array($text, $keys, true)) {
                $keys[] = $text;
            }
        }

        return $keys;
    }

    /** @return array<string, string> */
    private static function translations(string $lang): array
    {
        if (isset(self::$translations[$lang])) {
            return self::$translations[$lang];
        }

        $path = resource_path("lang/{$lang}.json");
        $data = is_file($path) ? json_decode((string) file_get_contents($path), true) : null;

        return self::$translations[$lang] = is_array($data) ? $data : [];
    }

    /**
     * The conventional view for a route: `web.<its uri>`.
     *
     * Holds for most of the site. Where a route's URI and its view name diverge,
     * the caller passes an override rather than this guessing.
     */
    private static function viewFromRoute(string $routeName): ?string
    {
        if (!RouteFacade::has($routeName)) {
            return null;
        }

        $uri = trim(RouteFacade::getRoutes()->getByName($routeName)->uri(), '/');

        if ($uri === '' || str_contains($uri, '{')) {
            return null;
        }

        return 'web.' . $uri;
    }
}
