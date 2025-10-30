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
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('company_name');
            $table->string('registration_number')->unique(); // SIRET equivalent
            $table->text('description');
            $table->string('industry');
            $table->string('website')->nullable();
            $table->string('phone');
            $table->text('address');
            $table->string('city');
            $table->string('postal_code');
            $table->string('country')->default('Cameroon');
            $table->string('contact_person');
            $table->string('contact_email');
            $table->string('contact_phone');
            $table->string('company_size'); // Small, Medium, Large
            $table->year('founded_year')->nullable();
            $table->timestamps();

            // Indexes for performance
            $table->index('user_id');
            $table->index('industry');
            $table->index('city');
            $table->index('company_size');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('companies');
    }
};