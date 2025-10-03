<?php

namespace App\Http\Controllers;

use App\Models\Stage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class StageController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function index()
    {
        $user = Auth::user();
        if ($user->role->name === 'admin') {
            $stages = Stage::with(['user', 'offre.entreprise', 'documents'])->get();
        } elseif ($user->role->name === 'entreprise') {
            $stages = Stage::whereHas('offre.entreprise', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            })->with(['user', 'offre.entreprise', 'documents'])->get();
        } else {
            $stages = $user->stages()->with(['offre.entreprise', 'documents'])->get();
        }

        return response()->json($stages);
    }

    public function store(Request $request)
    {
        $this->authorize('create', Stage::class);

        $validator = Validator::make($request->all(), [
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'offre_id' => 'required|integer|exists:offres,id',
            'user_id' => 'required|integer|exists:users,id',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $stage = Stage::create($request->all());

        return response()->json($stage, 201);
    }

    public function show(Stage $stage)
    {
        $this->authorize('view', $stage);
        return response()->json($stage->load(['user', 'offre.entreprise', 'documents', 'evaluations']));
    }

    public function update(Request $request, Stage $stage)
    {
        $this->authorize('update', $stage);

        $validator = Validator::make($request->all(), [
            'start_date' => 'date',
            'end_date' => 'date|after_or_equal:start_date',
            'status' => 'in:ongoing,completed,terminated',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $stage->update($request->all());

        return response()->json($stage);
    }

    public function destroy(Stage $stage)
    {
        $this->authorize('delete', $stage);
        $stage->delete();

        return response()->json(null, 204);
    }
}