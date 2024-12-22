<?php

namespace App\Http\Middleware;

use App\Models\Project;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ProjectReadOnlyIfArchivedApi
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $slug = $request->input('slug');
        $project = Project::where('slug', $slug)->firstOrFail();

        if ($project->is_archived) {
            return response()->json(['status' => 'error', 'message' => 'Project is archived, please unarchive first.'], 400);
        }

        return $next($request);
    }
}
