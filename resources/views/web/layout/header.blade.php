<header class='flex shadow-md py-4 px-4 sm:px-10 bg-white font-[sans-serif] min-h-[70px] tracking-wide relative z-50'>
    <div class='flex flex-wrap items-center justify-between gap-5 w-full'>
        <a href="{{ url('/') }}">
            <img src="{{ asset('images/icon.svg') }}" alt="logo" class='h-8 sm:hidden' />
            <img src="{{ asset('images/logo.svg') }}" alt="logo" class='h-8 hidden sm:block' />
        </a>
        @include('web.layout.components._navbar')
    </div>
</header>
