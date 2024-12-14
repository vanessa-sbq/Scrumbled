<div
    class="block relative bg-white border border-gray-300 rounded-lg p-6 hover:border-primary transition-border duration-300">
    <!-- Favorite Button -->
    @auth
        <button class="favorite-button absolute top-2 right-2 text-xl p-1"
            data-state="{{ $project->isFavoritedBy(auth()->id()) ? 'Favorited' : 'Unfavorited' }}"
            data-url="{{ route('projects.updateFavorite', $project->slug) }}">
            <x-lucide-star
                class="{{ $project->isFavoritedBy(auth()->id()) ? 'text-yellow-400' : 'text-gray-400' }} hover:text-yellow-500 transition-colors duration-300"
                width="20" height="20" />
        </button>
    @endauth

    <h2 class="text-2xl font-semibold mb-2">
        <a href="{{ route('projects.show', $project->slug) }}" class="hover:text-primary transition-colors duration-300">
            {{ $project->title }}
        </a>
    </h2>
    <p class="text-gray-700 mb-4">{{ $project->description }}</p>
</div>

