@extends('web.layout')

@section('content')
    <div class="container mx-auto py-8">
        <h1 class="text-4xl font-bold mb-8 text-center">Edit Profile</h1>

        <x-form :action="route('edit.profile', $user->username)" enctype="multipart/form-data">
            {{-- Profile Picture --}}
            <div class="mb-6">
                <label for="old_picture" class="block text-sm font-medium text-muted-foreground">Current Picture</label>
                <div class="flex items-center space-x-4 mt-2">
                    <img class="h-24 w-24 rounded-full border border-gray-300 shadow-sm" id="old_picture"
                         src="{{ asset($user->picture ? 'storage/' . $user->picture : 'images/users/default.png') }}" alt="Profile Picture">
                    <x-input type="file" name="picture" label="New Picture" />
                    @error('picture')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            {{-- Username --}}
            <x-input type="text" name="username" label="Username" value="{{ $user->username }}" placeholder="Choose a unique username" required />

            {{-- Email --}}
            <x-input type="text" name="email" label="Email" value="{{ $user->email }}" placeholder="Your email address" required />

            {{-- Full Name --}}
            <x-input type="text" name="full_name" label="Full Name" value="{{ $user->full_name }}" placeholder="Your full name" required />

            {{-- Bio --}}
            <x-input type="textarea" name="bio" label="Bio" value="{{ $user->bio }}" placeholder="Tell something about yourself"/>

            {{-- Profile Visibility --}}
            <x-input type="select" name="is_public" label="Profile Visibility"
                     :options="['0' => 'Private', '1' => 'Public']"
                     value="{{ old('is_public', $user->is_public) }}" />
        </x-form>
    </div>
@endsection
