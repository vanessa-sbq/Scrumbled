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
        <form method="GET" action="{{ route('projects.tasks.search', ['slug' => $project->slug]) }}" class="flex gap-2">
            <input type="text" name="query" id="task-search-input"
                class="w-full px-3 py-2 mb-4 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary sm:text-sm"
                placeholder="Search tasks...">
            <button type="submit"
                class="px-3 py-2 mb-4 bg-primary text-white rounded-md hover:bg-primary-dark">Search</button>
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
            <tbody class="bg-white divide-y divide-gray-200" id="task-results-container">
                @include('web.sections.task.components._task', ['task' => $tasks])
            </tbody>
        </table>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('js/taskSearch.js') }}"></script>
    <script src="{{ asset('js/dropdown.js') }}"></script>
@endpush
