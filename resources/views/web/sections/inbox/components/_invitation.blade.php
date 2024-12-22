<div class="flex flex-wrap md:flex-nowrap gap-2">
    <div class="md:basis-3/4">
        @if ($notificationInfo['current_po'])
            {{ $notificationInfo['current_po']->username }} invited you to participate in the project
            {{ $notificationInfo['project']->title }}.
        @else
            Anonymous invited you to participate in the project
            {{ $notificationInfo['project']->title }}.
        @endif
    </div>
    <div class="basis-1/4 flex gap-2">
        <form id="accept-invitation-form" method="POST" action="{{ route('inbox.acceptInvitation') }}">
            @csrf
            <input type="hidden" name="project_id" value="{{ $notificationInfo['project']->id }}">
            <input type="hidden" name="developer_id" value="{{ $notificationInfo['receiver_id'] }}">
            <button type="submit" class="bg-primary text-white px-3 py-1 rounded-md hover:bg-blue-700 transition">
                Accept
            </button>
        </form>
        <form id="decline-invitation-form" method="POST" action="{{ route('inbox.declineInvitation') }}">
            @csrf
            <input type="hidden" name="id" value="{{ $notificationInfo['id'] }}">
            <input type="hidden" name="project_id" value="{{ $notificationInfo['project']->id }}">
            <input type="hidden" name="developer_id" value="value="{{ $notificationInfo['receiver_id'] ?? 'Anonymous' }}">
            <button type="submit" class="bg-gray-200 text-gray-800 px-3 py-1 rounded-md hover:bg-gray-300">
                Decline
            </button>
        </form>
    </div>
</div>
