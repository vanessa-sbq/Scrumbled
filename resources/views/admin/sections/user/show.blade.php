@extends('admin.layout')

@section('content')
    <section class="container p-4 md:py-16">
        <h1 class="text-4xl font-bold text-center">{{ $user->full_name }}</h1>
        <div class="text-center">
            <img src="{{ $user->picture }}" alt="{{ $user->full_name }}'s profile picture" class="w-32 h-32 rounded-full mx-auto">
            <p class="mt-4">{{ $user->email }}</p>
            <p>{{ $user->username }}</p>
        </div>
        <h1 class="text-4xl font-bold text-center">{{ $user->full_name }}'s projects </h1>
        <div class="mt-8">
            @if($projects->isEmpty())
                <p class="text-center">User has no projects.</p>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach ($projects as $project)
                        @include('web.sections.project.components._project', ['project' => $project])
                    @endforeach
                </div>
            @endif
        </div>
    </section>
@endsection