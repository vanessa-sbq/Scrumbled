@extends('web.layout')

@section('content')
    <div class="container p-4 py-8">
        <!-- Navbar with Breadcrumb -->
        @include('web.sections.project.components._navbar', ['project' => $project])

        <h1 class="text-4xl font-bold mb-8 text-center">{{ $project->title }} Team Members</h1>

        <div class="max-w-lg mx-auto bg-white p-8 rounded-lg shadow-md">
            <!-- Product Owner -->
            <h2 class="text-2xl font-semibold mb-4">Product Owner</h2>
            @if ($project->productOwner)
                <div class="flex items-center justify-between mb-4 p-4 border border-gray-300 rounded-md shadow-sm">
                    <div class="flex items-center">
                        <img src="{{ $project->productOwner->picture ? asset('storage/' . $project->productOwner->picture) : asset('images/users/default.png') }}"
                            alt="{{ $project->productOwner->full_name }}" class="w-10 h-10 rounded-full mr-3">
                        <span class="font-medium">{{ $project->productOwner->full_name }}</span> (Product Owner)
                    </div>
                </div>
            @else
                <div class="mb-4 p-4 border border-gray-300 rounded-md shadow-sm">No Product Owner assigned.</div>
            @endif

            <!-- Scrum Master -->
            <h2 class="text-2xl font-semibold mb-4">Scrum Master</h2>
            @if ($project->scrumMaster)
                <div class="flex items-center justify-between mb-4 p-4 border border-gray-300 rounded-md shadow-sm">
                    <div class="flex items-center">
                        <img src="{{ $project->scrumMaster->picture ? asset('storage/' . $project->scrumMaster->picture) : asset('images/users/default.png') }}"
                            alt="{{ $project->scrumMaster->full_name }}" class="w-10 h-10 rounded-full mr-3">
                        <span class="font-medium">{{ $project->scrumMaster->full_name }}</span> (Scrum Master)
                    </div>

                    @if (auth()->id() === $project->product_owner_id)
                        <!-- Show 'Remove Member' button for the Product Owner -->
                        <form action="{{ route('projects.remove', [$project->slug, $project->scrumMaster->username]) }}"
                            method="POST">
                            @csrf
                            <button type="submit" class="px-3 py-2 bg-red-500 text-white rounded hover:bg-red-700">
                                Remove Member
                            </button>
                        </form>
                    @elseif (auth()->id() === $project->scrumMaster->id)
                        <!-- Show 'Leave Project' button for the Scrum Master -->
                        <form action="{{ route('projects.leave', $project->slug) }}" method="POST">
                            @csrf
                            <button type="submit" class="px-3 py-2 bg-red-500 text-white rounded hover:bg-red-700">
                                Leave Project
                            </button>
                        </form>
                    @endif
                </div>
            @else
                <div class="mb-4 p-4 border border-gray-300 rounded-md shadow-sm">No Scrum Master assigned.</div>
            @endif

            <!-- Developers -->
            <h2 class="text-2xl font-semibold mb-4">Developers</h2>
            @if ($project->developers->isNotEmpty())
                @foreach ($project->developers as $developer)
                    <?php 
                            $developer_project = \App\Models\DeveloperProject::where('project_id', $project->id)
                                ->where('developer_id', $developer->id)
                                ->first(); 
                    ?>
                    @if (!$developer_project->is_pending)
                        <div class="flex items-center justify-between mb-4 p-4 border border-gray-300 rounded-md shadow-sm">
                            <div class="flex items-center">
                                <img src="{{ $developer->picture ? asset('storage/' . $developer->picture) : asset('images/users/default.png') }}"
                                    alt="{{ $developer->full_name }}" class="w-10 h-10 rounded-full mr-3">
                                <span class="font-medium">{{ $developer->full_name }}</span> (Developer)
                            </div>

                            @if (auth()->id() === $project->product_owner_id)
                                <!-- Show 'Remove Member' button for the Product Owner -->
                                <form action="{{ route('projects.remove', [$project->slug, $developer->username]) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="px-3 py-2 bg-red-500 text-white rounded hover:bg-red-700">
                                        Remove Member
                                    </button>
                                </form>
                            @elseif (auth()->id() === $developer->id)
                                <!-- Show 'Leave Project' button for the Developer -->
                                <form action="{{ route('projects.leave', $project->slug) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="px-3 py-2 bg-red-500 text-white rounded hover:bg-red-700">
                                        Leave Project
                                    </button>
                                </form>
                            @endif
                        </div>
                    @endif
                @endforeach
            @else
                <div class="mb-4 p-4 border border-gray-300 rounded-md shadow-sm">No Developers assigned.</div>
            @endif

            <!-- Invite Members (only for users with manage permission) -->
            @can('manage', $project)
                <div class="mt-8 text-center">
                    <a href="{{ route('projects.inviteForm', $project->slug) }}"
                        class="bg-primary text-white px-4 py-2 rounded-md shadow-sm hover:bg-blue-600 transition">
                        Invite Members
                    </a>
                </div>
            @endcan
        </div>
    </div>
@endsection
