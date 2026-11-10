<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/*
| AI Help Center storage.
|
| Named `assistant_*` on purpose: `Ai*` is already taken by the AI & Data
| business-services request module (App\Models\AiRequest, admin.ai.* routes),
| which is a customer enquiry form and has nothing to do with this feature.
*/
return new class extends Migration
{
    public function up(): void
    {
        // Registered AI vendors. Two roles - `chat` answers, `embedding` vectorises -
        // because no single vendor is necessarily best (or even available) for both.
        Schema::create('assistant_providers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('driver', 32);              // gemini | openai | anthropic | custom
            $table->string('purpose', 16);             // chat | embedding
            $table->text('api_key')->nullable();       // 'encrypted' cast on the model
            $table->string('base_url')->nullable();
            $table->string('model');
            $table->text('params')->nullable();        // json: dimensions, prices, timeout
            $table->integer('priority')->default(1);   // failover order, lowest first
            $table->tinyInteger('status')->default(1);
            $table->timestamp('last_check_at')->nullable();
            $table->text('last_error')->nullable();
            $table->timestamps();

            $table->index(['purpose', 'status', 'priority']);
        });

        // One row per indexed source object. `body_hash` makes reindexing
        // incremental - unchanged sources are skipped entirely.
        Schema::create('assistant_documents', function (Blueprint $table) {
            $table->id();
            $table->string('source_type', 32);           // service | sector | section | blog | page
            $table->string('source_key', 191);           // stable id within that source
            $table->string('route_name')->nullable();    // where to send the visitor
            $table->string('url')->nullable();
            $table->string('title')->nullable();
            $table->string('title_ar')->nullable();
            $table->string('body_hash', 40)->nullable();
            $table->integer('chunk_count')->default(0);
            $table->timestamp('indexed_at')->nullable();
            $table->timestamps();

            $table->unique(['source_type', 'source_key']);
        });

        // Chunk text plus its packed float32 vector. FULLTEXT shortlists;
        // cosine over the shortlist happens in PHP.
        Schema::create('assistant_chunks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('assistant_document_id')->constrained()->cascadeOnDelete();
            $table->integer('ordinal')->default(0);
            $table->string('lang', 2)->default('en');
            $table->mediumText('content');
            $table->binary('embedding')->nullable();
            $table->smallInteger('dim')->default(0);
            $table->float('norm')->default(0);
            $table->timestamps();

            $table->index(['lang']);
        });

        // MariaDB 10.4 has no vector type; FULLTEXT is the prefilter that keeps
        // the PHP scan small. Added raw because the column is MEDIUMTEXT.
        DB::statement('ALTER TABLE assistant_chunks ADD FULLTEXT assistant_chunks_content_fulltext (content)');

        // Every question, including the ones served from cache. This is the table
        // the Insights screen reads.
        Schema::create('assistant_queries', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('assistant_provider_id')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('session_uid', 64)->nullable();

            $table->text('query');                      // raw, purged after retention_days
            $table->text('query_norm')->nullable();     // PII-masked, lowercased
            $table->string('query_hash', 64)->nullable();
            $table->string('lang', 2)->default('en');

            $table->longText('answer')->nullable();
            $table->text('sources')->nullable();        // json: chunk id, title, url
            $table->string('suggested_route')->nullable();
            $table->float('confidence')->default(0);

            $table->string('model')->nullable();
            $table->string('cache_layer', 16)->default('none'); // none | answer | provider
            $table->integer('latency_ms')->default(0);
            $table->integer('tokens_in')->default(0);
            $table->integer('tokens_out')->default(0);
            $table->integer('tokens_cached')->default(0);
            $table->decimal('cost_usd', 12, 6)->default(0);

            $table->string('status', 16)->default('ok');  // ok | no_answer | error | blocked
            $table->text('error')->nullable();

            $table->string('ip', 45)->nullable();
            $table->string('user_agent')->nullable();
            $table->string('page_url')->nullable();

            $table->tinyInteger('feedback')->nullable();   // 1 helpful, 0 not
            $table->tinyInteger('clicked_route')->default(0);
            $table->timestamps();

            $table->index(['created_at']);
            $table->index(['status', 'lang']);
            $table->index(['query_hash']);
        });

        // Repeat questions never reach the model. Keyed by KB version so a
        // reindex expires every stored answer without a manual flush.
        Schema::create('assistant_answer_caches', function (Blueprint $table) {
            $table->id();
            $table->string('query_hash', 64);
            $table->string('lang', 2)->default('en');
            $table->integer('kb_version')->default(1);
            $table->longText('answer');
            $table->text('sources')->nullable();
            $table->string('suggested_route')->nullable();
            $table->float('confidence')->default(0);
            $table->integer('hits')->default(0);
            $table->timestamp('expires_at')->nullable();
            $table->timestamps();

            $table->unique(['query_hash', 'lang', 'kb_version'], 'assistant_answer_cache_key');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('assistant_answer_caches');
        Schema::dropIfExists('assistant_queries');
        Schema::dropIfExists('assistant_chunks');
        Schema::dropIfExists('assistant_documents');
        Schema::dropIfExists('assistant_providers');
    }
};
