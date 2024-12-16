@extends('web.layout')

@section('content')
    <div class="flex flex-col flex-1 container p-4 md:py-16">
        <!-- Navbar with Breadcrumb -->
        @include('web.sections.project.components._navbar', ['project' => $project])

        <div class="flex h-screen">
            <!-- Sidebar -->
            <aside class="w-1/4 p-6">
                <h2 class="text-xl font-semibold mb-4">Settings</h2>
                <nav class="space-y-2">
                    @if (Auth::check() && (Auth::user()->id === $project->product_owner_id || Auth::user()->id === $project->scrum_master_id))
                        <a href="{{ route('projects.settings', $project->slug) }}" class="block py-2 px-4 rounded {{ request()->routeIs('projects.settings') ? 'bg-gray-200 font-semibold' : 'hover:underline' }}">General</a>
                    @endif
                    <a href="{{ route('projects.team.settings', $project->slug) }}" class="block py-2 px-4 rounded {{ request()->routeIs('projects.team.settings') ? 'bg-gray-200 font-semibold' : 'hover:underline' }}">Collaborators</a>
                </nav>
            </aside>

            <!-- Main Content -->
            <div class="flex flex-col w-3/4 p-6 gap-10">
                @if (request()->routeIs('projects.settings') && Auth::check() && (Auth::user()->id === $project->product_owner_id || Auth::user()->id === $project->scrum_master_id))
                    @include('web.sections.project.components._general', ['project' => $project])
                @else
                    @include('web.sections.project.components._team', ['project' => $project])
                @endif


            </div>
        </div>
    </div>
@endsection