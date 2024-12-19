<?php

namespace App\Http\Middleware;

use App\Models\Project;
use App\Models\Task;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TaskReadOnlyIfArchivedApi
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
            return response()->json(['status' => 'error', 'message' => 'Project is archived. Please unarchive the project first.'], 400);
        }

        return $next($request);
    }
}
