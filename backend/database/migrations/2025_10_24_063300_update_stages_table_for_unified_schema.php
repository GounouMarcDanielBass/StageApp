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
        Schema::table('stages', function (Blueprint $table) {
            // Add offer_id as nullable first
            $table->foreignId('offer_id')->nullable()->constrained('offres')->onDelete('cascade');
        });

        DB::statement('UPDATE stages SET offer_id = (SELECT id FROM offres WHERE id = stages.offre_id)');

        Schema::table('stages', function (Blueprint $table) {
            // Then make it not null
            $table->foreignId('offer_id')->nullable(false)->change();

            // Drop offre_id
            $table->dropForeign(['offre_id']);
            $table->dropColumn('offre_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('stages', function (Blueprint $table) {
            $table->foreignId('offre_id')->constrained('offres')->onDelete('cascade');
            $table->dropForeign(['offer_id']);
            $table->dropColumn('offer_id');
        });
    }
};