@extends('web.layout')

@section('content')
    <div class="container py-8">
        <h1 class="text-4xl font-bold mb-4">Sprints for Project ID: {{ $project->project_id }}</h1>

        @if($sprints->isNotEmpty())
            <ul class="list-disc pl-8">
                @foreach ($sprints as $sprint)
                    <li>
                        <strong>{{ $sprint->name }}</strong>
                        <span class="text-gray-500">
                            ({{ $sprint->start_date }} - {{ $sprint->end_date }})
                        </span>
                    </li>
                @endforeach
            </ul>
        @else
            <p class="text-gray-500">No sprints available for this project.</p>
        @endif

        <div class="mt-8">
            <a href="{{ route('projects') }}" class="text-blue-500 hover:underline">Back to Projects</a>
        </div>
    </div>
@endsection
