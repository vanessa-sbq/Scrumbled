<?php

namespace App\Http\Controllers;

use App\Models\AuthenticatedUser;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;

class InboxController extends Controller
{

    public function index()
    {
        $user = Auth::user();
        $notifications = Notification::where('receiver_id', $user->id)->get();
        return view('web.sections.inbox.index', compact('notifications'));
    }
}
