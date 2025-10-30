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
        // Drop conflicting tables in order to avoid dependency issues
        Schema::dropIfExists('candidatures');
        Schema::dropIfExists('offres');
        Schema::dropIfExists('offers');
        Schema::dropIfExists('applications');
        Schema::dropIfExists('documents');
        Schema::dropIfExists('candidature_comments');
        Schema::dropIfExists('stages');
        Schema::dropIfExists('evaluations');
        Schema::dropIfExists('notifications');
        Schema::dropIfExists('messages');
        Schema::dropIfExists('etudiants');
        Schema::dropIfExists('encadrants');
        Schema::dropIfExists('entreprises');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // This migration is intended to be a one-way operation to eliminate dual systems
        // Reversing would require recreating the dropped tables, but we don't want to undo the consolidation
        // Instead, we throw an exception to prevent accidental reversal
        throw new Exception('Cannot reverse this migration. Dual tables have been eliminated for unified schema.');
    }
};