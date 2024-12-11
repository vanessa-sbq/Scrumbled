<!-- resources/views/web/sections/static/_navbar.blade.php -->

<div id="collapseMenu"
    class='max-lg:hidden lg:!block max-lg:before:fixed max-lg:before:bg-black max-lg:before:opacity-50 max-lg:before:inset-0 max-lg:before:z-50'>
    <button id="toggleClose"
        class='lg:hidden fixed top-2 right-4 z-[100] rounded-full bg-white w-9 h-9 flex items-center justify-center border'>
        <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5 fill-black" viewBox="0 0 320.591 320.591">
            <path
                d="M30.391 318.583a30.37 30.37 0 0 1-21.56-7.288c-11.774-11.844-11.774-30.973 0-42.817L266.643 10.665c12.246-11.459 31.462-10.822 42.921 1.424 10.362 11.074 10.966 28.095 1.414 39.875L51.647 311.295a30.366 30.366 0 0 1-21.256 7.288z"
                data-original="#000000"></path>
            <path
                d="M287.9 318.583a30.37 30.37 0 0 1-21.257-8.806L8.83 51.963C-2.078 39.225-.595 20.055 12.143 9.146c11.369-9.736 28.136-9.736 39.504 0l259.331 257.813c12.243 11.462 12.876 30.679 1.414 42.922-.456.487-.927.958-1.414 1.414a30.368 30.368 0 0 1-23.078 7.288z"
                data-original="#000000"></path>
        </svg>
    </button>

    <ul
        class='lg:flex gap-x-5 max-lg:space-y-3 max-lg:fixed max-lg:bg-white max-lg:w-1/2 max-lg:min-w-[300px] max-lg:top-0 max-lg:left-0 max-lg:p-6 max-lg:h-full max-lg:shadow-md max-lg:overflow-auto z-50'>
        <li class='mb-6 hidden max-lg:block'>
            <a href="{{ url('/') }}"><img src="{{ asset('images/logo.svg') }}" alt="logo" class='w-36' /></a>
        </li>
        @php
            $links = [
                ['route' => 'projects', 'label' => 'Projects'],
                ['route' => 'profiles', 'label' => 'Profiles'],
                ['route' => 'about', 'label' => 'About Us'],
                ['route' => 'contact', 'label' => 'Contact Us'],
                ['route' => 'faq', 'label' => 'FAQ'],
            ];
        @endphp
        @foreach ($links as $link)
            <li class='max-lg:border-b border-gray-300 max-lg:py-3 px-3'>
                <a href="{{ route($link['route']) }}"
                    class="{{ request()->routeIs($link['route']) ? 'font-bold' : 'hover:underline' }}">{{ $link['label'] }}</a>
            </li>
        @endforeach
    </ul>
</div>

<div class='flex max-lg:ml-auto space-x-4'>
    @if (Auth::check())
        @php
            $dropdownLinks = [
                ['url' => route('show.profile', Auth::user()->username), 'label' => 'My Profile'],
                ['url' => url('/logout'), 'label' => 'Logout'],
            ];
        @endphp
        <x-dropdown :links="$dropdownLinks">
            <img src="{{ Auth::user()->picture ? asset('storage/' . Auth::user()->picture) : asset('images/users/default.png') }}"
                class="w-12 h-12 rounded-full" alt="Profile Picture" />
            <div>
                <p class="text-[15px] text-gray-800 font-bold">{{ Auth::user()->full_name }}</p>
                <p class="text-xs text-gray-500 mt-0.5">{{ Auth::user()->email }}</p>
            </div>
        </x-dropdown>
    @else
        <div class="flex space-x-4">
            <a href="/login"
                class="px-6 py-2 bg-gray-200 text-gray-800 rounded-md hover:bg-gray-300 transition-colors">
                <i class="fas fa-sign-in-alt"></i> Login
            </a>
            <a href="/register"
                class="px-6 py-2 bg-primary text-white rounded-md hover:bg-primary/90 transition-colors">Get
                Started</a>
        </div>
    @endif

    <button id="toggleOpen" class='lg:hidden'>
        <svg class="w-7 h-7" fill="#000" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
            <path fill-rule="evenodd"
                d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z"
                clip-rule="evenodd"></path>
        </svg>
    </button>
</div>

@push('scripts')
    <script src="{{ asset('js/navbar.js') }}"></script>
@endpush
