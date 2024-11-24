@extends('web.layout')

@section('content')
    <div class="container p-4 md:py-16">
        <!-- Navbar with Breadcrumb -->
        @include('web.sections.project.components._navbar', ['project' => $project])

        <!-- Title Section -->
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-4xl font-bold text-primary"> All Tasks </h1>
        </div>

        <!-- Search Bar -->
        <h1>{{ $project->name }}</h1>
        <form method="GET" action="{{ route('projects.tasks.search', ['slug' => $project->slug]) }}" class="mb-6">
            <input type="text" name="search" placeholder="Search tasks..." class="px-4 py-2 border rounded-lg" value="{{ request('search') }}">
            <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-lg">Search</button>
        </form> 

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
                    Assigned To
                </th>
                <th
                    class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider rounded-tr-lg hidden md:table-cell">
                    SPRINT
                </th>
                <th
                    class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider rounded-tr-lg hidden md:table-cell">
                    STATE
                </th>
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
                    @if($task->assignedDeveloper && $task->assignedDeveloper->user)
                        <x-user :user="$task->assignedDeveloper->user" />
                    @else
                        <p>No user assigned.</p>
                    @endif 
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 hidden md:table-cell">
                        @if ($task->state == "BACKLOG")
                            <p> - </p>
                        @else
                            <p>{{ $task->sprint->name ?? '-' }}</p>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 hidden md:table-cell">
                        <p>{{ strtolower(str_replace('_', ' ', $task->state)) }}</p>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    </div>
@endsection
