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

    public function updateState(Request $request, $taskId)
    {
        $task = Task::findOrFail($taskId);
        $newState = $request->input('state');

        // Validate state input
        $validStates = ['BACKLOG', 'SPRINT_BACKLOG', 'IN_PROGRESS', 'DONE', 'ACCEPTED'];
        if (!in_array($newState, $validStates)) {
            return response()->json(['status' => 'error', 'message' => 'Invalid task state.'], 400);
        }

        // Authorization checks
        $userId = Auth::id();

        if (in_array($newState, ['IN_PROGRESS', 'DONE', 'ACCEPTED']) && $task->assigned_to !== $userId) {
            return response()->json(['status' => 'error', 'message' => 'You are not authorized to modify this task.'], 403);
        }

        // Update the task state
        $task->update(['state' => $newState]);

        return response()->json(['status' => 'success', 'message' => "Task state updated to $newState."]);
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

        return redirect()->route('projects.backlog', $project->slug)->with('success', 'Task created successfully!');
    }

    public function showEdit($slug, $task_id){
        $task = Task::findOrFail($task_id);
        return view('web.sections.project.subviews.editTask', ['slug' => $slug, 'task' => $task]);
    }

    public function editTask(Request $request, $slug, $taskId){
        $task = Task::findOrFail($taskId);
        $task->title = $request->title;
        $task->description = $request->description;
        $task->value = $request->value;
        $task->effort = $request->effort;
        $task->save();

        return redirect()->back();
    }

    public function show($id)
    {
        $task = Task::where('id', $id)->firstOrFail();

        $sprint = $task->sprint;

        $project = $task->project;

        return view('web.sections.task.show', ['task' => $task, 'sprint' => $sprint, 'project' => $project,]);
    }

}
