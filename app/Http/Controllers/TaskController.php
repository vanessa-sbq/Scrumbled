<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
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

        if (!$task->project->developers->contains($request->user_id)) {
            return response()->json(['status' => 'error', 'message' => 'User is not a developer for this project.'], 403);
        }

        // Ensure the task is not already assigned
        if ($task->assigned_to !== null) {
            return response()->json(['status' => 'error', 'message' => 'Task is already assigned to another user.'], 400);
        }

        // Assign the task to the user
        $task->update(['assigned_to' => $request->user_id]);

        $task->load('assignedDeveloper');

        return response()->json([
            'status' => 'success',
            'userComponent' => view('components.user', ['user' => $task->assignedDeveloper->user])->render(),
            'assignedToCurrentUser' => $task->assignedDeveloper->user_id === Auth::id(),
        ]);
    }

    public function updateState(Request $request, $taskId)
    {
        $task = Task::findOrFail($taskId);
        $newState = $request->input('state');

        if($newState === 'ACCEPTED') {
            $this->authorize('manage', $task->project);
        }

        // Validate state input
        $validStates = ['BACKLOG', 'SPRINT_BACKLOG', 'IN_PROGRESS', 'DONE', 'ACCEPTED'];
        if (!in_array($newState, $validStates)) {
            return response()->json(['status' => 'error', 'message' => 'Invalid task state.'], 400);
        }

        // Authorization checks
        $userId = Auth::id();

        $project = Project::findOrFail($task->project_id);

        if ($userId !== $project->product_owner_id && in_array($newState, ['IN_PROGRESS', 'DONE']) && $task->assigned_to !== $userId && $task->state === 'ACCEPTED') {
            return response()->json(['status' => 'error', 'message' => 'You are not authorized to modify this task.'], 403);
        }

        if ($userId !== $project->product_owner_id && $task->state === 'ACCEPTED') {
            return response()->json(['status' => 'error', 'message' => 'You are not authorized to modify this task.'], 403);
        }

        $sprintID = $request->input('sprintID');

        // Update the task state
        if (isset($sprintID)) {
            $task->update(['state' => $newState, 'sprint_id' => $sprintID]);
        } else {
            $task->update(['state' => $newState]);
        }

        return response()->json(['status' => 'success', 'message' => "Task state updated to $newState."]);
    }


    public function showNew($slug){
        $project = Project::where('slug', $slug)->firstOrFail();
        $tasks = Task::where('project_id', $project->id)->get();

        return view('web.sections.task.create', ['slug' => $slug]);
    }

    public function createNew(Request $request)
    {
        $project = Project::where('slug', $request->slug)->firstOrFail();

        $validated = $request->validate([
            'title' => 'required|string|max:50',
            'description' => 'nullable|string|max:2000',
            'effort' => 'required',
            'value' => 'required',
        ]);

        $task = new Task([
            'project_id' => $project->id,
            'title' => $validated['title'],
            'description' => $validated['description'] ?? 'No description',
            'value' => $validated['value'],
            'effort' => $validated['effort'],
        ]);

        if ($this->authorize('create', $task)){
            $task->save();
            return redirect()->route('projects.backlog', $project->slug)->with('success', 'Task created successfully!');
        }
        else{
            return redirect()->back()->with('error', 'You are not authorized to create this task.');
        }
    }

    public function showEdit($slug, $task_id){
        $task = Task::findOrFail($task_id);
        return view('web.sections.task.edit', ['slug' => $slug, 'task' => $task]);
    }

    public function editTask(Request $request, $slug, $taskId){
        $validated = $request->validate([
            'title' => 'required|string|max:50',
            'description' => 'nullable|string|max:2000',
            'effort' => 'required',
            'value' => 'required',
        ]);

        $task = Task::findOrFail($taskId);
        $task->title =  $validated['title'];
        $task->description = $validated['description'] ?? 'No description';
        $task->value = $validated['value'];
        $task->effort = $validated['effort'];

        if ($this->authorize('update', $task)){
            $task->save();
            return redirect()->route('task.show', $task)->with('success', 'Task updated successfully!');
        }
        else {
            return redirect()->back()->with('error', 'You are not authorized to update this task.');
        }
    }

    public function show($id)
    {
        $task = Task::where('id', $id)->firstOrFail();
        $sprint = $task->sprint;
        $project = $task->project;
        $comments = $task->comments()->orderBy('created_at', 'asc')->get();

        return view('web.sections.task.show', ['task' => $task, 'sprint' => $sprint, 'project' => $project, 'comments' => $comments,]);
    }

    public function deleteTask($slug, $id)
    {
        $project = Project::where('slug', $slug)->firstOrFail();
        $task = Task::where('id', $id)->where('project_id', $project->id)->firstOrFail();

        if ($this->authorize('delete', $task)){
            $task->delete();
            return redirect()->route('projects.backlog', ['slug' => $slug])->with('success', 'Task deleted successfully.');
        }
        else{
            return redirect()->back()->with('error', 'You are not authorized to delete this task.');
        }
    }
}
