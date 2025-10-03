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
use App\Models\Offer;

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
        $admin = User::create([
            'name' => 'Admin IUC',
            'email' => 'admin@iuc.cm',
            'password' => Hash::make('password'),
            'role_id' => $roleAdmin->id,
        ]);

        // Create Student Users
        $etudiant1 = User::create([
            'name' => 'Yannick Noah',
            'email' => 'yannick.noah@iuc.cm',
            'password' => Hash::make('password'),
            'role_id' => $roleEtudiant->id,
        ]);
        Etudiant::create([
            'user_id' => $etudiant1->id,
            'student_id' => 'IUC2024001',
            'formation' => 'Génie Logiciel',
        ]);

        $etudiant2 = User::create([
            'name' => 'Brenda Biya',
            'email' => 'brenda.biya@iuc.cm',
            'password' => Hash::make('password'),
            'role_id' => $roleEtudiant->id,
        ]);
        Etudiant::create([
            'user_id' => $etudiant2->id,
            'student_id' => 'IUC2024002',
            'formation' => 'Réseaux et Télécommunications',
        ]);

        // Create Company Users
        $entreprise1 = User::create([
            'name' => 'MTN Cameroon',
            'email' => 'hr@mtn.cm',
            'password' => Hash::make('password'),
            'role_id' => $roleEntreprise->id,
        ]);
        Entreprise::create([
            'user_id' => $entreprise1->id,
            'company_name' => 'MTN Cameroon',
            'siret' => 'MTN-CM-12345',
        ]);

        $entreprise2 = User::create([
            'name' => 'Orange Cameroun',
            'email' => 'recrutement@orange.cm',
            'password' => Hash::make('password'),
            'role_id' => $roleEntreprise->id,
        ]);
        Entreprise::create([
            'user_id' => $entreprise2->id,
            'company_name' => 'Orange Cameroun',
            'siret' => 'ORANGE-CM-67890',
        ]);

        // Create Encadrant User
        $encadrant = User::create([
            'name' => 'Professeur Ngando',
            'email' => 'prof.ngando@iuc.cm',
            'password' => Hash::make('password'),
            'role_id' => $roleEncadrant->id,
        ]);
        Encadrant::create([
            'user_id' => $encadrant->id,
            'department' => 'Département Informatique',
            'speciality' => 'Intelligence Artificielle',
        ]);

        // Create Internship Offers
        Offer::create([
            'company_id' => $entreprise1->id,
            'title' => 'Stage en Développement Web',
            'description' => 'Nous recherchons un stagiaire passionné par le développement web pour rejoindre notre équipe.',
            'requirements' => 'PHP, Laravel, Vue.js',
            'location' => 'Douala',
            'duration' => '3-6 mois',
            'status' => 'active',
        ]);

        Offer::create([
            'company_id' => $entreprise2->id,
            'title' => 'Stage en Réseaux et Sécurité',
            'description' => 'Participez à la gestion et à la sécurisation de notre infrastructure réseau.',
            'requirements' => 'Cisco, Firewall, VPN',
            'location' => 'Yaoundé',
            'duration' => '4 mois',
            'status' => 'active',
        ]);
    }
}
