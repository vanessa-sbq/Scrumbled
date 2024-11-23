<header class="p-4 flex justify-between items-center container">
    <div class="flex items-end gap-4">
        <h1 class="text-3xl font-bold"><a href="{{ url('/projects') }}">Scrumbled</a></h1>
        <div class="flex space-x-4">
            <a href="{{ route('projects') }}"
                class="{{ request()->routeIs('projects') ? 'font-bold' : 'hover:underline' }}">Projects</a>
            <a href="{{ route('profiles') }}"
                class="{{ request()->routeIs('profiles') ? 'font-bold' : 'hover:underline' }}">Profiles</a>
        </div>
    </div>
    @if (Auth::check())
        <a href="{{ route('show.profile', Auth::user()->username) }}"
            class="flex flex-row gap-2 hover:bg-primary rounded-lg p-1 items-center text-black hover:text-white">
            @if (Auth::user()->picture)
                <img class="h-12 w-12 rounded"
                    src="{{ asset(Auth::user()->picture ? 'storage/' . Auth::user()->picture : 'img/users/default.png') }}"
                    alt="Profile Picture">
            @else
                <img class="h-12 w-12 rounded" src="{{ asset('img/users/default.png') }}" alt="Profile Picture">
            @endif
            <span class=" text-center pr-1">{{ Auth::user()->full_name }}</span>

        </a>
    @endif
</header>
