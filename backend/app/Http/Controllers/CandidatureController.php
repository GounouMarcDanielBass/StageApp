<?php

namespace App\Http\Controllers;

use App\Models\Candidature;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class CandidatureController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function index()
    {
        $user = Auth::user();
        if ($user->role->name === 'admin' || $user->role->name === 'entreprise') {
            $candidatures = Candidature::with(['user', 'offre'])->get();
        } else {
            $candidatures = $user->candidatures()->with('offre')->get();
        }
        return response()->json($candidatures);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'offre_id' => 'required|integer|exists:offres,id',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $candidature = Candidature::create([
            'user_id' => Auth::id(),
            'offre_id' => $request->offre_id,
            'status' => 'pending',
        ]);

        return response()->json($candidature, 201);
    }

    public function show(Candidature $candidature)
    {
        $this->authorize('view', $candidature);
        return response()->json($candidature->load(['user', 'offre']));
    }

    public function update(Request $request, Candidature $candidature)
    {
        $this->authorize('update', $candidature);

        $validator = Validator::make($request->all(), [
            'status' => 'required|in:pending,accepted,rejected',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $candidature->update($request->only('status'));

        return response()->json($candidature);
    }

    public function destroy(Candidature $candidature)
    {
        $this->authorize('delete', $candidature);
        $candidature->delete();

        return response()->json(null, 204);
    }
}
