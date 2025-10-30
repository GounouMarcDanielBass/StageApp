<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
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

Route::get('/', function () {
    if (Auth::check()) {
        return redirect('/dashboard');
    } else {
        Log::info('Route / accessed for index.html');
        return response()->file(public_path('index.html'));
    }
})->name('index');
Route::get('/login', function () { return response()->file(public_path('login.html')); })->name('login');
Route::get('/register', [ViewController::class, 'register'])->name('register');
Route::get('/signup', function () { return response()->file(public_path('signup.html')); })->name('signup');
// Route::get('/admin-dashboard', function () { return response()->file(public_path('admin-dashboard.html')); })->name('admin-dashboard');
Route::get('/company-dashboard', function () { return response()->file(public_path('company-dashboard.html')); })->name('company-dashboard');
Route::get('/dashboard', function () { return response()->file(public_path('dashboard.html')); })->name('dashboard');
Route::get('/dashboard-encadrant', function () { return response()->file(public_path('dashboard-encadrant.html')); })->name('dashboard-encadrant');
Route::get('/offres-stage', function () { return response()->file(public_path('offres-stage.html')); })->name('offres-stage');
Route::get('/about', function () { return response()->file(public_path('about.html')); })->name('about');
Route::get('/contact', function () { return response()->file(public_path('contact.html')); })->name('contact');
Route::get('/faq', function () { return response()->file(public_path('faq.html')); })->name('faq');
Route::get('/student-dashboard', function () { return response()->file(public_path('student-dashboard.html')); })->name('student-dashboard');
Route::get('/dashboard-entreprise', function () { return response()->file(public_path('dashboard-entreprise.html')); })->name('dashboard-entreprise');
Route::get('/services', [ViewController::class, 'services'])->name('services');
Route::get('/blogs', [ViewController::class, 'blogs'])->name('blogs');
Route::get('/blog-detail', [ViewController::class, 'blogDetail'])->name('blog.detail');
Route::get('/helpcenter-overview', [ViewController::class, 'helpcenterOverview'])->name('helpcenter.overview');
Route::get('/helpcenter-faqs', [ViewController::class, 'helpcenterFaqs'])->name('helpcenter.faqs');
Route::get('/helpcenter-guides', [ViewController::class, 'helpcenterGuides'])->name('helpcenter.guides');
Route::get('/helpcenter-support', [ViewController::class, 'helpcenterSupport'])->name('helpcenter.support');
Route::get('/employers', [ViewController::class, 'employers'])->name('employers');
Route::get('/candidates', [ViewController::class, 'candidates'])->name('candidates');

Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::get('/dashboard/student', function () { return response()->file(public_path('student-dashboard.html')); })->name('dashboard.student');
Route::get('/dashboard/admin', [DashboardController::class, 'admin'])->name('dashboard.admin');
Route::get('/dashboard/company', function () { return response()->file(public_path('entreprise/dashboard.html')); })->name('dashboard.company');
Route::get('/dashboard/teacher', function () { return response()->file(public_path('etudiant/dashboard.html')); })->name('dashboard.teacher');

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