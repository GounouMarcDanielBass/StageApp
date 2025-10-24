<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Offre;
use App\Models\Application;
use App\Models\Stage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function admin()
    {
        $userRegistrations = User::select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as count'))
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->get();

        $userRoles = User::join('roles', 'users.role_id', '=', 'roles.id')
            ->select('roles.name', DB::raw('count(*) as count'))
            ->groupBy('roles.name')
            ->get();

        // Offers statistics
        $offersByMonth = Offre::select(DB::raw('DATE_FORMAT(created_at, "%Y-%m") as month'), DB::raw('count(*) as count'))
            ->groupBy('month')
            ->orderBy('month', 'asc')
            ->get();

        $offerStatuses = Offre::select('status', DB::raw('count(*) as count'))
            ->groupBy('status')
            ->get();

        // Applications statistics
        $applicationsByMonth = Application::select(DB::raw('DATE_FORMAT(created_at, "%Y-%m") as month'), DB::raw('count(*) as count'))
            ->groupBy('month')
            ->orderBy('month', 'asc')
            ->get();

        $applicationStatuses = Application::select('status', DB::raw('count(*) as count'))
            ->groupBy('status')
            ->get();

        // Stages statistics
        $stagesByMonth = Stage::select(DB::raw('DATE_FORMAT(created_at, "%Y-%m") as month'), DB::raw('count(*) as count'))
            ->groupBy('month')
            ->orderBy('month', 'asc')
            ->get();

        $stageStatuses = Stage::select('status', DB::raw('count(*) as count'))
            ->groupBy('status')
            ->get();

        return response()->json([
            'userRegistrations' => $userRegistrations,
            'userRoles' => $userRoles,
            'offers' => [
                'byMonth' => $offersByMonth,
                'statuses' => $offerStatuses,
            ],
            'applications' => [
                'byMonth' => $applicationsByMonth,
                'statuses' => $applicationStatuses,
            ],
            'stages' => [
                'byMonth' => $stagesByMonth,
                'statuses' => $stageStatuses,
            ],
        ]);
    }

    public function student()
    {
        return view('student.dashboard');
    }

    public function company()
    {
        return view('company.dashboard');
    }

    public function teacher()
    {
        return view('teacher.dashboard');
    }

    public function companyStats()
    {
        $user = Auth::user();

        // Assuming entreprise model is linked
        $entreprise = $user->entreprise;

        if (!$entreprise) {
            return response()->json(['error' => 'Entreprise not found'], 404);
        }

        // Offers statistics for the company
        $offersByMonth = Offre::where('entreprise_id', $entreprise->id)
            ->select(DB::raw('DATE_FORMAT(created_at, "%Y-%m") as month'), DB::raw('count(*) as count'))
            ->groupBy('month')
            ->orderBy('month', 'asc')
            ->get();

        $offerStatuses = Offre::where('entreprise_id', $entreprise->id)
            ->select('status', DB::raw('count(*) as count'))
            ->groupBy('status')
            ->get();

        // Applications for the company's offers
        $applicationsByMonth = Application::whereHas('offer', function ($query) use ($entreprise) {
            $query->where('entreprise_id', $entreprise->id);
        })->select(DB::raw('DATE_FORMAT(created_at, "%Y-%m") as month'), DB::raw('count(*) as count'))
            ->groupBy('month')
            ->orderBy('month', 'asc')
            ->get();

        $applicationStatuses = Application::whereHas('offer', function ($query) use ($entreprise) {
            $query->where('entreprise_id', $entreprise->id);
        })->select('status', DB::raw('count(*) as count'))
            ->groupBy('status')
            ->get();

        return response()->json([
            'offers' => [
                'byMonth' => $offersByMonth,
                'statuses' => $offerStatuses,
            ],
            'applications' => [
                'byMonth' => $applicationsByMonth,
                'statuses' => $applicationStatuses,
            ],
        ]);
    }

    public function studentStats()
    {
        $user = Auth::user();

        // Applications statistics for the student
        $applicationsByMonth = Application::where('student_id', $user->id)
            ->select(DB::raw('DATE_FORMAT(created_at, "%Y-%m") as month'), DB::raw('count(*) as count'))
            ->groupBy('month')
            ->orderBy('month', 'asc')
            ->get();

        $applicationStatuses = Application::where('student_id', $user->id)
            ->select('status', DB::raw('count(*) as count'))
            ->groupBy('status')
            ->get();

        // Stages for the student
        $stagesByMonth = Stage::where('user_id', $user->id)
            ->select(DB::raw('DATE_FORMAT(created_at, "%Y-%m") as month'), DB::raw('count(*) as count'))
            ->groupBy('month')
            ->orderBy('month', 'asc')
            ->get();

        $stageStatuses = Stage::where('user_id', $user->id)
            ->select('status', DB::raw('count(*) as count'))
            ->groupBy('status')
            ->get();

        return response()->json([
            'applications' => [
                'byMonth' => $applicationsByMonth,
                'statuses' => $applicationStatuses,
            ],
            'stages' => [
                'byMonth' => $stagesByMonth,
                'statuses' => $stageStatuses,
            ],
        ]);
    }
}
