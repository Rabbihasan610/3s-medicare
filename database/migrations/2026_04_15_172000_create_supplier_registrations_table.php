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
        Schema::create('supplier_registrations', function (Blueprint $table) {
            $table->id();
            $table->string('company_name');
            $table->string('business_type')->nullable();
            $table->string('country')->nullable();
            $table->string('city')->nullable();
            $table->string('website')->nullable();

            $table->string('responsible_person_name');
            $table->string('job_title')->nullable();
            $table->string('email');
            $table->string('phone')->nullable();

            $table->json('supply_area')->nullable();
            $table->text('product_description')->nullable();
            $table->json('supply_scope')->nullable();
            $table->text('certifications')->nullable();

            $table->string('company_profile')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('supplier_registrations');
    }
};

