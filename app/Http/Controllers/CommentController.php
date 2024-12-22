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
        
        $comment = $task->comments()->make([
            'description' => $request->description,
            'user_id' => auth()->id(),
            'task_id' => $taskId,
        ]);
        
        if ($this->authorize('create', $comment)){
            $comment->save();
            $html = view('web.sections.task.components._comments', compact('comment'))->render();
            return response()->json(['success' => true, 'html' => $html]);
        }
        else {
            return response()->json(['success' => false]);
        }
    }

    public function delete($commentId)
    {
        $comment = Comment::findOrFail($commentId);
        $taskId = $comment->task->id;

        $comment->delete();

        return response()->json([
            'success' => true,
            'commentId' => $commentId,
            'task_id' => $taskId,
        ]);
    }

    public function edit(Request $request, $commentId)
    {
        $comment = Comment::findOrFail($commentId);

        $request->validate([
            'description' => 'required|string|max:1000',
        ]);

        $comment->description = $request->description;
        $comment->save();

        return response()->json([
            'success' => true,
            'comment' => $comment,
        ]);
    }
}