<?php

namespace App\Http\Controllers;

use App\Models\Offre;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class OffreController extends Controller
{

    public function index()
    {
        $offres = Offre::with('entreprise')->get();
        return view('offres.index', compact('offres'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'requirements' => 'required|string',
            'type' => 'required|string',
            'duration' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'entreprise_id' => 'required|integer|exists:entreprises,id',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $offre = Offre::create($request->all());

        return response()->json($offre, 201);
    }

    public function show(Offre $offre)
    {
        return response()->json($offre->load('entreprise'));
    }

    public function update(Request $request, Offre $offre)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'string|max:255',
            'description' => 'string',
            'requirements' => 'string',
            'type' => 'string',
            'duration' => 'string',
            'start_date' => 'date',
            'end_date' => 'date|after_or_equal:start_date',
            'status' => 'in:active,inactive',
            'entreprise_id' => 'integer|exists:entreprises,id',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $offre->update($request->all());

        return response()->json($offre);
    }

    public function destroy(Offre $offre)
    {
        $offre->delete();

        return response()->json(null, 204);
    }
}
