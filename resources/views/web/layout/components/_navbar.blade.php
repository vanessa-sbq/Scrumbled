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
                class="px-6 py-2 bg-gray-200 text-gray-800 rounded-md hidden sm:block hover:bg-gray-300 transition-colors">
                <i class="fas fa-sign-in-alt"></i> Login
            </a>
            <a href="/register"
                class="px-6 py-2 bg-primary text-white rounded-md hover:bg-primary/90 transition-colors">Get
                Started</a>
        </div>
    @endif

    <button id="toggleOpen" class='lg:hidden'>
        <x-lucide-menu class="w-8 h-8" />
    </button>
</div>

@push('scripts')
    <script src="{{ asset('js/navbar.js') }}"></script>
@endpush
