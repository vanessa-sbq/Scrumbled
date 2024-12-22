<div class="p-4 bg-gray-100 rounded-md shadow-sm task-card {{ $task->assigned_to == Auth::id() ? 'highlight' : '' }}"
    data-task-id="{{ $task->id }}" data-assigned-to="{{ $task->assigned_to }}" draggable="true">
    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 w-full">
        <a href="{{ route('task.show', $task->id) }}"
            class="task_title text-lg font-semibold text-gray-800 hover:text-primary transition">
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
                class="task_effort inline-flex items-center px-3 py-0.5 rounded-full text-sm font-medium bg-green-100 text-green-800">
                {{ $task->effort }}
            </span>
            <span
                class="task_value inline-flex items-center px-3 py-0.5 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                {{ $task->value }}
            </span>
        </div>
    </div>

    @if ($task->state === 'IN_PROGRESS')
        <button type="submit" id="{{ $task->id }}" class="cancel-button bg-gray-400 text-white px-3 py-1 rounded-md hover:bg-gray-500 transition"
                data-url="{{ route('tasks.updateState', $task->id) }}"
                data-state="SPRINT_BACKLOG">
            Cancel
        </button>
    @endif
</div>
