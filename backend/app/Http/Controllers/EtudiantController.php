<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Candidature;
use App\Models\Stage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Routing\Controller as BaseController;

class EtudiantController extends BaseController
{
    use AuthorizesRequests;
    /**
     * Récupérer les statistiques de l'étudiant
     */
    public function getStatistics()
    {
        $etudiant = Auth::user()->etudiant;
        
        $stats = [
            'candidatures_count' => Candidature::where('etudiant_id', $etudiant->id)->count(),
            'pending_count' => Candidature::where('etudiant_id', $etudiant->id)
                ->where('status', 'en_attente')
                ->count(),
            'interviews_count' => Candidature::where('etudiant_id', $etudiant->id)
                ->where('status', 'entretien')
                ->count(),
            'offers_count' => Stage::where('status', 'disponible')->count()
        ];

        return response()->json($stats);
    }

    /**
     * Récupérer les activités récentes de l'étudiant
     */
    public function getActivities()
    {
        $etudiant = Auth::user()->etudiant;
        
        $activities = [];

        // Récupérer les candidatures récentes
        $candidatures = Candidature::where('etudiant_id', $etudiant->id)
            ->with('stage')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        foreach ($candidatures as $candidature) {
            $activity = [
                'type' => 'candidature',
                'title' => 'Candidature envoyée',
                'description' => "Vous avez postulé pour le stage : {$candidature->stage->title}",
                'created_at' => $candidature->created_at,
                'link' => "/etudiant/candidatures/{$candidature->id}"
            ];

            if ($candidature->status === 'entretien') {
                $activities[] = [
                    'type' => 'entretien',
                    'title' => 'Entretien programmé',
                    'description' => "Entretien pour le stage : {$candidature->stage->title}",
                    'created_at' => $candidature->interview_date,
                    'link' => "/etudiant/candidatures/{$candidature->id}"
                ];
            }

            $activities[] = $activity;
        }

        // Trier les activités par date
        usort($activities, function($a, $b) {
            return strtotime($b['created_at']) - strtotime($a['created_at']);
        });

        return response()->json(array_slice($activities, 0, 5));
    }

    /**
     * Récupérer les stages disponibles
     */
    public function getStages()
    {
        $stages = Stage::where('status', 'disponible')
            ->with('entreprise')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return response()->json($stages);
    }

    /**
     * Récupérer les candidatures de l'étudiant
     */
    public function getCandidatures()
    {
        Log::info('getCandidatures called for user: ' . Auth::id());
        $etudiant = Auth::user()->etudiant;
        Log::info('Etudiant found: ', ['id' => $etudiant->id]);

        $candidatures = Candidature::where('etudiant_id', $etudiant->id)
            ->with(['offre', 'offre.entreprise'])
            ->orderBy('created_at', 'desc')
            ->get();

        Log::info('Candidatures fetched: ', ['count' => $candidatures->count(), 'data' => $candidatures->toArray()]);

        return response()->json($candidatures);
    }

    /**
     * Soumettre une nouvelle candidature
     */
    public function submitCandidature(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'stage_id' => 'required|exists:stages,id',
            'lettre_motivation' => 'required|string|min:100',
            'cv' => 'required|file|mimes:pdf|max:2048'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $etudiant = Auth::user()->etudiant;
        
        // Vérifier si une candidature existe déjà
        $existingCandidature = Candidature::where('etudiant_id', $etudiant->id)
            ->where('stage_id', $request->stage_id)
            ->first();

        if ($existingCandidature) {
            return response()->json([
                'message' => 'Vous avez déjà postulé pour ce stage'
            ], 422);
        }

        // Enregistrer le CV
        $cvPath = $request->file('cv')->store('cvs', 'public');

        // Créer la candidature
        $candidature = Candidature::create([
            'etudiant_id' => $etudiant->id,
            'stage_id' => $request->stage_id,
            'lettre_motivation' => $request->lettre_motivation,
            'cv_path' => $cvPath,
            'status' => 'en_attente'
        ]);

        return response()->json([
            'message' => 'Candidature envoyée avec succès',
            'candidature' => $candidature
        ], 201);
    }

    /**
     * Récupérer le profil de l'étudiant
     */
    public function getProfile()
    {
        $user = Auth::user();
        $etudiant = $user->etudiant;

        return response()->json([
            'user' => $user,
            'etudiant' => $etudiant
        ]);
    }

    /**
     * Mettre à jour le profil de l'étudiant
     */
    public function updateProfile(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . Auth::id(),
            'student_id' => 'required|string|unique:etudiants,student_id,' . Auth::user()->etudiant->id,
            'formation' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
            'bio' => 'nullable|string|max:1000',
            'avatar' => 'nullable|image|max:1024'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $user = Auth::user();
        $etudiant = $user->etudiant;

        // Mettre à jour les informations de l'utilisateur
        $user->update([
            'name' => $request->name,
            'email' => $request->email
        ]);

        // Gérer l'upload de l'avatar
        if ($request->hasFile('avatar')) {
            $avatarPath = $request->file('avatar')->store('avatars', 'public');
            $user->update(['avatar' => $avatarPath]);
        }

        // Mettre à jour les informations de l'étudiant
        $etudiant->update([
            'student_id' => $request->student_id,
            'formation' => $request->formation,
            'phone' => $request->phone,
            'address' => $request->address,
            'bio' => $request->bio
        ]);

        return response()->json([
            'message' => 'Profil mis à jour avec succès',
            'user' => $user,
            'etudiant' => $etudiant
        ]);
    }

    public function __construct()
    {
        $this->middleware('auth:api');
        $this->authorizeResource(User::class, 'etudiant');
    }

    public function index()
    {
        $etudiants = User::whereHas('role', function ($query) {
            $query->where('name', 'etudiant');
        })->with(['candidatures.offre', 'stages.offre', 'documents'])->get();

        return response()->json($etudiants);
    }

    public function show(User $etudiant)
    {
        $etudiant->load(['candidatures.offre', 'stages.offre', 'documents']);
        return response()->json($etudiant);
    }

    public function update(Request $request, User $etudiant)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'string|max:255',
            'email' => 'string|email|max:255|unique:users,email,' . $etudiant->id,
            'password' => 'string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $etudiant->update($request->only(['name', 'email', 'password']));

        return response()->json($etudiant);
    }

    public function destroy(User $etudiant)
    {
        $etudiant->delete();

        return response()->json(null, 204);
    }
}