<?php

namespace Database\Seeders;

use App\Constants\Status;
use App\Models\AssistantProvider;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Crypt;

/*
| Registers the two Gemini provider rows - one for answering, one for embeddings.
|
| The key is read from ASSISTANT_GEMINI_KEY so it never lands in version control.
| It accepts either a plain key or an already-encrypted Laravel payload: if the
| value decrypts under this app's APP_KEY it is stored as-is, otherwise it is
| treated as plaintext and encrypted by the model's cast. That matters because a
| payload encrypted under a different APP_KEY cannot be recovered here, and
| failing loudly at seed time is far better than failing on a visitor's question.
*/
class AssistantProviderSeeder extends Seeder
{
    public function run(): void
    {
        $key = $this->resolveKey();

        if ($key === null) {
            $this->command?->warn('ASSISTANT_GEMINI_KEY is not set - creating providers without a key. Add it in Admin > AI Help Center > Providers.');
        }

        AssistantProvider::updateOrCreate(
            ['driver' => 'gemini', 'purpose' => AssistantProvider::PURPOSE_CHAT],
            [
                'name'     => 'Gemini (answers)',
                'model'    => env('ASSISTANT_GEMINI_MODEL', 'gemini-3.6-flash'),
                'api_key'  => $key,
                'priority' => 1,
                'status'   => Status::ENABLE,
                'params'   => [
                    'embedding_model' => 'gemini-embedding-001',
                    'timeout'         => 45,
                    // Per-million-token prices. Left at 0 the feature works fine,
                    // the cost column just stays empty - fill them from the vendor's
                    // current price list rather than hardcoding a guess here.
                    'price_in'     => 0,
                    'price_out'    => 0,
                    'price_cached' => 0,
                ],
            ]
        );

        AssistantProvider::updateOrCreate(
            ['driver' => 'gemini', 'purpose' => AssistantProvider::PURPOSE_EMBEDDING],
            [
                'name'     => 'Gemini (embeddings)',
                'model'    => env('ASSISTANT_GEMINI_EMBED_MODEL', 'gemini-embedding-001'),
                'api_key'  => $key,
                'priority' => 1,
                'status'   => Status::ENABLE,
                'params'   => [
                    'dimensions' => (int) config('assistant.dimensions', 256),
                    'timeout'    => 60,
                ],
            ]
        );
    }

    private function resolveKey(): ?string
    {
        $raw = env('ASSISTANT_GEMINI_KEY');

        if (blank($raw)) {
            return null;
        }

        if (!$this->looksEncrypted($raw)) {
            return $raw;
        }

        // A Laravel payload. Return the plaintext so the model's cast re-encrypts
        // it consistently. If it will not decrypt it was encrypted under a
        // different APP_KEY - store nothing rather than a base64 blob that would
        // be sent to Google as an API key and fail on a visitor's first question.
        try {
            return Crypt::decryptString($raw);
        } catch (\Throwable $e) {
            throw new \RuntimeException(
                'ASSISTANT_GEMINI_KEY looks like a Laravel encrypted payload but will not decrypt '
                . 'under this APP_KEY. Put the plain Gemini API key in ASSISTANT_GEMINI_KEY instead.'
            );
        }
    }

    /** Laravel payloads are base64 JSON carrying iv/value/mac. */
    private function looksEncrypted(string $value): bool
    {
        $decoded = base64_decode($value, true);

        if ($decoded === false) {
            return false;
        }

        $json = json_decode($decoded, true);

        return is_array($json) && isset($json['iv'], $json['value'], $json['mac']);
    }
}
