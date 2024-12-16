<?php
    $invited_user = \App\Models\AuthenticatedUser::find($notification->invited_user_id)->username;
    $project = \App\Models\Project::find($notification->project_id)->title;      
?>
<?=$invited_user?> accepted your invitation to <?=$project?>.