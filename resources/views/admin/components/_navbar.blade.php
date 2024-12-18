@if (Auth::guard("admin")->check())
<div class="container p-4 md:pt-8">
    <h1 class="text-3xl font-bold">Admin Dashboard</h1>
    <div class="flex flex-wrap gap-4 min-h-14 justify-between items-center my-2 bg-white rounded-md py-2 px-8 border border-muted shadow-sm">
        <div class="flex flex-wrap items-center gap-4">
            <a href="{{route('admin.users')}}" class="{{ request()->routeIs('admin.users') ? 'text-primary font-bold' : 'text-gray-600' }} hover:text-primary transition-colors duration-300">Profiles</a>
            <a href="{{route('admin.projects')}}" class="{{ request()->routeIs('admin.projects') ? 'text-primary font-bold' : 'text-gray-600' }} hover:text-primary transition-colors duration-300">Projects</a>
        </div>
    </div>
</div>
@endif
