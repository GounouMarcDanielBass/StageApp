<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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

        return response()->json([
            'userRegistrations' => $userRegistrations,
            'userRoles' => $userRoles,
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
}
