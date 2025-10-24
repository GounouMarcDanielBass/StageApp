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
            $table->string('path');
            $table->string('type'); // e.g., 'CV', 'Motivation Letter', 'Report'
            $table->string('mime_type'); // e.g., 'application/pdf', 'image/jpeg'
            $table->unsignedBigInteger('size'); // File size in bytes
            $table->string('status')->default('pending'); // e.g., 'pending', 'validated', 'rejected'
            $table->foreignId('student_id')->constrained('etudiants')->onDelete('cascade');
            $table->foreignId('offer_id')->nullable()->constrained('offres')->onDelete('cascade');
            $table->timestamps();
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