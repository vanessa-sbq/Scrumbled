@extends('web.layout')

@section('content')
    <div class="flex flex-col flex-1 container p-4 md:py-16">
        <!-- Navbar with Breadcrumb -->
        @include('web.sections.project.components._navbar', ['project' => $project])

        <div class="flex">
            <!-- Sidebar -->
            <aside class="w-3/12 p-6 hidden md:block flex">
                <h2 class="text-xl font-semibold mb-4">Settings</h2>
                <nav class="space-y-2">
                    @if (Auth::guard("admin")->check() || (Auth::check() && (Auth::user()->id === $project->product_owner_id || Auth::user()->id === $project->scrum_master_id)))
                        <a href="{{ route('projects.settings', $project->slug) }}" class="block py-2 px-4 rounded {{ request()->routeIs('projects.settings') ? 'bg-gray-200 font-semibold' : 'hover:underline' }}">General</a>
                    @endif
                    <a href="{{ route('projects.team.settings', $project->slug) }}" class="block py-2 px-4 rounded {{ request()->routeIs('projects.team.settings') ? 'bg-gray-200 font-semibold' : 'hover:underline' }}">Collaborators</a>
                        @if (Auth::check() && ($project->developers->pluck('id')->contains(Auth::user()->id) || Auth::user()->id === $project->scrum_master_id))
                            <div class="group relative">
                                <button class="leave_project_button flex-1 py-2 px-4 w-full text-left rounded hover:text-white relative z-10" id="{{ Auth::user()->id }}">
                                    Leave Project
                                </button>
                                <span class="absolute left-0 top-0 rounded h-full w-full bg-red-600 scale-x-0 group-hover:scale-x-100 transition-transform origin-left"></span>
                                <x-modal id="leave_project_modal" title="Leave Project" closeButtonText="Cancel" saveButtonText="Leave" saveAction="leaveProject" activeButtonColor="bg-red-600" hoverButtonColor="bg-red-700">
                                    <p>Are you sure you want to leave this project? This action cannot be reverted by you.</p>
                                </x-modal>
                            </div>
                        @endif
                </nav>
            </aside>

            <!-- Main Content -->
            <div class="flex flex-1 flex-col w-3/4 p-6 gap-10">
                @if (request()->routeIs('projects.settings') && ((Auth::guard("admin")->check()) || (Auth::check() && (Auth::user()->id === $project->product_owner_id || Auth::user()->id === $project->scrum_master_id))))
                    @include('web.sections.project.components._general', ['project' => $project])
                @else
                    @include('web.sections.project.components._team', ['project' => $project, 'developers' => $developers])
                @endif


            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src=" {{ asset('js/settingsAside.js') }} "></script>
@endpush