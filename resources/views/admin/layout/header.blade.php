<header class='flex shadow-md py-4 px-4 sm:px-10 bg-white font-[sans-serif] min-h-[70px] tracking-wide relative z-50'>
    <div class='flex flex-wrap items-center gap-5 w-full'>
        <a href="{{ url('/') }}">
            <img src="{{ asset('svg/icon.svg') }}" alt="logo" class='h-8 sm:hidden' />
            <img src="{{ asset('svg/logo.svg') }}" alt="logo" class='h-8 hidden sm:block' />
        </a>
        <a class="text-primary hover:underline" href="{{ url('/') }}">Back to Main Website</a>
        @if (Auth::guard('admin')->check())
                <a class="ml-auto button bg-primary text-white px-4 py-2 rounded" href="{{ url('/admin/logout') }}">Logout</a>
        @endif
    </div>
</header>
