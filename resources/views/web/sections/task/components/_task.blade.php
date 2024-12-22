@foreach ($tasks as $task)
    <tr>
        <td class="px-6 py-4 whitespace-nowrap font-medium text-gray-900 w-full">
            <a href="{{ route('task.show', $task->id) }}" class="text-gray-800 hover:text-primary transition">
                {{ $task->title }}
            </a>
        </td>
        <td class="px-6 py-4 whitespace-nowrap text-sm hidden lg:table-cell">
            <span
                class="inline-flex items-center px-3 py-0.5 rounded-full text-sm font-medium bg-green-100 text-green-800">
                {{ $task->effort }}
            </span>
        </td>
        <td class="px-6 py-4 whitespace-nowrap text-sm hidden lg:table-cell">
            <span
                class="inline-flex items-center px-3 py-0.5 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                {{ $task->value }}
            </span>
        </td>
        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 hidden lg:table-cell">
            @if ($task->assignedDeveloper && $task->assignedDeveloper->user)
                <x-user :user="$task->assignedDeveloper->user" />
            @else
                <p>No user assigned.</p>
            @endif
        </td>
        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 hidden lg:table-cell">
            @if ($task->state == 'BACKLOG')
                <p> - </p>
            @else
                <p>{{ $task->sprint->name ?? '-' }}</p>
            @endif
        </td>
        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 hidden lg:table-cell">
            <span
                class="inline-flex items-center px-3 py-0.5 rounded-full text-sm font-medium bg-purple-100 text-purple-800">
                <p>{{ strtolower(str_replace('_', ' ', $task->state)) }}</p>
            </span>
        </td>
    </tr>
@endforeach
