<header class="py-4 flex justify-between items-center container mx-auto">
    <h1 class="text-3xl font-bold my-4"><a href="{{ url('/projects') }}">Scrumbled!</a></h1>
    @if (Auth::check())
        <div>
            <a class="button bg-blue-500 text-white px-4 py-2 rounded" href="{{ url('/logout') }}">Logout</a>
            <span>{{ Auth::user()->name }}</span>
        </div>
    @endif
</header>
