<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\ValidationException;
use App\Models\User;
use App\Models\Company;
use App\Models\Offer;
use App\Models\Application;
use App\Models\Stage;
use App\Models\Notification;
use App\Http\Requests\StoreOfferRequest;
use App\Http\Requests\UpdateOfferRequest;
use App\Http\Requests\ReviewApplicationRequest;
use App\Services\NotificationService;
use App\Services\WorkflowService;

class CompanyController extends Controller
{
    protected NotificationService $notificationService;
    protected WorkflowService $workflowService;

    public function __construct(NotificationService $notificationService, WorkflowService $workflowService)
    {
        $this->notificationService = $notificationService;
        $this->workflowService = $workflowService;
        $this->middleware('auth:api');
        $this->middleware('role:company');
    }

    /**
     * Display the company dashboard.
     */
    public function dashboard(Request $request): JsonResponse
    {
        $user = Auth::user();
        $company = $user->company;

        $offers = $user->offers();
        $applications = Application::whereHas('offer', function($q) use ($user) {
            $q->where('company_id', $user->company->id ?? 0);
        });

        $activeStages = Stage::whereHas('offer', function($q) use ($user) {
            $q->where('company_id', $user->company->id ?? 0);
        })->active();

        return response()->json([
            'success' => true,
            'data' => [
                'profile' => [
                    'id' => $company->id ?? null,
                    'company_name' => $company->company_name ?? '',
                    'name' => $user->name,
                    'email' => $user->email,
                    'industry' => $company->industry ?? null,
                ],
                'stats' => [
                    'total_offers' => $offers->count(),
                    'active_offers' => $offers->active()->count(),
                    'total_applications' => $applications->count(),
                    'pending_applications' => $applications->pending()->count(),
                    'active_stages' => $activeStages->count(),
                ],
                'recent_applications' => $applications->with(['student', 'offer'])
                    ->latest()
                    ->take(5)
                    ->get(),
            ],
        ]);
    }

    /**
     * Get company's offers.
     */
    public function offers(Request $request): JsonResponse
    {
        $offers = Auth::user()->offers()
            ->with(['applications' => function($q) {
                $q->with('student');
            }])
            ->when($request->status, fn($q) => $q->where('status', $request->status))
            ->latest()
            ->paginate(10);

        return response()->json([
            'success' => true,
            'data' => $offers,
        ]);
    }

    /**
     * Create new offer.
     */
    public function storeOffer(StoreOfferRequest $request): JsonResponse
    {
        $offer = Offer::create(array_merge($request->validated(), [
            'company_id' => Auth::user()->company->id,
            'status' => 'active',
        ]));

        return response()->json([
            'success' => true,
            'message' => 'Offer created successfully.',
            'data' => $offer,
        ], 201);
    }

    /**
     * Show offer details.
     */
    public function showOffer(Offer $offer): JsonResponse
    {
        Gate::authorize('view', $offer);

        $offer->load([
            'company',
            'applications.student',
            'stages.student',
            'documents'
        ]);

        return response()->json([
            'success' => true,
            'data' => $offer,
        ]);
    }

    /**
     * Update offer.
     */
    public function updateOffer(UpdateOfferRequest $request, Offer $offer): JsonResponse
    {
        Gate::authorize('update', $offer);

        $offer->update($request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Offer updated successfully.',
            'data' => $offer,
        ]);
    }

    /**
     * Delete offer.
     */
    public function deleteOffer(Offer $offer): JsonResponse
    {
        Gate::authorize('delete', $offer);

        // Check if offer has active applications or stages
        if ($offer->applications()->where('status', 'accepted')->exists() ||
            $offer->stages()->active()->exists()) {
            return response()->json([
                'success' => false,
                'message' => 'Cannot delete offer with active applications or stages.',
            ], 400);
        }

        $offer->delete();

        return response()->json([
            'success' => true,
            'message' => 'Offer deleted successfully.',
        ]);
    }

    /**
     * Get applications for company's offers.
     */
    public function applications(Request $request): JsonResponse
    {
        $applications = Application::whereHas('offer', function($q) {
            $q->where('company_id', Auth::user()->company->id);
        })
        ->with(['student', 'offer'])
        ->when($request->status, fn($q) => $q->where('status', $request->status))
        ->when($request->offer_id, fn($q) => $q->where('offer_id', $request->offer_id))
        ->latest()
        ->paginate(15);

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

        $application->load([
            'student.student', // Load student profile
            'offer',
            'documents',
            'stage.supervisor'
        ]);

        return response()->json([
            'success' => true,
            'data' => $application,
        ]);
    }

    /**
     * Review application (accept/reject).
     */
    public function reviewApplication(ReviewApplicationRequest $request, Application $application): JsonResponse
    {
        Gate::authorize('review', $application);

        $action = $request->action; // 'accept' or 'reject'

        if ($action === 'accept') {
            $application->accept();

            // Create stage automatically
            $this->workflowService->createStageFromApplication($application);

            $message = 'Application accepted successfully.';
        } else {
            $application->reject($request->rejection_reason);
            $message = 'Application rejected successfully.';
        }

        // Notify student
        $this->notificationService->createNotification(
            $application->student,
            'Application ' . ucfirst($action) . 'ed',
            "Your application for {$application->offer->title} has been " . $action . "ed.",
            'application_status',
            $application
        );

        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => $application->load('stage'),
        ]);
    }

    /**
     * Get active stages for company's offers.
     */
    public function stages(Request $request): JsonResponse
    {
        $stages = Stage::whereHas('offer', function($q) {
            $q->where('company_id', Auth::user()->company->id);
        })
        ->with(['student.student', 'offer', 'supervisor', 'evaluations'])
        ->when($request->status, fn($q) => $q->where('status', $request->status))
        ->latest()
        ->paginate(10);

        return response()->json([
            'success' => true,
            'data' => $stages,
        ]);
    }

    /**
     * Show stage details.
     */
    public function showStage(Stage $stage): JsonResponse
    {
        Gate::authorize('view', $stage);

        $stage->load([
            'student.student',
            'offer',
            'supervisor.supervisor', // Load supervisor profile
            'documents',
            'evaluations.evaluator'
        ]);

        return response()->json([
            'success' => true,
            'data' => $stage,
        ]);
    }

    /**
     * Update stage progress.
     */
    public function updateStageProgress(Request $request, Stage $stage): JsonResponse
    {
        Gate::authorize('update', $stage);

        $request->validate([
            'progress_percentage' => 'required|integer|min:0|max:100',
            'notes' => 'nullable|string|max:1000',
        ]);

        $stage->update([
            'progress_percentage' => $request->progress_percentage,
            'supervisor_notes' => $request->notes,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Stage progress updated successfully.',
            'data' => $stage,
        ]);
    }

    /**
     * Complete stage.
     */
    public function completeStage(Stage $stage): JsonResponse
    {
        Gate::authorize('update', $stage);

        $stage->complete();

        // Notify student and supervisor
        $this->notificationService->createNotification(
            $stage->student,
            'Stage Completed',
            "Your internship at {$stage->offer->company->company_name} has been completed.",
            'stage_update',
            $stage
        );

        $this->notificationService->createNotification(
            $stage->supervisor,
            'Stage Completed',
            "The internship for {$stage->student->name} has been completed.",
            'stage_update',
            $stage
        );

        return response()->json([
            'success' => true,
            'message' => 'Stage completed successfully.',
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
}