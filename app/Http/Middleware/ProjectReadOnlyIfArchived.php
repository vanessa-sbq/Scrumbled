<?php

namespace App\Http\Middleware;

use App\Models\Project;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class ProjectReadOnlyIfArchived
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        $slug = $request->input('slug') ?? $request->route('slug');
        $project = Project::where('slug', $slug)->firstOrFail();

        if ($project->is_archived) {
            return redirect()->route('projects.show', $slug);
        }

        return $next($request);
    }
}
