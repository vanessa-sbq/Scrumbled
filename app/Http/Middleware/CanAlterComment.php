<?php

namespace App\Http\Middleware;

use App\Models\Comment;
use App\Models\Project;
use App\Models\Task;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class CanAlterComment
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        $comment = Comment::where('id', $request->route('id'))->firstOrFail();

        Log::info($comment->id);

        $task_id  = $comment->task_id;
        $task = Task::where('id', $task_id)->firstOrFail();
        $project = Project::where('id', $task->project_id)->firstOrFail();

        if ($project->is_archived) {
            return response()->json(['status' => 'error', 'message' => 'Project is archived. Please unarchive the project first.'], 400);
        }

        if ( (!Auth::guard("admin")->check()) && (!Auth::user())) {
            return response()->json(['status' => 'error', 'message' => 'You do not have permission to do these changes.'], 403);
        }

        if (Auth::user()) {
            if ($project->product_owner_id !== Auth::user()->id) {
                if ($comment->user_id !== Auth::user()->id) {
                    return response()->json(['status' => 'error', 'message' => 'You do not have permission to do these changes.'], 403);
                }
            }
        } else {
            if (!Auth::guard("admin")->check()) {
                return response()->json(['status' => 'error', 'message' => 'You do not have permission to do these changes.'], 403);
            }
        }

        return $next($request);
    }
}
