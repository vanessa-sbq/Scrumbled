<!doctype html>
<html lang="{{ config('app.locale') }}">

<head>
    @include('web.layout.head')
</head>

<body>
    <header>
        @if (Auth::guard("admin")->check())
            @include('admin.layout.header')
        @else
            @include('web.layout.header')
        @endif
    </header>
    <main>
        @yield('content')
    </main>
    <footer>
        @include('web.layout.footer')
    </footer>

    <!-- Scripts -->
    @include('web.layout.scripts')
    @stack('scripts')
</body>

</html>
