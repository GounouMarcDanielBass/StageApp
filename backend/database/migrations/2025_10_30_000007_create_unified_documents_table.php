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
        Schema::create('documents', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('file_path');
            $table->string('file_type'); // pdf, doc, docx, jpg, png, etc.
            $table->integer('file_size'); // in bytes
            $table->string('mime_type');
            $table->morphs('documentable'); // Polymorphic relationship to attach documents to various models
            $table->string('document_type'); // cv, report, evaluation, contract, etc.
            $table->text('description')->nullable();
            $table->boolean('is_required')->default(false);
            $table->boolean('is_confidential')->default(false);
            $table->timestamp('uploaded_at')->useCurrent();
            $table->foreignId('uploaded_by')->constrained('users')->onDelete('cascade');
            $table->timestamps();

            // Indexes for performance
            $table->index('document_type');
            $table->index('uploaded_by');
            $table->index('uploaded_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('documents');
    }
};