@extends('web.layout')

@section('content')
    <div class="container mx-auto py-8">
        <h1 class="text-4xl font-bold mb-8 text-center">Edit Profile</h1>

        <form method="POST" action="{{ route('edit.profile', $user->username) }}" enctype="multipart/form-data"
              class="max-w-lg mx-auto bg-white p-8 rounded-card shadow-md">
            @csrf

            {{-- Hidden ID field if needed (for updates only) --}}
            @if (isset($user))
                <input type="hidden" name="id" value="{{ $user->id }}">
            @endif

            {{-- Profile Picture --}}
            <div class="mb-6">
                <label for="old_picture" class="block text-sm font-medium text-muted-foreground">Current Picture</label>
                <div class="flex items-center space-x-4 mt-2">
                    <img class="h-24 w-24 rounded-full border border-gray-300 shadow-sm" id="old_picture" src="{{ asset('storage/' . $user->picture) }}" alt="Profile Picture">
                    <div>
                        <label for="picture" class="block text-sm font-medium text-muted-foreground">New Picture</label>
                        <input type="file" id="picture" name="picture" class="mt-1 block w-full px-3 py-2 border border-muted rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary sm:text-sm">
                        @error('picture')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>

            {{-- Username --}}
            <div class="mb-4">
                <label for="username" class="block text-sm font-medium">Username</label>
                <input type="text" id="username" name="username" placeholder="Choose a unique username"
                       class="w-full px-3 py-2 border border-muted rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary sm:text-sm"
                       value="{{ $user->username }}" required>
                @error('username')
                <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            {{-- Email --}}
            <div class="mb-4">
                <label for="email" class="block text-sm font-medium">Email</label>
                <input type="email" id="email" name="email" placeholder="Your email address"
                       class="w-full px-3 py-2 border border-muted rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary sm:text-sm"
                       value="{{ $user->email }}" required>
                @error('email')
                <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            {{-- Full Name --}}
            <div class="mb-4">
                <label for="full_name" class="block text-sm font-medium">Full Name</label>
                <input type="text" id="full_name" name="full_name" placeholder="Your full name"
                       class="w-full px-3 py-2 border border-muted rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary sm:text-sm"
                       value="{{ $user->full_name }}" required>
                @error('full_name')
                <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            {{-- Bio --}}
            <div class="mb-4">
                <label for="bio" class="block text-sm font-medium">Bio</label>
                <textarea id="bio" name="bio" placeholder="Tell something about yourself"
                          class="min-h-40 w-full px-3 py-2 border border-muted rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary sm:text-sm">{{ $user->bio }}</textarea>
                @error('bio')
                <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            {{-- Actions --}}
            <div class="flex items-center justify-between space-x-4">
                <button type="submit"
                        class="w-full bg-primary text-white px-4 py-2 rounded-md shadow-sm hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">
                    Update Profile
                </button>
                <a href="{{ route('show.profile', $user->username) }}"
                   class="w-full bg-gray-500 text-white px-4 py-2 rounded-md shadow-sm hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 text-center">
                    Cancel
                </a>
            </div>
        </form>
    </div>
@endsection
