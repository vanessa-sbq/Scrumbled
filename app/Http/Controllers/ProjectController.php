<?php

namespace App\Http\Controllers;

use App\Models\AuthenticatedUser;
use App\Models\Developer;
use App\Models\DeveloperProject;
use App\Models\Favorite;
use App\Models\Sprint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Project;
use App\Models\Task;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Pagination\Paginator;

class ProjectController extends Controller
{
    /**
     * Display a listing of the user's projects.
     *
     * @return \Illuminate\View\View
     */
    public function list(Request $request)
    {
        /** @var AuthenticatedUser $user */
        $user = Auth::user();
        $type = $request->query('type', $user ? 'my_projects' : 'public');

        if ($type === 'my_projects' && $user) {
            $projects = $user->allProjects();
        } elseif ($type === 'public') {
            $projects = Project::where('is_public', true)->get();
        } elseif ($type === 'favorites' && $user) {
            $projects = $user->favorites()->get();
        } else {
            $projects = collect(); // Empty collection if no valid type
        }

        return view('web.sections.project.index', compact('projects', 'type'));
    }

    /**
     * Display the specified project.
     *
     * @param  string  $slug
     * @return \Illuminate\View\View
     */
    public function show($slug)
    {
        $project = Project::where('slug', $slug)->firstOrFail();

        $sprint = Sprint::where('project_id', $project->id)
            ->where('is_archived', false)
            ->first();

        $sprintBacklogTasks = $sprint ? $sprint->tasks()->where('state', 'SPRINT_BACKLOG')->get() : collect();
        $inProgressTasks = $sprint ? $sprint->tasks()->where('state', 'IN_PROGRESS')->get() : collect();
        $doneTasks = $sprint ? $sprint->tasks()->where('state', 'DONE')->get() : collect();
        $acceptedTasks = $sprint ? $sprint->tasks()->where('state', 'ACCEPTED')->get() : collect();

        return view('web.sections.project.show', compact(
            'project',
            'sprint',
            'sprintBacklogTasks',
            'inProgressTasks',
            'doneTasks',
            'acceptedTasks'
        ));
    }

    public function showTasks($slug)
    {
        $project = Project::where('slug', $slug)->firstOrFail();
        $tasks = Task::where('project_id', $project->id)->get();

        return view('web.sections.task.index', compact('project', 'tasks'));
    }

    /**
     * Show the form for creating a new project.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('web.sections.project.create');
    }

    /**
     * Store a newly created project in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'is_public' => 'required|boolean',
        ]);

        // Ensure the authenticated user is set
        $user = auth()->user();

        try {
            $project = new Project();
            $project->title = $request->title;
            $project->description = $request->description;
            $project->is_public = $request->is_public;
            $project->is_archived = false; // Default to false
            $project->product_owner_id = $user->id;

            // Generate a unique slug
            $slug = Str::slug($request->title);
            $originalSlug = $slug;
            $counter = 1;

            while (Project::where('slug', $slug)->exists()) {
                $slug = $originalSlug . '-' . $counter;
                $counter++;
            }

            $project->slug = $slug;

            // Log the project attributes before saving
            Log::info('Project attributes before saving:', $project->getAttributes());

            $project->save();

            // Log the project attributes after saving
            Log::info('Project attributes after saving:', $project->getAttributes());

            return redirect()->route('projects.show', $project->slug)->with('success', 'Project created successfully.');
        } catch (QueryException $e) {
            // Log detailed error information
            Log::error('QueryException:', ['error' => $e->getMessage(), 'errorInfo' => $e->errorInfo]);

            if ($e->errorInfo[1] == 1062) { // 1062 is the error code for duplicate entry
                return back()->withErrors(['title' => 'Title already in use.'])->withInput();
            }
            return back()->withErrors(['error' => 'An error occurred while creating the project.'])->withInput();
        }
    }

    public function showTeam($slug)
    {
        $project = Project::where('slug', $slug)->with(['productOwner', 'scrumMaster', 'developers'])->firstOrFail();
        return view('web.sections.project.team', compact('project'));
    }

    /**
     * Show the form for inviting a member to the project.
     *
     * @param string $slug
     * @return \Illuminate\View\View
     */
    public function showInviteForm($slug)
    {
        $project = Project::where('slug', $slug)->firstOrFail();

        // Get the IDs of users who are already in the project
        $existingUserIds = DeveloperProject::where('project_id', $project->id)
            ->pluck('developer_id')
            ->toArray();
        $existingUserIds[] = $project->product_owner_id;

        // Get all users that are not already in the project
        $users = AuthenticatedUser::whereNotIn('id', $existingUserIds)->paginate(10);

        return view('web.sections.project.invite', compact('project', 'users'));
    }

    /**
     * Invite a member to the project.
     *
     * @param \Illuminate\Http\Request $request
     * @param string $slug
     * @return \Illuminate\Http\RedirectResponse
     */
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

        if (!DeveloperProject::where(['developer_id' => $user->id, 'project_id' => $project->id ])->exists()) {
            DeveloperProject::create([
                'developer_id' => $user->id,
                'project_id' => $project->id,
            ]);
        }

        return redirect()->route('projects.team.settings', $project->slug)->with('success', 'Member invited successfully.');
    }

    public function backlog($slug)
    {
        $project = Project::where('slug', $slug)->firstOrFail();
        $backlogTasks = Task::where('project_id', $project->id)->where('state', 'BACKLOG')->get();
        $currentSprint = Sprint::where('project_id', $project->id)->where('is_archived', false)->first();

        $sprintBacklogTasks = $currentSprint ? $currentSprint->tasks()->where('state', 'SPRINT_BACKLOG')->get() : collect();

        return view('web.sections.project.backlog', compact('project', 'backlogTasks', 'currentSprint', 'sprintBacklogTasks'));
    }

    public function searchTasks(Request $request)
    {
        $url = $request->url();
        $slug = explode('/', $url)[4];
        $project = Project::where('slug', $slug)->firstOrFail();

        // Base query for tasks in the project
        $tasks = Task::where('project_id', $project->id);

        // Handle search query
        $search = $request->input('query');
        if (!empty($search)) {
            $tasks->where(function ($queryBuilder) use ($search) {
                $queryBuilder->whereRaw("tsvectors @@ plainto_tsquery('english', ?)", [$search])
                    ->orWhere('title', 'LIKE', '%' . $search . '%');
            })->orderByRaw('ts_rank(tsvectors, plainto_tsquery(\'english\', ?)) DESC', [$search]);
        }

        // Apply filters
        if ($request->filled('assigned_to')) {
            $tasks->where('assigned_to', $request->input('assigned_to'));
        }

        if ($request->filled('value')) {
            $tasks->where('value', $request->input('value'));
        }

        if ($request->filled('state')) {
            $tasks->where('state', $request->input('state'));
        }

        if ($request->filled('effort')) {
            $tasks->where('effort', $request->input('effort'));
        }

        // Get the filtered tasks
        $tasks = $tasks->get();

        // Handle AJAX requests
        if ($request->ajax()) {
            return response()->json([
                'html' => view('web.sections.task.components._task', ['tasks' => $tasks])->render()
            ]);
        }

        // Handle regular requests
        $developers = $project->developers;

        return view('web.sections.task.index', [
            'project' => $project,
            'tasks' => $tasks,
            'developers' => $developers,
        ]);
    }


    public function leave($slug) {
        $project = Project::where('slug', $slug)->firstOrFail();
        $user = auth()->user();

        // Check if the user is part of the project
        if ($project->developers()->where('developer_id', $user->id)->exists()) {
            // Detach the user from the project
            $project->developers()->detach($user->id);

            if ($project->scrum_master_id === $user->id) {
                $project->update(['scrum_master_id' => null]);
            }

            return redirect()->route('projects', $project->slug)
                ->with('success', 'You have left the project!');
        }

        // If user is not in the project
        return redirect()->route('projects.show', $project->slug)
            ->with('error', 'An error occurred while leaving the project.');
    }

    public function remove($slug, $username) {
        $project = Project::where('slug', $slug)->firstOrFail();
        $user = AuthenticatedUser::where('username', $username)->firstOrFail();

        if ($project->product_owner_id === $user->id) {
            return redirect()->route('projects.show', $project->slug)
                ->with('error', 'You cannot remove the Product Owner.');
        }

        $project->developers()->detach($user->id);

        if ($project->scrum_master_id === $user->id) {
            $project->update(['scrum_master_id' => null]);
        }

        return redirect()->route('projects.team', $project->slug)
            ->with('success', 'Member has been removed successfully.');
    }

    public function updateFavorite($slug) {
        $project = Project::where('slug', $slug)->firstOrFail();
        $user = auth()->user();

        $favorite = Favorite::where('user_id', $user->id)
            ->where('project_id', $project->id)
            ->first();

        if ($favorite) {
            Favorite::where('user_id', $user->id)
                ->where('project_id', $project->id)
                ->delete();

            return response()->json(['status' => 'success', 'message' => "Unfavorited!"]);
        } else {
            // Favorite logic
            Favorite::create([
                'user_id' => $user->id,
                'project_id' => $project->id,
            ]);
            return response()->json(['status' => 'success', 'message' => "Favorited!"]);
        }
    }

    public function showProjectSettings($slug)
    {
        $project = Project::where('slug', $slug)->with(['productOwner', 'scrumMaster', 'developers'])->firstOrFail();
        $users = AuthenticatedUser::paginate(5);

        // Get the IDs to exclude
        $excludedIds = [$project->scrum_master_id, $project->product_owner_id];
        foreach ($project->developers as $developer) {
            $excludedIds[] = $developer->id;
        }

        $collection = $users->getCollection();
        $filteredCollection = $collection->filter(function($users) use ($excludedIds) {
            return !in_array($users->id, $excludedIds);
        });
        $users->setCollection($filteredCollection);

        $developers = $project->developers()->paginate(2);
        return view('web.sections.project.settings', compact('project', 'users', 'developers'));
    }

}
