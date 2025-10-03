<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        // Mock data for now
        $users_count = User::count();
        $companies_count = User::whereHas('roles', function ($query) {
            $query->where('name', 'entreprise');
        })->count();
        $internships_count = 0; // Replace with actual internship count

        $recent_activities = [
            [
                'user' => 'John Doe',
                'activity' => 'Created a new account',
                'date' => '2023-10-26',
            ],
            [
                'user' => 'Jane Smith',
                'activity' => 'Applied for an internship',
                'date' => '2023-10-25',
            ],
        ];

        return response()->json([
            'users_count' => $users_count,
            'companies_count' => $companies_count,
            'internships_count' => $internships_count,
            'recent_activities' => $recent_activities,
        ]);
    }
}