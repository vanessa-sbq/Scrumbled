<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Models\AuthenticatedUser;
use App\Models\Notification;
use App\Models\DeveloperProject;
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


    public function acceptInvitation(Request $request)
    {
        // Retrieve the project_id and developer_id from the request
        $project_id = $request->input('project_id');
        $developer_id = $request->input('developer_id');
        
        $invite = DeveloperProject::where('developer_id', $developer_id)
            ->where('project_id', $project_id)
            ->first();
        
        $updated = DB::table('developer_project')
        ->where('developer_id', $developer_id)
        ->where('project_id', $project_id)
        ->update(['is_pending' => false, 'updated_at' => now()]);
    
        if (!$updated) {
            return redirect()->back()->with('error', 'Failed to accept the invitation.');
        }
        return redirect()->back()->with('success', 'Invitation accepted successfully.');
    }
}
