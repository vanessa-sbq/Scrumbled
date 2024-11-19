@extends('admin.layout')

@section('content')
    <section class="container p-4 md:py-16">
        <h1 class="text-4xl font-bold text-center">{{ $user->full_name }}</h1>
        <div class="text-center">
            <img src="{{ $user->picture }}" alt="{{ $user->full_name }}'s profile picture" class="w-32 h-32 rounded-full mx-auto">
            <p class="mt-4">{{ $user->email }}</p>
            <p>{{ $user->username }}</p>
        </div>
    </section>
@endsection