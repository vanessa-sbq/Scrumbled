<?php

namespace App\Http\Controllers;

use App\Models\AuthenticatedUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Project;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class ProjectController extends Controller
{
    /**
     * Display a listing of the user's projects.
     *
     * @return \Illuminate\View\View
     */
    public function list(Request $request)
    {
        /** @var AuthenticatedUser $user */
        $user = Auth::user();
        $type = $request->query('type', $user ? 'my_projects' : 'public');

        if ($type === 'my_projects' && $user) {
            $projects = Project::where('product_owner_id', $user->id)
                ->orWhereHas('developers', function ($query) use ($user) {
                    $query->where('developer_id', $user->id);
                })
                ->get();
        } elseif ($type === 'public') {
            $projects = Project::where('is_public', true)->get();
        } elseif ($type === 'favorites' && $user) {
            // Assuming you have a favorites relationship
            $projects = $user->favorites()->get();
        } else {
            $projects = collect(); // Empty collection if no valid type
        }

        return view('web.sections.project.index', compact('projects', 'type'));
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

    /**
     * Show the form for creating a new project.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('web.sections.project.create');
    }

    /**
     * Store a newly created project in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'is_public' => 'required|boolean',
        ]);

        // Ensure the authenticated user is set
        $user = auth()->user();

        try {
            $project = new Project();
            $project->title = $request->title;
            $project->description = $request->description;
            $project->is_public = $request->is_public;
            $project->is_archived = false; // Default to false
            $project->product_owner_id = $user->id;

            // Generate a unique slug
            $slug = Str::slug($request->title);
            $originalSlug = $slug;
            $counter = 1;

            while (Project::where('slug', $slug)->exists()) {
                $slug = $originalSlug . '-' . $counter;
                $counter++;
            }

            $project->slug = $slug;

            // Log the project attributes before saving
            Log::info('Project attributes before saving:', $project->getAttributes());

            $project->save();

            // Log the project attributes after saving
            Log::info('Project attributes after saving:', $project->getAttributes());

            return redirect()->route('projects.show', $project->slug)->with('success', 'Project created successfully.');
        } catch (QueryException $e) {
            // Log detailed error information
            Log::error('QueryException:', ['error' => $e->getMessage(), 'errorInfo' => $e->errorInfo]);

            if ($e->errorInfo[1] == 1062) { // 1062 is the error code for duplicate entry
                return back()->withErrors(['title' => 'Title already in use.'])->withInput();
            }
            return back()->withErrors(['error' => 'An error occurred while creating the project.'])->withInput();
        }
    }
}
