<div class="flex flex-col bg-white p-6 rounded-lg shadow-md">
    <!-- Product Owner -->
    <h2 class="text-xl font-semibold mb-4">Product Owner</h2>
    @if ($project->productOwner)
        <div class="flex items-center justify-between mb-4 p-4 border border-gray-300 rounded-md shadow-sm">
            <div class="flex items-center space-x-4">
                <img src="{{ $project->productOwner->picture ? asset('storage/' . $project->productOwner->picture) : asset('images/users/default.png') }}"
                     alt="{{ $project->productOwner->full_name }}" class="w-12 h-12 rounded-full">
                <span class="font-medium text-gray-800">{{ $project->productOwner->full_name }}</span>
            </div>
        </div>
    @else
        <div class="mb-4 p-4 border border-gray-300 rounded-md text-gray-500">No Product Owner assigned.</div>
    @endif

    <!-- Scrum Master -->
    <h2 class="text-xl font-semibold mb-4">Scrum Master</h2>
    @if ($project->scrumMaster)
        <div class="flex flex-col gap-2 md:flex-row md:gap-0 items-center justify-between mb-4 p-4 border border-gray-300 rounded-md shadow-sm">
            <div class="flex flex-wrap md:flex-nowrap items-center space-x-4">
                <img src="{{ $project->scrumMaster->picture ? asset('storage/' . $project->scrumMaster->picture) : asset('images/users/default.png') }}"
                     alt="{{ $project->scrumMaster->full_name }}" class="w-12 h-12 rounded-full">
                <span class="font-medium text-gray-800">{{ $project->scrumMaster->full_name }}</span>
            </div>
            @if (auth()->id() === $project->product_owner_id)
                <form action="{{ route('projects.remove', [$project->slug, $project->scrumMaster->username]) }}" method="POST">
                    @csrf
                    <button type="submit" class="px-3 py-1 bg-red-500 text-white rounded-md hover:bg-red-600">
                        Remove Member
                    </button>
                </form>
            @endif
        </div>
    @else
        <div class="mb-4 p-4 border border-gray-300 rounded-md text-gray-500">No Scrum Master assigned.</div>
    @endif

    <!-- Developers -->
    <h2 class="text-xl font-semibold mb-4">Developers</h2>
    @if ($developers->isNotEmpty())
        <div class="space-y-4">
            @foreach ($developers as $developer)
                <div class="flex flex-col gap-2 md:flex-row md:gap-0 items-center justify-between p-4 border border-gray-300 rounded-md shadow-sm">
                    <div class="flex flex-wrap md:flex-nowrap items-center space-x-4">
                        <img src="{{ $developer->picture ? asset('storage/' . $developer->picture) : asset('images/users/default.png') }}"
                             alt="{{ $developer->full_name }}" class="w-12 h-12 rounded-full">
                        <span class="font-medium text-gray-800">{{ $developer->full_name }}</span>
                    </div>
                    @if (auth()->id() === $project->product_owner_id)
                        <form action="{{ route('projects.remove', [$project->slug, $developer->username]) }}" method="POST">
                            @csrf
                            <button type="submit" class="px-3 py-1 bg-red-500 text-white rounded-md hover:bg-red-600">
                                Remove Member
                            </button>
                        </form>
                    @endif
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="mt-6">
            {{ $developers->links() }}
        </div>
    @else
        <div class="mb-4 p-4 border border-gray-300 rounded-md text-gray-500">No Developers assigned.</div>
    @endif

    <!-- Invite Members -->
    @can('manage', $project)
        <div class="mt-8 text-center">
            <a href="{{ route('projects.inviteForm', $project->slug) }}"
               class="bg-blue-500 text-white px-4 py-2 rounded-md shadow-sm hover:bg-blue-600 transition">
                Invite Members
            </a>
        </div>
    @endcan
</div>
