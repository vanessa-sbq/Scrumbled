<!doctype html>
<html lang="{{ config('app.locale') }}">

<head>
    @include('admin.layout.head')
</head>

<body>
    @include('admin.layout.header')
    @include('admin.components._navbar')
    <main>
        @yield('content')
    </main>
    <footer>
        @include('admin.layout.footer')
    </footer>

    <!-- Scripts -->
    @include('admin.layout.scripts')
    @stack('scripts')
</body>

</html>
