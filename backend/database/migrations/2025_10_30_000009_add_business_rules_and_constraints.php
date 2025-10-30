<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // SQLite doesn't support CHECK constraints in ALTER TABLE
        // We implement validation through application logic instead
        // Add additional indexes for better performance

        Schema::table('applications', function (Blueprint $table) {
            $table->index(['student_id', 'status']);
            $table->index(['offer_id', 'status']);
        });

        Schema::table('stages', function (Blueprint $table) {
            $table->index(['status', 'start_date']);
            $table->index(['supervisor_id', 'status']);
        });

        Schema::table('evaluations', function (Blueprint $table) {
            $table->index(['stage_id', 'evaluation_type']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Remove additional indexes
        Schema::table('applications', function (Blueprint $table) {
            $table->dropIndex(['student_id', 'status']);
            $table->dropIndex(['offer_id', 'status']);
        });

        Schema::table('stages', function (Blueprint $table) {
            $table->dropIndex(['status', 'start_date']);
            $table->dropIndex(['supervisor_id', 'status']);
        });

        Schema::table('evaluations', function (Blueprint $table) {
            $table->dropIndex(['stage_id', 'evaluation_type']);
        });
    }
};