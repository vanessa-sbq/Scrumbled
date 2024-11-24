<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Sprint;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class SprintController extends Controller {
    /**
     * Display a specific sprint.
     *
     * @param  string  $id
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        //Get the current sprint
        $sprint = Sprint::where('id', $id)->firstOrFail();

        //Divide the tasks in categories
        $sprintBacklogTasks = $sprint->tasks()->where('state', 'SPRINT_BACKLOG')->get();
        $inProgressTasks = $sprint->tasks()->where('state', 'IN_PROGRESS')->get();
        $doneTasks = $sprint->tasks()->where('state', 'DONE')->get();
        $acceptedTasks = $sprint->tasks()->where('state', 'ACCEPTED')->get();

        return view('web.sections.sprint.show', compact(
            'sprint',
            'sprintBacklogTasks',
            'inProgressTasks',
            'doneTasks',
            'acceptedTasks'
        ));
    }

    /**
     * Display all sprints of a specific project.
     *
     * @param  string  $slug
     * @return \Illuminate\View\View
     */
    public function list($slug)
    {
        // Get project by slug
        $project = Project::where('slug', $slug)->firstOrFail();

        // Get all sprints for this project
        $sprints = Sprint::where('project_id', $project->id)->get();

        return view('web.sections.sprint.index', compact('project', 'sprints'), [
            'sprints' => $sprints,
            'project' => $project,
        ]);
    }

    /**
     * Show the form for creating a new sprint.
     *
     * @return \Illuminate\View\View
     */
    public function create($slug)
    {
        $project = Project::where('slug', $slug)->firstOrFail();

        return view('web.sections.sprint.create', compact('project'));
    }

    /**
     * Store a newly created sprint in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request, $slug)
    {
        // Get project by slug
        $project = Project::where('slug', $slug)->firstOrFail();

        // Validate the request data
        $validated = $request->validate([
            'name' => 'nullable|string|max:255',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'is_archived' => 'nullable|boolean',
        ]);

        // Create the sprint with default values where needed
        $sprint = Sprint::create([
            'project_id' => $project->id,
            'name' => $validated['name'] ?? null,
            'start_date' => $validated['start_date'] ?? now(),
            'end_date' => $validated['end_date'] ?? null,
            'is_archived' => $validated['is_archived'] ?? false,
        ]);

        // Redirect to a relevant page (e.g., project or sprint list)
        return redirect()->route('projects.show', $project->slug)
            ->with('success', 'Sprint created successfully!');
    }

    public function edit($id)
    {
        $sprint = Sprint::where('id', $id)->firstOrFail();

        return view('web.sections.sprint.edit', compact('sprint'));
    }

    public function update(Request $request, $id)
    {
        $sprint = Sprint::where('id', $id)->firstOrFail();

        $user = auth()->user();
        if(!$user) {
            return redirect('/login')->with('error', 'Login required.');
        }

        $validated = $request->validate([
            'name' => 'nullable|string|max:255',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'is_archived' => 'nullable|boolean',
        ]);

        $sprint->update([
            'name' => $validated['name'] ?? $sprint->name,
            'start_date' => $validated['start_date'] ?? $sprint->start_date,
            'end_date' => $validated['end_date'] ?? $sprint->end_date,
        ]);

        return redirect()->route('sprint.show', $sprint->id)->with('success', 'Sprint updated successfully.');
    }

    public function close($id)
    {
        $sprint = Sprint::where('id', $id)->firstOrFail();

        $sprint->update(['is_archived' => true]);

        $project = $sprint->project ;

        return redirect()->back()->with('success', 'Sprint closed successfully!');
    }
}
