@extends('web.layout')

@section('content')
        <div class="container py-8">

                <!-- Title Section -->
                <div class="flex items-center justify-between mb-6">
                        <h1 class="text-4xl font-bold text-primary">{{ $sprint->name }} <span
                                        class="text-muted-foreground">(#{{ $sprint->id }})</span></h1>
                </div>

                <!-- Accepted Card -->
                <div class="bg-white shadow-md rounded-lg p-6">
                        <h3 class="text-xl font-bold text-primary mb-4">Accepted</h3>
                        <div class="space-y-4">
                                @foreach ($acceptedTasks as $task)
                                        @include('web.sections.project.components._task', ['task' => $task])
                                @endforeach
                        </div>
                </div>
        </div>
@endsection
