<!doctype html>
<html lang="{{ config('app.locale') }}">

<head>
    @include('web.layout.head')
</head>

<body>
    <header>
        @include('web.layout.header')
    </header>
    <main>
        @yield('content')
    </main>
    <footer>
        @include('web.layout.footer')
    </footer>

    <!-- Scripts -->
    @include('web.layout.scripts')
</body>

</html>
