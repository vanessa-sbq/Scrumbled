<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Sprint;

/**
 * Display sprint of the specified project.
 *
 * @param  string  $slug
 * @return \Illuminate\View\View
 */
class SprintController extends Controller {
    public function show($sprint, $project)
    {
        $project = Project::where('slug', $slug)->firstOrFail();
    }
}
