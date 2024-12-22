<div class="flex flex-col -mt-2 mb-6">
    @if ($project->is_archived)
        <div class="w-full bg-amber-100 border-amber-500 border-2 mb-2 p-4 text-center rounded-xl">Project is archived.
        </div>
    @endif
    <div class="flex flex-wrap gap-4 justify-between items-center">
        <div class="flex flex-wrap gap-2 items-center text-gray-600">
            <a href="{{ Auth::guard('admin')->check() ? route('admin.projects') : route('projects') }}"
                class="hover:underline">{{ Auth::user() ? Auth::user()->username : 'projects' }}</a>
            <span>/</span>
            <a href="{{ route('projects.show', $project->slug) }}"
                class="font-bold hover:underline">{{ $project->slug }}</a>
        </div>
        <div class="flex flex-wrap gap-4">
            <a href="{{ route('projects.show', $project->slug) }}"
                class="{{ request()->routeIs('projects.show') ? 'text-primary font-bold' : 'text-primary hover:underline' }}">Board</a>
            <a href="{{ route('projects.tasks', $project->slug) }}"
                class="{{ request()->routeIs('projects.tasks') || request()->routeIs('projects.tasks.search') ? 'text-primary font-bold' : 'text-primary hover:underline' }}">Tasks</a>
            <a href="{{ route('sprints', $project->slug) }}"
                class="{{ request()->routeIs('sprints') ? 'text-primary font-bold' : 'text-primary hover:underline' }}">Sprints</a>
            <a href="{{ route('projects.backlog', $project->slug) }}"
                class="{{ request()->routeIs('projects.backlog') ? 'text-blue-500 font-bold' : 'text-blue-500 hover:underline' }}">Backlog</a>
            @if (Auth::check() &&
                    (Auth::user()->id === $project->product_owner_id || Auth::user()->id === $project->scrum_master_id))
            <a href="{{ route('projects.settings', $project->slug) }}" @else <a
                    href="{{ route('projects.team.settings', $project->slug) }}" @endif
                    class="{{ request()->routeIs('projects.settings') || request()->routeIs('projects.team.settings') ? 'text-primary font-bold' : 'text-blue-500 hover:underline' }}">Settings</a>
        </div>
    </div>
</div>
