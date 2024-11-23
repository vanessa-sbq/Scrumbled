@extends('admin.layout')

@section('content')
    <section class="container p-4 md:py-16 max-w-2xl">
        <h1 class="text-4xl font-bold text-center mb-8">Users</h1>

        <!-- Search Form -->
        <form method="GET" action="{{ route('admin.users') }}" class="mb-4 flex justify-end">
            <input type="text" name="search" placeholder="Search users..." value="{{ request('search') }}"
                class="border p-2 mr-2 rounded">

            <!-- Status Filter Dropdown -->
            <select name="status" class="border p-2 rounded mr-2">
                <option value="">Any Status</option>
                <option value="ACTIVE" {{ request('status') == 'ACTIVE' ? 'selected' : '' }}>Active</option>
                <option value="NEEDS_CONFIRMATION" {{ request('status') == 'NEEDS_CONFIRMATION' ? 'selected' : '' }}>Needs
                    Confirmation</option>
                <option value="BANNED" {{ request('status') == 'BANNED' ? 'selected' : '' }}>Banned</option>
            </select>
            <button type="submit"
                class="bg-primary text-white px-4 py-2 rounded-md shadow-sm hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">Search</button>
        </form>

        <!-- Users List -->
        @if ($users->isEmpty())
            <p class="text-xl text-center mt-10 mb-20">No users found.</p>
        @else
            <ul>
                @foreach ($users as $user)
                    <div class="bg-white shadow-md rounded-card p-6 mb-5">
                        <li class="flex items-center space-x-4">
                            <!-- TODO: Add a default image -->
                            <img src="{{ asset($user->picture ? 'storage/' . $user->picture : 'img/users/default.png') }}"
                                alt="{{ $user->full_name }}'s profile picture" class="w-16 h-16 rounded-full">
                            <div>
                                <a href="{{ route('admin.users.show', $user->username) }}"
                                    class="font-bold hover:underline">{{ $user->username }}</a><br>
                                <a href="{{ route('admin.users.show', $user->username) }}"
                                    class="hover:underline">{{ $user->full_name }}</a> (<a>{{ $user->email }}</a>)
                                <p class="text-primary font-bold">Status:
                                    {{ strtolower(str_replace('_', ' ', $user->status)) }}</p>
                            </div>
                        </li>
                    </div>
                @endforeach
            </ul>
        @endif
    </section>

@endsection
