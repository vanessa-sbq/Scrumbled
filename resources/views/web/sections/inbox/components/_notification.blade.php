        @if ($notification->type == "INVITE")
            <div class="flex items-center justify-between w-full">
                <div class="flex items-center space-x-3 gap-3">
                    <input type="checkbox" class="notification-checkbox" name="selected_notifications[]" value="{{ $notification->id }}">
                    </form> 
                    <?php  
                        $project = \App\Models\Project::find($notification->project_id);
                        $po_id = \App\Models\Project::find($notification->project_id)->product_owner_id;
                        $po = \App\Models\AuthenticatedUser::find($po_id)->username;
                    ?>
                    <?=$po?> invited you to participate in project <?=$project->title?>.
                </div>
                <div class="flex gap-2">
                    <form id="accept-invitation-form" method="POST" action="{{ route('inbox.acceptInvitation') }}">
                        @csrf
                        <input type="hidden" name="project_id" value="{{ $project->id }}">
                        <input type="hidden" name="developer_id" value="{{ $notification->receiver_id }}">
                        <button type="submit" class="bg-primary text-white px-3 py-1 rounded-md hover:bg-blue-700 transition">
                            Accept
                        </button>
                    </form>
                    <form id="decline-invitation-form" method="POST" action="{{ route('inbox.declineInvitation') }}">
                        @csrf
                        <input type="hidden" name="id" value="{{ $notification->id }}">
                        <input type="hidden" name="project_id" value="{{ $project->id }}">
                        <input type="hidden" name="developer_id" value="{{ $notification->receiver_id }}">
                        <button type="submit" class="bg-gray-200 text-gray-800 px-3 py-1 rounded-md hover:bg-gray-300">
                            Decline
                        </button>
                    </form>
                </div>
            </div>
        @elseif ($notification->type == "COMPLETED_TASK")
            <div class="flex items-center space-x-3 gap-3">
            <input type="checkbox" class="notification-checkbox" name="selected_notifications[]" value="{{ $notification->id }}">

                <?php  
                    $task = \App\Models\Task::find($notification->task_id); 
                    $completed_by = \App\Models\AuthenticatedUser::find($notification->completed_by)->username;   
                    $project = \App\Models\Project::find($notification->project_id)->title;   
                    if ($task): ?>
                <?=$completed_by?> completed task "<?=$task->title?>" in project <?=$project?>.
                <?php endif; ?>
            </div>
        @elseif ($notification->type == "ACCEPTED_INVITATION")
            <div class="flex items-center space-x-3 gap-3">
            <input type="checkbox" class="notification-checkbox" name="selected_notifications[]" value="{{ $notification->id }}">

                <?php
                    $invited_user = \App\Models\AuthenticatedUser::find($notification->invited_user_id)->username;
                    $project = \App\Models\Project::find($notification->project_id)->title;      
                ?>
                <?=$invited_user?> accepted your invitation to <?=$project?>.
            </div>
        @elseif ($notification->type == "ASSIGN")
            <div class="flex items-center space-x-3 gap-3">
            <input type="checkbox" class="notification-checkbox" name="selected_notifications[]" value="{{ $notification->id }}">

                <?php
                    $task = \App\Models\Task::find($notification->task_id)->title; 
                    $project = \App\Models\Project::find($notification->project_id)->title;      
                ?>
                You got assigned to task "<?=$task?>" in project <?=$project?>.
            </div>
        @elseif ($notification->type == "PO_CHANGE")
            <div class="flex items-center space-x-3 gap-3">
            <input type="checkbox" class="notification-checkbox" name="selected_notifications[]" value="{{ $notification->id }}">
                <?php
                    $old_po = \App\Models\AuthenticatedUser::find($notification->old_product_owner_id)->username;   
                    $new_po = \App\Models\AuthenticatedUser::find($notification->new_product_owner_id)->username;   
                    $project = \App\Models\Project::find($notification->project_id)->title;         
                ?>
                <?=$old_po?> gave his role of Product Owner to <?=$new_po?> in project <?=$project?>.
            </div>
        @endif
    </td>
</tr>
