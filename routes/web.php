<?php

use App\Http\Controllers\ProjectController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;

use App\Http\Controllers\Admin\LoginController as AdminLoginController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\ProfileController as ProfileController;
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

// Home
Route::redirect('/', '/login');

Route::redirect('/admin', '/admin/login');

// End point Profiles needs an argument
Route::redirect('/profiles', '/');


// Admin
Route::prefix('admin')->group(function () {
    Route::get('/login', [AdminLoginController::class, 'showLoginForm'])->name('admin.login');
    Route::post('/login', [AdminLoginController::class, 'login']);
    Route::post('/logout', [AdminLoginController::class, 'logout'])->name('admin.logout');
    
    Route::get('/users', [AdminUserController::class, 'list'])->name('admin.users');
    Route::get('/users', [AdminUserController::class, 'findUser'])->name('admin.users');
    Route::get('/users/{username}', [AdminUserController::class, 'show'])->name('admin.users.show');
    Route::get('/users/{username}/edit', [AdminUserController::class, 'showEdit'])->name('admin.users.showEdit');
    Route::post('/users/{username}/edit', [AdminUserController::class, 'edit'])->name('admin.users.edit');
});

// Projects
Route::controller(ProjectController::class)->group(function () {
    Route::get('/projects', 'list')->name('projects');
    Route::get('/projects/new', 'create')->name('projects.create');
    Route::post('/projects/new', 'store')->name('projects.store');
    Route::get('/projects/{slug}', 'show')->name('projects.show');
});

// Authentication
Route::controller(LoginController::class)->group(function () {
    Route::get('/login', 'showLoginForm')->name('login');
    Route::post('/login', 'authenticate');
    Route::get('/logout', 'logout')->name('logout');
});

Route::controller(RegisterController::class)->group(function () {
    Route::get('/register', 'showRegistrationForm')->name('register');
    Route::post('/register', 'register');
});

// Profile

Route::controller(ProfileController::class)->group(function() {
    Route::get('/profiles/{username}', 'getProfile')->name('show.profile');
    Route::get('/profiles/{username}/edit', 'showEditProfileUI')->name('edit.profile.ui');
    Route::post('/profiles/{username}/edit', 'editProfile')->name('edit.profile');
});
