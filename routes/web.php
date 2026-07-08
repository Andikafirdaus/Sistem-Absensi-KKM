<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController as AdminDashboard;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\QrCodeController;
use App\Http\Controllers\Admin\AttendanceController as AdminAttendance;
use App\Http\Controllers\Admin\WorkHourController;

use App\Http\Controllers\User\DashboardController as UserDashboard;
use App\Http\Controllers\User\AttendanceController as UserAttendance;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/dashboard', function (\Illuminate\Http\Request $request) {
    if ($request->user()->role === 'admin') {
        return redirect()->route('admin.dashboard');
    }
    return redirect()->route('user.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Admin Routes
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboard::class, 'index'])->name('dashboard');
    Route::resource('/users', UserController::class);
    
    Route::get('/qr-code', [QrCodeController::class, 'index'])->name('qr-code.index');
    Route::post('/qr-code/generate', [QrCodeController::class, 'generate'])->name('qr-code.generate');
    
    Route::get('/attendances', [AdminAttendance::class, 'index'])->name('attendances.index');
    Route::get('/attendances/export', [AdminAttendance::class, 'export'])->name('attendances.export');
    
    Route::get('/settings', [\App\Http\Controllers\Admin\SettingController::class, 'index'])->name('settings.index');
    Route::post('/settings', [\App\Http\Controllers\Admin\SettingController::class, 'update'])->name('settings.update');
    
    Route::get('/activity-logs', [\App\Http\Controllers\Admin\ActivityLogController::class, 'index'])->name('activity-logs.index');
    
    Route::delete('/activity-logs/clear', [\App\Http\Controllers\Admin\ActivityLogController::class, 'clear'])
    ->name('activity-logs.clear');
});

// User Routes
Route::middleware(['auth', 'role:user'])->prefix('user')->name('user.')->group(function () {
    Route::get('/dashboard', [UserDashboard::class, 'index'])->name('dashboard');
    
    Route::get('/scan', [UserAttendance::class, 'scan'])->name('scan');
    Route::post('/scan/store', [UserAttendance::class, 'store'])->name('scan.store');
    
    Route::get('/history', [UserAttendance::class, 'history'])->name('history');
});

require __DIR__.'/auth.php';
