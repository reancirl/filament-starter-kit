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
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
        
            // Personal Information
            $table->foreignId('instance_id');
            $table->string('first_name', 100);
            $table->string('last_name', 100);
            $table->string('middle_name', 100)->nullable();
            $table->date('date_of_birth')->nullable();
            $table->string('email', 255)->nullable()->unique();
            $table->string('phone', 50)->nullable();
        
            // Address Information
            $table->text('google_maps_link')->nullable();
            $table->string('city', 255)->nullable();
            $table->string('zip_code', 20)->nullable();
            $table->string('province', 255)->nullable();
            $table->string('barangay', 255)->nullable();
            $table->string('street', 255)->nullable();
            $table->string('house_number', 100)->nullable();
            $table->string('landmark', 100)->nullable();
            $table->string('country', 100)->default('Philippines');  // Default country
             
            $table->timestamps();
        });        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
