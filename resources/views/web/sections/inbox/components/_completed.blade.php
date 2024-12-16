<?php 
    $task = \App\Models\Task::find($notification->task_id); 
    $completed_by = \App\Models\AuthenticatedUser::find($notification->completed_by)->username;   
    $project = \App\Models\Project::find($notification->project_id)->title;   
    if ($task): ?>
<?=$completed_by?> completed task "<?=$task->title?>" in project <?=$project?>.
<?php endif; ?>