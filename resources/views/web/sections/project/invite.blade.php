@extends('web.layout')

@section('content')
    <div class="container mx-auto py-8">
        <h1 class="text-4xl font-bold mb-8 text-center">Invite Member to {{ $project->title }}</h1>

        <div class="max-w-lg mx-auto bg-white p-8 rounded-card shadow-md">
            @foreach ($users as $user)
                @php
                    $imagePath = $user->picture ? 'storage/' . $user->picture : 'img/users/default.png';
                @endphp
                <div class="flex items-center justify-between mb-4 p-4 border border-gray-300 rounded-md shadow-sm">
                    <div class="flex items-center space-x-3">
                        <img src="{{ asset($imagePath) }}" alt="{{ $user->full_name }}" class="w-8 h-8 rounded-full">
                        <span>{{ $user->full_name }}</span>
                    </div>
                    <form method="POST" action="{{ route('projects.invite.submit', $project->slug) }}">
                        @csrf
                        <input type="hidden" name="user_id" value="{{ $user->id }}">
                        <button type="submit"
                            class="bg-primary text-white px-4 py-2 rounded-md shadow-sm hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">
                            Invite
                        </button>
                    </form>
                </div>
            @endforeach

            <div class="mt-4">
                {{ $users->links() }} <!-- Pagination links -->
            </div>
        </div>
    </div>
@endsection
