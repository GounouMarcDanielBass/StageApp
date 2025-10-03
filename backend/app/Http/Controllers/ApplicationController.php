<?php

namespace App\Http\Controllers;

use App\Models\Application;
use Illuminate\Http\Request;

class ApplicationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $applications = Application::with(['student', 'offer'])->get();
        return response()->json($applications);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'offer_id' => 'required|exists:offers,id',
            'motivation_letter' => 'nullable|string',
            'cv' => 'nullable|string', // Assuming CV is stored as a path or URL
        ]);

        $application = Application::create([
            'student_id' => auth()->id(), // Assuming authenticated user is the student
            'offer_id' => $request->offer_id,
            'motivation_letter' => $request->motivation_letter,
            'cv' => $request->cv,
            'status' => 'pending',
        ]);

        return response()->json(['message' => 'Application submitted successfully.', 'application' => $application], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Application $application)
    {
        return response()->json($application->load(['student', 'offer']));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Application $application)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Application $application)
    {
        $request->validate([
            'status' => 'required|in:pending,accepted,rejected',
        ]);

        $application->update(['status' => $request->status]);

        return response()->json(['message' => 'Application status updated successfully.', 'application' => $application]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Application $application)
    {
        //
    }
}
