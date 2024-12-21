<div>
    <h2 class="text-2xl font-bold mb-4">Edit Details</h2>
    <div class="flex flex-col divide-y divide-gray-400">
        <form id="changeTitleForm" class="flex flex-wrap items-center gap-4 mb-2 flex-1">
            @csrf
            <label for="title" class="text-md font-semibold">Project Title</label>
            <input
                    type="text"
                    id="title"
                    name="title"
                    placeholder="Choose a title for the project."
                    class="px-3 py-2 border border-muted rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary sm:text-sm"
                    value="{{ old('title', $project->title) }}"
                    required
            >
            <button type="button" id="changeTitleBtn" class="inline-flex items-center justify-center rounded-md transition-colors bg-primary text-white hover:bg-primary/90 px-6 py-2 text-base">
                Change title
            </button>
            <div id="titleError" class="text-sm text-red-600 mt-1" style="display:none;"></div>
        </form>

        <form id="changeDescriptionForm" class="flex flex-col items-start gap-4 mb-4">
            @csrf
            <label for="description" class="block text-md mt-2 font-semibold">Project Description</label>
            <textarea
                    id="description"
                    name="description"
                    placeholder="Describe your project in detail."
                    class="w-full  px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 resize-y"
                    rows="5"
                    required
            >{{ old('description', $project->description) }}</textarea>
            <button type="button" id="changeDescriptionBtn" class="inline-flex items-center justify-center rounded-md transition-colors bg-primary text-white hover:bg-primary/90 px-6 py-2 text-base">
                Change description
            </button>
            <div id="descriptionError" class="text-sm text-red-600 mt-1" style="display:none;"></div>
        </form>

    </div>
</div>

<div>
    <h2 class="text-2xl font-bold mb-4">Dangerous Settings</h2>

    <div class="border border-red-600 rounded-lg divide-y divide-gray-700">
        <!-- Change project visibility -->
        <div class="p-4 flex flex-wrap gap-4 items-center justify-between">
            <div>
                <h3 class="font-semibold">Change project visibility</h3>
                <p class="text-gray-400">This project is currently {{$project->is_public ? 'public' : 'private'}}.</p>
            </div>
            <button class="inline-flex items-center justify-center rounded-md transition-colors bg-gray-200 text-gray-800 hover:bg-gray-300 px-6 py-2 text-base " id="change_visibility">
                Change visibility
            </button>

            <x-modal id="visibility_modal" title="Project visibility" closeButtonText="Cancel" saveButtonText="Proceed" saveAction="changeVisibility" activeButtonColor="bg-red-600" hoverButtonColor="bg-red-700">
                <p>Are you sure you want to change the visibility to {{$project->is_public ? 'private' : 'public'}}?</p>
            </x-modal>
        </div>

        <!-- Transfer ownership -->
        <div class="p-4 flex flex-wrap gap-4 items-center justify-between">
            <div>
                <h3 class="font-semibold">Transfer ownership</h3>
                <p class="text-gray-400">
                    Transfer this project to another user.
                </p>
            </div>
            <button class="inline-flex items-center justify-center rounded-md transition-colors bg-gray-200 text-gray-800 hover:bg-gray-300 px-6 py-2 text-base " id="transfer_ownership">
                Transfer
            </button>

            <x-modal id="transfer_modal" title="Project ownership" closeButtonText="Cancel" saveButtonText="Confirm" saveAction="transferOwnership" activeButtonColor="bg-red-600" hoverButtonColor="bg-red-700">
                <div class="container mx-auto py-8">
                    <h1 class="text-4xl font-bold mb-8 text-center">User Profiles</h1>

                    <div class="max-w-xl mx-auto card" id="profileList">
                        <input type="text" id="search-input"
                               class="w-full px-3 py-2 mb-4 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary sm:text-sm"
                               placeholder="Search users...">

                        <div id="results-container" class="space-y-4">
                            @include('web.sections.project.components._userInvite', ['users' => $users])
                        </div>
                        <div id="pagination-container" class="mt-4">
                            {{ $users->links() }} <!-- Pagination links -->
                        </div>
                    </div>
                </div>
            </x-modal>

            <x-modal id="transfer_modal_sm" title="Confirm Scrum Master Role Change" closeButtonText="Cancel" saveButtonText="Confirm" saveAction="confirmScrumMasterLoss" activeButtonColor="bg-red-600" hoverButtonColor="bg-red-700">
                <p class="text-gray-600">
                    The selected user is currently assigned as the Scrum Master. By transferring ownership, they will lose this role.
                    Do you want to proceed?
                </p>
            </x-modal>

            <x-modal id="transfer_modal_dev" title="Confirm Developer Role Change" closeButtonText="Cancel" saveButtonText="Confirm" saveAction="confirmDeveloperLoss" activeButtonColor="bg-red-600" hoverButtonColor="bg-red-700">
                <p class="text-gray-600">
                    The selected user is currently assigned as a Developer. By transferring ownership, they will lose this role.
                    Do you want to proceed?
                </p>
            </x-modal>
        </div>

        <!-- Archive this project -->
        <div class="p-4 flex flex-wrap gap-4 items-center justify-between">
            <div>
                <h3 class="font-semibold">{{$project->is_archived ? 'Una' : 'A'}}rchive this project</h3>
                <p class="text-gray-400">Mark this project as {{$project->is_archived ? 'active' : 'archived'}}.</p>
            </div>
            <button class="inline-flex items-center justify-center rounded-md transition-colors bg-gray-200 text-gray-800 hover:bg-gray-300 px-6 py-2 text-base " id="archive_project">
                {{$project->is_archived ? 'Una' : 'A'}}rchive this project
            </button>

            <x-modal id="archive_modal" title="Project Archival" closeButtonText="Cancel" saveButtonText="Proceed" saveAction="archiveProject" activeButtonColor="bg-red-600" hoverButtonColor="bg-red-700">
                <p>You're about to archive the project.</p>
                <p>Do you want to proceed ?</p>
            </x-modal>
        </div>

        <!-- Delete this project -->
        <div class="p-4 flex flex-wrap gap-4 items-center justify-between">
            <div>
                <h3 class="font-semibold">Delete this project</h3>
                <p class="text-gray-400">Once you delete a project, there is no going back. Please be certain.</p>
            </div>
            <button class="inline-flex items-center justify-center rounded-md transition-colors bg-red-600 text-white hover:bg-red-700 px-6 py-2 text-base " id="delete_project">
                Delete this project
            </button>

            <x-modal id="delete_modal" title="Project Deletion" closeButtonText="Don't delete" saveButtonText="DELETE" saveAction="deleteProject" activeButtonColor="bg-red-600" hoverButtonColor="bg-red-700">
                <p>This is the point of no return.</p>
                <p>Are you sure you want to delete the project ?</p>
            </x-modal>
        </div>

    </div>
</div>

@push('scripts')
    <script src=" {{ asset('js/modal.js') }} "></script>
    <script src=" {{ asset('js/project.js') }} "></script>
@endpush