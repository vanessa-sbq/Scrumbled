@props(['user'])

<a href="{{ route('show.profile', $user->username) }}" class="flex items-center space-x-2 group">
    <img src="{{ asset($user->picture ? 'storage/' . $user->picture : 'images/users/default.png') }}"
        alt="{{ $user->username }}" class="w-6 h-6 rounded-full">
    <span class="group-hover:underline group-hover:text-primary transition-colors">{{ $user->username }}</span>
</a>
