<?php
    $task = \App\Models\Task::find($notification->task_id)->title; 
    $project = \App\Models\Project::find($notification->project_id)->title;      
?>
You got assigned to task "<?=$task?>" in project <?=$project?>.