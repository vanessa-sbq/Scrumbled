@extends('web.layout')

@section('content')
    <div class="container py-8">
        <!-- Breadcrumb Navigation -->
        <nav class="mb-6 text-sm text-gray-600">
            <a href="{{ route('projects.backlog', $project->slug) }}" class="text-primary hover:underline">
                {{ $project->title }}
            </a>
            <span class="mx-2 text-gray-400">/</span>
            <span class="font-bold text-gray-800">{{ $task->title }}</span>
        </nav>

        <!-- Task Details Section -->
        <div class="bg-white shadow rounded-lg p-8">
            <!-- Task Title -->
            <header class="mb-6 border-b pb-4">
                <h1 class="text-3xl font-extrabold text-primary">{{ $task->title }}</h1>
            </header>

            <!-- Task Details -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
                <!-- General Details -->
                <section>
                    <h2 class="text-xl font-bold text-gray-800 mb-4">Details</h2>
                    <div class="space-y-3 text-gray-600 text-sm">
                        <p>
                            <span class="font-semibold">Description:</span>
                            {{ $task->description ?? 'No description provided' }}
                        </p>
                        <p>
                            <span class="font-semibold">State:</span>
                            {{ ucfirst(strtolower($task->state)) }}
                        </p>
                        <p>
                            <span class="font-semibold">Effort:</span>
                            {{ $task->effort }}
                        </p>
                        <p>
                            <span class="font-semibold">Value:</span>
                            {{ $task->value }}
                        </p>
                    </div>
                </section>

                <!-- Project and Sprint Details -->
                <section>
                    <h2 class="text-xl font-bold text-gray-800 mb-4">Associations</h2>
                    <div class="space-y-3 text-gray-600 text-sm">
                        <p>
                            <span class="font-semibold">Project:</span>
                            <a href="{{ route('projects.backlog', $project->slug) }}" class="text-primary hover:underline">
                                {{ $project->title }}
                            </a>
                        </p>
                        <p>
                            <span class="font-semibold">Sprint:</span>
                            @if ($sprint)
                                <a href="{{ route('sprint.show', $sprint->id) }}" class="text-primary hover:underline">
                                    {{ $sprint->title }}
                                </a>
                            @else
                                Not assigned to any sprint
                            @endif
                        </p>
                    </div>
                </section>
            </div>

            <!-- Assigned Developer -->
            <section class="mb-8">
                <h2 class="text-xl font-bold text-gray-800 mb-4">Assigned Developer</h2>
                @if ($task->assignedDeveloper)
                    <div class="flex items-center">
                        <x-user :user="$task->assignedDeveloper->user" />
                        <span class="ml-3 text-gray-600">{{ $task->assignedDeveloper->user->name }}</span>
                    </div>
                @else
                    <p class="text-sm text-gray-600">No developer assigned</p>
                @endif
            </section>

            <!-- Action Buttons -->
            <footer class="flex justify-end space-x-4">
                <a href="{{ route('tasks.showEdit', ['slug' => $project->slug, 'id' => $task->id]) }}"
                    class="bg-primary text-white px-4 py-2 rounded-md hover:bg-blue-700 transition">
                    Edit Task
                </a>
            </footer>
        </div>
    </div>
@endsection
