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
        Schema::table('entreprises', function (Blueprint $table) {
            // Drop columns only if they exist
            $columnsToDrop = [];
            if (Schema::hasColumn('entreprises', 'email')) {
                $columnsToDrop[] = 'email';
            }
            if (Schema::hasColumn('entreprises', 'name')) {
                $columnsToDrop[] = 'name';
            }
            if (Schema::hasColumn('entreprises', 'description')) {
                $columnsToDrop[] = 'description';
            }
            if (Schema::hasColumn('entreprises', 'address')) {
                $columnsToDrop[] = 'address';
            }
            if (Schema::hasColumn('entreprises', 'phone')) {
                $columnsToDrop[] = 'phone';
            }

            if (!empty($columnsToDrop)) {
                $table->dropColumn($columnsToDrop);
            }

            // Add correct columns
            if (!Schema::hasColumn('entreprises', 'company_name')) {
                $table->string('company_name');
            }
            if (!Schema::hasColumn('entreprises', 'siret')) {
                $table->string('siret')->unique();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('entreprises', function (Blueprint $table) {
            $table->dropColumn(['company_name', 'siret']);
            $table->string('name');
            $table->text('description');
            $table->string('address');
            $table->string('phone');
            $table->string('email')->unique();
        });
    }
};