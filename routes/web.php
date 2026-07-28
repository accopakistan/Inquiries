<?php

use App\Http\Controllers\InquiryController;
use App\Http\Controllers\ProjectTypeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\FollowupController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::middleware(['login'])->group(function () {
    Route::get('/inquiries', [InquiryController::class, 'index']);
    Route::get('/', [InquiryController::class, 'dashboard']);
    Route::get('/inquiries', [InquiryController::class, 'index'])->name('inquiries');
    Route::get('/add-inquiry', [InquiryController::class, 'create']);
    Route::post('/add-inquiry', [InquiryController::class, 'store']);
    Route::get('/update-inquiry-data/{id}', [InquiryController::class, 'edit']);
    Route::get('/inquiry-by-type/{id}', [InquiryController::class, 'inquiryByType']);
    Route::post('/update-inquiry-data', [InquiryController::class, 'update']);
    Route::delete('/delete-inquiry/{id}', [InquiryController::class, 'destroy'])->name('inquiries.destroy');

    Route::get('/project-type', [ProjectTypeController::class, 'index']);
    Route::get('/add-project-type', [ProjectTypeController::class, 'create']);
    Route::post('/add-project-type', [ProjectTypeController::class, 'store']);
    Route::get('/update-project-type/{id}', [ProjectTypeController::class, 'edit']);
    Route::post('/update-projects-type', [ProjectTypeController::class, 'update']);
    Route::get('/inquiry-view/{id}', [InquiryController::class, 'show'])->name('inquiry.view');
    Route::get('/inquiries-by-status', [InquiryController::class, 'inquiriesByStatus'])->name('inquiries.byStatus');
    Route::get('/inquiries/export', [InquiryController::class, 'export'])->name('inquiries.export');
    Route::get('/inquiries/export-date', [InquiryController::class, 'exportDateForm'])->name('inquiries.exportDateForm');
    Route::post('/inquiries/export-date', [InquiryController::class, 'exportDate'])->name('inquiries.exportDate');
    Route::get('/inquiries/export-project-type', [InquiryController::class, 'exportProjectTypeForm'])->name('inquiries.exportProjectTypeForm');
    Route::post('/inquiries/export-project-type', [InquiryController::class, 'exportProjectType'])->name('inquiries.exportProjectType');
    Route::get('/inquiries/export-status', [InquiryController::class, 'exportStatusForm'])->name('inquiries.exportStatusForm');
    Route::post('/inquiries/export-status', [InquiryController::class, 'exportStatus'])->name('inquiries.exportStatus');

    Route::get('/inquiries/{inquiry}/followups', [FollowupController::class, 'index'])->name('followup');
    Route::get('/inquiries/{inquiry}/followups/create', [FollowupController::class, 'create'])->name('followups.create');
    Route::post('/inquiries/{inquiry}/followups', [FollowupController::class, 'store'])->name('followups.store');
    Route::get('/today-followups', [InquiryController::class, 'todayFollowups'])->name('today.followups');
    Route::get('/most-important', [InquiryController::class, 'mostImportant'])->name('most-important');
});
