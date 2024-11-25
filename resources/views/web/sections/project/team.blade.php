@extends('web.layout')

@section('content')
    <div class="container mx-auto py-8">
        <!-- Navbar with Breadcrumb -->
        @include('web.sections.project.components._navbar', ['project' => $project])

        <h1 class="text-4xl font-bold mb-8 text-center">{{ $project->title }} Team Members</h1>

        <div class="max-w-lg mx-auto bg-white p-8 rounded-lg shadow-md">
            <h2 class="text-2xl font-semibold mb-4">Product Owner</h2>
            @if ($project->productOwner)
                <div class="flex items-center mb-4 p-4 border border-gray-300 rounded-md shadow-sm">
                    <img src="{{ $project->productOwner->picture ? asset('storage/' . $project->productOwner->picture) : asset('images/users/default.png') }}"
                        alt="{{ $project->productOwner->full_name }}" class="w-10 h-10 rounded-full mr-3">
                    <span class="font-medium">{{ $project->productOwner->full_name }}</span> (Product Owner)
                </div>
            @else
                <div class="mb-4 p-4 border border-gray-300 rounded-md shadow-sm">No Product Owner assigned.</div>
            @endif

            <h2 class="text-2xl font-semibold mb-4">Scrum Master</h2>
            @if ($project->scrumMaster)
                <div class="flex items-center mb-4 p-4 border border-gray-300 rounded-md shadow-sm">
                    <img src="{{ $project->scrumMaster->picture ? asset('storage/' . $project->scrumMaster->picture) : asset('images/users/default.png') }}"
                        alt="{{ $project->scrumMaster->full_name }}" class="w-10 h-10 rounded-full mr-3">
                    <span class="font-medium">{{ $project->scrumMaster->full_name }}</span> (Scrum Master)
                </div>
            @else
                <div class="mb-4 p-4 border border-gray-300 rounded-md shadow-sm">No Scrum Master assigned.</div>
            @endif

            <h2 class="text-2xl font-semibold mb-4">Developers</h2>
            @if ($project->developers->isNotEmpty())
                @foreach ($project->developers as $developer)
                    <div class="flex items-center mb-4 p-4 border border-gray-300 rounded-md shadow-sm">
                        <img src="{{ $developer->picture ? asset('storage/' . $developer->picture) : asset('images/users/default.png') }}"
                            alt="{{ $developer->full_name }}" class="w-10 h-10 rounded-full mr-3">
                        <span class="font-medium">{{ $developer->full_name }}</span> (Developer)
                    </div>
                @endforeach
            @else
                <div class="mb-4 p-4 border border-gray-300 rounded-md shadow-sm">No Developers assigned.</div>
            @endif

            @can('manage', $project)
            <div class="mt-8 text-center">
                <a href="{{ route('projects.inviteForm', $project->slug) }}"
                    class="bg-blue-500 text-white px-4 py-2 rounded-md shadow-sm hover:bg-blue-600 transition">
                    Invite Members
                </a>
            </div>
            @endcan
        </div>
    </div>
@endsection
