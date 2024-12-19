@extends('web.layout')

@section('content')
    <div class="container py-8 p-4">
        <!-- Breadcrumb Navigation -->
        @if ($project->is_archived) <div class="w-full bg-amber-100 mb-2 p-4 text-center rounded-xl">Project is archived.</div>@endif
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
            <header class="mb-6 border-b pb-4 flex justify-between items-center">
                <h1 class="text-3xl font-extrabold text-primary">{{ $task->title }}</h1>

                <a href="{{ route('tasks.showEdit', ['slug' => $project->slug, 'id' => $task->id]) }}"
                   class="bg-primary text-white px-4 py-2 rounded-md hover:bg-blue-700 transition ml-auto">
                    Edit Task
                </a>
            </header>

            <!-- Task Details -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-8">
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
            </div>
        </div>

        <section class="mt-8" data-create-comment-url="{{ route('comments.create', $task->id) }}">
            <h2 class="text-xl font-bold text-gray-800 mb-4">Comments</h2>

            <!-- Display Comments -->
            <div class="space-y-4">
                @forelse ($comments as $comment)
                    @include('web.sections.task.components._comments', ['user' => $comment->user, 'comment' => $comment])
                @empty
                    <p class="text-gray-500">No comments yet.</p>
                @endforelse
            </div>

            <!-- Add Comment Section -->
            <div class="mt-6">
                <button id="addComment" class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600">
                    Add Comment
                </button>
            </div>

            <div id="commentForm" class="mt-4 hidden">
                <div class="bg-gray-50 p-4 rounded-lg shadow">
                    <form id="add-comment-form">
                        @csrf
                        <div class="mb-4">
                    <textarea name="description" id="new-comment-description" rows="3" class="w-full p-2 border rounded-lg focus:ring focus:ring-blue-200"
                              placeholder="Write your comment here..." required></textarea>
                        </div>
                        <div class="flex justify-end">
                            <button type="button" id="submit-comment" class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600">
                                Confirm
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </div>
@endsection

@once
    @push('scripts')

        <script  src=" {{ asset('js/comments.js') }} "></script>
    @endpush
@endonce

