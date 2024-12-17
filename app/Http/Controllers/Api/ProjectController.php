<?php

namespace App\Http\Controllers\Api;

use App\Models\AuthenticatedUser;
use App\Models\DeveloperProject;
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

        $newSlug = transliterator_transliterate('Any-Latin; Latin-ASCII', $title);

        // Convert to lowercase
        $newSlug = strtolower($newSlug);

        // Replace spaces and special characters with hyphens
        $newSlug = preg_replace('/[^a-z0-9]+/', '-', $newSlug);

        // Trim hyphens from the start and end
        $newSlug = trim($newSlug, '-');

        $originalSlug = $newSlug; // Store the original slug for numbering
        $counter = 1;

        // Check for existing slug in the database and append a number if necessary
        while (Project::where('slug', $newSlug)->exists()) {
            $newSlug = $originalSlug . '-' . $counter;
            $counter++;
        }

        $project = Project::where('slug', $projectSlug)->firstOrFail();

        if ($title === $project->title || $newSlug === $project->slug) {
            return response()->json(['status' => 'error', 'message' => 'New title must be different than old title.'], 400);
        }

        $user = auth()->user();

        if (strlen($title) <= 0) {
            return response()->json(['status' => 'error', 'message' => 'Title cannot be empty.'], 400);
        }

        if ($project->product_owner_id !== $user->id) {
            return response()->json(['status' => 'error', 'message' => 'Cannot perform these changes. Are you the Product Owner?'], 403);
        }

        $project->update(['title' => $title, 'slug' => $newSlug]);
        return response()->json(['status' => 'success', 'message' => 'Archival state changed successfully', 'redirect' => route('projects.show', $newSlug)], 301);
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

    public function selfRemoveFromProject(Request $request) {
        $projectSlug = $request->input('slug');
        $uid = $request->input('userId');

        $user = auth()->user();

        $project = Project::where('slug', $projectSlug)->firstOrFail();

        if ($user->id != $uid) {
            return response()->json(['status' => 'error', 'message' => 'You cannot remove other members this way.'.$user->id], 400);
        }

        $projectManagement = [$project->scrum_master_id, $project->product_owner_id];
        $developers = [];
        foreach ($project->developers as $developer) {
            $developers[] = $developer->id;
        }

        if ((!in_array($uid, $projectManagement)) && (!in_array($uid, $developers))) {
            return response()->json(['status' => 'error', 'message' => 'You do not belong to this project.'], 400);
        }

        if ($uid == $project->product_owner_id) {
            return response()->json(['status' => 'error', 'message' => 'To remove your self from the project please transfer or delete the project.'], 400);
        }

        if ($uid == $project->scrum_master_id) {
            $project->update(['scrum_master_id' => null]);
        }

        if (in_array($uid, $developers)) {
            $project->developers()->detach($uid);

            $developerProject = DeveloperProject::where('project_id', $project->id)
                ->where('developer_id', $uid)
                ->first();

            // Remove only if the record exists
            if ($developerProject) {
                $developerProject->delete();
            }

        }

        $project->save();
        return response()->json(['status' => 'success', 'message' => 'You have been removed from the project.'], 200);
    }

}
