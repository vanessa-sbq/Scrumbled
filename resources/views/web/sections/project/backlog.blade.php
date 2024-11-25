@extends('web.layout')

@section('content')
    <div class="container py-8">
        <!-- Navbar with Breadcrumb -->
        @include('web.sections.project.components._navbar', ['project' => $project])

        <!-- Title Section -->
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-4xl font-bold text-primary">{{ $project->title }} Backlog</h1>
        </div>

        <!-- Backlog Table -->
        <div class="overflow-x-auto bg-white shadow-md rounded-lg p-6 mb-6">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-white border-b border-black rounded-t-lg">
                <tr>
                    <th
                            class="px-6 py-3 text-left text-lg font-bold text-primary uppercase tracking-wider rounded-tl-lg">
                        To Do ({{ count($backlogTasks) }})
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider hidden md:table-cell">
                        Effort</th>
                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider hidden md:table-cell">
                        Value</th>
                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider hidden md:table-cell whitespace-nowrap">
                        Assigned To</th>
                    @if ($currentSprint) <!-- Only show the Add to Sprint column if there is an active sprint -->
                    <th
                            class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider rounded-tr-lg hidden md:table-cell">
                        Actions</th>
                    @endif
                </tr>
                </thead>
                <tbody id="backlog-tasks" class="bg-white divide-y divide-gray-200">
                @foreach ($backlogTasks as $task)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 w-full">
                            {{ $task->title }}</td>
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
                                <span class="text-gray-400 italic">Unassigned</span>
                            @endif
                        </td>

                        @if ($currentSprint) <!-- Only show the Add to Sprint button if there is an active sprint -->
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 hidden md:table-cell">
                            <button data-url="{{ route('tasks.updateState', $task->id) }}" data-state="BACKLOG" class="add-button bg-primary text-white px-3 py-1 rounded-md hover:bg-blue-700 transition">
                                Add to Sprint
                            </button>
                        </td>
                        @endif
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>

        @if (!$currentSprint)
            <!-- No Active Sprint -->
            <div class="text-center py-16">
                <h2 class="text-2xl font-bold text-gray-600 mb-4">This project has no active sprints!</h2>
                <a href="{{ route('sprint.create', $project->slug) }}"
                   class="bg-blue-500 text-white px-6 py-3 rounded-md hover:bg-blue-700 transition">
                    Create Sprint
                </a>
            </div>
        @else
            <!-- Sprint Exists with Tasks -->
            <div class="overflow-x-auto bg-white shadow-md rounded-lg p-6 mb-6">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-white border-b border-black rounded-t-lg">
                    <tr>
                        <th
                                class="px-6 py-3 text-left text-lg font-bold text-primary uppercase tracking-wider rounded-tl-lg">
                            Sprint Backlog ({{ count($sprintBacklogTasks) }})
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider hidden md:table-cell">
                            Effort</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider hidden md:table-cell">
                            Value</th>
                        <th
                                class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider hidden md:table-cell rounded-tr-lg whitespace-nowrap">
                            Assigned To</th>
                        <th
                                class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider hidden md:table-cell rounded-tr-lg">
                            Actions</th>
                    </tr>
                    </thead>
                    <tbody id="sprint-tasks" class="bg-white divide-y divide-gray-200">
                    @foreach ($sprintBacklogTasks as $task)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 w-full">
                                {{ $task->title }}</td>
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
                                    <span class="text-gray-400 italic">Unassigned</span>
                                @endif
                            </td>

                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 hidden md:table-cell">
                                <button data-url="{{ route('tasks.updateState', $task->id) }}" data-state="SPRINT_BACKLOG" class="remove-button  bg-primary text-white px-3 py-1 rounded-md hover:bg-blue-700 transition">
                                    Remove
                                </button>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
@endsection

@section('scripts')
    <script src=" {{ asset('js/backlog.js') }} "></script>
@endsection
