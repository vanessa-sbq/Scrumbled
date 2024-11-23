@extends('web.layout')

@section('content')
    <!-- upper div -->
    <div class="max-w-lg container pt-6">

        <h2 class="text-center text-4xl font-bold mb-6">Edit Profile</h2>

        <form class="bg-white rounded-card shadow-md flex flex-col gap-6 p-8"
            action="{{ route('edit.profile', $user->username) }}" method="POST" enctype="multipart/form-data">
            @csrf

            {{-- Hidden ID field if needed (for updates only) --}}
            @if (isset($user))
                <input type="hidden" name="id" value="{{ $user->id }}">
            @endif

            {{-- Picture --}}
            <div class="flex flex-col gap-4">
                <div class="space-y-2 place">
                    <label for="old_picture" class="block text-gray-700 place-self-center">Current Picture</label>
                    <img class="h-24 w-24" id="old_picture" src="{{ asset('storage/' . $user->picture) }}"
                        alt="Profile Picture">
                </div>
                <div>
                    <input type="file" id="picture" name="picture" class="w-full px-3 py-2 border rounded">
                    @error('picture')
                        <div class="text-red-500 mt-2">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            {{-- Username --}}
            <div>
                <label for="username" class="block text-gray-700">Username</label>
                <input type="text" id="username" name="username" class="w-full px-3 py-2 border rounded"
                    value="{{ $user->username }}" required>
                @error('username')
                    <div class="text-red-500 mt-2">{{ $message }}</div>
                @enderror
            </div>

            {{-- Email --}}
            <div>
                <label for="email" class="block text-gray-700">Email</label>
                <input type="email" id="email" name="email" class="w-full px-3 py-2 border rounded"
                    value="{{ $user->email }}" required>
                @error('email')
                    <div class="text-red-500 mt-2">{{ $message }}</div>
                @enderror
            </div>

            {{-- Full Name --}}
            <div>
                <label for="full_name" class="block text-gray-700">Full Name</label>
                <input type="text" id="full_name" name="full_name" class="w-full px-3 py-2 border rounded"
                    value="{{ $user->full_name }}" required>
                @error('full_name')
                    <div class="text-red-500 mt-2">{{ $message }}</div>
                @enderror
            </div>

            {{-- Bio --}}
            <div>
                <label for="bio" class="block text-gray-700">Bio</label>
                <textarea id="bio" name="bio" class="w-full px-3 py-2 border rounded">{{ $user->bio }}</textarea>
                @error('bio')
                    <div class="text-red-500 mt-2">{{ $message }}</div>
                @enderror
            </div>

            {{-- Submit Button --}}
            <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-700">Submit</button>
            <a class="px-4 py-2 bg-red-600 text-white hover:bg-red-800 rounded text-center"
                href="{{ route('show.profile', $user->username) }}">Cancel</a>
        </form>
    </div>
@endsection
