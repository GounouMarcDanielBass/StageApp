<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\OffreController;
use App\Http\Controllers\CandidatureController;
use App\Http\Controllers\StageController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\EntrepriseController;
use App\Http\Controllers\EtudiantController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\EncadrantController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\EvaluationController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\NotificationController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::get('latest-offers', [ApiController::class, 'latestOffers']);
Route::get('stats', [ApiController::class, 'stats']);
Route::get('testimonials', [ApiController::class, 'testimonials']);

Route::get('/admin/dashboard', [DashboardController::class, 'admin'])->middleware('auth:api');

Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function ($router) {
    Route::post('login', [AuthController::class, 'login']);
    Route::post('register/{role}', [AuthController::class, 'register']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('refresh', [AuthController::class, 'refresh']);
    Route::get('me', [AuthController::class, 'me']);

    // 2FA Routes
    Route::post('2fa/generate', [AuthController::class, 'generate2faSecret']);
    Route::post('2fa/enable', [AuthController::class, 'enable2fa']);
    Route::post('2fa/disable', [AuthController::class, 'disable2fa']);
    Route::post('2fa/verify', [AuthController::class, 'verify2fa']);
});

// Routes protégées par l'authentification
Route::middleware('auth:api')->group(function () {
    // Routes communes
    Route::get('/user', [AuthController::class, 'user']);

    // Routes pour les étudiants
    Route::middleware(['role:etudiant'])->prefix('etudiant')->group(function () {
        Route::get('/statistics', [EtudiantController::class, 'getStatistics']);
        Route::get('/activities', [EtudiantController::class, 'getActivities']);
        Route::get('/stages', [EtudiantController::class, 'getStages']);
        Route::get('/candidatures', [EtudiantController::class, 'getCandidatures']);
        Route::post('/candidatures', [EtudiantController::class, 'submitCandidature']);
        Route::get('/profile', [EtudiantController::class, 'getProfile']);
        Route::put('/profile', [EtudiantController::class, 'updateProfile']);
    });

    Route::middleware(['role:etudiant'])->prefix('student')->group(function () {
        Route::get('/dashboard', [StudentController::class, 'dashboard']);
    });

    // Routes pour les entreprises
    Route::middleware(['role:entreprise'])->prefix('entreprise')->group(function () {
        Route::get('/statistics', [EntrepriseController::class, 'getStatistics']);
        Route::get('/activities', [EntrepriseController::class, 'getActivities']);
        Route::get('/stages', [EntrepriseController::class, 'getStages']);
        Route::post('/stages', [EntrepriseController::class, 'createStage']);
        Route::put('/stages/{stage}', [EntrepriseController::class, 'updateStage']);
        Route::delete('/stages/{stage}', [EntrepriseController::class, 'deleteStage']);
        Route::get('/candidatures', [EntrepriseController::class, 'getCandidatures']);
        Route::put('/candidatures/{candidature}/status', [EntrepriseController::class, 'updateCandidatureStatus']);
        Route::get('/profile', [EntrepriseController::class, 'getProfile']);
        Route::put('/profile', [EntrepriseController::class, 'updateProfile']);
        Route::get('/charts-data', [EntrepriseController::class, 'getChartsData']);
    });

    // Public-like resources but authenticated
    Route::apiResource('offers', OffreController::class)->only(['index', 'show']);
    Route::apiResource('stages', StageController::class)->only(['index', 'show']);

    // Role-specific resources
    Route::middleware(['role:entreprise'])->group(function () {
        Route::apiResource('offers', OffreController::class)->except(['index', 'show']);
        Route::apiResource('stages', StageController::class)->except(['index', 'show']);
    });

    Route::middleware(['role:etudiant'])->group(function () {
        Route::apiResource('applications', CandidatureController::class);
    });

    Route::middleware(['role:entreprise'])->group(function () {
        Route::apiResource('applications', CandidatureController::class)->except(['index']);
    });

    Route::middleware(['role:admin'])->group(function () {
        Route::apiResource('documents', DocumentController::class);
        Route::apiResource('entreprises', EntrepriseController::class);
        Route::apiResource('etudiants', EtudiantController::class);
        Route::apiResource('encadrants', EncadrantController::class);
    });

    // Admin routes protected by auth and role
    Route::middleware(['role:admin'])->prefix('admin')->group(function () {
        Route::get('dashboard', [AdminController::class, 'dashboard']);
        Route::get('users', [AdminController::class, 'manageUsers']);
    });

    // Encadrant routes
    Route::middleware(['role:encadrant'])->prefix('encadrant')->group(function () {
        Route::get('/statistics', [EncadrantController::class, 'getStatistics']);
        Route::get('/activities', [EncadrantController::class, 'getActivities']);
        Route::get('/stages', [EncadrantController::class, 'getStages']);
        Route::get('/candidatures', [EncadrantController::class, 'getCandidatures']);
        Route::put('/candidatures/{candidature}/status', [EncadrantController::class, 'updateCandidatureStatus']);
        Route::get('/profile', [EncadrantController::class, 'getProfile']);
        Route::put('/profile', [EncadrantController::class, 'updateProfile']);
    });

    Route::middleware(['role:etudiant'])->group(function () {
        Route::apiResource('applications', ApplicationController::class)->only(['store', 'index', 'show']);
    });

    Route::middleware(['role:entreprise'])->group(function () {
        Route::apiResource('applications', ApplicationController::class)->only(['index', 'show', 'update']);
    });

    // Document routes
    Route::prefix('documents')->group(function () {
        // Student can upload and view their documents
        Route::middleware('role:etudiant')->group(function () {
            Route::post('/', [DocumentController::class, 'store']);
            Route::get('/', [DocumentController::class, 'index']);
            Route::get('/{document}', [DocumentController::class, 'show']);
        });

        // Encadrant and Admin can view, update, and delete documents
        Route::middleware('role:encadrant|admin')->group(function () {
            Route::get('/', [DocumentController::class, 'index']);
            Route::get('/{document}', [DocumentController::class, 'show']);
            Route::put('/{document}', [DocumentController::class, 'update']);
            Route::delete('/{document}', [DocumentController::class, 'destroy']);
        });
    });

    // Evaluation routes
    Route::prefix('evaluations')->group(function () {
        // Encadrant can create, view, update, and delete evaluations
        Route::middleware('role:encadrant')->group(function () {
            Route::post('/', [EvaluationController::class, 'store']);
            Route::put('/{evaluation}', [EvaluationController::class, 'update']);
            Route::delete('/{evaluation}', [EvaluationController::class, 'destroy']);
        });

        // Student can view their own evaluations
        Route::middleware('role:etudiant')->group(function () {
            Route::get('/', [EvaluationController::class, 'index']);
            Route::get('/{evaluation}', [EvaluationController::class, 'show']);
        });

        // Admin can view all evaluations
        Route::middleware('role:admin')->group(function () {
            Route::get('/', [EvaluationController::class, 'index']);
            Route::get('/{evaluation}', [EvaluationController::class, 'show']);
            Route::delete('/{evaluation}', [EvaluationController::class, 'destroy']);
        });
    });

    Route::middleware('role:etudiant')->group(function () {
        Route::get('/student/dashboard', [StudentController::class, 'dashboard']);
    });

    Route::middleware('role:entreprise')->group(function () {
        Route::get('/company/dashboard', [CompanyController::class, 'dashboard']);
    });

    Route::middleware('role:encadrant')->group(function () {
        Route::get('/encadrant/dashboard', [EncadrantController::class, 'dashboard']);
    });

    Route::middleware('role:admin')->group(function () {
        Route::get('/admin/dashboard', [AdminController::class, 'dashboard']);
        Route::get('/admin/stats', [DashboardController::class, 'admin']);
    });

    Route::middleware('role:entreprise')->group(function () {
        Route::get('/company/stats', [DashboardController::class, 'companyStats']);
    });

    Route::middleware('role:etudiant')->group(function () {
        Route::get('/student/stats', [DashboardController::class, 'studentStats']);
    });

    Route::post('/logout', [AuthController::class, 'logout']);
});

// Route pour le formulaire de contact
Route::post('contact', [ContactController::class, 'store']);

// Profile Management Routes
Route::middleware('auth:api')->prefix('profile')->group(function () {
    Route::get('/', [ProfileController::class, 'show']);
    Route::put('/', [ProfileController::class, 'update']);
    Route::delete('/', [ProfileController::class, 'deleteAccount']);
});

// Notification Routes
Route::middleware('auth:api')->group(function () {
    Route::apiResource('notifications', NotificationController::class)->only(['index', 'update', 'destroy']);
});
