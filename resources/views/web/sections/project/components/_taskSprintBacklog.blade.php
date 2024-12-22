<tr data-task-id="{{ $task->id }}">
    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 w-full">
        <a href="{{ route('task.show', $task->id) }}" class="task_title text-gray-800 hover:text-primary transition">
            {{ $task->title }}
        </a>
    </td>
    <td class="px-6 py-4 whitespace-nowrap text-sm hidden md:table-cell">
        <span class="task_effort inline-flex items-center px-3 py-0.5 rounded-full text-sm font-medium bg-green-100 text-green-800">
        {{ $task->effort }}
        </span>
    </td>
    <td class="px-6 py-4 whitespace-nowrap text-sm hidden md:table-cell">
        <span class="task_value inline-flex items-center px-3 py-0.5 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
        {{ $task->value }}
        </span>
    </td>
    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 hidden md:table-cell">
        <x-user :user="$task->assignedDeveloper->user" />
    </td>
    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 hidden md:table-cell">
        <button data-url="{{ route('tasks.updateState', $task->id) }}" data-task-id="{{$task->id}}" data-state="IN_PROGRESS" class="state-button bg-primary text-white px-3 py-1 rounded-md hover:bg-blue-700 transition">
            Start
        </button>
    </td>
</tr>