<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\User;
use App\Models\Entreprise;
use App\Models\Offre;
use App\Models\Stage;
use App\Models\Document;
use App\Models\Evaluation;
use Illuminate\Support\Facades\Hash;

class TestDataSeeder extends Seeder
{
    public function run()
    {
        // Création des rôles
        $roles = [
            ['name' => 'admin', 'description' => 'Administrateur du système'],
            ['name' => 'entreprise', 'description' => 'Représentant entreprise'],
            ['name' => 'etudiant', 'description' => 'Étudiant en stage'],
            ['name' => 'encadrant', 'description' => 'Encadrant académique']
        ];

        foreach ($roles as $role) {
            Role::create($role);
        }

        // Création des utilisateurs
        $users = [
            [
                'name' => 'Admin Test',
                'email' => 'admin@test.com',
                'password' => Hash::make('password123'),
                'role_id' => 1
            ],
            [
                'name' => 'Entreprise Test',
                'email' => 'entreprise@test.com',
                'password' => Hash::make('password123'),
                'role_id' => 2
            ],
            [
                'name' => 'Étudiant Test',
                'email' => 'etudiant@test.com',
                'password' => Hash::make('password123'),
                'role_id' => 3
            ],
            [
                'name' => 'Encadrant Test',
                'email' => 'encadrant@test.com',
                'password' => Hash::make('password123'),
                'role_id' => 4
            ]
        ];

        foreach ($users as $user) {
            User::create($user);
        }

        // Création des entreprises
        $entreprises = [
            [
                'name' => 'Tech Solutions Cameroun',
                'description' => 'Entreprise de solutions technologiques',
                'address' => 'Douala, Cameroun',
                'phone' => '+237612345678',
                'email' => 'contact@techsolutions.cm',
                'user_id' => 2
            ]
        ];

        foreach ($entreprises as $entreprise) {
            Entreprise::create($entreprise);
        }

        // Création des offres
        $offres = [
            [
                'title' => 'Stage en développement web',
                'description' => 'Stage de 6 mois en développement web',
                'requirements' => 'Connaissance en PHP, JavaScript',
                'duration' => '6 mois',
                'entreprise_id' => 1
            ]
        ];

        foreach ($offres as $offre) {
            Offre::create($offre);
        }

        // Création des stages
        $stages = [
            [
                'start_date' => '2024-01-01',
                'end_date' => '2024-06-30',
                'status' => 'en_cours',
                'offre_id' => 1,
                'user_id' => 3
            ]
        ];

        foreach ($stages as $stage) {
            Stage::create($stage);
        }

        // Création des documents
        $documents = [
            [
                'name' => 'CV Test',
                'path' => 'documents/cv_test.pdf',
                'stage_id' => 1,
                'user_id' => 3
            ]
        ];

        foreach ($documents as $document) {
            Document::create($document);
        }

        // Création des évaluations
        $evaluations = [
            [
                'rating' => 15,
                'comment' => 'Très bon travail',
                'stage_id' => 1,
                'user_id' => 4
            ]
        ];

        foreach ($evaluations as $evaluation) {
            Evaluation::create($evaluation);
        }
    }
}