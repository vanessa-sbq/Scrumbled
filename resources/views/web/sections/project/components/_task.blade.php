<div class="p-4 bg-gray-100 rounded-md shadow-sm task-card @if ($task->assigned_to === Auth::id()) bg-yellow-100 @endif"
    data-assigned-to="{{ $task->assigned_to }}">
    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 w-full">
        <a href="{{ route('task.show', $task->id) }}"
           class="text-lg font-semibold text-gray-800 hover:text-blue-500 transition">
            {{ $task->title }}
        </a>
    </td>
    <div class="text-sm text-gray-600 flex items-center gap-2 mt-2 justify-between flex-wrap">
        @if ($task->assignedDeveloper && $task->assignedDeveloper->user)
            <x-user :user="$task->assignedDeveloper->user" />
        @else
            <p>No user assigned.</p>
        @endif
        <div class="space-y-2">
            <span
                class="inline-flex items-center px-3 py-0.5 rounded-full text-sm font-medium bg-green-100 text-green-800">
                {{ $task->effort }}
            </span>
            <span
                class="inline-flex items-center px-3 py-0.5 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                {{ $task->value }}
            </span>
        </div>
    </div>
    @if ($task->assigned_to === Auth::id())
        <div class="mt-4 flex gap-2 justify-between" id="buttons">
            @if ($task->state == 'IN_PROGRESS')
                <button data-url="{{ route('tasks.updateState', $task->id) }}" data-state="SPRINT_BACKLOG" class="state-button text-red-500 hover:text-red-700 hover:underline transition">Cancel</button>
                <button class="arrow-button" data-url="{{ route('tasks.updateState', $task->id) }}" data-state="DONE">➡️</button>
            @elseif ($task->state == 'DONE')
                <button class="arrow-button" data-url="{{ route('tasks.updateState', $task->id) }}" data-state="IN_PROGRESS">⬅️</button>
                <button class="arrow-button" data-url="{{ route('tasks.updateState', $task->id) }}" data-state="ACCEPTED">➡️</button>
            @elseif ($task->state == 'ACCEPTED')
                <button class="arrow-button" data-url="{{ route('tasks.updateState', $task->id) }}" data-state="DONE">⬅️</button>
            @endif
        </div>
    @endif
</div>
