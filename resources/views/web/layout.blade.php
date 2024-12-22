<!doctype html>
<html lang="{{ config('app.locale') }}">

<head>
    @include('web.layout.head')
</head>

<body>
    @if (Auth::guard("admin")->check())
        @include('admin.layout.header')
    @else
        @include('web.layout.header')
    @endif
    <main>
        @yield('content')
    </main>
        @include('web.layout.footer')

    <!-- Scripts -->
    @include('web.layout.scripts')
    @stack('scripts')
</body>

</html>
