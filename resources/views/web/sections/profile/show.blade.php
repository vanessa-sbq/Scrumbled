@extends('web.layout')

@section('content')
    <div class="container p-4 md:py-16">
        <!-- Profile Header -->
        <header class="mb-6 border-b pb-4 flex justify-between items-center">
            <div class="flex items-center gap-4">
                @if ($profileOwner->picture)
                    <img class="h-24 w-24 rounded-full" src="{{ asset('storage/' . $profileOwner->picture) }}"
                        alt="Profile Picture">
                @else
                    <img class="h-24 w-24 rounded-full" src="{{ asset('images/users/default.png') }}" alt="Profile Picture">
                @endif
                <div>
                    <h2 class="text-2xl font-bold">{{ $profileOwner->full_name }}</h2>
                    <h5>{{ $profileOwner->username }}</h5>
                </div>
            </div>
            @if (Auth::check() && $user->username === $profileOwner->username)
                <a href="{{ route('edit.profile.ui', ['username' => $user->username]) }}"
                    class="bg-primary text-white px-4 py-2 rounded-md hover:bg-blue-600 transition">
                    Edit Profile
                </a>
            @endif
        </header>

        <div class="flex flex-col-reverse md:flex-row gap-4">
            <!-- User Projects -->
            <div class="md:w-2/3 space-y-4">
                @if ($projects->isEmpty())
                    <p class="text-gray-600">No public projects.</p>
                @else
                    <div class="flex flex-1 flex-wrap gap-4 flex-col">
                        @foreach ($projects as $project)
                            <div
                                class="block relative bg-white border border-gray-300 rounded-lg p-4 sm:p-6 lg:p-8 hover:border-primary transition-all duration-300 w-full max-w-7xl mx-auto min-w-64">
                                <h2 class="text-xl sm:text-2xl lg:text-3xl font-semibold mb-2">
                                    <a href="{{ route('projects.show', $project->slug) }}"
                                        class="hover:text-primary transition-colors duration-300">
                                        {{ $project->title }}
                                    </a>
                                </h2>
                                <p class="text-gray-700 mb-4 overflow-hidden text-ellipsis truncate text-wrap break-all">
                                    {{ Str::limit($project->description, 100) }}
                                </p>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            <!-- User Info -->
            <div class="md:w-1/3">
                <div class="bg-white shadow rounded-lg p-8 sticky top-4">
                    <h2 class="text-xl font-bold mb-4">User Info</h2>
                    <div class="space-y-4">
                        <div>
                            <h3 class="text-lg font-semibold">Bio</h3>
                            <p>{{ $profileOwner->bio }}</p>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold">Email</h3>
                            <p>{{ $profileOwner->email }}</p>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold">Verified Status</h3>
                            <p>{{ $profileOwner->is_verified ? 'Verified' : 'Not Verified' }}</p>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold">Profile Status</h3>
                            <x-badge type="{{ $profileOwner->is_public ? 'public' : 'private' }}" :value="$profileOwner->is_public ? 'Public' : 'Private'" />
                        </div>
                        <!-- Add other user info here -->
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
