<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\ValidationException;
use App\Models\User;
use App\Models\Application;
use App\Models\Offer;
use App\Models\Document;
use App\Models\Stage;
use App\Models\Notification;
use App\Models\Message;
use App\Http\Requests\StoreApplicationRequest;
use App\Http\Requests\UpdateApplicationRequest;
use App\Http\Requests\UploadDocumentRequest;
use App\Services\DocumentService;
use App\Services\NotificationService;
use App\Policies\ApplicationPolicy;

class StudentController extends Controller
{
    protected DocumentService $documentService;
    protected NotificationService $notificationService;

    public function __construct(DocumentService $documentService, NotificationService $notificationService)
    {
        $this->documentService = $documentService;
        $this->notificationService = $notificationService;
        $this->middleware('auth:api');
        $this->middleware('role:student');
    }

    /**
     * Display the student dashboard.
     */
    public function dashboard(Request $request): JsonResponse
    {
        $user = Auth::user();
        $student = $user->student;

        $applications = $user->applications()
            ->with(['offer.company', 'stage'])
            ->latest()
            ->get();

        $activeStage = $user->stages()->active()->first();

        $unreadNotifications = $user->notifications()->unread()->count();

        return response()->json([
            'success' => true,
            'data' => [
                'profile' => [
                    'id' => $student->id ?? null,
                    'name' => $user->name,
                    'email' => $user->email,
                    'matricule' => $student->matricule ?? null,
                    'department' => $student->department ?? null,
                    'level' => $student->level ?? null,
                ],
                'applications' => $applications,
                'active_stage' => $activeStage,
                'stats' => [
                    'total_applications' => $applications->count(),
                    'pending_applications' => $applications->where('status', 'pending')->count(),
                    'accepted_applications' => $applications->where('status', 'accepted')->count(),
                    'unread_notifications' => $unreadNotifications,
                ],
            ],
        ]);
    }

    /**
     * Get available offers for application.
     */
    public function offers(Request $request): JsonResponse
    {
        $query = Offer::active()->with(['company']);

        if ($request->has('department')) {
            $query->where('department', $request->department);
        }

        if ($request->has('location')) {
            $query->where('location', 'like', '%' . $request->location . '%');
        }

        if ($request->boolean('remote')) {
            $query->remote();
        }

        $offers = $query->paginate(15);

        return response()->json([
            'success' => true,
            'data' => $offers,
        ]);
    }

    /**
     * Show specific offer details.
     */
    public function showOffer(Offer $offer): JsonResponse
    {
        $offer->load(['company', 'applications' => function($q) {
            $q->where('student_id', Auth::id());
        }]);

        return response()->json([
            'success' => true,
            'data' => $offer,
        ]);
    }

    /**
     * Apply to an offer.
     */
    public function apply(StoreApplicationRequest $request, Offer $offer): JsonResponse
    {
        if (!$offer->canAcceptApplications()) {
            return response()->json([
                'success' => false,
                'message' => 'This offer is no longer accepting applications.',
            ], 400);
        }

        // Check if student already applied
        $existingApplication = Application::where('student_id', Auth::id())
            ->where('offer_id', $offer->id)
            ->first();

        if ($existingApplication) {
            return response()->json([
                'success' => false,
                'message' => 'You have already applied to this offer.',
            ], 409);
        }

        $application = Application::create([
            'student_id' => Auth::id(),
            'offer_id' => $offer->id,
            'motivation_letter' => $request->motivation_letter,
            'cv_path' => $request->cv_path,
            'applied_at' => now(),
            'status' => 'pending',
        ]);

        // Notify company
        $this->notificationService->createNotification(
            $offer->company->user,
            'New Application',
            "New application received for your offer: {$offer->title}",
            'application_status',
            $application
        );

        return response()->json([
            'success' => true,
            'message' => 'Application submitted successfully.',
            'data' => $application->load('offer.company'),
        ], 201);
    }

    /**
     * Get student's applications.
     */
    public function applications(Request $request): JsonResponse
    {
        $applications = Auth::user()->applications()
            ->with(['offer.company', 'stage'])
            ->when($request->status, fn($q) => $q->where('status', $request->status))
            ->latest()
            ->paginate(10);

        return response()->json([
            'success' => true,
            'data' => $applications,
        ]);
    }

    /**
     * Show application details.
     */
    public function showApplication(Application $application): JsonResponse
    {
        Gate::authorize('view', $application);

        $application->load(['offer.company', 'stage.supervisor', 'documents']);

        return response()->json([
            'success' => true,
            'data' => $application,
        ]);
    }

    /**
     * Update application.
     */
    public function updateApplication(UpdateApplicationRequest $request, Application $application): JsonResponse
    {
        Gate::authorize('update', $application);

        if ($application->status !== 'pending') {
            return response()->json([
                'success' => false,
                'message' => 'Cannot update application that has been reviewed.',
            ], 400);
        }

        $application->update($request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Application updated successfully.',
            'data' => $application,
        ]);
    }

    /**
     * Withdraw application.
     */
    public function withdrawApplication(Application $application): JsonResponse
    {
        Gate::authorize('delete', $application);

        if ($application->status === 'accepted') {
            return response()->json([
                'success' => false,
                'message' => 'Cannot withdraw accepted application.',
            ], 400);
        }

        $application->delete();

        return response()->json([
            'success' => true,
            'message' => 'Application withdrawn successfully.',
        ]);
    }

    /**
     * Get student's documents.
     */
    public function documents(Request $request): JsonResponse
    {
        $documents = Auth::user()->documents()
            ->when($request->type, fn($q) => $q->where('type', $request->type))
            ->when($request->status, fn($q) => $q->where('status', $request->status))
            ->latest()
            ->paginate(10);

        return response()->json([
            'success' => true,
            'data' => $documents,
        ]);
    }

    /**
     * Upload document.
     */
    public function uploadDocument(UploadDocumentRequest $request): JsonResponse
    {
        try {
            $document = $this->documentService->uploadDocument(
                $request->file('file'),
                Auth::user(),
                $request->type,
                $request->application_id ?? null,
                $request->stage_id ?? null
            );

            return response()->json([
                'success' => true,
                'message' => 'Document uploaded successfully.',
                'data' => $document,
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to upload document: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Get student's stages.
     */
    public function stages(Request $request): JsonResponse
    {
        $stages = Auth::user()->stages()
            ->with(['offer.company', 'supervisor', 'evaluations'])
            ->when($request->status, fn($q) => $q->where('status', $request->status))
            ->latest()
            ->paginate(10);

        return response()->json([
            'success' => true,
            'data' => $stages,
        ]);
    }

    /**
     * Get stage details.
     */
    public function showStage(Stage $stage): JsonResponse
    {
        Gate::authorize('view', $stage);

        $stage->load([
            'offer.company',
            'supervisor',
            'documents',
            'evaluations.evaluator'
        ]);

        return response()->json([
            'success' => true,
            'data' => $stage,
        ]);
    }

    /**
     * Get notifications.
     */
    public function notifications(Request $request): JsonResponse
    {
        $notifications = Auth::user()->notifications()
            ->when($request->boolean('unread_only'), fn($q) => $q->unread())
            ->latest()
            ->paginate(20);

        return response()->json([
            'success' => true,
            'data' => $notifications,
        ]);
    }

    /**
     * Mark notification as read.
     */
    public function markNotificationAsRead(Notification $notification): JsonResponse
    {
        if ($notification->user_id !== Auth::id()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized.',
            ], 403);
        }

        $notification->markAsRead();

        return response()->json([
            'success' => true,
            'message' => 'Notification marked as read.',
        ]);
    }

    /**
     * Get messages.
     */
    public function messages(Request $request): JsonResponse
    {
        $messages = Message::betweenUsers(Auth::id(), $request->other_user_id)
            ->with(['sender', 'receiver'])
            ->orderBy('created_at', 'desc')
            ->paginate(50);

        return response()->json([
            'success' => true,
            'data' => $messages,
        ]);
    }

    /**
     * Send message.
     */
    public function sendMessage(Request $request): JsonResponse
    {
        $request->validate([
            'receiver_id' => 'required|exists:users,id',
            'content' => 'required|string|max:1000',
            'stage_id' => 'nullable|exists:stages,id',
        ]);

        $message = Message::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $request->receiver_id,
            'content' => $request->content,
            'stage_id' => $request->stage_id,
            'is_read' => false,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Message sent successfully.',
            'data' => $message->load(['sender', 'receiver']),
        ], 201);
    }
}