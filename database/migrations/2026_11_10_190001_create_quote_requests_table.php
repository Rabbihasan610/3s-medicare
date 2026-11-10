<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('quote_requests', function (Blueprint $table) {
            $table->id();
            $table->string('name', 120);
            $table->string('email', 120);
            $table->string('phone', 30)->nullable();
            $table->string('client_type', 50); // Doctor, Hospital, Clinic, Diagnostic Center
            $table->json('services')->nullable(); // ['Website', 'SEO', 'Marketing', etc.]
            $table->text('message');
            $table->string('status', 20)->default('pending'); // pending, contacted, completed, rejected
            $table->text('admin_notes')->nullable();
            $table->string('ip_address', 45)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('quote_requests');
    }
};

