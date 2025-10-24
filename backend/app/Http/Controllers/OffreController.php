<?php

namespace App\Http\Controllers;

use App\Models\Offer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class OffreController extends Controller
{

    public function index()
    {
        $offers = Offer::with('entreprise')->get();
        return response()->json($offers);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'requirements' => 'required|string',
            'location' => 'required|string',
            'duration' => 'required|string',
            'status' => 'in:pending,active,closed',
            'entreprise_id' => 'required|integer|exists:entreprises,id',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $offre = Offer::create($request->all());

        return response()->json($offre, 201);
    }

    public function show(Offer $offre)
    {
        return response()->json($offre->load('entreprise'));
    }

    public function update(Request $request, Offer $offre)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'string|max:255',
            'description' => 'string',
            'requirements' => 'string',
            'location' => 'string',
            'duration' => 'string',
            'status' => 'in:pending,active,closed',
            'entreprise_id' => 'integer|exists:entreprises,id',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $offre->update($request->all());

        return response()->json($offre);
    }

    public function destroy(Offer $offre)
    {
        $offre->delete();

        return response()->json(null, 204);
    }
}
