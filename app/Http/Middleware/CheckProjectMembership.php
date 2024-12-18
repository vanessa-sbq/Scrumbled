<?php

namespace App\Http\Middleware;

use App\Models\DeveloperProject;
use App\Models\Project;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckProjectMembership
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response {

        if (Auth::guard("admin")->check()) {
            return $next($request);
        }

        $slug = $request->route('slug'); // Retrieve the slug from the route

        $project = Project::where('slug', $slug)->firstOrFail(); // Find the project by slug

        if ($project->is_public) {
            return $next($request);
        }

        $authId = Auth::user()->id;

        $pending_developers = DeveloperProject::where(['project_id' => $project->id, 'is_pending' => true])->get();


        foreach ($pending_developers as $pending_developer) {
            if ($pending_developer['developer_id'] === $authId) {
                return redirect()->route('projects')->with('error', 'You do not have access to this project.');
            }
        }

        if ($project->product_owner_id === $authId) {
            return $next($request);
        }

        foreach ($project->developers()->get() as $developer) {
            if ($developer && $developer['id'] === $authId) {
                return $next($request);
            }
        }

        return redirect()->route('projects')->with('error', 'You do not have access to this project.');
    }
}
