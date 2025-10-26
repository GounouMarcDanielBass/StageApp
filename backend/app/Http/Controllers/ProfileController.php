<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Etudiant;
use App\Models\Entreprise;
use App\Models\Encadrant;

use Illuminate\Support\Facades\Log;
class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function show()
    {
        $user = Auth::user();

        if (!$user) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        Log::info('ProfileController show: Checking if user isEtudiant method exists: ' . (method_exists($user, 'isEtudiant') ? 'Yes' : 'No'));

        $profileData = [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'role' => $user->role->name,
        ];

        if ($user->isEtudiant()) {
            $etudiant = $user->etudiant;
            if ($etudiant) {
                $profileData['student_id'] = $etudiant->student_id;
                $profileData['formation'] = $etudiant->formation;
            }
        } elseif ($user->isEntreprise()) {
            $entreprise = $user->entreprise;
            if ($entreprise) {
                $profileData['company_name'] = $entreprise->company_name;
                $profileData['siret'] = $entreprise->siret;
            }
        } elseif ($user->isEncadrant()) {
            $encadrant = $user->encadrant;
            if ($encadrant) {
                $profileData['department'] = $encadrant->department;
                $profileData['speciality'] = $encadrant->speciality;
            }
        }

        return response()->json($profileData);
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        if (!$user) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'avatar' => 'nullable|string|max:500',
        ];

        if ($user->isEtudiant()) {
            $rules['student_id'] = 'required|string|max:255';
            $rules['formation'] = 'required|string|max:255';
        } elseif ($user->isEntreprise()) {
            $rules['company_name'] = 'required|string|max:255';
            $rules['siret'] = 'required|string|max:255';
        } elseif ($user->isEncadrant()) {
            $rules['department'] = 'required|string|max:255';
            $rules['speciality'] = 'required|string|max:255';
        }

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $user->name = $request->name;
        $user->email = $request->email;
        if ($request->has('avatar')) {
            $user->avatar = $request->avatar;
        }
        $user->save();

        if ($user->isEtudiant()) {
            $etudiant = $user->etudiant;
            if ($etudiant) {
                $etudiant->student_id = $request->student_id;
                $etudiant->formation = $request->formation;
                $etudiant->save();
            }
        } elseif ($user->isEntreprise()) {
            $entreprise = $user->entreprise;
            if ($entreprise) {
                $entreprise->company_name = $request->company_name;
                $entreprise->siret = $request->siret;
                $entreprise->save();
            }
        } elseif ($user->isEncadrant()) {
            $encadrant = $user->encadrant;
            if ($encadrant) {
                $encadrant->department = $request->department;
                $encadrant->speciality = $request->speciality;
                $encadrant->save();
            }
        }

        return response()->json(['message' => 'Profile updated successfully', 'user' => $user->load('role')]);
    }

    public function deleteAccount(Request $request)
    {
        $user = Auth::user();

        if (!$user) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        DB::beginTransaction();
        try {
            // Delete related data
            if ($user->etudiant) {
                $user->etudiant->delete();
            }
            if ($user->entreprise) {
                $user->entreprise->delete();
            }
            if ($user->encadrant) {
                $user->encadrant->delete();
            }

            // Delete notifications
            $user->notifications()->delete();

            // Delete user
            $user->delete();

            DB::commit();
            return response()->json(['message' => 'Account deleted successfully']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => 'Error deleting account'], 500);
        }
    }
}
