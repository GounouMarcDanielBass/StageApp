<?php

namespace Database\Seeders;

use App\Models\Candidature;
use App\Models\Document;
use App\Models\Encadrant;
use App\Models\Entreprise;
use App\Models\Etudiant;
use App\Models\Evaluation;
use App\Models\Message;
use App\Models\Notification;
use App\Models\Offre;
use App\Models\Role;
use App\Models\Stage;
use App\Models\User;
use Illuminate\Database\Seeder;

class ComprehensiveSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Seed Roles
        $roles = ['etudiant', 'entreprise', 'encadrant', 'admin'];
        foreach ($roles as $role) {
            Role::firstOrCreate(['name' => $role]);
        }

        // Seed Users
        $roleEtudiant = Role::where('name', 'etudiant')->first();
        $roleEntreprise = Role::where('name', 'entreprise')->first();
        $roleEncadrant = Role::where('name', 'encadrant')->first();
        $roleAdmin = Role::where('name', 'admin')->first();

        $etudiantUsers = User::factory()->count(5)->for($roleEtudiant)->create();
        $entrepriseUsers = User::factory()->count(5)->for($roleEntreprise)->create();
        $encadrantUsers = User::factory()->count(5)->for($roleEncadrant)->create();
        $adminUsers = User::factory()->count(5)->for($roleAdmin)->create();

        // Seed Etudiants
        $etudiants = [];
        foreach ($etudiantUsers as $user) {
            $etudiants[] = Etudiant::factory()->create(['user_id' => $user->id]);
        }

        // Seed Entreprises
        $entreprises = [];
        foreach ($entrepriseUsers as $user) {
            $entreprises[] = Entreprise::factory()->create(['user_id' => $user->id]);
        }

        // Seed Encadrants
        $encadrants = [];
        foreach ($encadrantUsers as $user) {
            $encadrants[] = Encadrant::factory()->create(['user_id' => $user->id]);
        }

        // Seed Offres
        $offres = [];
        foreach ($entreprises as $entreprise) {
            $offres = array_merge($offres, Offre::factory()->count(2)->create(['entreprise_id' => $entreprise->id])->all());
        }

        // Seed Candidatures
        $candidatures = [];
        foreach ($etudiants as $etudiant) {
            foreach (array_slice($offres, 0, 2) as $offre) {
                $candidatures[] = Candidature::factory()->create([
                    'user_id' => $etudiant->user_id,
                    'offre_id' => $offre->id,
                ]);
            }
        }

        // Seed Stages
        $stages = [];
        foreach (array_slice($candidatures, 0, 5) as $candidature) {
            $stages[] = Stage::factory()->create([
                'offre_id' => $candidature->offre_id,
                'user_id' => $candidature->user_id,
            ]);
        }

        // Seed Documents
        foreach ($stages as $stage) {
            Document::factory()->count(2)->create(['stage_id' => $stage->id]);
        }

        // Seed Evaluations
        foreach ($stages as $stage) {
            Evaluation::factory()->create(['stage_id' => $stage->id]);
        }

        // Seed Notifications
        $users = array_merge($etudiantUsers->all(), $entrepriseUsers->all(), $encadrantUsers->all(), $adminUsers->all());
        foreach ($users as $user) {
            Notification::factory()->count(3)->create(['user_id' => $user->id]);
        }

        // Seed Messages
        foreach ($etudiantUsers as $etudiantUser) {
            foreach ($encadrantUsers as $encadrantUser) {
                Message::factory()->count(2)->create([
                    'sender_id' => $etudiantUser->id,
                    'receiver_id' => $encadrantUser->id,
                ]);
                Message::factory()->count(2)->create([
                    'sender_id' => $encadrantUser->id,
                    'receiver_id' => $etudiantUser->id,
                ]);
            }
        }
    }
}