@extends('web.layout')

@section('content')
    <div class="container p-4 md:py-16">
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-4xl font-bold">My Projects</h1>
            <a href="{{ route('projects.create') }}"
                class="bg-primary text-white px-4 py-2 rounded-md shadow-sm hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">
                Create Project
            </a>
        </div>

        @if ($projects->isEmpty())
            <p class="text-gray-600">You have no projects.</p>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($projects as $project)
                    @include('web.sections.project.components._project', ['project' => $project])
                @endforeach
            </div>
        @endif
    </div>
@endsection
