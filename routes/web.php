<?php

use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\PublicMemberController;
use Illuminate\Support\Facades\Route;

// Public Routes
Route::get('/', [PublicController::class, 'home'])->name('home');
Route::get('/profil', [PublicController::class, 'profile'])->name('public.profile');
Route::get('/verify-member/{uuid}', [PublicMemberController::class, 'verify'])->name('public.member.verify');
Route::get('/tata-tertib', [PublicController::class, 'rules'])->name('public.rules');
Route::get('/berita', [NewsController::class, 'index'])->name('news.index');
Route::get('/berita/{slug}', [NewsController::class, 'show'])->name('news.show');

// Public Reports
Route::get('/lapor', [ReportController::class, 'create'])->name('public.reports.create');
Route::post('/lapor', [ReportController::class, 'store'])->name('public.reports.store');

// Custom Registration
Route::get('/registrasi', [PublicController::class, 'registration'])->name('registration');
Route::post('/registrasi', [PublicController::class, 'storeRegistration'])->name('registration.store');

// Dashboard & Admin Routes
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');

    // Admin Only Routes (Role based check is inside controller logic or can be middleware)
    Route::prefix('admin')->name('admin.')->group(function () {
        // Members
        Route::get('/members', [AdminController::class, 'members'])->name('members.index');
        Route::get('/members/create', [AdminController::class, 'createMember'])->name('members.create');
        Route::post('/members', [AdminController::class, 'storeMember'])->name('members.store');
        Route::get('/members/{member}/edit', [AdminController::class, 'editMember'])->name('members.edit');
        Route::get('/members/{member}', [AdminController::class, 'showMember'])->name('members.show');
        Route::patch('/members/{member}', [AdminController::class, 'updateMember'])->name('members.update');
        Route::delete('/members/{member}', [AdminController::class, 'destroyMember'])->name('members.destroy');
        Route::patch('/members/{member}/status', [AdminController::class, 'updateMemberStatus'])->name('members.status');
        Route::get('/members/{member}/kta', [AdminController::class, 'downloadKta'])->name('members.kta');
        Route::get('/members/export', [AdminController::class, 'exportMembers'])->name('members.export');

        // News
        Route::get('/news', [NewsController::class, 'adminIndex'])->name('news.index');
        Route::get('/news/create', [NewsController::class, 'create'])->name('news.create');
        Route::post('/news', [NewsController::class, 'store'])->name('news.store');
        Route::get('/news/{news}/edit', [NewsController::class, 'edit'])->name('news.edit');
        Route::patch('/news/{news}', [NewsController::class, 'update'])->name('news.update');
        Route::delete('/news/{news}', [NewsController::class, 'destroy'])->name('news.destroy');

        // Pages
        Route::resource('pages', App\Http\Controllers\PageController::class)->except(['show']);

        // Settings
        Route::get('/settings', [AdminController::class, 'settingsIndex'])->name('settings.index');
        Route::put('/settings', [AdminController::class, 'settingsUpdate'])->name('settings.update');

        // User Management
        Route::resource('users', UserController::class);

        // Reports Management
        Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
        Route::get('/reports/{report}', [ReportController::class, 'show'])->name('reports.show');
        Route::patch('/reports/{report}', [ReportController::class, 'update'])->name('reports.update');
        Route::delete('/reports/{report}', [ReportController::class, 'destroy'])->name('reports.destroy');
    });
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
