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
       Schema::create('opportunities_requests', function (Blueprint $table) {
            $table->id();

            // Investor Information
            $table->string('full_name');
            $table->string('company_name')->nullable();
            $table->string('job_title')->nullable();
            $table->string('email');
            $table->string('phone')->nullable();
            $table->string('country')->nullable();
            $table->string('city')->nullable();

            // Investor Interest
            $table->string('investment_sector')->nullable();
            $table->string('expected_investment_size')->nullable();
            $table->string('targeted_country')->nullable();
            $table->text('additional_details')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('opportunities_requests');
    }
};
