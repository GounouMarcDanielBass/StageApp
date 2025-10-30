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
        Schema::create('supervisors', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('department');
            $table->string('specialization');
            $table->string('academic_title'); // Professor, Lecturer, etc.
            $table->string('phone')->nullable();
            $table->string('office_location')->nullable();
            $table->text('bio')->nullable();
            $table->boolean('is_available_for_supervision')->default(true);
            $table->integer('max_students')->default(5);
            $table->timestamps();

            // Indexes for performance
            $table->index('user_id');
            $table->index('department');
            $table->index('specialization');
            $table->index('is_available_for_supervision');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('supervisors');
    }
};