@extends('web.layout')

@section('content')
    <div class="container p-4 md:py-16">
        <h1 class="text-4xl font-bold">Projects List</h1>
        <div
            class="flex flex-wrap gap-4 min-h-14 justify-between items-center my-8 bg-white rounded-md py-2 px-8 border border-muted shadow-sm">
            @php
                $projectLinks = [];
                if (auth()->check()) {
                    $projectLinks[] = ['type' => 'my_projects', 'label' => 'My Projects'];
                }

                $projectLinks[] = ['type' => 'public', 'label' => 'Public'];

                if (auth()->check()) {
                    $projectLinks[] = ['type' => 'favorites', 'label' => 'Favorites'];
                }
            @endphp

            <div class="flex flex-wrap items-center gap-4">
                @foreach ($projectLinks as $link)
                    <a href="{{ route('projects', ['type' => $link['type']]) }}"
                        class="{{ $type === $link['type'] ? 'text-primary font-bold' : 'text-gray-600' }} hover:text-primary transition-colors duration-300">
                        {{ $link['label'] }}
                    </a>
                @endforeach
            </div>
            @auth
                <x-button variant="primary" size="md" href="{{ route('projects.create') }}" extraClasses="shadow-lg">
                    Create Project
                </x-button>
            @endauth
        </div>

        @if ($projects->isEmpty())
            <p class="text-gray-600">No projects found.</p>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($projects as $project)
                    @include('web.sections.project.components._project', ['project' => $project])
                @endforeach
            </div>
        @endif
    </div>
@endsection
