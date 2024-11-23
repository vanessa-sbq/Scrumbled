@extends('web.layout')

@section('content')
    <div class="container py-8 p-4">
        <!-- Navbar with Breadcrumb -->
        <div class="flex justify-between items-center mb-6">
            <div class="flex items-center space-x-2 text-gray-600">
                <a href="{{ route('projects') }}" class="hover:underline">{{ Auth::user()->name }}</a>
                <span>/</span>
                <a href="{{ route('projects.show', $project->slug) }}" class="hover:underline">{{ $project->slug }}</a>
            </div>
            <div class="flex space-x-4">
                <a href="{{ route('projects', $project->slug) }}" class="text-blue-500 hover:underline">Backlog</a>
                <a href="{{ route('projects', $project->slug) }}" class="text-blue-500 hover:underline">Settings</a>
            </div>
        </div>

        <!-- Title Section -->
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-4xl font-bold text-primary">{{ $sprint->name }} <span
                    class="text-muted-foreground">(#{{ $sprint->id }})</span></h1>
            <form method="POST" action="{{ route('sprint.close', $sprint->id) }}" class="ml-4">
                @csrf
                <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded-md hover:bg-red-700 transition">Close
                    Sprint</button>
            </form>
        </div>

        <!-- Sprint Backlog -->
        @include('web.sections.project.components._sprint', ['tasks' => $sprintBacklogTasks])

        <!-- Other Cards (In Progress, Done, Accepted) -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- In Progress -->
            <div class="bg-white shadow-md rounded-lg p-6">
                <h3 class="text-xl font-bold text-primary mb-4">In Progress</h3>
                <div class="space-y-4">
                    @foreach ($inProgressTasks as $task)
                        @include('web.sections.project.components._task', ['task' => $task])
                    @endforeach
                </div>
            </div>

            <!-- Done -->
            <div class="bg-white shadow-md rounded-lg p-6">
                <h3 class="text-xl font-bold text-primary mb-4">Done</h3>
                <div class="space-y-4">
                    @foreach ($doneTasks as $task)
                        @include('web.sections.project.components._task', ['task' => $task])
                    @endforeach
                </div>
            </div>

            <!-- Accepted -->
            <div class="bg-white shadow-md rounded-lg p-6">
                <h3 class="text-xl font-bold text-primary mb-4">Accepted</h3>
                <div class="space-y-4">
                    @foreach ($acceptedTasks as $task)
                        @include('web.sections.project.components._task', ['task' => $task])
                    @endforeach
                </div>
            </div>
        </div>

        <div class="mt-8">
            <a href="{{ route('projects') }}" class="text-blue-500 hover:underline">Back to Projects</a>
        </div>
    </div>
@endsection
