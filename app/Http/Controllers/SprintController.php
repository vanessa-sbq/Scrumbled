<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Sprint;


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

}
