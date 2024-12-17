<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

    public function delete($commentId)
    {
        $comment = Comment::findOrFail($commentId);

        $author = $comment->user;
        $user = Auth::user();

        $task = $comment->task;

        if($user->id === $author->id) {
            $comment->delete();

            return redirect()->route('task.show', $task->id)->with('success', 'Comment deleted successfully!');
        }

        return redirect()->route('task.show', $task->id)->with('error', 'Comment could not be deleted!');
    }
}