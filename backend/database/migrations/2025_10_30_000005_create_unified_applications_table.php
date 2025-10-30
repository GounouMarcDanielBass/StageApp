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
        Schema::create('applications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('students')->onDelete('cascade');
            $table->foreignId('offer_id')->constrained('offers')->onDelete('cascade');
            $table->enum('status', ['pending', 'under_review', 'shortlisted', 'accepted', 'rejected', 'withdrawn'])->default('pending');
            $table->text('motivation_letter')->nullable();
            $table->string('cv_path')->nullable();
            $table->text('additional_documents')->nullable(); // JSON array of document paths
            $table->text('company_notes')->nullable();
            $table->text('student_notes')->nullable();
            $table->timestamp('submitted_at')->useCurrent();
            $table->timestamp('reviewed_at')->nullable();
            $table->foreignId('reviewed_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();

            // Unique constraint to prevent duplicate applications
            $table->unique(['student_id', 'offer_id']);

            // Indexes for performance
            $table->index('student_id');
            $table->index('offer_id');
            $table->index('status');
            $table->index('submitted_at');
            $table->index('reviewed_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('applications');
    }
};