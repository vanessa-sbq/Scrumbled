@extends('web.layout')

@section('content')
    <div class="container py-8 p-4">
        <!-- Navbar with Breadcrumb -->
        @include('web.sections.project.components._navbar', ['project' => $project])

        <!-- Title Section -->
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-4xl font-bold text-primary">{{ $project->title }} Backlog</h1>

            <!-- Create Task Button -->
            <a href="{{ route('tasks.createNew', $project->slug) }}"
                class="bg-primary text-white px-4 py-2 rounded-md hover:bg-blue-700 transition">
                Create Task
            </a>
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
                        <th
                            class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider hidden md:table-cell whitespace-nowrap">
                            Assigned To</th>
                        @if ($currentSprint)
                            <th
                                class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider rounded-tr-lg hidden md:table-cell">
                                Actions</th>
                        @endif
                    </tr>
                </thead>
                <tbody id="backlog-tasks" class="bg-white divide-y divide-gray-200">
                    @foreach ($backlogTasks as $task)
                        @include('web.sections.project.components._backlogTasks', ['task' => $task, 'state' => 'backlog'])
                    @endforeach
                </tbody>
            </table>
        </div>

        @if (!$currentSprint)
            <!-- No Active Sprint -->
            <div class="text-center py-16">
                <h2 class="text-2xl font-bold text-gray-600 mb-4">This project has no active sprints!</h2>
                @if (Auth::user())
                    <a href="{{ route('sprint.create', $project->slug) }}"
                       class="bg-primary text-white px-6 py-3 rounded-md hover:bg-blue-700 transition">
                        Create Sprint
                    </a>
                @endif
            </div>
        @else
            <!-- Sprint Backlog Table -->
            <div class="overflow-x-auto bg-white shadow-md rounded-lg p-6 mb-6">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-white border-b border-black rounded-t-lg">
                        <tr>
                            <th
                                class="px-6 py-3 text-left text-lg font-bold text-primary uppercase tracking-wider rounded-tl-lg">
                                Sprint Backlog ({{ count($sprintBacklogTasks) }})
                            </th>
                            <th
                                class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider hidden md:table-cell">
                                Effort</th>
                            <th
                                class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider hidden md:table-cell">
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
                            @include('web.sections.project.components._backlogTasks', ['task' => $task, 'state' => 'sprint'])
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
@endsection

@once
    @push('scripts')
        <script src="{{ asset('js/backlog.js') }}"></script>
        <script src="{{ asset('js/dropdown.js') }}"></script>
    @endpush
@endonce
