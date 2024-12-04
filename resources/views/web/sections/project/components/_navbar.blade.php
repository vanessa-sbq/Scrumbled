<div class="flex justify-between items-center mb-6">
    <div class="flex items-center space-x-2 text-gray-600">
        <a href="{{ route('projects') }}" class="hover:underline">{{ Auth::user() ? Auth::user()->username : 'projects' }}</a>
        <span>/</span>
        <a href="{{ route('projects.show', $project->slug) }}" class="font-bold hover:underline">{{ $project->slug }}</a>
    </div>
    <div class="flex space-x-4">
        <a href="{{ route('projects.show', $project->slug) }}"
            class="{{ request()->routeIs('projects.show') ? 'text-blue-500 font-bold' : 'text-blue-500 hover:underline' }}">Board</a>
        <a href="{{ route('projects.tasks', $project->slug) }}"
           class="{{ (request()->routeIs('projects.tasks') || request()->routeIs('projects.tasks.search')) ? 'text-blue-500 font-bold' : 'text-blue-500 hover:underline' }}">Tasks</a>
        <a href="{{ route('projects.backlog', $project->slug) }}"
            class="{{ request()->routeIs('projects.backlog') ? 'text-blue-500 font-bold' : 'text-blue-500 hover:underline' }}">Backlog</a>
        <a href="{{ route('projects.team', $project->slug) }}"
            class="{{ request()->routeIs('projects.invite') ? 'text-blue-500 font-bold' : 'text-blue-500 hover:underline' }}">Team</a>
    </div>
</div>
