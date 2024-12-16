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
        $notifications = Notification::where('receiver_id', $user->id)->paginate(5);
        return view('web.sections.inbox.index', compact('notifications'));
    }

    public function filterByInvitations(){
        $user = Auth::user();
        $notifications = Notification::where('receiver_id', $user->id)->where('type', 'INVITE')->paginate(5);
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
    
    public function declineInvitation(Request $request)
    {
        $project_id = $request->input('project_id');
        $developer_id = $request->input('developer_id');
        $id = $request->input('id');

        $deleted = DB::table('developer_project')
            ->where('developer_id', $developer_id)
            ->where('project_id', $project_id)
            ->delete();

        if (!$deleted) {
            return redirect()->back()->with('error', 'Failed to decline the invitation.');
        }
        Notification::where('id', $id)->delete(); // Delete the corresponding notification
        return redirect()->back()->with('success', 'Invitation declined successfully.');
    }    

    public function delete(Request $request) {
        $validated = $request->validate([
            'selected_notifications' => 'required|array|min:1', // Ensure at least one ID is selected
        ]);

        Notification::whereIn('id', $request->selected_notifications)->delete();

        return redirect()->back()->with('success', 'Notifications deleted successfully.');
    }

}
