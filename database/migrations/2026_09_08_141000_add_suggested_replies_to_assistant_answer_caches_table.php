<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/*
| Follow-up chips have to survive the answer cache.
|
| Without this column a repeat question is served from cache and silently comes
| back with no suggested replies, so the same question shows chips the first time
| and none the second - a difference the visitor can see and cannot explain.
*/
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('assistant_answer_caches', function (Blueprint $table) {
            $table->text('suggested_replies')->nullable()->after('sources');
        });
    }

    public function down(): void
    {
        Schema::table('assistant_answer_caches', function (Blueprint $table) {
            $table->dropColumn('suggested_replies');
        });
    }
};
