@extends('web.layout')

@section('content')
    <div class="container py-8">
        <h1 class="text-4xl font-bold mb-6 text-blue-700 border-b border-gray-300 pb-2">{{ $project->title }} Sprints:</h1>

        @if($sprints->isNotEmpty())
            <ul class="space-y-4">
                @foreach ($sprints as $sprint)
                    <li class="p-4 bg-white shadow-md rounded-lg border border-gray-200">
                        <h2 class="text-lg font-semibold text-gray-800">{{ $sprint->name }}</h2>
                        <p class="text-sm text-gray-500">
                            ({{ \Carbon\Carbon::parse($sprint->start_date)->format('m/d/Y') }} - {{ \Carbon\Carbon::parse($sprint->end_date)->format('m/d/Y') }})
                        </p>
                    </li>
                @endforeach
            </ul>
        @else
            <p class="text-gray-500 mt-4 text-center">No sprints available for this project.</p>
        @endif
    </div>
@endsection
