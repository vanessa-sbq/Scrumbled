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
        <tbody id="SPRINT_BACKLOG" class="bg-white divide-y divide-gray-200">
            @foreach ($tasks as $task)
                <tr data-task-id="{{ $task->id }}">
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 w-full">
                        <a href="{{ route('task.show', $task->id) }}" class="task_title text-gray-800 hover:text-primary transition">
                            {{ $task->title }}
                        </a>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm hidden md:table-cell">
                        <span
                                class="task_effort inline-flex items-center px-3 py-0.5 rounded-full text-sm font-medium bg-green-100 text-green-800">
                            {{ $task->effort }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm hidden md:table-cell">
                        <span
                                class="task_value inline-flex items-center px-3 py-0.5 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
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
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 hidden md:table-cell">
                        @if ($task->assigned_to === null && Auth::check() && ($task->project->developers->contains(Auth::user())))
                            <!-- Assign Button -->
                            <button class="open-sidebar-button bg-primary text-white px-3 py-1 rounded-md hover:bg-blue-700 transition">
                                Assign
                            </button>
                            <div class="assign-sidebar fixed top-0 right-0 w-80 h-full bg-white p-6 rounded-lg shadow-md transform translate-x-full transition-transform duration-300 z-50">
                                <div class="flex items-center justify-between mb-4">
                                    <h2 class="text-xl font-semibold text-gray-800">Assign Developer</h2>
                                    <button class="close-sidebar-button text-gray-500 hover:text-gray-700">✖</button>
                                </div>
                                <div class="overflow-y-auto">
                                    @if (count($task->project->developers) > 0)
                                        @foreach ($task->project->developers as $developer)
                                            <div class="flex justify-between items-center p-4 mb-4 border border-gray-300 rounded-md shadow-sm">
                                                <span class="font-medium text-gray-800">{{ $developer->username }}</span>
                                                <button class="assign-button bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 transition"
                                                        data-developer-id="{{ $developer->id }}"
                                                        data-task-id="{{ $task->id }}">
                                                    Assign
                                                </button>
                                            </div>
                                        @endforeach
                                    @else
                                        <div class="p-4 border border-gray-300 rounded-md text-gray-500">
                                            No developers available.
                                        </div>
                                    @endif
                                </div>
                            </div>

</div>
                        @elseif (Auth::check() && $task->assigned_to == Auth::id())
                        <!-- Start Button -->
                        <button data-url="{{ route('tasks.updateState', $task->id) }}" data-task-id="{{$task->id}}" data-state="IN_PROGRESS"
                                class="state-button bg-primary text-white px-3 py-1 rounded-md hover:bg-blue-700 transition">
                            Start
                        </button>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

@once
    @push('scripts')
        <script src="{{ asset('js/assignDeveloper.js') }}"></script>
    @endpush
@endonce