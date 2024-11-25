<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Task $task)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Task $task)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        //
    }

    public function assign(Request $request, $taskId)
    {
        $request->validate([
            'user_id' => 'required|exists:authenticated_user,id',
        ]);

        $task = Task::findOrFail($taskId);

        // Ensure the task is in the sprint backlog
        if ($task->state !== 'SPRINT_BACKLOG') {
            return response()->json(['status' => 'error', 'message' => 'Task must be in the sprint backlog to be assigned.'], 400);
        }

        // Ensure the task is not already assigned
        if ($task->assigned_to !== null) {
            return response()->json(['status' => 'error', 'message' => 'Task is already assigned to another user.'], 400);
        }

        // Assign the task to the user
        $task->update(['assigned_to' => $request->user_id]);

        return response()->json(['status' => 'success']);
    }

    public function start($taskId)
    {
        $task = Task::findOrFail($taskId);

        // Ensure the authenticated user is the one assigned to the task
        if ($task->assigned_to !== Auth::id()) {
            return response()->json(['status' => 'error', 'message' => 'You are not authorized to start this task.'], 403);
        }

        $task->update(['state' => 'IN_PROGRESS']);
        return response()->json(['status' => 'success']);
    }

    public function complete($taskId)
    {
        $task = Task::findOrFail($taskId);

        // Ensure the authenticated user is the one assigned to the task
        if ($task->assigned_to !== Auth::id()) {
            return response()->json(['status' => 'error', 'message' => 'You are not authorized to complete this task.'], 403);
        }

        $task->update(['state' => 'DONE']);
        return response()->json(['status' => 'success']);
    }

    public function accept($taskId)
    {
        $task = Task::findOrFail($taskId);

        // Ensure the authenticated user is the one assigned to the task
        if ($task->assigned_to !== Auth::id()) {
            return response()->json(['status' => 'error', 'message' => 'You are not authorized to accept this task.'], 403);
        }

        $task->update(['state' => 'ACCEPTED']);
        return response()->json(['status' => 'success']);
    }

    public function showNew($slug){
        $project = Project::where('slug', $slug)->firstOrFail();
        $tasks = Task::where('project_id', $project->id)->get();

        return view('web.sections.project.subviews.newTask', ['slug' => $slug]);
    }

    public function createNew(Request $request)
    {
        $project = Project::where('slug', $request->slug)->firstOrFail();
        $task = new Task();
        $task->project_id = $project->id;
        $task->title = $request->title;
        $task->description = $request->description;
        $task->value = $request->value;
        $task->effort = $request->effort;
        $task->save();
        
        return redirect()->back();
    }
}
