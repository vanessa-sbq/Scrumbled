@extends('web.layout')

@section('content')

    <div class="container py-8 p-4">
        @include('web.sections.sprint.components._navbar')
        <h1 class="text-4xl font-bold mb-6 text-primary border-b border-gray-300 pb-2">{{ $project->title }} Sprints:</h1>

        @if($sprints->isNotEmpty())
            <ul class="space-y-4">
                @foreach ($sprints as $sprint)
                    <li class="project-sprint p-4 bg-white shadow-md rounded-lg border border-gray-200 flex items-center justify-between cursor-pointer" data-sprint-url="{{route('sprint.show', $sprint->id)}}">
                        <div>
                            <h2 class="text-lg font-semibold text-gray-800">{{ $sprint->name }}</h2>
                            <p class="text-sm text-gray-500">
                                ({{ \Carbon\Carbon::parse($sprint->start_date)->format('m/d/Y') }} - {{ \Carbon\Carbon::parse($sprint->end_date)->format('m/d/Y') }})
                            </p>
                        </div>
                        <div>
                            @if ($sprint->is_archived)
                                <span class="bg-yellow-100 text-yellow-600 text-xs font-semibold px-3 py-1 rounded-full">
                                    Archived
                                </span>
                            @else
                                <span class="bg-green-100 text-green-600 text-xs font-semibold px-3 py-1 rounded-full"> Active </span>
                            @endif
                        </div>
                    </li>
                @endforeach
            </ul>
        @else
            <p class="text-gray-500 mt-4 text-center">No sprints available for this project.</p>
        @endif
    </div>
@endsection

@once
    @push('scripts')
        <script src="{{ asset('js/sprints.js') }}"></script>
    @endpush
@endonce
