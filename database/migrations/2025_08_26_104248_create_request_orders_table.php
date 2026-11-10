<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('request_orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('service_id');
            $table->string('type');
            $table->json('form_data')->nullable();
            $table->json('form_checkbox')->nullable();
            $table->json('form_radio')->nullable();
            $table->json('form_file')->nullable();
            $table->string('status');
            $table->string('is_seen');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('request_orders');
    }
};
