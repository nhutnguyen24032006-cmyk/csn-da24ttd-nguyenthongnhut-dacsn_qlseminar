<?php
use App\Http\Controllers\Admin\SeminarController as AdminSeminar;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SeminarController;
use App\Http\Middleware\AdminOnly;
use Illuminate\Support\Facades\Route;

Route::get('/', [SeminarController::class, 'index'])->name('home');
Route::get('/seminars/{seminar}', [SeminarController::class, 'show'])->name('seminars.show');

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::post('/seminars/{seminar}/register', [SeminarController::class, 'register'])->name('seminars.register');
    Route::delete('/seminars/{seminar}/register', [SeminarController::class, 'cancel'])->name('seminars.cancel');
});

Route::prefix('admin')->name('admin.')->middleware(['auth', AdminOnly::class])->group(function () {
    Route::resource('seminars', AdminSeminar::class);
});
