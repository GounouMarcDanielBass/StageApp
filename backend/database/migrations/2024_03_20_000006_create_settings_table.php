<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Exécuter les migrations.
     */
    public function up(): void
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->json('value');
            $table->timestamps();
        });

        // Insérer les paramètres par défaut
        DB::table('settings')->insert([
            [
                'key' => 'site_name',
                'value' => json_encode('Gestion des Stages'),
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'key' => 'maintenance_mode',
                'value' => json_encode(false),
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'key' => 'registration_enabled',
                'value' => json_encode(true),
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'key' => 'default_pagination',
                'value' => json_encode(10),
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'key' => 'email_notifications',
                'value' => json_encode(true),
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'key' => 'file_types',
                'value' => json_encode(['pdf', 'doc', 'docx']),
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'key' => 'file_size_limit',
                'value' => json_encode(2048), // 2MB
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);
    }

    /**
     * Annuler les migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};