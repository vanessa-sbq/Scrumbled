@extends('web.layout')

@section('content')
    <!-- upper div -->
    <div class="container p-4 md:py-16 flex flex-col gap-2">
        <form action="{{ route('edit.profile', $user->username) }}" method="POST" enctype="multipart/form-data">
            @csrf

            {{-- Hidden ID field if needed (for updates only) --}}
            @if(isset($user))
                <input type="hidden" name="id" value="{{ $user->id }}">
            @endif

            {{-- Picture --}}
            <div>
                <label for="old_picture" class="block text-gray-700">Current Picture</label>
                <img class="h-24 w-24" id="old_picture" src="{{$user->picture}}" alt="Profile Picture">
                <div class="mb-4">
                    <input type="file" id="picture" name="picture" class="w-full px-3 py-2 border rounded">
                    @error('picture')
                    <div class="text-red-500 mt-2">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            {{-- Full Name --}}
            <div class="mb-4">
                <label for="full_name" class="block text-gray-700">Full Name</label>
                <input type="text" id="full_name" name="full_name" class="w-full px-3 py-2 border rounded" value="{{ $user->full_name }}" required>
                @error('full_name')
                <div class="text-red-500 mt-2">{{ $message }}</div>
                @enderror
            </div>

            {{-- Username --}}
            <div class="mb-4">
                <label for="username" class="block text-gray-700">Username</label>
                <input type="text" id="username" name="username" class="w-full px-3 py-2 border rounded" value="{{ $user->username }}" required>
                @error('username')
                <div class="text-red-500 mt-2">{{ $message }}</div>
                @enderror
            </div>

            {{-- Email --}}
            <div class="mb-4">
                <label for="email" class="block text-gray-700">Email</label>
                <input type="email" id="email" name="email" class="w-full px-3 py-2 border rounded" value="{{ $user->email }}" required>
                @error('email')
                <div class="text-red-500 mt-2">{{ $message }}</div>
                @enderror
            </div>

            {{-- Bio --}}
            <div class="mb-4">
                <label for="bio" class="block text-gray-700">Bio</label>
                <textarea id="bio" name="bio" class="w-full px-3 py-2 border rounded">{{ $user->bio }}</textarea>
                @error('bio')
                <div class="text-red-500 mt-2">{{ $message }}</div>
                @enderror
            </div>

            {{-- Password --}}
            <div class="mb-4">
                <label for="password" class="block text-gray-700">Confirm Password</label>
                <input type="password" id="password" name="password" class="w-full px-3 py-2 border rounded" required>
                @error('password')
                <div class="text-red-500 mt-2">{{ $message }}</div>
                @enderror
            </div>

            {{-- Submit Button --}}
            <div class="mt-6">
                <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-700">Submit</button>
            </div>
        </form>
    </div>
@endsection
