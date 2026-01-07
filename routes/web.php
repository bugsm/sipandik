<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\User\BugReportController as UserBugReportController;
use App\Http\Controllers\User\DataRequestController as UserDataRequestController;
use App\Http\Controllers\User\DashboardController as UserDashboardController;
use App\Http\Controllers\Admin\BugReportController as AdminBugReportController;
use App\Http\Controllers\Admin\DataRequestController as AdminDataRequestController;
use App\Http\Controllers\Admin\OpdController as AdminOpdController;
use App\Http\Controllers\Admin\ApplicationController as AdminApplicationController;
use App\Http\Controllers\Admin\VulnerabilityTypeController as AdminVulnerabilityTypeController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Landing page
Route::get('/', function () {
    return view('welcome');
})->name('home');

// Redirect old dashboard to user dashboard
Route::get('/dashboard', function () {
    return redirect()->route('user.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// User Profile
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

/*
|--------------------------------------------------------------------------
| User Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'verified'])->prefix('user')->name('user.')->group(function () {
    // Dashboard
    Route::get('/dashboard', [UserDashboardController::class, 'index'])->name('dashboard');
    
    // Bug Reports
    Route::resource('bug-reports', UserBugReportController::class)->only(['index', 'create', 'store', 'show']);
    
    // Data Requests
    Route::resource('data-requests', UserDataRequestController::class)->only(['index', 'create', 'store', 'show']);
    Route::get('data-requests/{data_request}/download', [UserDataRequestController::class, 'download'])->name('data-requests.download');
});

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'verified', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('dashboard');
    
    // Bug Reports Management
    Route::get('/bug-reports/export/{format}', [AdminBugReportController::class, 'export'])->name('bug-reports.export');
    Route::get('/bug-reports', [AdminBugReportController::class, 'index'])->name('bug-reports.index');
    Route::get('/bug-reports/{bugReport}', [AdminBugReportController::class, 'show'])->name('bug-reports.show');
    Route::patch('/bug-reports/{bugReport}/status', [AdminBugReportController::class, 'updateStatus'])->name('bug-reports.update-status');
    Route::patch('/bug-reports/{bugReport}/apresiasi', [AdminBugReportController::class, 'updateApresiasi'])->name('bug-reports.update-apresiasi');
    Route::patch('/bug-reports/{bugReport}/folder', [AdminBugReportController::class, 'toggleFolder'])->name('bug-reports.toggle-folder');
    Route::patch('/bug-reports/{bugReport}/note', [AdminBugReportController::class, 'addNote'])->name('bug-reports.add-note');
    
    // Data Requests Management
    Route::get('/data-requests/export/{format}', [AdminDataRequestController::class, 'export'])->name('data-requests.export');
    Route::get('/data-requests', [AdminDataRequestController::class, 'index'])->name('data-requests.index');
    Route::get('/data-requests/{dataRequest}', [AdminDataRequestController::class, 'show'])->name('data-requests.show');
    Route::patch('/data-requests/{dataRequest}/status', [AdminDataRequestController::class, 'updateStatus'])->name('data-requests.update-status');
    Route::post('/data-requests/{dataRequest}/upload', [AdminDataRequestController::class, 'uploadData'])->name('data-requests.upload');
    
    // OPD Management
    Route::resource('opd', AdminOpdController::class);
    
    // Applications Management
    Route::resource('applications', AdminApplicationController::class);
    
    // Vulnerability Types Management
    Route::resource('vulnerability-types', AdminVulnerabilityTypeController::class);
});

require __DIR__.'/auth.php';
