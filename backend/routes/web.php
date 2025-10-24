<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ViewController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [ViewController::class, 'index'])->name('index');
Route::get('/login', [ViewController::class, 'login'])->name('login');
Route::get('/signup', [ViewController::class, 'signup'])->name('signup');
Route::get('/admin-dashboard', [ViewController::class, 'adminDashboard'])->name('admin-dashboard');
Route::get('/company-dashboard', [ViewController::class, 'companyDashboard'])->name('company-dashboard');
Route::get('/dashboard', [ViewController::class, 'dashboard'])->name('dashboard');
Route::get('/encadrant-dashboard', [ViewController::class, 'encadrantDashboard'])->name('encadrant-dashboard');
Route::get('/offres-stage', [ViewController::class, 'offresStage'])->name('offres-stage');
Route::get('/about', [ViewController::class, 'about'])->name('about');
Route::get('/contact', [ViewController::class, 'contact'])->name('contact');
Route::get('/faq', [ViewController::class, 'faq'])->name('faq');

Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::get('/dashboard/student', function () { return view('student.dashboard'); })->name('dashboard.student');
Route::get('/dashboard/admin', [DashboardController::class, 'admin'])->name('dashboard.admin');
Route::get('/dashboard/company', [DashboardController::class, 'company'])->name('dashboard.company');
Route::get('/dashboard/teacher', [DashboardController::class, 'teacher'])->name('dashboard.teacher');

// Routes authentifiées
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::get('/profile/settings', [ProfileController::class, 'settings'])->name('profile.settings');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Routes pour les étudiants
    Route::middleware(['role:etudiant'])->prefix('etudiant')->group(function () {
        Route::get('/candidatures', function () {
            return view('etudiant.candidatures-etudiant');
        })->name('etudiant.candidatures');
        Route::get('/detail-candidature', function () {
            return view('etudiant.detail-candidature');
        })->name('etudiant.detail-candidature');
        Route::get('/documents', function () {
            return view('etudiant.documents-etudiant');
        })->name('etudiant.documents');
        Route::get('/suivi-stage', function () {
            return view('etudiant.suivi-stage-etudiant');
        })->name('etudiant.suivi-stage');
        Route::get('/profil', function () {
            return view('etudiant.profil-etudiant');
        })->name('etudiant.profil');
        Route::get('/rapports', function () {
            return view('etudiant.rapports-etudiant');
        })->name('etudiant.rapports');
    });

    // Routes pour les entreprises
    Route::middleware(['role:entreprise'])->prefix('entreprise')->group(function () {
        Route::get('/offres', function () {
            return view('entreprise.offers-entreprise');
        })->name('entreprise.offres');
        Route::get('/edit-offre', function () {
            return view('entreprise.edit-offre');
        })->name('entreprise.edit-offre');
        Route::get('/candidatures', function () {
            return view('entreprise.candidatures-entreprise');
        })->name('entreprise.candidatures');
        Route::get('/evaluation-stagiaire', function () {
            return view('entreprise.evaluation-stagiaire');
        })->name('entreprise.evaluation-stagiaire');
        Route::get('/profil', function () {
            return view('entreprise.profil-entreprise');
        })->name('entreprise.profil');
    });

    // Routes pour les encadrants
    Route::middleware(['role:encadrant'])->prefix('encadrant')->group(function () {
        Route::get('/suivi-etudiants', function () {
            return view('encadrant.suivi-etudiants');
        })->name('encadrant.suivi-etudiants');
        Route::get('/validation-rapports', function () {
            return view('encadrant.validation-rapports');
        })->name('encadrant.validation-rapports');
        Route::get('/evaluation-etudiants', function () {
            return view('encadrant.evaluation-etudiants');
        })->name('encadrant.evaluation-etudiants');
        Route::get('/profil', function () {
            return view('encadrant.profil-encadrant');
        })->name('encadrant.profil');
    });

    // Routes pour les administrateurs
    Route::middleware(['role:admin'])->prefix('admin')->group(function () {
        Route::get('/sessions-stage', function () {
            return view('admin.sessions-stage');
        })->name('admin.sessions-stage');
        Route::get('/gestion-utilisateurs', function () {
            return view('admin.gestion-utilisateurs');
        })->name('admin.gestion-utilisateurs');
        Route::get('/validation-entreprises', function () {
            return view('admin.validation-entreprises');
        })->name('admin.validation-entreprises');
        Route::get('/attribution-encadrants', function () {
            return view('admin.attribution-encadrants');
        })->name('admin.attribution-encadrants');
        Route::get('/statistiques', function () {
            return view('admin.statistiques');
        })->name('admin.statistiques');
        Route::get('/parametres-systeme', function () {
            return view('admin.parametres-systeme');
        })->name('admin.parametres-systeme');
    });
});
