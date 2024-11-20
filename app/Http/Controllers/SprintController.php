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
    public function show($id)
    {
        $sprint = Sprint::where('id', $id)->firstOrFail();

        return view('web.sections.sprint.show', compact('sprint'));
    }
}
