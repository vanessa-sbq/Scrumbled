<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;

class ProjectController extends Controller{
    public function projectList() {
        $projects = Project::all();
        return view('admin.sections.project.index', compact('projects'));
    }

}
