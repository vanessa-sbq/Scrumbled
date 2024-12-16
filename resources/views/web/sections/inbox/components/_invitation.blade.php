<div class="justify-between w-full left">
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