<?php

namespace App\Http\Controllers;

use App\Models\AuthenticatedUser;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;

class InboxController extends Controller
{

    public function index()
    {
        return view('web.sections.inbox.index');
    }
}
