@extends('web.layout')

@section('content')
        <div class="container py-8 p-4">
                @php
                    $project = \App\Models\Project::where('id', $sprint->project_id)->firstOrFail();
                @endphp
                @include('web.sections.sprint.components._navbar')
                <!-- Title Section -->
                <div class="flex items-center justify-between mb-6">
                        <h1 class="text-4xl font-bold text-primary">{{ $sprint->name }} <span
                                        class="text-muted-foreground">(#{{ $sprint->id }})</span></h1>
                </div>

                <!-- Accepted Card -->
                <div class="bg-white shadow-md rounded-lg p-6">
                        <h3 class="text-xl font-bold text-primary mb-4">Accepted</h3>
                        <div class="space-y-4">
                                @php($found = false)
                                @foreach ($acceptedTasks as $task)
                                        @php($found = true)
                                        @include('web.sections.project.components._task', ['task' => $task])
                                @endforeach
                                @if (!$found)
                                        This sprint has no accepted tasks.
                                @endif
                        </div>
                </div>
        </div>
@endsection
