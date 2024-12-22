<tr>
    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 w-full">
        <a href="{{ route('task.show', $task->id) }}"
           class="text-lg font-semibold text-gray-800 hover:text-primary transition">
            {{ $task->title }}
        </a>
    </td>
    <td class="px-6 py-4 whitespace-nowrap text-sm hidden md:table-cell">
        <span
                class="inline-flex items-center px-3 py-0.5 rounded-full text-sm font-medium bg-green-100 text-green-800">
            {{ $task->effort }}
        </span>
    </td>
    <td class="px-6 py-4 whitespace-nowrap text-sm hidden md:table-cell">
        <span
                class="inline-flex items-center px-3 py-0.5 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
            {{ $task->value }}
        </span>
    </td>
    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 hidden md:table-cell">
        @if ($task->assignedDeveloper)
            <x-user :user="$task->assignedDeveloper->user" />
        @else
            <span class="text-red-500">Not Assigned</span>
        @endif
    </td>

    @if ($currentSprint)
        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 hidden md:table-cell">
            <button id="{{ $currentSprint->id }}"
                    data-url="{{ route('tasks.updateState', $task->id) }}"
                    data-state="{{ $task->state === 'BACKLOG' ? 'BACKLOG' : 'SPRINT_BACKLOG' }}"
                    class="{{ $task->state === 'BACKLOG' ? 'add-button bg-primary' : 'remove-button bg-primary' }} text-white px-3 py-1 rounded-md hover:bg-blue-700 transition">
                {{ $task->state === 'BACKLOG' ? 'Add to Sprint' : 'Remove' }}
            </button>
        </td>
    @endif
</tr>
