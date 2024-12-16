<?php

namespace App\Http\Controllers\Api;

use App\Models\AuthenticatedUser;
use App\Models\ProductOwner;
use App\Models\Project;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProjectController extends Controller
{

    public function changeVisibility(Request $request) {
        $projectSlug = $request->input('slug');

        $project = Project::where('slug', $projectSlug)->firstOrFail();

        $user = auth()->user();

        if ($project->product_owner_id !== $user->id) {
            return response()->json(['status' => 'error', 'message' => 'Cannot perform these changes. Are you the Product Owner?'], 403);
            //return redirect()->route('projects.settings', $project->slug)->with('error', 'Cannot perform these changes. Are you the Product Owner?');
        }

        $project->update(['is_public' => !$project->is_public]);
        return response()->json(['status' => 'success', 'message' => 'Visibility change successful']);
        //return redirect()->route('projects.settings', $project->slug)->with('success', 'Visibility change successful.');
    }

    public function deleteProject(Request $request) {
        $projectSlug = $request->input('slug');

        $project = Project::where('slug', $projectSlug)->firstOrFail();

        $user = auth()->user();

        if ($project->product_owner_id !== $user->id) {
            return response()->json(['status' => 'error', 'message' => 'Cannot perform these changes. Are you the Product Owner?'], 403);
        }

        $project->delete();
        return response()->json(['status' => 'success', 'message' => 'Project deleted', 'redirect' => '/projects'], 303);

    }

    public function transferProject(Request $request) {
        $projectSlug = $request->input('slug');
        $uid = $request->input('userId');

        $project = Project::where('slug', $projectSlug)->firstOrFail();
        $newOwner = AuthenticatedUser::where('id', $uid)->firstOrFail();

        $user = auth()->user();

        if ($project->product_owner_id !== $user->id) {
            return response()->json(['status' => 'error', 'message' => 'Cannot perform these changes. Are you the Product Owner?'], 403);
        }

        if ($project->product_owner_id === $newOwner->id) {
            return response()->json(['status' => 'error', 'message' => 'You are already the Product Owner.']);
        }

        if ($newOwner->id === $project->scrum_master_id) {
            return response()->json(['status' => 'error', 'message' => 'The user ' . $user->username . 'is a scrum master and cannot be both PO and Scrum master at the same time.']);
        }

        foreach ($project->developers as $developer) {
            if ($newOwner->id === $developer->id) {
                return response()->json(['status' => 'error', 'message' => 'The user ' . $user->username . 'is a developer and cannot be both PO and Developer at the same time.']);
            }
        }

        $oldPossiblePO = ProductOwner::where('user_id', $uid)->first();

        if (!isset($oldPossiblePO)) {
            ProductOwner::create(['user_id' => $uid]);
        }

        $project->update(['product_owner_id' => $newOwner->id]);

        return response()->json(['status' => 'success', 'message' => 'Project transferred']);
    }
    public function archiveProject(Request $request) {
        $projectSlug = $request->input('slug');

        $project = Project::where('slug', $projectSlug)->firstOrFail();

        $user = auth()->user();

        if ($project->product_owner_id !== $user->id) {
            return response()->json(['status' => 'error', 'message' => 'Cannot perform these changes. Are you the Product Owner?'], 403);
        }

        $project->update(['is_archived' => !$project->is_archived]);
        return response()->json(['status' => 'success', 'message' => 'Archival state changed successfully']);
    }

    public function changeProjectTitle(Request $request) {
        $projectSlug = $request->input('slug');
        $title = $request->input('title');

        $project = Project::where('slug', $projectSlug)->firstOrFail();

        $user = auth()->user();

        if (strlen($title) <= 0) {
            return response()->json(['status' => 'error', 'message' => 'Description cannot exceed 5000 characters.'], 400);
        }

        if ($project->product_owner_id !== $user->id) {
            return response()->json(['status' => 'error', 'message' => 'Cannot perform these changes. Are you the Product Owner?'], 403);
        }

        $project->update(['title' => $title]);
        return response()->json(['status' => 'success', 'message' => 'Archival state changed successfully']);
    }

    public function changeProjectDescription(Request $request) {
        $projectSlug = $request->input('slug');
        $description = $request->input('description');

        $project = Project::where('slug', $projectSlug)->firstOrFail();

        $user = auth()->user();

        if (strlen($description) > 5000) {
            return response()->json(['status' => 'error', 'message' => 'Description cannot exceed 5000 characters.'], 400);
        }

        if ($project->product_owner_id !== $user->id && $project->scrum_master_id !== $user->id) {
            return response()->json(['status' => 'error', 'message' => 'Do you have permission to perform these changes ?'], 403);
        }

        $project->update(['description' => $description]);
        return response()->json(['status' => 'success', 'message' => 'Archival state changed successfully']);
    }

    public function transferProjectSearch(Request $request) {
        $search = $request->input('search');

        $users = AuthenticatedUser::query()
            ->where('username', 'like', "%{$search}%")
            ->orWhere('full_name', 'like', "%{$search}%")
            ->orWhere('email', 'like', "%{$search}%")
            ->get();

        $v = view('web.sections.project.components._userInvite', ['users' => $users])->render();

        return response()->json($v);
    }

    public function setScrumMaster() {

    }

    public function removeScrumMaster() {

    }

    public function removeDeveloper() {

    }

}
