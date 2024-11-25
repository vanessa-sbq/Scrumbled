<?php

namespace App\Http\Middleware;

use App\Models\Project;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ProductOwnerMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        $project = Project::where('slug', $request->route('slug'))->firstOrFail();

        if ($request->user()->id !== $project->product_owner_id) {
            return redirect()->route('home')->with('error', 'You are not authorized to access this page.');
        }

        return $next($request);
    }
}
