<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\SprintController;
use App\Http\Controllers\InboxController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;

use App\Http\Controllers\Admin\LoginController as AdminLoginController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\ProjectController as AdminProjectController;
use App\Http\Controllers\ProfileController as ProfileController;
use App\Http\Controllers\TaskController;

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

Route::middleware(['no.admin'])->group(function () {
    // Home
    Route::view("/", 'web.sections.static.home')->name('homePage');

    // Static routes
    Route::view('/about', 'web.sections.static.about')->name('about');
    Route::view('/contact', 'web.sections.static.contact')->name('contact');
    Route::view('/faq', 'web.sections.static.faq')->name('faq');
});

Route::redirect('/admin', '/admin/login');

// Admin
Route::prefix('admin')->group(function () {
    Route::get('/login', [AdminLoginController::class, 'showLoginForm'])->name('admin.login');
    Route::post('/login', [AdminLoginController::class, 'login']);
    Route::post('/api/users/delete', [AdminUserController::class, 'deleteUser']);
    Route::middleware(['auth:admin'])->group(function () {
        Route::get('/users/create', [AdminUserController::class, 'showCreate'])->name('admin.users.showCreate');
        Route::post('/users/create', [AdminUserController::class, 'createUser'])->name('admin.users.createUser');

        Route::get('/logout', [AdminLoginController::class, 'logout'])->name('admin.logout');
        Route::get('/users', [AdminUserController::class, 'list'])->name('admin.users');
        Route::get('/users/{username}', [AdminUserController::class, 'show'])->name('admin.users.show');
        Route::get('/users/{username}/edit', [AdminUserController::class, 'showEdit'])->name('admin.users.showEdit');
        Route::post('/users/{username}/edit', [AdminUserController::class, 'edit'])->name('admin.users.edit');
        Route::post('/users/{username}/ban', [AdminUserController::class, 'ban'])->name('admin.users.ban');
        Route::post('/users/{username}/unban', [AdminUserController::class, 'unban'])->name('admin.users.unban');
        Route::get('/projects', [AdminProjectController::class, 'projectList'])->name('admin.projects');
    });
});

// Projects
Route::controller(ProjectController::class)->group(function () {
    Route::middleware(['no.admin'])->group(function () {
        Route::get('/projects', 'list')->name('projects');
        Route::middleware(['auth'])->group(function () {
            Route::get('/projects/new', 'create')->name('projects.create');
            Route::post('/projects/new', 'store')->name('projects.store');
        });
        Route::middleware(['auth'])->group(function () {
            Route::post('/projects/{slug}/favorite', 'updateFavorite')->name('projects.updateFavorite'); // FIXME: Should this be inside the middleware? Doesn't it expose data to public?
        });
    });

        Route::middleware(['project.membership'])->group(function () {
            Route::get('/projects/{slug}', 'show')->name('projects.show');
            Route::get('/projects/{slug}/backlog', 'backlog')->name('projects.backlog');
            Route::get('/projects/{slug}/team', 'showTeam')->name('projects.team');
            Route::get('/projects/{slug}/settings/general', 'showProjectSettings')->name('projects.settings');
            Route::get('/projects/{slug}/settings/team', 'showProjectSettings')->name('projects.team.settings');
            Route::get('/projects/{slug}/tasks', 'showTasks')->name('projects.tasks');
            Route::get('/projects/{slug}/tasks/search', 'searchTasks')->name('projects.tasks.search');
            Route::post('projects/{slug}/leave', 'leave')->name('projects.leave');
        });

        Route::middleware(['product.owner'])->group(function () {
            Route::get('/projects/{slug}/invite', 'showInviteForm')->name('projects.inviteForm');
            Route::post('/projects/{slug}/invite', 'inviteMember')->name('projects.invite.submit');
            Route::post('/projects/{slug}/remove/{username}', 'remove')->name('projects.remove');
        });

});

// Authentication
Route::controller(LoginController::class)->group(function () {
    Route::get('/login', 'showLoginForm')->name('login');
    Route::post('/login', 'authenticate');
    Route::middleware(['no.admin'])->group(function () {
        Route::get('/login/forgot-password', 'forgotPassword')->name('login.forgotPassword');
        Route::post('/login/reset-password', 'resetPassword')->name('login.resetPassword');
    });
    Route::get('/logout', 'logout')->name('logout')->middleware(['auth:web']);
});

Route::controller(RegisterController::class)->group(function () {
    Route::middleware(['guest', 'no.admin'])->group(function () {
        Route::get('/register', 'showRegistrationForm')->name('register');
        Route::post('/register', 'register');
    });
});

// Profile
Route::controller(ProfileController::class)->group(function () {
    Route::middleware(['no.admin'])->group(function () {
        Route::get('/profiles', 'index')->name('profiles');
        Route::get('/profiles/{username}', 'getProfile')->name('show.profile');
        Route::middleware(['auth', 'no.admin'])->group(function () {
            Route::get('/profiles/{username}/edit', 'showEditProfileUI')->name('edit.profile.ui');
            Route::post('/profiles/{username}/edit', 'editProfile')->name('edit.profile');
        });
    });
});

// Inbox
Route::controller(InboxController::class)->group(function () {
    Route::middleware(['auth', 'no.admin'])->group(function () {
        Route::get('/inbox', 'index')->name('inbox');
        Route::get('/inbox/invitations', 'filterByInvitations')->name('inbox.invitations');
        Route::post('/inbox/acceptInvitation', 'acceptInvitation')->name('inbox.acceptInvitation');
        Route::post('/inbox/declineInvitation', 'declineInvitation')->name('inbox.declineInvitation');
        Route::post('/inbox/delete', 'delete')->name('inbox.delete');
    });
});

// API
Route::controller(\App\Http\Controllers\Api\UserController::class)->group(function () {
    Route::get('/api/profiles/search', 'search');
});

Route::controller(\App\Http\Controllers\Api\ProjectController::class)->group(function () {
    Route::middleware(['auth.admin_or_user'])->group(function () {
        Route::post('/api/projects/changeVisibility', 'changeVisibility');
        Route::post('/api/projects/transferProject', 'transferProject');
        Route::get('/api/profiles/transferProject/search', 'transferProjectSearch'); // FIXME: Change this
        Route::post('/api/projects/team/setScrumMaster', 'setScrumMaster');
        Route::post('/api/projects/team/removeScrumMaster', 'removeScrumMaster');
        Route::post('/api/projects/team/removeDeveloper', 'removeDeveloper');
        Route::post('/api/projects/leaveProject', 'selfRemoveFromProject');
        Route::post('/api/projects/archiveProject', 'archiveProject');
        Route::post('/api/projects/deleteProject', 'deleteProject');
        Route::post('/api/projects/changeProjectTitle', 'changeProjectTitle');
        Route::post('/api/projects/changeProjectDescription', 'changeProjectDescription');
        Route::get('/api/projects/search', 'searchProjects');
    });
});

// TODO: Remove
/* Route::controller(\App\Http\Controllers\Api\TaskController::class)->group(function () {
    Route::get('/api/projects/{slug}/tasks/search', 'search');
}); */

//Sprints
Route::controller(SprintController::class)->group(function () {
        Route::get('/projects/{slug}/sprints', 'list')->name('sprints');
        Route::middleware(['auth.admin_or_user'])->group(function () {
            Route::get('/projects/{slug}/sprints/new', 'create')->name('sprint.create');
            Route::post('/projects/{slug}/sprints/new', 'store')->name('sprint.store');
            Route::get('/sprints/{id}/edit', 'edit')->name('sprint.edit');
            Route::post('/sprints/{id}/edit', 'update')->name('sprint.update');
            Route::post('sprints/{id}/close', 'close')->name('sprint.close');
        });
        Route::get('/sprints/{id}', 'show')->name('sprint.show');
});

//Tasks
Route::controller(TaskController::class)->group(function () {
    Route::middleware(['auth.admin_or_user'])->group(function () {
        Route::post('/tasks/{id}/assign', 'assign')->name('tasks.assign');
        Route::get('projects/{slug}/tasks/new', 'showNew')->name('tasks.showNew');
        Route::post('projects/{slug}/tasks/new', 'createNew')->name('tasks.createNew');
        Route::get('projects/{slug}/tasks/{id}/edit', 'showEdit')->name('tasks.showEdit');
        Route::post('projects/{slug}/tasks/{id}/edit', 'editTask')->name('tasks.editTask');
        Route::post('/tasks/{id}/state', 'updateState')->name('tasks.updateState');
    });
    Route::get('/tasks/{id}', 'show')->name('task.show');
});

//Comments
Route::controller(CommentController::class)->group(function () {
    Route::middleware(['auth.admin_or_user'])->group(function () {
        Route::post('/tasks/{id}/comment', 'create')->name('comments.create');
        Route::post('/comments/{id}', 'delete')->name('comments.delete');
        Route::post('/comments/{id}/edit', 'edit')->name('comments.edit');
    });
});
