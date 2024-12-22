<div class="flex flex-col md:flex-row items-start md:items-center gap-3 w-full">
    <!-- Checkbox section -->
    <div class="md:basis-1/12">
        <input type="checkbox" class="notification-checkbox" name="selected_notifications[]"
               value="{{ $notificationInfo['id'] }}">
    </div>

    <!-- Notification content based on type -->
    <div class="flex-grow">
        @if ($notificationInfo['type'] == 'INVITE')
            @include('web.sections.inbox.components._invitation', [
                '$notificationInfo' => $notificationInfo,
            ])
        @elseif ($notificationInfo['type'] == 'COMPLETED_TASK')
            {{ $notificationInfo['completed_by'] ?? 'Anonymous' }} completed task
            "{{ $notificationInfo['task_title'] }}" in project
            {{ $notificationInfo['project']->title }}.
        @elseif ($notificationInfo['type'] == 'ACCEPTED_INVITATION')
            {{ $notificationInfo['invited_user'] ?? 'Anonymous' }} accepted your invitation to
            {{ $notificationInfo['project']->title }}.
        @elseif ($notificationInfo['type'] == 'ASSIGN')
            You got assigned to task
            "{{ $notificationInfo['task_title']  }}" in project
            {{ $notificationInfo['project']->title }}.
        @elseif ($notificationInfo['type'] == 'PO_CHANGE')
            {{ $notificationInfo['old_po'] ?? 'Anonymous' }} gave their role of Product Owner to
            {{ $notificationInfo['new_po'] ?? 'Anonymous' }} in project
            {{ $notificationInfo['project']->title ?? 'Unknown Project' }}.
        @endif
    </div>

    <!-- Display time -->
    <div class="md:basis-1/12 text-gray-500 text-sm md:text-right">
        {{ \Carbon\Carbon::parse($notificationInfo['created_at'] ?? now())->diffForHumans() }}
    </div>
</div>
