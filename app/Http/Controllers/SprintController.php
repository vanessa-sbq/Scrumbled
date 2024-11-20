<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Sprint;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SprintController extends Controller {
    /**
     * Display sprint of the specified project.
     *
     * @param  string  $slug
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $sprint = Sprint::where('id', $id)->firstOrFail();

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
        public function store(Request $request, Project $project)
        {
            $request->validate([
                'name' => 'string|max:255',
                'start_date' => 'date',
                'end_date' => 'date|after:start_date',
                'is_archived' => 'boolean',
            ]);

            $user = auth()->user();
            if(!$user) {
                return redirect('/login')->with('error', 'Login required.');
            }

            try{
                $sprint  = new Sprint();
                $sprint->project_id = $project->id;
                $sprint->name = $request->name;
                $sprint->start_date = $request->input('start_date', now());
                $sprint->end_date = $request->end_date;
                $sprint->is_archived = $request->input('is_archived', false);

                Log::info('Sprint attributes before saving:', $sprint->getAttributes());

                $project->save();

                Log::info('Sprint attributes after saving:', $sprint->getAttributes());

                return redirect()->route('sprint.show', $project->slug)->with('success', 'Sprint created successfully.');
            } catch (QueryException $e) {
                Log::error('QueryException: ', ['error' => $e->getMessage(), 'errorInfo' => $e->errorInfo]);

                if($e->errorInfo[1] == 1062) {
                    return back()->with('error', 'Sprint name already exists.')->withInput();
                }
                return back()->withErrors(['error' => 'An error occurred while creating the project.'])->withInput();
            }
        }
}
