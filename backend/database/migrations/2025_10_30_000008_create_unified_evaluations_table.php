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
        Schema::create('evaluations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('stage_id')->constrained('stages')->onDelete('cascade');
            $table->foreignId('evaluator_id')->constrained('users')->onDelete('cascade');
            $table->enum('evaluation_type', ['mid_term', 'final', 'monthly', 'weekly'])->default('final');
            $table->date('evaluation_date');
            $table->integer('technical_skills_rating')->nullable(); // 1-5 scale
            $table->integer('work_quality_rating')->nullable(); // 1-5 scale
            $table->integer('communication_rating')->nullable(); // 1-5 scale
            $table->integer('punctuality_rating')->nullable(); // 1-5 scale
            $table->integer('teamwork_rating')->nullable(); // 1-5 scale
            $table->integer('overall_rating'); // 1-5 scale
            $table->text('strengths')->nullable();
            $table->text('areas_for_improvement')->nullable();
            $table->text('comments')->nullable();
            $table->text('recommendations')->nullable();
            $table->boolean('is_confidential')->default(false);
            $table->timestamp('submitted_at')->useCurrent();
            $table->timestamps();

            // Indexes for performance
            $table->index('stage_id');
            $table->index('evaluator_id');
            $table->index('evaluation_type');
            $table->index('evaluation_date');
            $table->index('overall_rating');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('evaluations');
    }
};