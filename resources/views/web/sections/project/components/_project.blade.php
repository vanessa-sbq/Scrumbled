<div class="flex flex-wrap gap-4">
    <div class="block relative bg-white border border-gray-300 rounded-lg p-4 sm:p-6 lg:p-8 hover:border-primary transition-all duration-300 w-full max-w-7xl mx-auto min-w-64">
        <!-- Favorite Button -->
        @auth
            @if (!Auth::guard("admin")->check())
                <button class="favorite-button absolute top-2 right-2 text-xl p-1"
                    data-state="{{ $project->isFavoritedBy(auth()->id()) ? 'Favorited' : 'Unfavorited' }}"
                    data-url="{{ route('projects.updateFavorite', $project->slug) }}">
                    <x-lucide-star
                        class="{{ $project->isFavoritedBy(auth()->id()) ? 'text-yellow-400' : 'text-gray-400' }} hover:text-yellow-500 transition-colors duration-300"
                        width="20" height="20" />
                </button>
            @endif
        @endauth
        <h2 class="text-xl sm:text-2xl lg:text-3xl font-semibold mb-2">
            <a href="{{ route('projects.show', $project->slug) }}" class="hover:text-primary transition-colors duration-300">
                {{ $project->title }}
            </a>
        </h2>
        <p class="text-gray-700 mb-4 overflow-hidden text-ellipsis truncate text-wrap break-all">
            {{ Str::limit($project->description, 100) }}
        </p>
    </div>
</div>

@once
    @push('scripts')
        <script src="{{ asset('js/favorite.js') }}"></script>
    @endpush
@endonce
