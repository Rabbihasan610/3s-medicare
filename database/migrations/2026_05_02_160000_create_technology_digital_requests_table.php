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
        Schema::create('technology_digital_requests', function (Blueprint $table) {
            $table->id();
            $table->string('full_name');
            $table->string('company_name')->nullable();
            $table->string('job_title')->nullable();
            $table->string('email');
            $table->string('phone')->nullable();
            $table->string('country')->nullable();
            $table->string('city')->nullable();

            $table->text('service_type')->nullable(); // Stores array
            $table->text('project_type')->nullable(); // Stores array
            $table->string('project_name')->nullable();
            $table->text('project_description')->nullable();
            $table->string('estimated_budget')->nullable();
            $table->date('expected_start_date')->nullable();
            $table->string('attachment')->nullable();

            $table->tinyInteger('status')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('technology_digital_requests');
    }
};
