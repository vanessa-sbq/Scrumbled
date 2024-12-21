@extends('web.layout')

@section('content')

    <div id="backdrop" class="fixed inset-0 bg-black opacity-50 hidden z-50"></div>

    <div id="collapseSettings" class="md:hidden before:fixed max-md:before:bg-black hidden max-lg:fixed max-lg:bg-white max-lg:w-1/2 max-lg:min-w-[300px] max-lg:top-0 max-lg:left-0 max-lg:p-6 max-lg:h-full max-lg:shadow-md max-lg:overflow-auto z-50">
        <button id="closeSettings" class="lg:hidden fixed top-2 right-4 z-[100] rounded-full bg-white w-9 h-9 flex items-center justify-center border">
            <x-lucide-x class="w-8 h-8" />
        </button>

        <div class="lg:flex gap-x-5 max-lg:space-y-3 z-50">
            @php $hidden = "" @endphp
            @include('web.sections.project.components._settingsSidebar', ['project' => $project, 'hidden' => $hidden])
        </div>
    </div>

    <div id="openSettings" class="md:hidden fixed left-0 top-1/2 transform -translate-y-1/2 flex items-center justify-center w-10 bg-gray-200 hover:bg-gray-300 active:bg-gray-300 h-12 rounded-r-full z-40 cursor-pointer">
        <x-lucide-wrench />
        <x-lucide-chevron-right />
    </div>

    <x-modal id="leave_project_modal" title="Leave Project" closeButtonText="Cancel" saveButtonText="Leave" saveAction="leaveProject" activeButtonColor="bg-red-600" hoverButtonColor="bg-red-700">
        <p>Are you sure you want to leave this project? This action cannot be reverted by you.</p>
    </x-modal>

    <div class="flex flex-col flex-1 container py-8 p-4">
        <!-- Navbar with Breadcrumb -->
        @php $hidden = "hidden" @endphp
        @include('web.sections.project.components._navbar', ['project' => $project, 'hidden' => $hidden])

        <div class="flex">
            <!-- Sidebar -->
            @include('web.sections.project.components._settingsSidebar', ['project' => $project])

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