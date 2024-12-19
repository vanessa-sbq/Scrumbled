<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Models\AuthenticatedUser;
use App\Models\Notification;
use App\Models\DeveloperProject;
use App\Models\Developer;
use App\Models\Project;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use App\Events\NewNotification;

class InboxController extends Controller
{
    /*
     * Auxiliary function to get the infos for a notifications array
     */
    public function getNotificationInfos($notifications){
        // Return an empty array if there are no notifications
        if (empty($notifications)) {
            return [];
        }

        $notificationInfos = [];

        foreach($notifications as $notification){
            if ($notification->project_id) {
                $notificationInfo['project'] = Project::find($notification->project_id);
                $notificationInfo['current_po'] = AuthenticatedUser::find($notificationInfo['project']->product_owner_id);
            }

            if ($notification->invited_user_id){
                $notificationInfo['invited_user'] = AuthenticatedUser::find($notification->invited_user_id)->username;
            }

            if ($notification->task_id){
                $notificationInfo['task_title'] = Task::find($notification->task_id)->title; 
            }

            if ($notification->completed_by){
                $notificationInfo['completed_by'] = AuthenticatedUser::find($notification->completed_by)->username;   
            }

            if ($notification->old_product_owner_id){
                $notificationInfo['old_po'] = AuthenticatedUser::find($notification->old_product_owner_id)->username;   
            }

            if ($notification->new_product_owner_id){
                $notificationInfo['new_po'] = AuthenticatedUser::find($notification->new_product_owner_id)->username;   
            }

            $notificationInfo['type'] = $notification->type;
            $notificationInfo['id'] = $notification->id;
            $notificationInfo['receiver_id'] = $notification->receiver_id;
            $notificationInfo['created_at'] = $notification->created_at;
            
            $notificationInfos[] = $notificationInfo;
        }

        return $notificationInfos;
    }


    public function index()
    {
        $user = Auth::user();
        $notifications = Notification::where('receiver_id', $user->id)->paginate(5);
        $notificationInfos = self::getNotificationInfos($notifications);
        return view('web.sections.inbox.index', compact('notificationInfos', 'notifications'));
    }

    public function filterByInvitations(){
        $user = Auth::user();
        $notifications = Notification::where('receiver_id', $user->id)->where('type', 'INVITE')->paginate(5);
        $notificationInfos = self::getNotificationInfos($notifications);
        return view('web.sections.inbox.index', compact('notificationInfos', 'notifications'));
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

        session()->flash('fire_event', true);
        $user = Auth::user();

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

    /* public function delete(Request $request) {
        $validated = $request->validate([
            'selected_notifications' => 'required|array|min:1', // Ensure at least one ID is selected
        ]);

        Notification::whereIn('id', $request->selected_notifications)->delete();

        return redirect()->back()->with('success', 'Notifications deleted successfully.');
    } */
    public function delete(Request $request) {
        $validated = $request->validate([
            'selected_notifications' => 'required|array|min:1', // Ensure at least one ID is selected
        ]);
    
        // Get the selected notifications
        $notifications = Notification::whereIn('id', $request->selected_notifications)->get();
    
        // Loop through the notifications
        foreach ($notifications as $notification) {
            if ($notification->type == 'INVITE') {
                $user = Auth::user();
                $project_id = $notification->project_id;
                $developer_id = $notification->receiver_id;
                $id = $notification->id;
                $deleted = DB::table('developer_project')
                    ->where('developer_id', $developer_id)
                    ->where('project_id', $project_id)
                    ->delete();
                Notification::where('id', $id)->delete(); // Delete the corresponding notification
            } else {
                $notification->delete();
            }
        }
    
        return redirect()->back()->with('success', 'Notifications processed successfully.');
    }

}
