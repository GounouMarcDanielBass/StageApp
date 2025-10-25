<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Role;
use App\Models\Entreprise;
use App\Models\Etudiant;
use App\Models\Encadrant;
use App\Models\Offre;

class CameroonDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create Roles
        $roleAdmin = Role::firstOrCreate(['name' => 'admin']);
        $roleEtudiant = Role::firstOrCreate(['name' => 'etudiant']);
        $roleEntreprise = Role::firstOrCreate(['name' => 'entreprise']);
        $roleEncadrant = Role::firstOrCreate(['name' => 'encadrant']);

        // Create Admin User
        $admin = User::updateOrCreate([
            'email' => 'admin@iuc.cm',
        ], [
            'name' => 'Admin IUC',
            'password' => Hash::make('password'),
            'role_id' => $roleAdmin->id,
        ]);

        // Create Student Users
        $etudiant1 = User::updateOrCreate([
            'email' => 'yannick.noah@iuc.cm',
        ], [
            'name' => 'Yannick Noah',
            'password' => Hash::make('password'),
            'role_id' => $roleEtudiant->id,
        ]);
        Etudiant::updateOrCreate([
            'user_id' => $etudiant1->id,
        ], [
            'student_id' => 'IUC2024001',
            'formation' => 'Génie Logiciel',
        ]);

        $etudiant2 = User::updateOrCreate([
            'email' => 'brenda.biya@iuc.cm',
        ], [
            'name' => 'Brenda Biya',
            'password' => Hash::make('password'),
            'role_id' => $roleEtudiant->id,
        ]);
        Etudiant::updateOrCreate([
            'user_id' => $etudiant2->id,
        ], [
            'student_id' => 'IUC2024002',
            'formation' => 'Réseaux et Télécommunications',
        ]);

        // Create Company Users
        $entreprise1 = User::updateOrCreate([
            'email' => 'hr@mtn.cm',
        ], [
            'name' => 'MTN Cameroon',
            'password' => Hash::make('password'),
            'role_id' => $roleEntreprise->id,
        ]);
        Entreprise::updateOrCreate([
            'user_id' => $entreprise1->id,
        ], [
            'company_name' => 'MTN Cameroon',
            'siret' => '123456789',
        ]);

        $entrepriseUser2 = User::updateOrCreate([
            'email' => 'recrutement@orange.cm',
        ], [
            'name' => 'Orange Cameroun',
            'password' => Hash::make('password'),
            'role_id' => $roleEntreprise->id,
        ]);
        $entreprise2 = Entreprise::updateOrCreate([
            'user_id' => $entrepriseUser2->id,
        ], [
            'company_name' => 'Orange Cameroun',
            'siret' => '987654321',
        ]);

        // Create Encadrant User
        $encadrant = User::updateOrCreate([
            'email' => 'prof.ngando@iuc.cm',
        ], [
            'name' => 'Professeur Ngando',
            'password' => Hash::make('password'),
            'role_id' => $roleEncadrant->id,
        ]);
        Encadrant::updateOrCreate([
            'user_id' => $encadrant->id,
        ], [
            'department' => 'Département Informatique',
            'speciality' => 'Intelligence Artificielle',
        ]);

        // Create Internship Offers
        Offre::updateOrCreate([
            'company_id' => $entreprise2->id,
            'title' => 'Stage en Développement Web',
        ], [
            'description' => 'Nous recherchons un stagiaire passionné par le développement web pour rejoindre notre équipe.',
            'requirements' => 'PHP, Laravel, Vue.js',
            'location' => 'Douala',
            'duration' => '3-6 mois',
            'status' => 'active',
        ]);

        Offre::updateOrCreate([
            'company_id' => $entreprise2->id,
            'title' => 'Stage en Réseaux et Sécurité',
        ], [
            'description' => 'Participez à la gestion et à la sécurisation de notre infrastructure réseau.',
            'requirements' => 'Cisco, Firewall, VPN',
            'location' => 'Yaoundé',
            'duration' => '4 mois',
            'status' => 'active',
        ]);
    }
}
