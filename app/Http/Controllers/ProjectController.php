<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Project;

class ProjectController extends Controller
{
    /**
     * Display a listing of the user's projects.
     *
     * @return \Illuminate\View\View
     */
    public function list()
    {
        // Get the authenticated user
        $user = Auth::user();

        // Get the projects where the user is a product owner or a developer
        $projects = Project::where('product_owner_id', $user->id)
            ->orWhereHas('developers', function ($query) use ($user) {
                $query->where('developer_id', $user->id);
            })
            ->get();

        // Return the view with the projects
        return view('web.sections.project.index', compact('projects'));
    }

    /**
     * Display the specified project.
     *
     * @param  string  $slug
     * @return \Illuminate\View\View
     */
    public function show($slug)
    {
        // Find the project by slug
        $project = Project::where('slug', $slug)->firstOrFail();

        // Return the view with the project
        return view('web.sections.project.show', compact('project'));
    }
}