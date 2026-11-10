<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('healthcare_services', function (Blueprint $table) {
            $table->id();
            $table->string('group_key', 50); // digital_presence, marketing_creative, patient_services
            $table->string('group_name', 100);
            $table->string('title', 120);
            $table->string('slug', 140)->unique();
            $table->string('icon', 50)->default('bi-window');
            $table->text('short_description');
            $table->longText('description')->nullable();
            $table->string('image')->nullable();
            $table->integer('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('healthcare_services');
    }
};

