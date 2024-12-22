@extends('web.layout')

@section('content')
    <div class="container py-8 p-4">
        <!-- Breadcrumb Navigation -->
        @if ($project->is_archived)
            <div class="w-full bg-amber-100 border-amber-500 border-2 mb-2 p-4 text-center rounded-xl">Project is archived.
            </div>
        @endif
        <nav class="mb-6 text-sm text-gray-600">
            <a href="{{ route('projects.backlog', $project->slug) }}" class="text-primary hover:underline">
                {{ $project->title }}
            </a>
            <span class="mx-2 text-gray-400">/</span>
            <span class="font-bold text-gray-800">{{ $task->title }}</span>
        </nav>

        <!-- Task Header -->
        <header class="mb-6 border-b pb-4 flex flex-wrap gap-4 justify-between items-center">
            <div>
                <h1 class="text-3xl font-extrabold text-primary">{{ $task->title }}</h1>
            </div>
            @if (Auth::guard('admin')->check() || Auth::user())
                <div class="flex gap-4">
                    <!-- Edit Task Button -->
                    <a href="{{ route('tasks.showEdit', ['slug' => $project->slug, 'id' => $task->id]) }}"
                        class="bg-primary text-white px-4 py-2 rounded-md hover:bg-blue-700 transition">
                        Edit Task
                    </a>
                    <!-- Delete Task Button -->
                    <form action="{{ route('tasks.deleteTask', ['slug' => $project->slug, 'id' => $task->id]) }}"
                        method="POST" onsubmit="return confirm('Are you sure you want to delete this task?');">
                        @csrf
                        <button type="submit"
                            class="bg-red-600 text-white px-4 py-2 rounded-md hover:bg-red-700 transition">
                            Delete Task
                        </button>
                    </form>
                </div>
            @endif
        </header>

        <div class="flex flex-col-reverse md:flex-row gap-4">
            <!-- Task Description and Comments -->
            <div class="md:w-2/3 space-y-4">
                <!-- Task Description -->
                <div class="bg-white shadow rounded-lg p-8">
                    <h2 class="text-xl font-bold mb-4">Description</h2>
                    <p>{{ $task->description }}</p>
                </div>

                <!-- Comments Section -->
                <section class="bg-white shadow rounded-lg p-8"
                    data-create-comment-url="{{ route('comments.create', $task->id) }}">
                    <h2 class="text-xl font-bold mb-4">Comments</h2>
                    <div class="space-y-4 comments-container">
                        @forelse ($task->comments as $comment)
                            @include('web.sections.task.components._comments', ['comment' => $comment])
                        @empty
                            <p class="text-gray-500">No comments yet.</p>
                        @endforelse
                    </div>
                </section>

                <!-- Add Comment Form -->
                <section class="bg-white shadow rounded-lg p-8">
                    <h2 class="text-xl font-bold mb-4">Add Comment</h2>
                    <form id="add-comment-form" method="POST">
                        @csrf
                        <textarea name="description" id="new-comment-description" class="w-full p-2 border rounded-md" rows="4"
                            placeholder="Add your comment here"></textarea>
                        <button type="button" id="submit-comment"
                            class="bg-primary text-white px-4 py-2 rounded-md hover:bg-blue-700 transition mt-2">
                            Submit
                        </button>
                    </form>
                </section>
            </div>

            <!-- Task Details -->
            <section class="md:w-1/3">
                <div class="bg-white shadow rounded-lg p-8 sticky top-4">
                    <h2 class="text-xl font-bold mb-4">Details</h2>
                    <div class="space-y-4">
                        <div>
                            <h3 class="text-lg font-semibold">Project</h3>
                            <p><a href="{{ route('projects.backlog', $project->slug) }}"
                                    class="text-primary hover:underline">{{ $project->title }}</a></p>
                        </div>
                        @if ($task->sprint)
                            <div>
                                <h3 class="text-lg font-semibold">Sprint</h3>
                                <p>{{ $task->sprint->name }}</p>
                            </div>
                        @endif
                        <div>
                            <h3 class="text-lg font-semibold">Assigned Developer</h3>
                            @if ($task->assignedDeveloper && $task->assignedDeveloper->user)
                                <x-user :user="$task->assignedDeveloper->user" />
                            @else
                                <button id="assignButton"
                                    class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-600 transition">
                                    Assign to Me
                                </button>
                            @endif
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold">Status</h3>
                            <x-badge type="status" :value="$task->state" />
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold">Effort</h3>
                            <x-badge type="effort" :value="$task->effort" />
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold">Value</h3>
                            <x-badge type="value" :value="$task->value" />
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
@endsection

@once
    @push('scripts')
        <script src="{{ asset('js/comments.js') }}"></script>
        <script>
            document.getElementById('assignButton').addEventListener('click', function() {
                fetch('{{ route('tasks.assign', ['id' => $task->id]) }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            user_id: '{{ Auth::id() }}'
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.status === 'success') {
                            location.reload();
                        } else {
                            alert(data.message);
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('An unexpected error occurred. Please try again.');
                    });
            });
        </script>
    @endpush
@endonce
