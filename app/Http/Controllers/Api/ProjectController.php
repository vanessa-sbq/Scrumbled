<?php

namespace App\Http\Controllers\Api;

use App\Models\AuthenticatedUser;
use App\Models\Developer;
use App\Models\DeveloperProject;
use App\Models\ProductOwner;
use App\Models\Project;
use App\Http\Controllers\Controller;
use App\Models\ScrumMaster;
use App\Models\Sprint;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ProjectController extends Controller
{

    public function changeVisibility(Request $request) {
        $projectSlug = $request->input('slug');

        $project = Project::where('slug', $projectSlug)->firstOrFail();

        $user = auth()->user();

        if (!Auth::guard("admin")->check() && $project->product_owner_id !== $user->id) {
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

        if (!Auth::guard("admin")->check()) {
            $user = auth()->user();
        }

        if ((!Auth::guard("admin")->check()) && ($project->product_owner_id !== $user->id)) {
            return response()->json(['status' => 'error', 'message' => 'Cannot perform these changes. Are you the Product Owner?'], 403);
        }

        $project->delete();
        return response()->json(['status' => 'success', 'message' => 'Project deleted', 'redirect' => '/projects'], 303);

    }

    public function transferProject(Request $request) {
        $projectSlug = $request->input('slug');
        $uid = $request->input('userId');
        $acceptLossOfSM = $request->input('sm_loss');
        $acceptLossOfDev = $request->input('dev_loss');

        Log::info($uid);

        $project = Project::where('slug', $projectSlug)->firstOrFail();
        $oldOwner = $project->product_owner_id;

        $newOwner = AuthenticatedUser::query()
            ->whereIn('id', function ($query) use ($project) {
                $query->select('developer_id')
                    ->from('developer_project')
                    ->where('project_id', $project->id);
            })
            ->where('id', $uid)->firstOrFail();

        $user = auth()->user();

        if (!Auth::guard("admin")->check() && $oldOwner !== $user->id) {
            return response()->json(['status' => 'error', 'message' => 'Cannot perform these changes. Are you the Product Owner?'], 403);
        }

        if ($oldOwner === $newOwner->id) {
            return response()->json(['status' => 'error', 'message' => 'The chosen person is already the Product Owner.']);
        }

        if ($newOwner->id === $project->scrum_master_id && (!isset($acceptLossOfSM))) {
            return response()->json(['status' => 'waiting_for_confirmation_sm', 'message' => 'The user ' . $newOwner->username . ' is a scrum master and cannot be both Product Owner and Scrum master at the same time. Continuing will remove ' . $user->username . ' from Scrum Master.']);
        }

        if (isset($acceptLossOfSM) && !$acceptLossOfSM) {
            return response()->json(['status' => 'error', 'message' => 'The user ' . $newOwner->username . ' is a scrum master and cannot be both Product Owner and Scrum master at the same time.']);
        } else {
            $project->scrum_master_id = null;
            $project->save();
        }



        foreach ($project->developers as $developer) {
            if ($newOwner->id === $developer->id && (!isset($acceptLossOfDev))) {
                return response()->json(['status' => 'waiting_for_confirmation_dev', 'message' => 'The user ' . $newOwner->username . ' is a developer and cannot be both PO and Developer at the same time.']);
            }
        }

        Log::info($acceptLossOfDev);

        if (isset($acceptLossOfDev) && !$acceptLossOfDev) {
            return response()->json(['status' => 'error', 'message' => 'The user ' . $newOwner->username . ' is a developer and cannot be both PO and Developer at the same time.']);
        } else {
            $project->developers()->detach($newOwner->id);

            $developerProject = DeveloperProject::where('project_id', $project->id)
                ->where('developer_id', $newOwner->id)
                ->first();

            if ($developerProject) {
                $developerProject->delete();
            }
        }

        $newPossiblePO = ProductOwner::where('user_id', $uid)->first();

        if (!isset($newPossiblePO)) {
            ProductOwner::create(['user_id' => $uid]);
        }

        $project->update(['product_owner_id' => $newOwner->id]);

        if (!Developer::where('user_id', $oldOwner)->exists()) {
            Developer::create([
                'user_id' => $oldOwner,
            ]);
        }

        if (!DeveloperProject::where(['developer_id' => $oldOwner, 'project_id' => $project->id ])->exists()) {
            DeveloperProject::create([
                'developer_id' => $oldOwner,
                'project_id' => $project->id,
            ]);
        }

        $backlogTasks = Task::where('project_id', $project->id)->where('state', 'BACKLOG')->get();
        $currentSprint = Sprint::where('project_id', $project->id)->where('is_archived', false)->first();
        $sprintBacklogTasks = $currentSprint ? $currentSprint->tasks()->where('state', 'SPRINT_BACKLOG')->get() : collect();

        foreach ($backlogTasks as $task) {
            $task->update(['assigned_to' => null]);
        }

        foreach ($sprintBacklogTasks as $task) {
            $task->update(['assigned_to' => null]);
        }

        return response()->json(['status' => 'success', 'message' => 'Project transferred']);
    }
    public function archiveProject(Request $request) {
        $projectSlug = $request->input('slug');

        $project = Project::where('slug', $projectSlug)->firstOrFail();

        $user = auth()->user();

        if ((!Auth::guard("admin")->check()) && ($project->product_owner_id !== $user->id)) {
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

        if (!Auth::guard("admin")->check() && $project->product_owner_id !== $user->id) {
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

        if (!Auth::guard("admin")->check() && $project->product_owner_id !== $user->id && $project->scrum_master_id !== $user->id) {
            return response()->json(['status' => 'error', 'message' => 'Do you have permission to perform these changes ?'], 403);
        }

        $project->update(['description' => $description]);
        return response()->json(['status' => 'success', 'message' => 'Archival state changed successfully']);
    }

    public function transferProjectSearch(Request $request) {
        $search = $request->input('search');
        $slug = $request->input('slug');

        // Find the project by slug
        $project = Project::query()->where('slug', $slug)->firstOrFail();

        $users = AuthenticatedUser::query()
            ->whereIn('id', function ($query) use ($project) {
                $query->select('developer_id')
                    ->from('developer_project')
                    ->where('project_id', $project->id);
            })
            ->where(function ($query) use ($search) {
                $query->where('username', 'like', "%{$search}%")
                    ->orWhere('full_name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            })
            ->get();


        $v = view('web.sections.project.components._userInvite', ['users' => $users])->render();

        return response()->json($v);
    }

    public function setScrumMaster(Request $request) {
        $projectSlug = $request->input('slug');
        $uid = $request->input('userId');

        if (!Auth::guard("admin")->check()) {
            $authId = Auth::user()->id;
        }

        $project = Project::where('slug', $projectSlug)->firstOrFail();

        if ((!Auth::guard("admin")->check()) && $authId != $project->product_owner_id) {
            return response()->json(['status' => 'error', 'message' => 'You do not have permission to set the Scrum Master.']);
        }

        if ($uid == $project->product_owner_id) {
            return response()->json(['status' => 'error', 'message' => 'Product Owner cannot be a Scrum Master.']);
        }

        $developers = [];
        foreach ($project->developers as $developer) {
            $developers[] = $developer->id;
        }

        //Log::info('Developers Array: ' . json_encode($developers));


        if (!in_array($uid, $developers)) {
            return response()->json(['status' => 'error', 'message' => 'The person does not belong to this project.']);
        }

        if (isset($project->scrum_master_id)) {
            return response()->json(['status' => 'error', 'message' => 'This role has been already taken.']);
        }

        if (!ScrumMaster::where(['developer_id' => $uid])->exists()) {
            ScrumMaster::create([
                'developer_id' => $uid
            ]);
        }

        $project->update(['scrum_master_id' => $uid]);
        return response()->json(['status' => 'success', 'message' => 'User attributed to Scrum Master.']);
    }


    public function removeScrumMaster(Request $request) {
        $projectSlug = $request->input('slug');
        $uid = $request->input('userId');

        if (!Auth::guard("admin")->check()) {
            $authId = Auth::user()->id;
        }

        $project = Project::where('slug', $projectSlug)->firstOrFail();

        if ((!Auth::guard("admin")->check()) && $authId != $project->product_owner_id && $authId != $project->scrum_master) {
            return response()->json(['status' => 'error', 'message' => 'You do not have permission to remove the Srum Master.']);
        }

        if ($uid == $project->product_owner_id) {
            return response()->json(['status' => 'error', 'message' => 'Product Owner is not a Scrum Master.']);
        }

        $developers = [];
        foreach ($project->developers as $developer) {
            $developers[] = $developer->id;
        }

        if (!in_array($uid, $developers)) {
            return response()->json(['status' => 'error', 'message' => 'The person does not belong to this project.']);
        }

        if (!isset($project->scrum_master_id)) {
            return response()->json(['status' => 'error', 'message' => 'This role is already empty.n.']);
        }

        $project->update(['scrum_master_id' => null]);
        return response()->json(['status' => 'success', 'message' => 'Scrum Master was removed successfully.']);
    }

    public function removeDeveloper(Request $request) {
        $projectSlug = $request->input('slug');
        $uid = $request->input('userId');

        if (!Auth::guard("admin")->check()) {
            $authId = Auth::user()->id;
        }

        $project = Project::where('slug', $projectSlug)->firstOrFail();

        if ((!Auth::guard("admin")->check()) && $authId != $project->product_owner_id) {
            return response()->json(['status' => 'error', 'message' => 'You do not have permission to remove a Developer.']);
        }

        if ($uid == $project->product_owner_id) {
            return response()->json(['status' => 'error', 'message' => 'Product Owner cannot be removed this way.']);
        }

        $developers = [];
        foreach ($project->developers as $developer) {
            $developers[] = $developer->id;
        }

        if (!in_array($uid, $developers)) {
            return response()->json(['status' => 'error', 'message' => 'The person does not belong to this project.']);
        }

        if ($project->scrum_master_id == $uid) {
            $project->update(['scrum_master_id' => null]);
        }

        $project->developers()->detach($uid);

        $developerProject = DeveloperProject::where('project_id', $project->id)
            ->where('developer_id', $uid)
            ->first();

        // Remove only if the record exists
        if ($developerProject) {
            $developerProject->delete();
        }

        $project->save();
        return response()->json(['status' => 'success', 'message' => 'Developer was removed successfully.', 'redirect' => route('projects.team.settings', $projectSlug)]);
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

    public function searchProjects(Request $request) {
        $search = $request->input('search');
        $statusVisibility = $request->input('statusVisibility');
        $statusArchival = $request->input('statusArchival');

        $query1 = Project::query()
            ->when($search, function ($query, $search) {
                $query->where(function ($query) use ($search) {
                    $query->where('title', 'like', "%{$search}%")
                        ->orWhere('slug', 'like', "%{$search}%")
                        ->orWhere('description', 'like', "%{$search}%");
                });
            });

        if ($statusVisibility !== "ANY") {
            $query1 = $query1->where('is_public', $statusVisibility === "PUBLIC");
        }

        if ($statusArchival !== "ANY") {
            $query1 = $query1->where('is_archived', $statusArchival === "ARCHIVED");
        }

        $projects = $query1->get();

        $v = view('admin.components._project', ['projects' => $projects])->render();
        return response()->json($v);
    }

}
