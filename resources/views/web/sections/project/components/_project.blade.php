<div class="relative bg-white shadow-md rounded-lg p-6">
    <!-- Favorite Button -->
    @auth
        <button
            class="favorite-button absolute top-2 right-2 text-2xl {{ $project->isFavoritedBy(auth()->id()) ? 'text-yellow-400' : 'text-gray-400' }}"
            data-state="{{ $project->isFavoritedBy(auth()->id()) ? 'Favorited' : 'Unfavorited' }}"
            data-url="{{ route('projects.updateFavorite', $project->slug) }}">
            {{ $project->isFavoritedBy(auth()->id()) ? '★' : '☆' }}
        </button>
    @endauth

    <h2 class="text-2xl font-semibold mb-2">{{ $project->title }}</h2>
    <p class="text-gray-700 mb-4">{{ $project->description }}</p>
    <a href="{{ route('projects.show', $project->slug) }}" class="text-blue-500 hover:underline">View Project</a>
</div>

@push('scripts')
    <script src="{{ asset('js/favorite.js') }}"></script>
@endpush
