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
        Schema::create('investment_services_requests', function (Blueprint $table) {
            $table->id();

            /*
            |--------------------------------------------------------------------------
            | Basic Information
            
            |--------------------------------------------------------------------------
            */
            $table->string('full_name');
            $table->string('company_name')->nullable();
            $table->string('email')->index();
            $table->string('phone', 20)->nullable();
            $table->string('country', 100)->nullable();

            /*
            |--------------------------------------------------------------------------
            | Multi Select Fields (Stored as JSON)
            |--------------------------------------------------------------------------
            */
            $table->json('investor_type')->nullable();
            $table->json('investment_sector')->nullable();
            $table->json('expected_investment_size')->nullable();
            $table->json('partnership_type')->nullable();

            /*
            |--------------------------------------------------------------------------
            | Description
            |--------------------------------------------------------------------------
            */
            $table->text('description')->nullable();

            /*
            |--------------------------------------------------------------------------
            | Timestamps
            |--------------------------------------------------------------------------
            */
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('investment_services_requests');
    }
};
