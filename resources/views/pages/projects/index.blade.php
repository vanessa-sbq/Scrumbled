@extends('layouts.app')

@section('title', 'Projects')

@section('content')
    <div class="container p-4 md:py-16">
        <h1 class="text-4xl font-bold mb-8">My Projects</h1>

        @if ($projects->isEmpty())
            <p class="text-gray-600">You have no projects.</p>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($projects as $project)
                    @include('partials._project', ['project' => $project])
                @endforeach
            </div>
        @endif
    </div>
@endsection
