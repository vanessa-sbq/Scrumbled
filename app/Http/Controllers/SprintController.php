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
        $project = Project::where('slug', $slug)->firstOrFail();

        $openSprint = Sprint::where('project_id', $project->id)->where('is_archived', false)->first();

        if($openSprint){
            return redirect()->back()->withErrors(['error'=> 'There is already an active sprint!'])->withInput();
        }

        // Validate the request data
        $validated = $request->validate([
            'name' => 'nullable|string|max:255',
            'start_date' => 'nullable|date|after_or_equal:today',
            'end_date' => 'nullable|date|after:start_date',
            'is_archived' => 'nullable|boolean',
        ]);

        $startDate = $validated['start_date'] ?? now()->toDateString();

        $sprint = Sprint::create([
            'project_id' => $project->id,
            'name' => $validated['name'] ?? null,
            'start_date' => $startDate,
            'end_date' => $validated['end_date'] ?? null,
            'is_archived' => $validated['is_archived'] ?? false,
        ]);

        if ($this->authorize('create', $sprint)){
            $sprint->save();
            return redirect()->route('projects.show', $project->slug)->with('success', 'Sprint created successfully!');
        } else {
            return redirect()->back()->withErrors(['error'=> 'You are not authorized to create a sprint.'])->withInput();
        }
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
            'start_date' => 'nullable|date|after_or_equal:today',
            'end_date' => 'nullable|date|after:start_date',
            'is_archived' => 'nullable|boolean',
        ]);

        if ($this->authorize('update', $sprint)){
            $sprint->update([
                'name' => $validated['name'] ?? $sprint->name,
                'start_date' => $validated['start_date'] ?? $sprint->start_date,
                'end_date' => $validated['end_date'] ?? $sprint->end_date,
            ]);
            $project = $sprint->project;
            return redirect()->route('projects.show', $project->slug)->with('success', 'Sprint updated successfully.');
        }
        else{
            return redirect()->back()->withErrors(['error'=> 'You are not authorized to update this sprint.'])->withInput();
        }
    }

    public function close($id)
    {
        $sprint = Sprint::where('id', $id)->firstOrFail();

        if ($this->authorize('close', $sprint)){
            $tasks = $sprint->tasks()->where('state', '!=', 'ACCEPTED')->get();
            foreach ($tasks as $task) {
                $task->update(['state' => 'BACKLOG']);
            }
            $sprint->update(['is_archived' => true]);
            return redirect()->back()->with('success', 'Sprint closed successfully and tasks moved to BACKLOG!');
        }
        else{
            return redirect()->back()->withErrors(['error'=> 'You are not authorized to close this sprint.']);
        }
    }
}
