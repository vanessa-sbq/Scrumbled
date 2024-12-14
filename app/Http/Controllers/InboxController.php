<?php

namespace App\Http\Controllers;

use App\Models\AuthenticatedUser;
use App\Models\Notification;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;

class InboxController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $notifications = Notification::where('receiver_id', $user->id) ->get();

        return view('web.sections.inbox.index', [
            'user' => $user,
            'notifications' => $notifications
        ]);
    }

    public function showNotifications()
    {
        $tasks = Task::where('project_id', $project->id)->get();

        return view('web.sections.task.index', compact('project', 'tasks'));
    }
}
