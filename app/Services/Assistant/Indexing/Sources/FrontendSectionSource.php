<?php

namespace App\Services\Assistant\Indexing\Sources;

use App\Models\Frontend;
use App\Services\Assistant\Indexing\KnowledgeSource;
use App\Services\Assistant\Support\LanguageGuard;
use App\Services\Assistant\Support\TextNormalizer;
use Illuminate\Support\Collection;

/*
| The Frontend key/JSON section store - the CMS behind the homepage, About, Why
| Amlaek, the business model, and so on.
|
| Rows are `{section}.content` / `{section}.element` with an arbitrary JSON blob
| whose editable shape is declared in resources/views/sections.json. Rather than
| hardcode field names per section, this walks the blob and keeps anything that
| looks like prose, using sections.json only for the human-readable section name.
|
| `.element` rows are repeaters - many rows share one data_keys - so they are
| grouped back into a single document per section.
*/
class FrontendSectionSource implements KnowledgeSource
{
    /** Field names that hold assets or config, never text worth answering from. */
    private const SKIP_KEYS = [
        'image', 'images', 'icon', 'tag_icon', 'sub_image', 'background',
        'link', 'url', 'status', 'color', 'position', 'video', 'file',
        'button_link', 'explore_button_link', 'investment_button_link', 'modal',
    ];

    public function type(): string
    {
        return 'section';
    }

    public function documents(): iterable
    {
        $names = $this->sectionNames();

        $rows = Frontend::whereNotNull('data_values')
            ->orderBy('id')
            ->get()
            ->groupBy('data_keys');

        foreach ($rows as $dataKey => $group) {
            $section = explode('.', (string) $dataKey)[0];

            // Policy pages and cookie text are served by their own routes and are
            // legal boilerplate; they drown out service answers if indexed here.
            if (in_array($section, ['cookie', 'policy_pages', 'seo', 'footer', 'social_media'], true)) {
                continue;
            }

            $en = $this->collect($group, 'en');
            $ar = $this->collect($group, 'ar');

            if (trim($en) === '' && trim($ar) === '') {
                continue;
            }

            $label   = $names[$section] ?? ucwords(str_replace('_', ' ', $section));
            $labelAr = $this->arabicTitle($group);

            yield [
                'source_key' => (string) $dataKey,
                'route_name' => null,
                // A path, not an absolute URL: resolved against the running host
                // at read time so an index built locally does not hand production
                // visitors 127.0.0.1 links.
                'url'      => '/',
                'title'    => $label,
                'title_ar' => $labelAr,
                'bodies'   => [
                    'en' => $label . "\n\n" . $en,
                    'ar' => ($labelAr ?: $label) . "\n\n" . $ar,
                ],
            ];
        }
    }

    /** @param Collection<int, Frontend> $group */
    private function collect($group, string $lang): string
    {
        $lines = [];

        foreach ($group as $row) {
            $values = (array) $row->data_values;

            foreach ($values as $key => $value) {
                if (! is_string($value) && ! is_numeric($value)) {
                    continue;
                }

                /*
                | Suffixes are handled symmetrically because the CMS is not
                | consistent about which column holds which language. The
                | documented shape is "bare column = English, _ar twin =
                | Arabic", but rows like explore_investment_opportunities put
                | Arabic in the bare `description` and the English in a
                | non-standard `description_en`. Treating `_en` as a real twin
                | is what keeps that row's English out of the Arabic index and
                | its Arabic out of the English one.
                */
                if (str_ends_with($key, '_ar')) {
                    if ($lang !== 'ar') {
                        continue;
                    }
                    $baseKey = substr($key, 0, -3);
                } elseif (str_ends_with($key, '_en')) {
                    if ($lang !== 'en') {
                        continue;
                    }
                    $baseKey = substr($key, 0, -3);
                } else {
                    $baseKey = $key;

                    // The bare column is only this language's copy when the
                    // other language has no twin of its own.
                    $twin = $lang === 'ar' ? $key . '_ar' : $key . '_en';

                    if (! empty($values[$twin])) {
                        continue;
                    }
                }

                if ($this->skip($baseKey)) {
                    continue;
                }

                $text = TextNormalizer::plain((string) $value);
                if (mb_strlen($text) < 3) {
                    continue;
                }

                $lines[] = $text;
            }
        }

        return implode("\n", array_unique($lines));
    }

    /**
     * The section's own Arabic heading.
     *
     * sections.json carries an English `name` only, so without this every
     * section document was stored with a null title_ar and Arabic answers cited
     * their sources under English headings.
     *
     * @param  Collection<int, Frontend>  $group
     */
    private function arabicTitle($group): ?string
    {
        foreach ($group as $row) {
            $values = (array) $row->data_values;

            foreach (['title_ar', 'heading_ar', 'name_ar', 'sub_title_ar'] as $key) {
                $value = TextNormalizer::plain((string) ($values[$key] ?? ''));

                // Guarded: these fields are hand-filled and sometimes hold the
                // English string, which would be worse than storing nothing.
                if ($value !== ''
                    && preg_match('/\p{Arabic}/u', $value)
                    && LanguageGuard::detect($value) !== 'en') {
                    return $value;
                }
            }
        }

        return null;
    }

    private function skip(string $key): bool
    {
        if (in_array($key, self::SKIP_KEYS, true)) {
            return true;
        }

        return (bool) preg_match('/(_link|_url|_icon|_image|_color)$/', $key);
    }

    /** @return array<string, string> */
    private function sectionNames(): array
    {
        $names = [];

        foreach ((array) getPageSections(true) as $key => $definition) {
            $names[$key] = $definition['name'] ?? ucwords(str_replace('_', ' ', $key));
        }

        return $names;
    }
}
