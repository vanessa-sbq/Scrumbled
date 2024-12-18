<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notification;
use App\Models\Project;
use App\Models\AuthenticatedUser;
use App\Models\DeveloperProject;
use App\Models\Developer;
use App\Events\InviteCreated;

class PusherController extends Controller
{
    public function inviteMember(Request $request, $slug)
    {
        $request->validate([
            'user_id' => 'required|exists:authenticated_user,id',
        ]);

        $project = Project::where('slug', $slug)->firstOrFail();
        $user = AuthenticatedUser::findOrFail($request->user_id);

        // Check if the user is already in the project
        $isUserInProject = DeveloperProject::where('project_id', $project->id)
            ->where('developer_id', $user->id)
            ->exists() || $project->product_owner_id == $user->id;

        if ($isUserInProject) {
            return redirect()->route('projects.show', $project->slug)->with('error', 'User is already in the project.');
        }

        // Add user to the developer table if not already present
        if (!Developer::where('user_id', $user->id)->exists()) {
            Developer::create([
                'user_id' => $user->id,
            ]);
        }

        // Attach the user to the project
        $project->developers()->attach($user);

        $notification = "New Invite Notification"; // TODO: Change
        event(new InviteCreated($notification));

        return redirect()->route('projects.team', $project->slug)->with('success', 'Member invited successfully.');
    }

    public function showPusherTest(){
        return view('pusher.pusher');
    }
}
