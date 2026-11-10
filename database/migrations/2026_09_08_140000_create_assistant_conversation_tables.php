<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/*
| Conversation memory for the AI Help Center.
|
| Until now every question was answered standing alone, which made follow-ups
| ("what about the second one?", "و كم تكلفتها؟") impossible - the retriever saw
| only the words of that one message.
|
| Deliberately kept alongside `assistant_queries` rather than replacing it. That
| table is the cost, token and feedback ledger the Insights screen reads, and it
| stays the system of record for what one turn spent; these two tables add only
| the thread that links turns together. Each message points back at its query
| row so nothing has to be counted twice or kept in sync.
*/
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('assistant_conversations', function (Blueprint $table) {
            $table->id();

            /*
            | Client-generated, held in the browser. This is the widget's only
            | handle on "this conversation", so it is a uuid rather than the
            | sequential id - knowing one thread's handle must say nothing about
            | any other thread's.
            */
            $table->uuid('uuid')->unique();

            $table->unsignedBigInteger('user_id')->nullable()->index();
            $table->string('session_uid', 64)->nullable()->index();

            /*
            | Reporting only. The language of an individual answer lives on the
            | message, because a visitor can switch language mid-thread and each
            | turn is answered in the language of the question that asked it.
            */
            $table->string('locale', 2)->nullable();

            $table->string('ip', 45)->nullable();
            $table->string('user_agent', 500)->nullable();
            $table->unsignedSmallInteger('message_count')->default(0);
            $table->timestamp('last_message_at')->nullable();
            $table->timestamps();

            $table->index('last_message_at');
        });

        Schema::create('assistant_messages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('assistant_conversation_id')
                ->constrained()
                ->cascadeOnDelete();

            // The cost/token/feedback row for this turn. Null on the visitor's
            // own message, and on an assistant turn whose logging failed.
            $table->unsignedBigInteger('assistant_query_id')->nullable()->index();

            $table->string('role', 10);            // user | assistant
            $table->string('lang', 2)->default('en');
            $table->mediumText('content');

            // Which chunks the answer was grounded on, so a follow-up can be
            // re-grounded against the same passages the visitor is referring to.
            $table->text('source_ids')->nullable();

            $table->string('status', 16)->default('ok');   // ok | no_answer | error
            $table->timestamps();

            $table->index(['assistant_conversation_id', 'id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('assistant_messages');
        Schema::dropIfExists('assistant_conversations');
    }
};
