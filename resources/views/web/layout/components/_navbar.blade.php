<!-- resources/views/web/sections/static/_navbar.blade.php -->

<div id="collapseMenu"
    class='max-lg:hidden lg:!block max-lg:before:fixed max-lg:before:bg-black max-lg:before:opacity-50 max-lg:before:inset-0 max-lg:before:z-50'>
    <button id="toggleClose"
        class='lg:hidden fixed top-2 right-4 z-[100] rounded-full bg-white w-9 h-9 flex items-center justify-center border'>
        <x-lucide-x class="w-8 h-8" />
    </button>

    <ul
        class='lg:flex gap-x-5 max-lg:space-y-3 max-lg:fixed max-lg:bg-white max-lg:w-1/2 max-lg:min-w-[300px] max-lg:top-0 max-lg:left-0 max-lg:p-6 max-lg:h-full max-lg:shadow-md max-lg:overflow-auto z-50'>
        <li class='mb-6 hidden max-lg:block'>
            <a href="{{ url('/') }}"><img src="{{ asset('svg/logo.svg') }}" alt="logo" class='w-36' /></a>
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
                    class="{{ request()->routeIs($link['route']) ? 'text-primary font-bold' : 'text-gray-600' }} hover:text-primary transition-colors duration-300">
                    {{ $link['label'] }}
                </a>
            </li>
        @endforeach
    </ul>
</div>

<div class='flex max-lg:ml-auto space-x-4'>
    @if (Auth::check())
    <div class='max-lg:py-3 px-3 flex items-center'>
        <a href="{{ route('inbox') }}" class="no-underline">
            <x-lucide-inbox class="text-gray-600 hover:text-primary transition-colors duration-300" width="20" height="20"/>
        </a>
    </div>
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
        <div class="flex flex-wrap space-x-4">
            <x-button variant="secondary" size="md" href="/login">
                <i class="fas fa-sign-in-alt"></i> Login
            </x-button>
            <x-button variant="primary" size="md" href="/register">
                Get Started
            </x-button>

        </div>
    @endif

    <button id="toggleOpen" class='lg:hidden'>
        <x-lucide-menu class="w-8 h-8" />
    </button>
</div>

@push('scripts')
    <script src="{{ asset('js/navbar.js') }}"></script>
@endpush
