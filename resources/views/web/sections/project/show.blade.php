@extends('web.layout')

@section('content')
    <div class="container py-8 p-4">
        <!-- Navbar with Breadcrumb -->
        @include('web.sections.project.components._navbar', ['project' => $project])

        <!-- Title Section -->
        @if ($sprint && !$sprint->is_archived)
            <div class="flex items-center justify-between mb-6">
                <h1 class="text-4xl font-bold text-primary">{{ $sprint->name }} <span
                        class="text-muted-foreground">(#{{ $sprint->id }})</span></h1>
                @can('manage', $project)
                    <form method="POST" action="{{ route('sprint.close', $sprint->id) }}" class="ml-4">
                        @csrf
                        <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded-md hover:bg-red-700 transition">
                            Close Sprint
                        </button>
                    </form>
                @endcan
            </div>

            <!-- Sprint Backlog -->
            @include('web.sections.project.components._sprint', ['tasks' => $sprintBacklogTasks])

            <div class="mb-6 mt-4 flex items-center">
                <label class="inline-flex items-center">
                    <input type="checkbox" id="showMyTasks" class="form-checkbox text-primary" />
                    <span class="ml-2 text-lg font-medium text-gray-700">Show only my tasks</span>
                </label>
            </div>

            <!-- Other Cards (In Progress, Done, Accepted) -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- In Progress -->
                <div class="bg-white shadow-md rounded-lg p-6">
                    <h3 class="text-xl font-bold text-primary mb-4">In Progress</h3>
                    <div class="space-y-4" id="in-progress">
                        @foreach ($inProgressTasks as $task)
                            @include('web.sections.project.components._task', ['task' => $task])
                        @endforeach
                    </div>
                </div>

                <!-- Done -->
                <div class="bg-white shadow-md rounded-lg p-6">
                    <h3 class="text-xl font-bold text-primary mb-4">Done</h3>
                    <div class="space-y-4" id="done">
                        @foreach ($doneTasks as $task)
                            @include('web.sections.project.components._task', ['task' => $task])
                        @endforeach
                    </div>
                </div>

                <!-- Accepted -->
                <div class="bg-white shadow-md rounded-lg p-6">
                    <h3 class="text-xl font-bold text-primary mb-4">Accepted</h3>
                    <div class="space-y-4" id="accepted">
                        @foreach ($acceptedTasks as $task)
                            @include('web.sections.project.components._task', ['task' => $task])
                        @endforeach
                    </div>
                </div>
            @else
                <!-- No Active Sprint Message -->
                <div class="text-center py-16">
                    <h2 class="text-2xl font-bold text-gray-600 mb-4">This project has no active sprints!</h2>
                    <a href="{{ route('sprint.create', $project->slug) }}"
                        class="bg-primary text-white px-6 py-3 rounded-md hover:bg-blue-700 transition">
                        Create Sprint
                    </a>
                </div>
        @endif

        <div class="mt-8">
            <a href="{{ route('projects') }}" class="text-primary hover:underline">Back to Projects</a>
        </div>
    </div>
@endsection

@push('scripts')
    <script src=" {{ asset('js/task.js') }} "></script>
    <script src="{{ asset('js/dropdown.js') }}"></script>
@endpush
