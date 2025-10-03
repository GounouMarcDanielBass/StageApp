<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CompanyController extends Controller
{
    public function dashboard()
    {
        $company = Auth::user();

        // Mock data for now
        $active_offers_count = 5;
        $applications_count = 25;
        $interns_count = 3;

        $recent_applications = [
            [
                'student_name' => 'John Doe',
                'offer_title' => 'Développeur Web',
                'date' => '2023-10-27',
                'status' => 'En attente',
            ],
            [
                'student_name' => 'Jane Smith',
                'offer_title' => 'Marketing Digital',
                'date' => '2023-10-26',
                'status' => 'Accepté',
            ],
        ];

        return response()->json([
            'active_offers_count' => $active_offers_count,
            'applications_count' => $applications_count,
            'interns_count' => $interns_count,
            'recent_applications' => $recent_applications,
        ]);
    }
}