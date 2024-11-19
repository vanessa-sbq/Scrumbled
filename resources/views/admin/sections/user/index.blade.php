@extends('admin.layout')

@section('content')
    <section class="container p-4 md:py-16">
        <h1 class="text-4xl font-bold text-center">Users</h1>
    </section>

    <!-- Search Form -->
    <section class="container p-4">
        <form method="GET" action="{{ route('admin.users') }}" class="mb-4">
            <input type="text" name="search" placeholder="Search users..." value="{{ request('search') }}" class="border p-2 rounded">
            <button type="submit" class="bg-primary text-white px-4 py-2 rounded-md shadow-sm hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">Search</button>
            <!-- TODO: Implement search -->
        </form>
    </section>

    <!-- Users List -->
        @if ($users->isEmpty())
            <h1 class="text-4xl font-bold text-center">There are no users.</h1>
        @else
            <ul>
                @foreach ($users as $user)
                    <section class="container bg-white shadow-md rounded-lg p-6 mb-5">
                        <li class="flex items-center space-x-4"> 
                            <img src="{{ $user->picture }}" alt="{{ $user->full_name }}'s profile picture" class="w-16 h-16 rounded-full">
                            <div>
                                <!-- TODO: Add links to profile -->
                                <a href="{{ route('admin.users.show', $user->username) }}" class="font-bold hover:underline">{{ $user->username }}</a><br>
                                <a href="{{ route('admin.users.show', $user->username) }}" class="hover:underline">{{ $user->full_name }}</a> (<a>{{ $user->email }}</a>)
                            </div>
                        </li>
                    </section>
                @endforeach
            </ul>
        @endif
@endsection
