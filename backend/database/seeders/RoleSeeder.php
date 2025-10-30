<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            [
                'name' => 'admin',
                'description' => 'System Administrator with full access to all features',
            ],
            [
                'name' => 'student',
                'description' => 'Student user who can apply for internships and manage their applications',
            ],
            [
                'name' => 'company',
                'description' => 'Company representative who can post offers and manage applications',
            ],
            [
                'name' => 'supervisor',
                'description' => 'Academic supervisor who oversees student internships',
            ],
        ];

        foreach ($roles as $role) {
            Role::updateOrCreate(
                ['name' => $role['name']],
                ['description' => $role['description']]
            );
        }
    }
}