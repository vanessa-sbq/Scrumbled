@extends('admin.layout')

@section('content')
    <section class="container p-4 md:py-16">
        <h1 class="text-4xl font-bold text-center">{{ $user->full_name }}</h1>
        <div class="flex flex-col md:flex-row items-center justify-center mt-8">
            <div class="flex flex-col items-center md:items-center">    
            <img src="{{ $user->picture }}" alt="{{ $user->full_name }}'s profile picture" class="w-64 h-64 rounded-full mx-auto">
                <div class="text-center mt-4">
                    <p>{{ $user->email }}</p>
                    <p>{{ $user->username }}</p>
                </div>
            </div>
            <div class="shadow-lg p-6 bg-white rounded-lg text-left w-full md:w-3/4 h-64 flex flex-col justify-start mt-6 md:mt-0 md:ml-6">
                <p class="mt-4">{{ $user->bio }}</p>
            </div>
        </div>
        
        <h2 class="font-bold text-2xl mt-8">{{ $user->full_name }}'s projects </h2>
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