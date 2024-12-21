    @extends('web.layout')

    @section('content')
        <div class="container py-8 p-4">
            <!-- Navbar with Breadcrumb -->
            @include('web.sections.project.components._navbar', ['project' => $project])

            <!-- Title Section -->
            <div class="flex items-center justify-between mb-6">
                <h1 class="text-4xl font-bold text-primary"> All Tasks </h1>
            </div>

            <form id="task-search" method="GET" action="{{ route('projects.tasks.search', ['slug' => $project->slug]) }}" class="flex flex-col gap-3">
                <!-- Search Input -->
                <div class="flex gap-2">
                    <input type="text" name="query" id="task-search-input"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary sm:text-sm"
                           placeholder="Search tasks...">
                    <button type="submit"
                            class="px-3 py-2 bg-primary text-white rounded-md hover:bg-primary-dark">Search</button>
                </div>

                <!-- Filters -->
                <div class="flex gap-2 mb-2">
                    <select id="state-input" name="state" class="w-1/5 border py-1.5 px-2 rounded text-sm">
                        <option value="">All States</option>
                        <option value="BACKLOG">Backlog</option>
                        <option value="SPRINT_BACKLOG">Sprint Backlog</option>
                        <option value="IN_PROGRESS">In Progress</option>
                        <option value="DONE">Done</option>
                        <option value="ACCEPTED">Accepted</option>
                    </select>
                    <select id="value-input" name="value" class="w-1/5 border py-1.5 px-2 rounded text-sm">
                        <option value="">All Values</option>
                        <option value="MUST_HAVE">Must Have</option>
                        <option value="SHOULD_HAVE">Should Have</option>
                        <option value="COULD_HAVE">Could Have</option>
                        <option value="WILL_NOT_HAVE">Will Not Have</option>
                    </select>
                    <select id="effort-input" name="effort" class="w-1/5 border py-1.5 px-2 rounded text-sm">
                        <option value="">All Efforts</option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="5">5</option>
                        <option value="8">8</option>
                        <option value="13">13</option>
                    </select>
                    <select id="assigned-input" name="assigned_to" class="w-1/5 border py-1.5 px-2 rounded text-sm">
                        <option value="">All Developers</option>
                        @foreach($project->developers as $developer)
                            <option value="{{ $developer->id }}">{{ $developer->username }}</option>
                        @endforeach
                        <option value="unassigned">Unassigned</option>
                    </select>
                </div>
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

    @once
        @push('scripts')
            <script src="{{ asset('js/taskFilters.js') }}"></script>
            <script src="{{ asset('js/dropdown.js') }}"></script>
        @endpush
    @endonce
