<?php

namespace App\Http\Controllers;

use App\Models\Evaluation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class EvaluationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        $query = Evaluation::query();

        if ($user->role->name === 'admin') {
            // Admin can see all evaluations
        } elseif ($user->role->name === 'encadrant') {
            // Encadrant can see evaluations for stages they are assigned to
            $query->whereHas('stage', function ($q) use ($user) {
                $q->where('encadrant_id', $user->id);
            });
        } elseif ($user->role->name === 'etudiant') {
            // Student can only see their own evaluations
            $query->whereHas('stage', function ($q) use ($user) {
                $q->where('student_id', $user->id);
            });
        } else {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $evaluations = $query->with(['stage.student', 'stage.encadrant', 'stage.offer.entreprise'])->get();
        return response()->json($evaluations);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = Auth::user();

        if ($user->role->name !== 'encadrant') {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $validator = Validator::make($request->all(), [
            'stage_id' => 'required|exists:stages,id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // Check if the encadrant is assigned to the stage
        $stage = \App\Models\Stage::find($request->stage_id);
        if (!$stage || $stage->encadrant_id !== $user->id) {
            return response()->json(['message' => 'Unauthorized to evaluate this stage'], 403);
        }

        $evaluation = Evaluation::create([
            'stage_id' => $request->stage_id,
            'user_id' => $user->id, // The encadrant creating the evaluation
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);

        return response()->json($evaluation, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Evaluation $evaluation)
    {
        $user = Auth::user();

        if ($user->role->name === 'admin') {
            // Admin can view any evaluation
        } elseif ($user->role->name === 'encadrant' && $evaluation->user_id === $user->id) {
            // Encadrant can view their own evaluations
        } elseif ($user->role->name === 'etudiant' && $evaluation->stage->student_id === $user->id) {
            // Student can view evaluations for their own stages
        } else {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        return response()->json($evaluation->load(['stage.student', 'stage.encadrant', 'stage.offer.entreprise']));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Evaluation $evaluation)
    {
        $user = Auth::user();

        if ($user->role->name !== 'encadrant' || $evaluation->user_id !== $user->id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $validator = Validator::make($request->all(), [
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $evaluation->update($request->only(['rating', 'comment']));

        return response()->json($evaluation);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Evaluation $evaluation)
    {
        $user = Auth::user();

        if ($user->role->name === 'admin' || ($user->role->name === 'encadrant' && $evaluation->user_id === $user->id)) {
            $evaluation->delete();
            return response()->json(null, 204);
        }

        return response()->json(['message' => 'Unauthorized'], 403);
    }
}
