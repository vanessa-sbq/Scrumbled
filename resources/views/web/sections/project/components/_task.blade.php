<div class="p-4 bg-gray-100 rounded-md shadow-sm task-card" data-task-id="{{ $task->id }}"
    data-assigned-to="{{ $task->assigned_to }}" draggable="true">
    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 w-full">
        <a href="{{ route('task.show', $task->id) }}"
            class="text-lg font-semibold text-gray-800 hover:text-primary transition">
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
</div>
