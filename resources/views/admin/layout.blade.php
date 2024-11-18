<!doctype html>
<html lang="{{ config('app.locale') }}">

<head>
    @include('admin.layout.head')
</head>

<body>
    <header>
        @include('admin.layout.header')
    </header>
    <main>
        @yield('content')
    </main>
    <footer>
        @include('admin.layout.footer')
    </footer>

    <!-- Scripts -->
    @include('admin.layout.scripts')
</body>

</html>
