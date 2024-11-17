@extends('layouts.app')

@section('title', $project->title)

@section('content')
    <div class="container mx-auto py-8">
        <h1 class="text-4xl font-bold mb-4">{{ $project->title }}</h1>
        <p class="text-gray-700 mb-4">{{ $project->description }}</p>

        <div class="bg-white shadow-md rounded-lg p-6">
            <h2 class="text-2xl font-semibold mb-2">Project Details</h2>
            <p class="text-gray-700 mb-4">Owner: {{ $project->productOwner->name }}</p>
            <p class="text-gray-700 mb-4">Status: {{ $project->status }}</p>
            <p class="text-gray-700 mb-4">Created at: {{ $project->created_at->format('M d, Y') }}</p>
        </div>

        <div class="mt-8">
            <a href="{{ route('projects') }}" class="text-blue-500 hover:underline">Back to Projects</a>
        </div>
    </div>
@endsection
