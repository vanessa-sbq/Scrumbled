<div class="flex flex-wrap gap-4">
    <div class="block relative bg-white border border-gray-300 rounded-lg p-4 sm:p-6 lg:p-8 hover:border-primary transition-all duration-300 w-full max-w-7xl mx-auto min-w-64">
        <!-- Favorite Button -->
        @auth
            @if (!Auth::guard("admin")->check())
                <button class="favorite-button absolute top-2 right-2 text-xl p-1"
                    data-state="{{ $project->isFavoritedBy(auth()->id()) ? 'Favorited' : 'Unfavorited' }}"
                    data-url="{{ route('projects.updateFavorite', $project->slug) }}">
                    <svg class="{{ $project->isFavoritedBy(auth()->id()) ? 'text-yellow-400' : 'text-gray-400' }} hover:text-yellow-500 transition-colors duration-300" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M11.525 2.295a.53.53 0 0 1 .95 0l2.31 4.679a2.123 2.123 0 0 0 1.595 1.16l5.166.756a.53.53 0 0 1 .294.904l-3.736 3.638a2.123 2.123 0 0 0-.611 1.878l.882 5.14a.53.53 0 0 1-.771.56l-4.618-2.428a2.122 2.122 0 0 0-1.973 0L6.396 21.01a.53.53 0 0 1-.77-.56l.881-5.139a2.122 2.122 0 0 0-.611-1.879L2.16 9.795a.53.53 0 0 1 .294-.906l5.165-.755a2.122 2.122 0 0 0 1.597-1.16z"/></svg>
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
