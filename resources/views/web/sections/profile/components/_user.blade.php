@foreach ($users as $user)
    @php
        $imagePath = $user->picture ? 'storage/' . $user->picture : 'images/users/default.png';
    @endphp
    <div class="flex items-center justify-between mb-4 p-4 border border-gray-300 rounded-md shadow-sm">
        <div class="flex items-center space-x-3">
            <img src="{{ asset($imagePath) }}" alt="{{ $user->full_name }}" class="w-12 h-12 rounded-full">
            <div>
                <span>{{ $user->full_name }}</span>
                <div class="text-muted-foreground text-sm">{{ $user->username }}</div>
            </div>
        </div>
        <a href="{{ route('show.profile', $user->username) }}"
            class="bg-primary text-white px-4 py-2 rounded-md shadow-sm hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">
            View Profile
        </a>
    </div>
@endforeach
