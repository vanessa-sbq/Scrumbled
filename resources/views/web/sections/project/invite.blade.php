@extends('web.layout')

@section('content')
    <div class="container mx-auto py-8">
        <h1 class="text-4xl font-bold mb-8 text-center">Invite Member to {{ $project->title }}</h1>

        <form method="POST" action="{{ route('projects.invite.submit', $project->slug) }}"
            class="max-w-lg mx-auto bg-white p-8 rounded-card shadow-md">
            @csrf

            <div class="mb-4">
                <label for="user_id" class="block text-sm font-medium text-muted-foreground">Select Member</label>
                <div class="mt-1">
                    <select id="user_id" name="user_id" required
                        class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary sm:text-sm">
                        @foreach ($users as $user)
                            <option value="{{ $user->id }}">
                                <div class="flex items-center space-x-3">
                                    <img src="{{ asset('storage/' . $user->image_path) }}" alt="{{ $user->full_name }}"
                                        class="w-8 h-8 rounded-full">
                                    <span>{{ $user->full_name }}</span>
                                </div>
                            </option>
                        @endforeach
                    </select>
                </div>
                @error('user_id')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div class="flex items-center justify-between">
                <button type="submit"
                    class="w-full bg-primary text-white px-4 py-2 rounded-md shadow-sm hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">
                    Invite Member
                </button>
            </div>
        </form>
    </div>
@endsection
