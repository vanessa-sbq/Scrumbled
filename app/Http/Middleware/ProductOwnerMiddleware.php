<?php

namespace App\Http\Middleware;

use App\Models\Project;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class ProductOwnerMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next) {
        if (!Auth::guard("admin")->check()) {
            $project = Project::where('slug', $request->route('slug'))->firstOrFail();

            if ($request->user()->id !== $project->product_owner_id) {
                abort(403, 'You are not authorized to access this page.');
            }
        }

        return $next($request);
    }
}
