<?php

namespace App\Http\Controllers;

use App\Models\Candidature;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use App\Services\NotificationService;

class CandidatureController extends Controller
{
    public function __construct()
    {
        Log::info('CandidatureController: Checking if middleware method exists: ' . (method_exists($this, 'middleware') ? 'Yes' : 'No'));
        $this->middleware('auth:api');
    }

    public function index()
    {
        $user = Auth::user();
        Log::info('CandidatureController index: Checking if user applications method exists: ' . (method_exists($user, 'applications') ? 'Yes' : 'No'));
        if ($user->role->name === 'admin' || $user->role->name === 'entreprise') {
            $applications = Candidature::with(['user', 'offre'])->get();
        } else {
            $applications = $user->candidatures()->with('offre')->get();
        }
        return response()->json($applications);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'offer_id' => 'required|integer|exists:offers,id',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $application = Candidature::create([
            'user_id' => Auth::id(),
            'offre_id' => $request->offer_id,
            'status' => 'pending',
        ]);

        return response()->json($application, 201);
    }

    public function show(Candidature $application)
    {
        $this->authorize('view', $application);
        return response()->json($application->load(['user', 'offre']));
    }

    public function update(Request $request, Candidature $application, NotificationService $notificationService)
    {
        $this->authorize('update', $application);

        $validator = Validator::make($request->all(), [
            'status' => 'required|in:pending,accepted,rejected',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $oldStatus = $application->status;
        $application->update($request->only('status'));

        // Send notification if status changed
        if ($oldStatus !== $request->status) {
            $notificationService->sendApplicationStatusEmail($application->user, $application, $request->status);
        }

        return response()->json($application);
    }

    public function destroy(Candidature $application)
    {
        $this->authorize('delete', $application);
        $application->delete();

        return response()->json(null, 204);
    }
}
