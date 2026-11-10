<?php

/*
|--------------------------------------------------------------------------
| AI Help Center
|--------------------------------------------------------------------------
|
| Tuning knobs for the retrieval-grounded assistant. Provider credentials do
| NOT live here - they are rows in `assistant_providers`, managed from
| Admin > AI Help Center > Providers, so a key can be rotated without a deploy.
|
| Everything below is a behavioural default. Anything a provider needs to
| override per-vendor goes in that row's `params` JSON instead.
|
*/

return [

    /*
    | Vector width requested from the embedding provider. Gemini and OpenAI both
    | support truncating the output, and 256 dimensions is ample for a single
    | site's knowledge base. Dropping from 1536 to 256 cuts the blob we unpack
    | in PHP by 6x, which is what makes similarity search viable on MariaDB.
    |
    | Changing this invalidates every stored vector - reindex with --fresh.
    */
    'dimensions' => 256,

    'chunk' => [
        'max_chars' => 2400,   // ~600 tokens
        'overlap'   => 400,
        'min_chars' => 120,    // shorter fragments carry no retrievable meaning
    ],

    'retrieval' => [
        // FULLTEXT shortlists this many rows; only these get unpacked and scored.
        'candidates' => 250,

        // Chunks handed to the model.
        'top_k' => 6,

        // Hybrid score = vector_weight * cosine + (1 - vector_weight) * fulltext.
        'vector_weight' => 0.65,

        // Below this the answer is refused and logged as a content gap.
        'min_score' => 0.42,
    ],

    'cache' => [
        'answer_days'    => 7,
        'embedding_days' => 30,
    ],

    'answer' => [
        'max_output_tokens' => 1500,
        'temperature'       => 0.2,
    ],

    /*
    | Blog posts and page-builder documents can be dated or promotional, so they
    | are indexed but pushed below official service content at ranking time.
    | Set to 1.0 to treat them as equal, or disable the source outright.
    */
    'source_weights' => [
        'service' => 1.0,
        'sector'  => 1.0,
        'section' => 0.95,
        'page'    => 0.9,
        'blog'    => 0.75,
    ],

    /*
    | Multi-turn conversations.
    |
    | `history_turns` is the number of previous messages replayed to the model.
    | It is paid for on every single turn, so it stays small deliberately.
    |
    | `carry_forward` re-offers the passages the previous answer cited, so a
    | follow-up like "tell me more about the second one" - which retrieves
    | nothing useful on its own words - still has its referent to work from.
    |
    | `max_messages` caps one thread. Past it the widget starts a new
    | conversation rather than replaying an ever-growing history.
    */
    'conversation' => [
        'history_turns' => 6,
        'carry_forward' => 3,
        'max_messages'  => 40,
    ],

    /*
    | Abuse and cost control. `daily_cost_cap` is in USD and uses the per-token
    | prices stored on the provider row; leave those at 0 and the cap never trips.
    */
    'limits' => [
        'per_minute'    => 8,
        'daily_cost_cap' => 0,
    ],

    /*
    | Raw visitor questions are personal data under Saudi PDPL. Masked copies are
    | kept for analytics; the raw text is purged after this many days by
    | `php artisan assistant:purge`.
    */
    'retention_days' => 90,
];
