<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/*
| Sender identity for system notification emails. Until now the "from" name was
| always the site name and there was no reply-to or signature at all, so those
| could not be changed without editing code.
*/
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('general_settings', function (Blueprint $table) {
            if (!Schema::hasColumn('general_settings', 'email_from_name')) {
                $table->string('email_from_name', 191)->nullable()->after('email_from');
            }
            if (!Schema::hasColumn('general_settings', 'email_reply_to')) {
                $table->string('email_reply_to', 191)->nullable()->after('email_from_name');
            }
            if (!Schema::hasColumn('general_settings', 'email_signature')) {
                $table->text('email_signature')->nullable()->after('email_reply_to');
            }
            if (!Schema::hasColumn('general_settings', 'email_signature_ar')) {
                $table->text('email_signature_ar')->nullable()->after('email_signature');
            }
        });

        // Seed the from-name with the current behaviour so nothing changes on upgrade.
        DB::table('general_settings')
            ->whereNull('email_from_name')
            ->update(['email_from_name' => DB::raw('site_name')]);
    }

    public function down(): void
    {
        Schema::table('general_settings', function (Blueprint $table) {
            foreach (['email_from_name', 'email_reply_to', 'email_signature', 'email_signature_ar'] as $column) {
                if (Schema::hasColumn('general_settings', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
