<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function create(Request $request, $taskId)
    {
        $request->validate([
            'description' => 'required|string|max:1000',
        ]);

        $task = Task::findOrFail($taskId);

        $task->comments()->create([
            'description' => $request->description,
            'user_id' => auth()->id(), // Assumes the user is authenticated
            'task_id' => $taskId,
        ]);

        return redirect()->route('task.show', $taskId)->with('success', 'Comment added successfully!');
    }
}