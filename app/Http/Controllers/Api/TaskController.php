<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AuthenticatedUser;
use App\Models\Task;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class TaskController extends Controller
{
    public function search(Request $request) {
        $url = $request->url();
        $slug = explode('/', $url)[5];
        $project = Project::where('slug', $slug)->firstOrFail();
        
        $search = $request->input('search');

        $tasks = Task::where('project_id', $project->id)->get();

        if (isset($search) && $search !== '') {
            $tasks = Task::where('project_id',  $project->id)
                    ->whereRaw("tsvectors @@ plainto_tsquery('english', ?) OR title = ?", [$search, $search])
                    ->orderByRaw('ts_rank(tsvectors, plainto_tsquery(\'english\', ?)) DESC', [$search])
                    ->get();
        }

        $v = view('web.sections.task.components._task', ['tasks' => $tasks])->render();
        return response()->json($v);
    }

    public function generateTaskForBacklog(Request $request)
    {
        // Validate the incoming request data
        $request->validate([
            'assigned_to' => 'required',
            'task_id' => 'required',
            'title' => 'required',
            'effort' => 'required',
            'value' => 'required',
            'state' => 'required',
        ]);

        // Manually create the $task object
        $task = new \stdClass();
        $task->id = $request->task_id;
        $task->title = $request->title;
        $task->effort = $request->effort;
        $task->value = $request->value;
        $task->state = $request->state;

        if ($request->state === 'IN_PROGRESS') {
            $assignedDeveloper = AuthenticatedUser::where(['username' => $request->assigned_to])->firstOrFail();
        } else {
            $assignedDeveloper = AuthenticatedUser::where(['id' => $request->assigned_to])->firstOrFail();
        }

        $task->assigned_to = $assignedDeveloper->id;

        $task->assignedDeveloper = new \stdClass();
        $task->assignedDeveloper->user = $assignedDeveloper;;


        if ($request->state === 'IN_PROGRESS') {
            $v = view('web.sections.project.components._task', compact('task'))->render();
            return response()->json($v);
        }

        $v = view('web.sections.project.components._taskSprintBacklog', compact('task'))->render();
        return response()->json($v);
    }

}
