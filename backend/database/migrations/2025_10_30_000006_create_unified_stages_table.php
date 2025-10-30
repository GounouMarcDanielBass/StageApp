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
        Schema::create('stages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('application_id')->constrained('applications')->onDelete('cascade');
            $table->foreignId('supervisor_id')->constrained('supervisors')->onDelete('cascade');
            $table->date('start_date');
            $table->date('end_date');
            $table->date('actual_start_date')->nullable();
            $table->date('actual_end_date')->nullable();
            $table->enum('status', ['assigned', 'ongoing', 'completed', 'terminated', 'extended'])->default('assigned');
            $table->text('objectives')->nullable();
            $table->text('supervisor_notes')->nullable();
            $table->text('student_notes')->nullable();
            $table->integer('progress_percentage')->default(0); // 0-100
            $table->string('final_grade')->nullable(); // A, B, C, etc.
            $table->text('completion_report')->nullable();
            $table->decimal('stipend_amount', 8, 2)->nullable();
            $table->string('stipend_frequency')->nullable(); // Monthly, Bi-weekly, etc.
            $table->boolean('is_paid')->default(false);
            $table->timestamps();

            // Indexes for performance
            $table->index('application_id');
            $table->index('supervisor_id');
            $table->index('status');
            $table->index('start_date');
            $table->index('end_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stages');
    }
};