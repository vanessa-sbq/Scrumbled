<aside class="md:w-3/12 p-6 {{ $hidden }} md:block">
    <h2 class="text-xl font-semibold mb-4">Settings</h2>
    <nav class="space-y-2">
        @if (Auth::guard('admin')->check() ||
                (Auth::check() &&
                    (Auth::user()->id === $project->product_owner_id || Auth::user()->id === $project->scrum_master_id)))
            <a href="{{ route('projects.settings', $project->slug) }}"
                class="block py-2 px-4 rounded {{ request()->routeIs('projects.settings') ? 'bg-gray-200 font-semibold' : 'hover:underline' }}">General</a>
        @endif
        <a href="{{ route('projects.team.settings', $project->slug) }}"
            class="block py-2 px-4 rounded {{ request()->routeIs('projects.team.settings') ? 'bg-gray-200 font-semibold' : 'hover:underline' }}">Collaborators</a>
        @if (Auth::check() &&
                ($project->developers->pluck('id')->contains(Auth::user()->id) ||
                    Auth::user()->id === $project->scrum_master_id))
            <div class="group relative">
                <button
                    class="leave_project_button flex-1 py-2 px-4 w-full text-left rounded bg-red-500 text-white hover:bg-red-500/90 relative z-10"
                    id="{{ Auth::user()->id }}">
                    Leave Project
                </button>
            </div>
        @endif
    </nav>
</aside>
