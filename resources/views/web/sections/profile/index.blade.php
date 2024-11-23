@extends('web.layout')

@section('content')
    <section class="container p-4 md:py-16 max-w-2xl">
        <h1 class="text-4xl font-bold text-center mb-8">Users</h1>

        <!-- Search Form -->
        <form method="GET" action="{{ route('profiles') }}" class="mb-4 flex justify-end gap-2">
            <input type="text" name="search" placeholder="Search users..." value="{{ request('search') }}"
                class="border p-2 rounded">

            <button type="submit"
                class="bg-primary text-white px-4 py-2 rounded-md shadow-sm hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">Search</button>
        </form>

        <!-- Users List -->
        @if ($users->isEmpty())
            <p class="text-xl text-center mt-10 mb-20">No users found.</p>
        @else
            <ul>
                @foreach ($users as $user)
                    <li class="bg-white shadow-md rounded-card p-6 mb-5">
                        <div class="flex items-center space-x-4">
                            <img src="{{ asset($user->picture ? 'storage/' . $user->picture : 'img/users/default.png') }}"
                                alt="{{ $user->full_name }}'s profile picture" class="w-16 h-16 rounded">
                            <div>
                                <a href="{{ route('show.profile', $user->username) }}"
                                    class="font-bold hover:underline">{{ $user->username }}</a><br>
                                <a href="{{ route('show.profile', $user->username) }}"
                                    class="hover:underline">{{ $user->full_name }}</a> (<a>{{ $user->email }}</a>)
                            </div>
                        </div>
                    </li>
                @endforeach
                <div class="mt-4">
                    {{ $users->links() }} <!-- Pagination links -->
                </div>
            </ul>
        @endif
    </section>

@endsection
