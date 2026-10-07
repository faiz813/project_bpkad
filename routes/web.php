<?php

use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TamuController;
use Illuminate\Support\Facades\Route;

// Public Guest & Portal Routes
Route::get('/', [TamuController::class, 'portal'])->name('portal');
Route::get('/tamu/isi', [TamuController::class, 'create'])->name('tamu.create');
Route::post('/tamu', [TamuController::class, 'store'])->name('tamu.store');
Route::get('/tamu/sukses/{tamu}', [TamuController::class, 'success'])->name('tamu.success');

// Public API for guest phone lookup & captcha refresh
Route::get('/api/tamu/lookup-phone', [TamuController::class, 'lookupByPhone'])->name('tamu.lookup-phone');
Route::get('/api/tamu/captcha-refresh', [TamuController::class, 'refreshCaptcha'])->name('tamu.captcha-refresh');

// Redirect /dashboard to /admin/dashboard
Route::get('/dashboard', function () {
    return redirect()->route('admin.dashboard');
})->middleware(['auth'])->name('dashboard');

// Admin Protected Routes
Route::middleware(['auth'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
    Route::post('/tamu/{tamu}/checkout', [AdminDashboardController::class, 'checkout'])->name('admin.tamu.checkout');
    Route::put('/tamu/{tamu}', [AdminDashboardController::class, 'update'])->name('admin.tamu.update');
    Route::delete('/tamu/{tamu}', [AdminDashboardController::class, 'destroy'])->name('admin.tamu.destroy');
    Route::get('/export/excel', [AdminDashboardController::class, 'exportExcel'])->name('admin.export.excel');
    Route::get('/export/pdf', [AdminDashboardController::class, 'exportPdf'])->name('admin.export.pdf');
    Route::get('/api/new-guests', [AdminDashboardController::class, 'getNewGuests'])->name('admin.new-guests');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
