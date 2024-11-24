<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function searchTasks(Request $request, $slug) {
        $project = Project::where('slug', $slug)->firstOrFail();
        $search = $request->input('search');

        // FIXME: Implement FTS with AJAX instead
        /* $tasks = Task::where('project_id', $project->id)
                ->where(function($query) use ($search) {
                    $query->where('title', 'LIKE', "%{$search}%");
                                })
                ->get(); */

        $tasks = Task::where('project_id', $project->id)
            ->whereRaw("tsvectors @@ plainto_tsquery('english', ?) OR title = ?", [$search, $search])
            ->orderByRaw('ts_rank(tsvectors, plainto_tsquery(\'english\', ?)) DESC', [$search])
            ->get();

        //return view('web.sections.project.subviews.tasks', compact('project', 'tasks'));
        $v = view('web.sections.project.subviews.components._task', ['tasks' => $tasks])->render();

        return response()->json($v);
    }
}
