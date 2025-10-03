<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class EncadrantController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
        $this->authorizeResource(User::class, 'encadrant');
    }

    public function index()
    {
        $encadrants = User::whereHas('role', function ($query) {
            $query->where('name', 'encadrant');
        })->with('stages')->get();

        return response()->json($encadrants);
    }

    public function show(User $encadrant)
    {
        $encadrant->load('stages');
        return response()->json($encadrant);
    }

    public function update(Request $request, User $encadrant)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'string|max:255',
            'email' => 'string|email|max:255|unique:users,email,' . $encadrant->id,
            'password' => 'string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $encadrant->update($request->only(['name', 'email', 'password']));

        return response()->json($encadrant);
    }

    public function destroy(User $encadrant)
    {
        $encadrant->delete();

        return response()->json(null, 204);
    }

    public function dashboard()
    {
        $encadrant = Auth::user();

        // Mock data for now
        $supervised_students_count = 8;
        $pending_reports_count = 4;
        $final_evaluations_count = 2;

        $documents_to_validate = [
            [
                'student_name' => 'Alice Martin',
                'document_type' => 'Rapport de mi-stage',
                'submission_date' => '2023-10-25',
            ],
            [
                'student_name' => 'Bob Durand',
                'document_type' => 'Rapport final',
                'submission_date' => '2023-10-24',
            ],
        ];

        return response()->json([
            'supervised_students_count' => $supervised_students_count,
            'pending_reports_count' => $pending_reports_count,
            'final_evaluations_count' => $final_evaluations_count,
            'documents_to_validate' => $documents_to_validate,
        ]);
    }
}
