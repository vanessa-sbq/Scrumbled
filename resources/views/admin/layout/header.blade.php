<header class="py-4 flex justify-between items-center container">
    <div class="flex items-center">
        <h1 class="text-3xl font-bold my-4 mr-6"><a href="{{ url('/projects') }}">Scrumbled!</a></h1>
        <a class="text-blue-500 hover:underline" href="{{ url('/') }}">Back to Main Website</a>
    </div>
    @if (Auth::guard('admin')->check())
        <div>
            <a class="button bg-blue-500 text-white px-4 py-2 rounded" href="{{ url('/admin/logout') }}">Logout</a>
            <span>{{ Auth::guard('admin')->user()->name }}</span>
        </div>
    @endif
</header>
