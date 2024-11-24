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
        <div class="relative inline-block text-left">
            <div>
                <button type="button" class="inline-flex items-center w-full justify-center gap-x-1.5 rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50" id="trigger" aria-expanded="true" aria-haspopup="true">
                    @if (Auth::user()->picture)
                        <img class="h-12 w-12 rounded-full" src="{{ asset(Auth::user()->picture ? 'storage/' . Auth::user()->picture : 'img/users/default.png') }}" alt="Profile Picture">
                    @else
                        <img class="h-12 w-12 rounded-full" src="{{ asset('img/users/default.png') }}" alt="Profile Picture">
                    @endif
                    <span class="text-center pr-1">{{ Auth::user()->full_name }}</span>
                </button>
            </div>

            <!-- Dropdown menu -->
            <div id="dropdown" class="absolute right-0 z-10 mt-2 w-56 origin-top-right rounded-md bg-white shadow-lg ring-1 ring-black/5 focus:outline-none opacity-0 scale-95 transform transition ease-in duration-75 hidden" role="menu" aria-orientation="vertical" aria-labelledby="menu-button" tabindex="-1">
                <a href="{{route('show.profile', Auth::user()->username)}}" class="block px-4 py-2 text-sm text-gray-700" role="menuitem" tabindex="-1" id="menu-item-0">My Profile</a>
                <a href="{{url('/logout')}}" class="block px-4 py-2 text-sm text-gray-700" role="menuitem" tabindex="-1" id="menu-item-1">Logout</a>
            </div>
        </div>
    @endif
</header>
