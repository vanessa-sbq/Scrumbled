@extends('web.layout')

@section('content')
    <div class="container py-8">
        <h1 class="text-4xl font-bold mb-6 text-primary">{{ $sprint->name }} <span class="text-muted-foreground">(#{{ $sprint->id }})</span></h1>

        <!-- Sprint Backlog Table -->
        <div class="bg-card shadow-card rounded-card p-6 mb-6">
            <table class="table-auto w-full border-collapse">
                <thead>
                <tr class="bg-primary text-white">
                    <th class="text-left py-3 px-4">To Do</th>
                    <th class="text-left py-3 px-4">Description</th>
                    <th class="text-left py-3 px-4">Effort</th>
                    <th class="text-left py-3 px-4">Value</th>
                    <th class="text-left py-3 px-4">Assigned To</th>
                    <th class="text-left py-3 px-4">Start</th>
                </tr>
                </thead>
                <tbody>
                @foreach($sprintBacklogTasks as $task)
                    <tr class="even:bg-muted odd:bg-background">
                        <td class="py-3 px-4 text-foreground">{{ $task->title }}</td>
                        <td class="py-3 px-4 text-muted-foreground">{{ $task->description }}</td>
                        <td class="py-3 px-4 text-foreground">{{ $task->effort }}</td>
                        <td class="py-3 px-4 text-foreground">{{ $task->value }}</td>
                        <td class="py-3 px-4 text-foreground">{{ $task->assigned_to }}</td>
                        <td class="py-3 px-4">
                            <button class="bg-primary text-white px-4 py-2 rounded-md hover:bg-blue-700 transition">
                                Start Task
                            </button>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>

        <!-- Other Cards (In Progress, Done, Accepted) -->
        <div class="flex flex-wrap gap-6">
            <!-- In Progress -->
            <div class="bg-card shadow-card rounded-card p-6 flex-1 min-w-[300px]">
                <h3 class="text-xl font-bold text-primary mb-4">In Progress</h3>
                <div class="space-y-4">
                    @foreach($inProgressTasks as $task)
                        <div class="p-4 bg-muted rounded-md shadow-sm">
                            <h4 class="text-lg font-semibold text-foreground">{{ $task->title }}</h4>
                            <p class="text-muted-foreground">{{ $task->description }}</p>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Done -->
            <div class="bg-card shadow-card rounded-card p-6 flex-1 min-w-[300px]">
                <h3 class="text-xl font-bold text-primary mb-4">Done</h3>
                <div class="space-y-4">
                    @foreach($doneTasks as $task)
                        <div class="p-4 bg-muted rounded-md shadow-sm">
                            <h4 class="text-lg font-semibold text-foreground">{{ $task->title }}</h4>
                            <p class="text-muted-foreground">{{ $task->description }}</p>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Accepted -->
            <div class="bg-card shadow-card rounded-card p-6 flex-1 min-w-[300px]">
                <h3 class="text-xl font-bold text-primary mb-4">Accepted</h3>
                <div class="space-y-4">
                    @foreach($acceptedTasks as $task)
                        <div class="p-4 bg-muted rounded-md shadow-sm">
                            <h4 class="text-lg font-semibold text-foreground">{{ $task->title }}</h4>
                            <p class="text-muted-foreground">{{ $task->description }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

    <div class="mt-8">
        <a href="{{ route('projects') }}" class="text-blue-500 hover:underline">Back to Projects</a>
    </div>

@endsection
