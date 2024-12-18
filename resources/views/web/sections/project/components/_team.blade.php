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
            @if (Auth::guard("admin")->check() || auth()->id() === $project->product_owner_id)
                <button data-user-id="{{$project->scrum_master_id}}" class="remove_sm_button px-3 py-1 bg-gray-200 text-gray-800 hover:bg-gray-300 rounded-md">
                    Remove Scrum Master
                </button>
            @endif
        </div>
    @else
        <div class="mb-4 p-4 border border-gray-300 rounded-md text-gray-500">No Scrum Master assigned.</div>
    @endif

    <!-- Developers -->
    <h2 class="text-xl font-semibold mb-3">Developers</h2>
    @if ($developers->isNotEmpty())
        <p class="space-y-4">
            @foreach ($developers as $developer)
                <div class="flex flex-col gap-2 md:flex-row md:gap-0 items-center p-4 border border-gray-300 rounded-md shadow-sm">
                    <div class="flex justify-self-start flex-wrap md:flex-nowrap items-center space-x-4">
                        <img src="{{ $developer->picture ? asset('storage/' . $developer->picture) : asset('images/users/default.png') }}"
                             alt="{{ $developer->full_name }}" class="w-12 h-12 rounded-full">
                        <span class="font-medium text-gray-800">{{ $developer->full_name }}</span>
                    </div>
                    <div class=" md:ml-auto flex gap-2 items-center justify-center flex-wrap">
                        @if (Auth::guard("admin")->check() || auth()->id() === $project->product_owner_id)
                            @if (!isset($project->scrum_master_id))
                                <button data-user-id="{{$developer->id}}" class="set_as_sm_button px-3 py-1 bg-primary text-white rounded-md hover:bg-blue-700">
                                    Set as Scrum Master
                                </button>
                            @endif
                            <button data-user-id="{{$developer->id}}" data-user-name="{{ $developer->username }}" class="remove_dev_button px-3 py-1 bg-red-500 text-white rounded-md hover:bg-red-600">
                                Remove Developer
                            </button>
                        @endif
                    </div>
                </div>
            @endforeach
                @if (Auth::guard("admin")->check() || auth()->id() === $project->product_owner_id)
                    <x-modal id="remove_developer_modal" title="Developer removal" closeButtonText="Cancel" saveButtonText="Yes, remove" saveAction="removeDeveloperHelper" activeButtonColor="bg-red-600" hoverButtonColor="bg-red-700">
                        <div>
                            <p id="fill_user_name"></p>
                            <p id="extra"></p>
                        </div>
                    </x-modal>
                @endif


        <!-- Pagination -->
        <div class="mt-6">
            {{ $developers->links() }}
        </div>
    @else
        <div class="mb-4 p-4 border border-gray-300 rounded-md text-gray-500">No Developers assigned.</div>
    @endif

    <!-- Invite Members -->
</div>

@if (Auth::guard("admin")->check() || Gate::allows('manage', $project))
    <div class="mt-2 text-center">
        <a href="{{ route('projects.inviteForm', $project->slug) }}"
           class="bg-blue-500 text-white px-4 py-2 rounded-md shadow-sm hover:bg-blue-600 transition">
            Invite Members
        </a>
    </div>
@endif


@push('scripts')
    <script src=" {{ asset('js/team.js') }} "></script>
@endpush