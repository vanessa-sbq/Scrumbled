<?php
    $old_po = \App\Models\AuthenticatedUser::find($notification->old_product_owner_id)->username;   
    $new_po = \App\Models\AuthenticatedUser::find($notification->new_product_owner_id)->username;   
    $project = \App\Models\Project::find($notification->project_id)->title;         
?>
<?=$old_po?> gave his role of Product Owner to <?=$new_po?> in project <?=$project?>.