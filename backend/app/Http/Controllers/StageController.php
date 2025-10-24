<?php

namespace App\Http\Controllers;

use App\Models\Stage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Services\NotificationService;

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
            $stages = Stage::with(['user', 'offer.entreprise', 'documents'])->get();
        } elseif ($user->role->name === 'entreprise') {
            $stages = Stage::whereHas('offer.entreprise', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            })->with(['user', 'offer.entreprise', 'documents'])->get();
        } else {
            $stages = $user->stages()->with(['offer.entreprise', 'documents'])->get();
        }

        return response()->json($stages);
    }

    public function store(Request $request)
    {
        $this->authorize('create', Stage::class);

        $validator = Validator::make($request->all(), [
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'offer_id' => 'required|integer|exists:offers,id',
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
        return response()->json($stage->load(['user', 'offer.entreprise', 'documents', 'evaluations']));
    }

    public function update(Request $request, Stage $stage, NotificationService $notificationService)
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

        $oldStatus = $stage->status;
        $stage->update($request->all());

        // Send notification if status changed
        if ($oldStatus !== $request->status) {
            $notificationService->sendStageProgressEmail($stage->user, $stage, "Status updated to: {$request->status}");
        }

        return response()->json($stage);
    }

    public function destroy(Stage $stage)
    {
        $this->authorize('delete', $stage);
        $stage->delete();

        return response()->json(null, 204);
    }
}