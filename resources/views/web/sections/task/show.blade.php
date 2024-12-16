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

        <!-- Comment Section -->
        <section class="mt-8">
            <h2 class="text-xl font-bold text-gray-800 mb-4">Comments</h2>

            <!-- Display Comments -->
            <div class="space-y-4">
                @forelse ($comments as $comment)
                    <div class="bg-gray-50 p-4 rounded-lg shadow text-sm text-gray-700">
                        <p class="mb-2">{{ $comment->description }}</p>

                        <div class="flex justify-between items-center text-xs text-gray-500">
                            <!-- Display User -->
                            <a href="{{ route('show.profile', $comment->user->username) }}" class="flex items-center space-x-2 group">
                                <img src="{{ asset($comment->user->picture ? 'storage/' . $comment->user->picture : 'images/users/default.png') }}"
                                     alt="{{ $comment->user->username }}" class="w-6 h-6 rounded-full">
                                <span class="group-hover:underline group-hover:text-primary transition-colors">
                            {{ $comment->user->username }}
                        </span>
                            </a>

                            <!-- Posted Timestamp -->
                            <span>Posted on: {{ $comment->created_at->format('F j, Y, g:i a') }}</span>
                        </div>
                    </div>
                @empty
                    <p class="text-gray-500">No comments yet.</p>
                @endforelse
            </div>

            <!-- Trigger Button -->
            <div class="mt-6">
                <button id="addComment" class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600">
                    Add Comment
                </button>
            </div>

            <!-- Hidden Comment Form -->
            <div id="commentForm" class="mt-4 hidden">
                <div class="bg-gray-50 p-4 rounded-lg shadow">
                    <form method="POST" action="{{ route('comments.create', $task->id) }}">
                        @csrf
                        <div class="mb-4">
                    <textarea name="description" rows="3" class="w-full p-2 border rounded-lg focus:ring focus:ring-blue-200"
                              placeholder="Write your comment here..." required></textarea>
                        </div>
                        <div class="flex justify-end">
                            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600">
                                Add Comment
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
        <script src=" {{ asset('js/comments.js') }} "></script>
    @endpush
@endonce

