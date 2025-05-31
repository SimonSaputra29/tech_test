<?php

use App\Http\Controllers\Admin\PenggunaController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\MuridController;
use App\Http\Controllers\RequestController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// ==============================
// Landing Page (Public)
// ==============================
Route::get('/', function () {
    return view('welcome');
});

// ==============================
// Authentication Routes (Guest Only)
// ==============================
Route::middleware('guest')->group(function () {
    Route::get('register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('register', [AuthController::class, 'register']);
    Route::get('login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('login', [AuthController::class, 'login']);
});

// ==============================
// Logout Route (Authenticated Only)
// ==============================
Route::post('logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// ==============================
// Admin Routes (Authenticated + Role: admin)
// ==============================
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('index');

    // Admin Chat
    Route::get('/chats', [ChatController::class, 'adminIndex'])->name('chats.index');
    Route::get('/chats/{requestId}', [ChatController::class, 'adminShow'])->name('chats.show');

    // Profile Admin
    Route::get('/profile', [AdminController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [AdminController::class, 'edit'])->name('profile.edit');
    Route::post('/profile/update', [AdminController::class, 'update'])->name('profile.update');

    // Pengguna Resource
    Route::resource('pengguna', PenggunaController::class);
});

// ==============================
// Guru Routes (Authenticated + Role: guru)
// ==============================
Route::middleware(['auth', 'role:guru'])->prefix('guru')->name('guru.')->group(function () {
    Route::get('/', [GuruController::class, 'index'])->name('index');

    // Profile Guru
    Route::get('/profile', [GuruController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [GuruController::class, 'edit'])->name('profile.edit');
    Route::post('/profile/update', [GuruController::class, 'update'])->name('profile.update');

    // Request & Jadwal untuk Guru
    Route::get('/requests', [GuruController::class, 'requestIndex'])->name('requests.index');

    Route::prefix('requests/{request}')->name('requests.')->group(function () {
        Route::get('/jadwal', [GuruController::class, 'scheduleIndex'])->name('schedule.index');
        Route::get('/jadwal/create', [GuruController::class, 'scheduleCreate'])->name('schedule.create');
        Route::post('/jadwal', [GuruController::class, 'scheduleStore'])->name('schedule.store');
        Route::delete('/jadwal/{schedule}', [GuruController::class, 'scheduleDestroy'])->name('schedule.destroy');
    });
});

// ==============================
// Murid Routes (Authenticated + Role: murid)
// ==============================
Route::middleware(['auth', 'role:murid'])->prefix('murid')->name('murid.')->group(function () {
    Route::get('/', [MuridController::class, 'index'])->name('index');

    // Profile Murid (handled by UserController)
    Route::get('/profile', [UserController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [UserController::class, 'edit'])->name('profile.edit');
    Route::post('/profile/update', [UserController::class, 'update'])->name('profile.update');
});

// ==============================
// Request & Chat Routes (Authenticated Only)
// ==============================
Route::middleware('auth')->group(function () {

    // Request management
    Route::get('/requests', [RequestController::class, 'index'])->name('requests.index');
    Route::get('/requests/create', [RequestController::class, 'create'])->name('requests.create');
    Route::post('/requests', [RequestController::class, 'store'])->name('requests.store');
    Route::post('/requests/{request}/accept', [RequestController::class, 'accept'])->name('requests.accept');
    Route::post('/requests/{request}/reject', [RequestController::class, 'reject'])->name('requests.reject');

    // Chat routes
    Route::get('/chat/{request}', [ChatController::class, 'show'])->name('chat.show');
    Route::post('/chat/{request}', [ChatController::class, 'send'])->name('chat.send');
    Route::post('/chat/{request}/end', [ChatController::class, 'end'])->name('chat.end');
});

// ==============================
// Public Profile Routes (Authenticated + Roles: murid, guru, admin)
// ==============================
Route::middleware(['auth', 'role:murid,guru,admin'])->group(function () {
    Route::get('/profil/murid/{id}', [MuridController::class, 'show'])->name('murid.show');
    Route::get('/profil/admin/{id}', [AdminController::class, 'show'])->name('admin.show');
    Route::get('/profil/guru/{id}', [GuruController::class, 'show'])->name('guru.show');
});
