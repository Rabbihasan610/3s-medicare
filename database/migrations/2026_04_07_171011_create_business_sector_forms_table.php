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
        Schema::create('business_sector_forms', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('name_ar');
            $table->string('type')->default('text');
            $table->string('required')->default('no')->nullable();
            $table->string('placeholder')->nullable();
            $table->string('placeholder_ar')->nullable();
            $table->json('options')->nullable();
            $table->json('options_ar')->nullable();
            $table->integer('col')->default(12)->nullable();
            $table->foreignId('service_id');
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('business_sector_forms');
    }
};
