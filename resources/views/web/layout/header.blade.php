<header class='flex shadow-md py-4 px-4 sm:px-10 bg-white font-[sans-serif] min-h-[70px] tracking-wide relative z-50'>
    <div class='flex flex-wrap items-center justify-between gap-5 w-full'>
        <a href="{{ url('/') }}"><img src="{{ asset('images/logo.svg') }}" alt="logo" class='w-36' /></a>
        @include('web.layout.components._navbar')
    </div>
</header>

@section('scripts')
    <script src="{{ asset('js/navbar.js') }}"></script>
    <script src="{{ asset('js/dropdown.js') }}"></script>
@endsection
