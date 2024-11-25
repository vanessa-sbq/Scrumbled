<?php

namespace App\Http\Controllers;

use App\Models\Task;
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

}
