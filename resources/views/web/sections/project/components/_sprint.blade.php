<div class="overflow-x-auto bg-white shadow-md rounded-lg p-6 mb-6">
    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-white border-b border-black rounded-t-lg">
            <tr>
                <th class="px-6 py-3 text-left text-lg font-bold text-primary uppercase tracking-wider rounded-tl-lg">
                    To Do ({{ count($tasks) }})
                </th>
                <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider hidden md:table-cell">Effort
                </th>
                <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider hidden md:table-cell">Value
                </th>
                <th
                    class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider hidden md:table-cell whitespace-nowrap">
                    Assigned To</th>
                <th
                    class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider rounded-tr-lg hidden md:table-cell">
                    Start</th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            @foreach ($tasks as $task)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 w-full">{{ $task->title }}
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
                        <x-user :user="$task->assignedDeveloper->user" />
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 hidden md:table-cell">
                        <button class="bg-primary text-white px-3 py-1 rounded-md hover:bg-blue-700 transition">
                            Start
                        </button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
