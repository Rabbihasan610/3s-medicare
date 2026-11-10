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
        /*
        | This table already exists on environments where it was created outside
        | the migration - from database/amlaek_test.sql, or by hand - without the
        | corresponding row ever being written to `migrations`.
        |
        | The effect was that `php artisan migrate` aborted here with "table
        | already exists" and refused to run ANY later migration, so every
        | subsequent schema change had to be applied one at a time with --path.
        |
        | Guarding the create makes the migration idempotent: it still builds the
        | table on a fresh database, and simply records itself as run where the
        | table is already present. The live table was verified column for column
        | against the definition below before this guard was added.
        */
        if (Schema::hasTable('strategic_procurement_requests')) {
            return;
        }

        Schema::create('strategic_procurement_requests', function (Blueprint $table) {
            $table->id();
            $table->string('full_name');
            $table->string('company_name')->nullable();
            $table->string('job_title')->nullable();
            $table->string('email');
            $table->string('phone')->nullable();
            $table->string('country')->nullable();

            $table->text('request_type')->nullable(); // Stores array
            $table->text('sector')->nullable();       // Stores array
            $table->text('product_description')->nullable();
            $table->string('approx_quantity')->nullable();
            $table->string('delivery_location')->nullable();
            $table->date('expected_supply_date')->nullable();
            $table->text('additional_details')->nullable();
            $table->string('attachment')->nullable();

            $table->integer('status')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('strategic_procurement_requests');
    }
};
