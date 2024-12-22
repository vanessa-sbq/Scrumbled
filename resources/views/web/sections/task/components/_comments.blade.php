<div class="bg-gray-50 p-4 rounded-lg shadow text-sm text-gray-700" id="comment-{{ $comment->id }}">
    <div class="flex justify-between">
        <div>
            <!-- Display User -->
            @if ($comment->user)
            <a href="{{route('show.profile', $comment->user->username) }}" class="flex items-center space-x-2 group">
                <img src="{{ asset($comment->user->picture ? 'storage/' . $comment->user->picture : 'images/users/default.png') }}"
                     alt="{{ $comment->user->username }}" class="w-6 h-6 rounded-full">
                <span class="group-hover:underline group-hover:text-primary transition-colors">
                                {{ $comment->user->username }}
                            </span>
            </a>
            @else
                <div class="flex items-center space-x-2 group">
                    <img src="{{ asset('images/users/default.png') }}"
                         alt="anonymous" class="w-6 h-6 rounded-full">
                    <span class="group-hover:underline group-hover:text-primary transition-colors">
                                anonymous
                            </span>
                </div>
            @endif
        </div>

        <!-- Actions -->
        <div class="flex space-x-2" data-edit-comment-url="{{ route('comments.edit', $comment->id) }}" data-delete-comment-url="{{ route('comments.delete', $comment->id) }}">
            @if (Auth::guard("admin")->check() || (Auth::user() && $comment->user && Auth::user()->id === $comment->user->id))
                <button class="edit-comment-button text-blue-500 hover:text-blue-700 edit-comment" data-id="{{ $comment->id }}">
                    ✏️ Edit
                </button>
                <button type="button" class="delete-comment-buttton text-red-500 hover:text-red-700 delete-comment" data-id="{{ $comment->id }}">
                    🗑️ Delete
                </button>
            @endif
        </div>
    </div>

    <!-- Comment Text -->
    <div id="comment-text-{{ $comment->id }}" class="mb-2">
        <p class="overflow-hidden text-ellipsis truncate text-wrap break-all">
            {{ $comment->description }}
        </p>
    </div>

    <!-- Edit Comment Form -->
    <form id="edit-form-{{ $comment->id }}" class="hidden">
        @csrf
        <textarea name="description" id="description-{{ $comment->id }}" rows="3"
                  class="w-full p-2 border rounded-lg focus:ring focus:ring-blue-200" required>{{ $comment->description }}</textarea>
        <button type="button" class="save-edit-comment-button mt-2 px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 save-edit" data-id="{{ $comment->id }}">
            Save Changes
        </button>
    </form>

    <!-- Metadata -->
    <div class="text-right text-xs text-gray-500">
        <span>Posted on {{ $comment->created_at->format('F j, Y, g:i a') }}</span>
    </div>
</div>