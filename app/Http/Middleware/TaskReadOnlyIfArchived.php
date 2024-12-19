<?php

namespace App\Http\Middleware;

use App\Models\DeveloperProject;
use App\Models\Project;
use App\Models\Task;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class TaskReadOnlyIfArchived
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $task_id  = $request->input('id') ?? $request->route('id');
        $task = Task::where('id', $task_id)->firstOrFail();
        $project = Project::where('id', $task->project_id)->firstOrFail();

        if ($project->is_archived) {
            return redirect()->route('projects')->with('error', 'Project is archived. Please unarchive the project first.');
        }

        return $next($request);

    }
}
