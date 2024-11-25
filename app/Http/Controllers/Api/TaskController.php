<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Task;
use App\Models\Project;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function search(Request $request) {
        $url = $request->url();
        $slug = explode('/', $url)[5];
        $project = Project::where('slug', $slug)->firstOrFail();
        
        $search = $request->input('search');
        //dd($project);
        // FIXME: slug passing as parameter gives error

        $tasks = Task::all();

        if (isset($search) && $search !== '') {
            $tasks = Task::where('project_id',  $project->id)
                    ->whereRaw("tsvectors @@ plainto_tsquery('english', ?) OR title = ?", [$search, $search])
                    ->orderByRaw('ts_rank(tsvectors, plainto_tsquery(\'english\', ?)) DESC', [$search])
                    ->get();
        }
        
            

        $v = view('web.sections.task.components._task', ['tasks' => $tasks])->render();
        return response()->json($v);
    }
}
