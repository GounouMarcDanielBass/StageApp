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
});
