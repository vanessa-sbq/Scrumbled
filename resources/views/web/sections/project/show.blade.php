@extends('web.layout')

@section('content')
    <div class="container mx-auto py-8">
        <div class="flex justify-between items-center mb-4">
            <h1 class="text-4xl font-bold">{{ $project->title }}</h1>
            @auth
                <a href="{{ route('projects.invite', $project->slug) }}"
                    class="bg-primary text-white px-4 py-2 rounded-md shadow-sm hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">
                    Invite Members
                </a>
            @endauth
        </div>
        <p class="text-gray-700 mb-4">{{ $project->description }}</p>

        <div class="bg-white shadow-md rounded-lg p-6">
            <h2 class="text-2xl font-semibold mb-2">Project Details</h2>
            <p class="text-gray-700 mb-4">Created at: {{ $project->created_at->format('M d, Y') }}</p>
        </div>

        <div class="mt-8">
            <a href="{{ route('projects') }}" class="text-blue-500 hover:underline">Back to Projects</a>
        </div>
    </div>
@endsection
