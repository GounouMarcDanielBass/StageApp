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
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('student_number')->unique();
            $table->string('university');
            $table->string('field_of_study');
            $table->string('educational_level'); // Bachelor's, Master's, etc.
            $table->year('graduation_year')->nullable();
            $table->string('phone')->nullable();
            $table->text('bio')->nullable();
            $table->timestamps();

            // Indexes for performance
            $table->index('user_id');
            $table->index('university');
            $table->index('field_of_study');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};