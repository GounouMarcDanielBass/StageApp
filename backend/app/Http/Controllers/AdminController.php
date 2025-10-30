<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use App\Models\User;
use App\Models\Role;
use App\Models\Student;
use App\Models\Company;
use App\Models\Supervisor;
use App\Models\Offer;
use App\Models\Application;
use App\Models\Stage;
use App\Models\Evaluation;
use App\Models\Document;
use App\Models\Notification;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Services\NotificationService;
use App\Services\DocumentService;

class AdminController extends Controller
{
    protected NotificationService $notificationService;
    protected DocumentService $documentService;

    public function __construct(NotificationService $notificationService, DocumentService $documentService)
    {
        $this->notificationService = $notificationService;
        $this->documentService = $documentService;
        $this->middleware('auth:api');
        $this->middleware('role:admin');
    }

    /**
     * Display the admin dashboard.
     */
    public function dashboard(Request $request): JsonResponse
    {
        $stats = [
            'total_users' => User::count(),
            'students' => User::byRole('student')->count(),
            'companies' => User::byRole('company')->count(),
            'supervisors' => User::byRole('supervisor')->count(),
            'admins' => User::byRole('admin')->count(),
            'total_offers' => Offer::count(),
            'active_offers' => Offer::active()->count(),
            'total_applications' => Application::count(),
            'pending_applications' => Application::pending()->count(),
            'active_stages' => Stage::active()->count(),
            'completed_stages' => Stage::completed()->count(),
        ];

        $recentActivities = [
            // This would typically come from an activity log table
            // For now, we'll get recent applications and stages
        ];

        $recentApplications = Application::with(['student', 'offer.company'])
            ->latest()
            ->take(5)
            ->get();

        $recentStages = Stage::with(['student.student', 'offer.company', 'supervisor.supervisor'])
            ->latest()
            ->take(5)
            ->get();

        return response()->json([
            'success' => true,
            'data' => [
                'stats' => $stats,
                'recent_applications' => $recentApplications,
                'recent_stages' => $recentStages,
            ],
        ]);
    }

    /**
     * Get all users with pagination.
     */
    public function users(Request $request): JsonResponse
    {
        $users = User::with(['role', 'student', 'company', 'supervisor'])
            ->when($request->role, fn($q) => $q->byRole($request->role))
            ->when($request->search, function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%');
            })
            ->latest()
            ->paginate(15);

        return response()->json([
            'success' => true,
            'data' => $users,
        ]);
    }

    /**
     * Create new user.
     */
    public function storeUser(StoreUserRequest $request): JsonResponse
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => Role::where('name', $request->role)->first()->id,
        ]);

        // Create role-specific profile
        switch ($request->role) {
            case 'student':
                Student::create(array_merge($request->student ?? [], ['user_id' => $user->id]));
                break;
            case 'company':
                Company::create(array_merge($request->company ?? [], ['user_id' => $user->id]));
                break;
            case 'supervisor':
                Supervisor::create(array_merge($request->supervisor ?? [], ['user_id' => $user->id]));
                break;
        }

        return response()->json([
            'success' => true,
            'message' => 'User created successfully.',
            'data' => $user->load(['role', 'student', 'company', 'supervisor']),
        ], 201);
    }

    /**
     * Show user details.
     */
    public function showUser(User $user): JsonResponse
    {
        $user->load(['role', 'student', 'company', 'supervisor']);

        return response()->json([
            'success' => true,
            'data' => $user,
        ]);
    }

    /**
     * Update user.
     */
    public function updateUser(UpdateUserRequest $request, User $user): JsonResponse
    {
        $user->update($request->validated());

        // Update role-specific profile
        if ($request->has('student') && $user->student) {
            $user->student->update($request->student);
        }
        if ($request->has('company') && $user->company) {
            $user->company->update($request->company);
        }
        if ($request->has('supervisor') && $user->supervisor) {
            $user->supervisor->update($request->supervisor);
        }

        return response()->json([
            'success' => true,
            'message' => 'User updated successfully.',
            'data' => $user->load(['role', 'student', 'company', 'supervisor']),
        ]);
    }

    /**
     * Delete user.
     */
    public function deleteUser(User $user): JsonResponse
    {
        // Check if user has active relationships
        if ($user->stages()->active()->exists() ||
            $user->applications()->where('status', 'accepted')->exists()) {
            return response()->json([
                'success' => false,
                'message' => 'Cannot delete user with active relationships.',
            ], 400);
        }

        $user->delete();

        return response()->json([
            'success' => true,
            'message' => 'User deleted successfully.',
        ]);
    }

    /**
     * Get all offers.
     */
    public function offers(Request $request): JsonResponse
    {
        $offers = Offer::with(['company.user', 'applications'])
            ->when($request->status, fn($q) => $q->where('status', $request->status))
            ->when($request->company_id, fn($q) => $q->where('company_id', $request->company_id))
            ->latest()
            ->paginate(15);

        return response()->json([
            'success' => true,
            'data' => $offers,
        ]);
    }

    /**
     * Approve/reject offer.
     */
    public function reviewOffer(Request $request, Offer $offer): JsonResponse
    {
        $request->validate([
            'action' => 'required|in:approve,reject',
            'reason' => 'nullable|string|max:500',
        ]);

        $action = $request->action;

        if ($action === 'approve') {
            $offer->update(['status' => 'active']);
            $message = 'Offer approved successfully.';
        } else {
            $offer->update(['status' => 'rejected']);
            $message = 'Offer rejected successfully.';
        }

        // Notify company
        $this->notificationService->createNotification(
            $offer->company->user,
            'Offer ' . ucfirst($action) . 'ed',
            "Your offer '{$offer->title}' has been " . $action . "ed. " . ($request->reason ? "Reason: {$request->reason}" : ""),
            'offer_status',
            $offer
        );

        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => $offer,
        ]);
    }

    /**
     * Get all stages.
     */
    public function stages(Request $request): JsonResponse
    {
        $stages = Stage::with(['student.student', 'offer.company', 'supervisor.supervisor'])
            ->when($request->status, fn($q) => $q->where('status', $request->status))
            ->when($request->supervisor_id, fn($q) => $q->where('supervisor_id', $request->supervisor_id))
            ->latest()
            ->paginate(15);

        return response()->json([
            'success' => true,
            'data' => $stages,
        ]);
    }

    /**
     * Assign supervisor to stage.
     */
    public function assignSupervisor(Request $request, Stage $stage): JsonResponse
    {
        $request->validate([
            'supervisor_id' => 'required|exists:users,id',
        ]);

        $supervisor = User::find($request->supervisor_id);

        if (!$supervisor->hasRole('supervisor')) {
            return response()->json([
                'success' => false,
                'message' => 'Selected user is not a supervisor.',
            ], 400);
        }

        $stage->assignSupervisor($supervisor);

        // Notify supervisor
        $this->notificationService->createNotification(
            $supervisor,
            'New Stage Assignment',
            "You have been assigned as supervisor for {$stage->student->name}'s internship at {$stage->offer->company->company_name}.",
            'stage_assignment',
            $stage
        );

        // Notify student and company
        $this->notificationService->createNotification(
            $stage->student,
            'Supervisor Assigned',
            "A supervisor has been assigned to your internship at {$stage->offer->company->company_name}.",
            'stage_assignment',
            $stage
        );

        return response()->json([
            'success' => true,
            'message' => 'Supervisor assigned successfully.',
            'data' => $stage->load('supervisor.supervisor'),
        ]);
    }

    /**
     * Get system statistics.
     */
    public function statistics(Request $request): JsonResponse
    {
        $stats = [
            'users_by_role' => [
                'students' => User::byRole('student')->count(),
                'companies' => User::byRole('company')->count(),
                'supervisors' => User::byRole('supervisor')->count(),
                'admins' => User::byRole('admin')->count(),
            ],
            'offers_by_status' => [
                'active' => Offer::where('status', 'active')->count(),
                'inactive' => Offer::where('status', 'inactive')->count(),
                'expired' => Offer::where('status', 'expired')->count(),
            ],
            'applications_by_status' => [
                'pending' => Application::where('status', 'pending')->count(),
                'accepted' => Application::where('status', 'accepted')->count(),
                'rejected' => Application::where('status', 'rejected')->count(),
            ],
            'stages_by_status' => [
                'active' => Stage::where('status', 'active')->count(),
                'completed' => Stage::where('status', 'completed')->count(),
                'cancelled' => Stage::where('status', 'cancelled')->count(),
            ],
            'documents_by_status' => [
                'approved' => Document::where('status', 'approved')->count(),
                'pending' => Document::where('status', 'pending')->count(),
                'rejected' => Document::where('status', 'rejected')->count(),
            ],
        ];

        return response()->json([
            'success' => true,
            'data' => $stats,
        ]);
    }

    /**
     * Get system settings.
     */
    public function settings(Request $request): JsonResponse
    {
        // This would typically interact with a settings model
        // For now, return basic configuration
        $settings = [
            'max_applications_per_offer' => 50,
            'max_students_per_supervisor' => 5,
            'document_upload_limit_mb' => 10,
            'internship_min_duration_months' => 3,
            'internship_max_duration_months' => 12,
            'notification_email_enabled' => true,
        ];

        return response()->json([
            'success' => true,
            'data' => $settings,
        ]);
    }

    /**
     * Update system settings.
     */
    public function updateSettings(Request $request): JsonResponse
    {
        // Validate and update settings
        $request->validate([
            'max_applications_per_offer' => 'nullable|integer|min:1|max:100',
            'max_students_per_supervisor' => 'nullable|integer|min:1|max:20',
            'document_upload_limit_mb' => 'nullable|integer|min:1|max:50',
            'internship_min_duration_months' => 'nullable|integer|min:1|max:6',
            'internship_max_duration_months' => 'nullable|integer|min:6|max:24',
            'notification_email_enabled' => 'nullable|boolean',
        ]);

        // Update settings logic here

        return response()->json([
            'success' => true,
            'message' => 'Settings updated successfully.',
        ]);
    }
}