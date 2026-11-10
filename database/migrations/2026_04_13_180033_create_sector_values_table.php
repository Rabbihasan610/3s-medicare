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
        Schema::create('sector_values', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('business_sector_id');
            $table->string('slug');
            $table->string('title');
            $table->string('title_ar');
            $table->text('description')->nullable();
            $table->text('description_ar')->nullable();
            $table->string('image')->nullable();
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->timestamps();

            $table->foreign('business_sector_id')->references('id')->on('business_sectors')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sector_values');
    }
};
