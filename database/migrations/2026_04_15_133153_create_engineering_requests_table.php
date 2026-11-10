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

        Schema::create('engineering_requests', function (Blueprint $table) {
            $table->id();

            // Applicant Information
            $table->string('company_name');
            $table->string('organisation_name')->nullable();
            $table->string('job_title')->nullable();
            $table->string('email');
            $table->string('phone')->nullable();

            // Services & Project Type
            $table->json('services_required')->nullable();
            $table->json('project_types')->nullable();

            // Project Details
            $table->string('project_name')->nullable();
            $table->string('project_location')->nullable();
            $table->string('approximate_area')->nullable();
            $table->string('estimated_budget')->nullable();
            $table->string('current_project_stage')->nullable();
            $table->longText('project_description')->nullable();
            $table->date('expected_start_date')->nullable();

            // File
            $table->string('attachment')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('engineering_requests');
    }
};
