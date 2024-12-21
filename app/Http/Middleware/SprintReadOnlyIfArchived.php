<?php

namespace App\Http\Middleware;

use App\Models\Project;
use App\Models\Sprint;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SprintReadOnlyIfArchived
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $sprint_id = $slug = $request->input('id') ?? $request->route('id');

        $sprint = Sprint::where('id', $sprint_id)->firstOrFail();

        $project = Project::where('id', $sprint->project_id)->firstOrFail();

        if ($project->is_archived) {
            return redirect()->back()->with('error', 'Project is archived. Please unarchive first.');
        }

        return $next($request);
    }
}
