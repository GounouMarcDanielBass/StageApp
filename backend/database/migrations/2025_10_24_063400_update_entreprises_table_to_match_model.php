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
            // Drop existing columns that don't match the model
            $table->dropColumn(['name', 'description', 'address', 'phone', 'email']);
            // Add correct columns
            $table->string('company_name');
            $table->string('siret')->unique();
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