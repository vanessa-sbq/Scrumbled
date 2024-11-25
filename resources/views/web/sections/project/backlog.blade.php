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
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider hidden md:table-cell">
                            Assigned To</th>
                        <th
                            class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider rounded-tr-lg hidden md:table-cell">
                            Add to Sprint</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
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
                                    <span class="text-red-500">Not Assigned</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 hidden md:table-cell">
                                <button class="bg-primary text-white px-3 py-1 rounded-md hover:bg-blue-700 transition">
                                    Add to Sprint
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
