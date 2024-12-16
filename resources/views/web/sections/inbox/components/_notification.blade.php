<div class="flex flex-row items-center gap-3">
    <!-- Checkbox section -->
    <div class="basis-1/7">
        <input type="checkbox" class="notification-checkbox" name="selected_notifications[]" value="{{ $notification->id }}">
    </div>    

    <!-- Notification content based on type -->
    <div class="basis-5/7 flex-grow left">
        @if ($notification->type == "INVITE")
            @include('web.sections.inbox.components._invitation', ['$notifications' => $notifications])
        @elseif ($notification->type == "COMPLETED_TASK")
            @include('web.sections.inbox.components._completed', ['$notifications' => $notifications])
        @elseif ($notification->type == "ACCEPTED_INVITATION")
            @include('web.sections.inbox.components._acceptedinv', ['$notifications' => $notifications])
        @elseif ($notification->type == "ASSIGN")
            @include('web.sections.inbox.components._assign', ['$notifications' => $notifications])
        @elseif ($notification->type == "PO_CHANGE")
            @include('web.sections.inbox.components._pochange', ['$notifications' => $notifications])
        @endif
    </div>

    <!-- Display time -->
    <div class="basis-1/7">
        {{ \Carbon\Carbon::parse($notification->created_at)->diffForHumans() }}
    </div>
</div>