<?php

use App\Http\Controllers\ProjectController;
use App\Http\Controllers\SprintController;
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

    Route::get('/users', [AdminUserController::class,'list'])->name('admin.users');
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

//Sprints
Route::controller(SprintController::class)->group(function () {
    Route::get('/projects/{slug}/sprints', 'list')->name('sprints');
    Route::get('/projects/{slug}/sprints/new', 'create')->name('sprint.create');
    Route::post('/projects/{slug}/sprints/new', 'store')->name('sprint.store');
    Route::get('/sprints/{id}/edit', 'edit')->name('sprint.edit');
    Route::post('/sprints/{id}/edit', 'update')->name('sprint.update');
    Route::post('sprints/{id}/close', 'close')->name('sprint.close');
    Route::get('/sprints/{id}', 'show')->name('sprint.show'); //For info about all sprints(Past, Present, Future)??
});
