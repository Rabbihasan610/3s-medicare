<?php

namespace App\Services\Assistant\Support;

use Illuminate\Support\Str;

/*
| Question hygiene, used for three different jobs:
|
|   normalize() -> the cache key, so "ما هي خدماتكم؟" and "ما هى خدماتكم" hit the
|                  same cached answer instead of paying for the model twice.
|   mask()      -> strips personal data before anything is stored for analytics.
|                  Visitors routinely type their phone number into search boxes,
|                  and under Saudi PDPL that is personal data we should not retain.
|   plain()     -> flattens CMS HTML into indexable text.
*/
class TextNormalizer
{
    /** Arabic diacritics (tashkeel), superscript alef, and tatweel. */
    private const ARABIC_MARKS = '/[\x{0610}-\x{061A}\x{064B}-\x{065F}\x{0670}\x{06D6}-\x{06ED}\x{0640}]/u';

    public static function normalize(string $text): string
    {
        $text = self::mask($text);
        $text = Str::lower(trim($text));

        // Fold Arabic orthographic variants so spelling differences collapse.
        $text = preg_replace(self::ARABIC_MARKS, '', $text);
        $text = strtr($text, [
            'أ' => 'ا', 'إ' => 'ا', 'آ' => 'ا', 'ٱ' => 'ا',
            'ة' => 'ه',
            'ى' => 'ي',
            'ؤ' => 'و',
            'ئ' => 'ي',
        ]);

        // Drop punctuation in both scripts, then squeeze whitespace.
        $text = preg_replace('/[^\p{L}\p{N}\s]+/u', ' ', $text);
        $text = preg_replace('/\s+/u', ' ', $text);

        return trim($text);
    }

    public static function hash(string $normalized): string
    {
        return hash('sha256', $normalized);
    }

    /**
     * Replace anything that looks like contact details with a placeholder.
     *
     * Deliberately aggressive: a false positive costs us a slightly worse cache
     * key, a false negative puts a visitor's phone number in the query log.
     */
    public static function mask(string $text): string
    {
        $text = preg_replace('/[\w.+-]+@[\w-]+\.[\w.-]+/u', '[email]', $text);

        // Saudi mobile / landline shapes plus any long digit run (IBAN, CR, ID).
        // Each pattern must end on a digit so it cannot swallow the space that
        // separates the number from the next word.
        $text = preg_replace('/(\+?966|00966)[\s-]?\d[\d\s-]{5,}\d/u', '[phone]', $text);
        $text = preg_replace('/\b0\d[\d\s-]{5,}\d\b/u', '[phone]', $text);
        $text = preg_replace('/\b\d{9,}\b/u', '[number]', $text);

        return $text;
    }

    /** CMS content is HTML; the index and the model both want plain text. */
    public static function plain(?string $html): string
    {
        if (blank($html)) {
            return '';
        }

        $text = preg_replace('#<(script|style)\b[^>]*>.*?</\1>#is', ' ', (string) $html);
        $text = preg_replace('#<(br|/p|/div|/li|/h[1-6])\s*/?>#i', "\n", $text);
        $text = strip_tags($text);
        $text = html_entity_decode($text, ENT_QUOTES | ENT_HTML5, 'UTF-8');
        $text = preg_replace('/[ \t]+/u', ' ', $text);
        $text = preg_replace('/\n{3,}/u', "\n\n", $text);

        return trim($text);
    }

    /**
     * Detects whether a string is predominantly Arabic.
     *
     * Delegates to LanguageGuard so there is one detector in the codebase. The
     * original test here treated a single Arabic character as decisive, which
     * called an English sentence containing one Arabic brand name "Arabic".
     */
    public static function detectLang(string $text): string
    {
        return LanguageGuard::detect($text) ?? 'en';
    }
}
