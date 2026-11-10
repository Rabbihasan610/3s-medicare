<?php

namespace App\Services\Assistant\Support;

/*
| Decides which language a piece of text actually *is*, as opposed to which
| language it was filed under.
|
| Two jobs, both of which were being done wrong before this class existed:
|
|   resolve()   - which language to answer a visitor in. The site's own toggle
|                 (session('lang')) is only a hint: a visitor who types Arabic
|                 into an English page wants an Arabic answer, and the retriever
|                 filters chunks by language, so guessing wrong here means the
|                 model is handed passages in a language the visitor cannot read.
|
|   reconcile() - which language a CMS body belongs in at index time. Amlaek's
|                 `_ar` twin columns are filled in by hand and are routinely
|                 wrong: Arabic typed into the base column, or an untranslated
|                 section copied into both. Indexing those verbatim puts Arabic
|                 passages in the English index, where an English visitor then
|                 retrieves them.
|
| Detection is a script-ratio test, not a language model. That is enough here
| because the only two options are Arabic and English, which share no letters.
*/
class LanguageGuard
{
    /** At or above this share of Arabic letters, the text is Arabic. */
    private const ARABIC_THRESHOLD = 0.40;

    /** At or below this share, it is English. Between the two is undecidable. */
    private const LATIN_THRESHOLD = 0.15;

    /**
     * Fewer letters than this and the ratio is noise - "SAP 2024", "ISO 9001"
     * and bare numbers must not be scored as confidently English.
     */
    private const MIN_LETTERS = 4;

    /**
     * The language a string is written in, or null when it genuinely cannot be
     * told (too short, digits only, or an even mix of both scripts).
     */
    public static function detect(string $text): ?string
    {
        preg_match_all('/\p{Arabic}/u', $text, $arabic);
        preg_match_all('/[a-zA-Z]/u', $text, $latin);

        $arabicCount = count($arabic[0]);
        $latinCount  = count($latin[0]);
        $total       = $arabicCount + $latinCount;

        if ($total < self::MIN_LETTERS) {
            return null;
        }

        $ratio = $arabicCount / $total;

        if ($ratio >= self::ARABIC_THRESHOLD) {
            return 'ar';
        }

        if ($ratio <= self::LATIN_THRESHOLD) {
            return 'en';
        }

        return null;
    }

    /**
     * The language to answer a question in.
     *
     * The question's own script wins when it is unambiguous, because that is the
     * language the visitor chose to speak in. The site toggle is the fallback for
     * everything else - a one-word query, a product code, a phone number.
     */
    public static function resolve(string $question, string $fallback = 'en'): string
    {
        $detected = self::detect($question);

        if ($detected !== null) {
            return $detected;
        }

        return in_array($fallback, ['ar', 'en'], true) ? $fallback : 'en';
    }

    /**
     * Route each indexed body to the language it is actually written in.
     *
     * Two failure modes, handled asymmetrically on purpose:
     *
     *   Arabic filed as English - always wrong, and actively harmful: it puts
     *   Arabic passages in front of English visitors. The body is removed from
     *   `en`, and promoted into `ar` if nothing is there yet, so the content
     *   stays reachable by the audience that can actually read it.
     *
     *   English filed as Arabic - this is the untranslated-section fallback the
     *   sources deliberately apply so Arabic visitors can still find a page that
     *   has no Arabic copy yet. It is KEPT (dropping it would make that content
     *   invisible in Arabic entirely) but reported as a gap, because the answer
     *   will be written in Arabic from English source material.
     *
     * @param  array<string, string>  $bodies  language code => text
     * @return array{bodies: array<string, string>, gaps: array<int, string>}
     */
    public static function reconcile(array $bodies): array
    {
        $gaps = [];

        $en = trim((string) ($bodies['en'] ?? ''));
        $ar = trim((string) ($bodies['ar'] ?? ''));

        if ($en !== '' && self::detect($en) === 'ar') {
            if ($ar === '') {
                $ar     = $en;
                $gaps[] = 'English body is written in Arabic; moved to the Arabic index';
            } else {
                $gaps[] = 'English body is written in Arabic; dropped from the English index';
            }

            $en = '';
        }

        if ($ar !== '' && self::detect($ar) === 'en') {
            $gaps[] = 'Arabic body is untranslated English; indexed as-is, answers will be translated on the fly';
        }

        $clean = [];

        if ($en !== '') {
            $clean['en'] = $en;
        }

        if ($ar !== '') {
            $clean['ar'] = $ar;
        }

        return ['bodies' => $clean, 'gaps' => $gaps];
    }
}
