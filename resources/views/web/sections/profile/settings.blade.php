@extends('web.layout')

@section('content')
    <div class="flex flex-col flex-1 container py-8 p-4 items-center">
        <div class="flex flex-1 flex-col w-3/4 p-6 gap-10">
            <h2 class="text-2xl font-bold mb-4 text-center">Profile Settings</h2>

            <div class="flex flex-col divide-y divide-gray-400">
                <!-- Profile Picture and Details Section -->
                <div class="flex flex-row gap-6 mb-10">
                    <div class="flex-shrink-0 flex flex-col items-center">
                        <label for="old_picture" class="block text-lg font-medium text-muted-foreground mb-4">Current Picture</label>
                        <img class="h-24 w-24 rounded-full border border-gray-300 shadow-sm mb-4" id="old_picture"
                             src="{{ asset($user->picture ? 'storage/' . $user->picture : 'images/users/default.png') }}" alt="Profile Picture">
                        <form id="changeProfilePictureForm" class="flex flex-col gap-2 w-full items-center">
                            @csrf
                            <x-input type="file" name="picture" label="New Picture" />
                            @error('picture')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                            <button type="submit" class="inline-flex items-center justify-center rounded-md transition-colors bg-primary text-white hover:bg-primary/90 px-6 py-2 text-base w-full">
                                Update Picture
                            </button>
                        </form>
                    </div>
                    <div class="flex flex-col flex-1 gap-8 justify-center">
                        <!-- Username Update -->
                        <form id="changeUsernameForm" class="flex flex-col gap-2">
                            @csrf
                            <label for="username" class="text-md font-semibold">Username</label>
                            <input
                                    type="text"
                                    id="username"
                                    name="username"
                                    placeholder="Choose a new username"
                                    class="px-3 py-2 border border-muted rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary sm:text-sm"
                                    value="{{ old('username', $user->username) }}"
                                    required
                            >
                            <button type="button" id="changeUsernameBtn" class="inline-flex items-center justify-center rounded-md transition-colors bg-primary text-white hover:bg-primary/90 px-6 py-2 text-base">
                                Change Username
                            </button>
                            <div id="usernameError" class="text-sm text-red-600 mt-1" style="display:none;"></div>
                        </form>

                        <!-- Email Update -->
                        <form id="changeEmailForm" class="flex flex-col gap-2">
                            @csrf
                            <label for="email" class="text-md font-semibold">Email</label>
                            <input
                                    type="text"
                                    id="email"
                                    name="email"
                                    placeholder="Choose a new email"
                                    class="px-3 py-2 border border-muted rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary sm:text-sm"
                                    value="{{ old('email', $user->email) }}"
                                    required
                            >
                            <button type="button" id="changeEmailBtn" class="inline-flex items-center justify-center rounded-md transition-colors bg-primary text-white hover:bg-primary/90 px-6 py-2 text-base">
                                Change Email
                            </button>
                            <div id="emailError" class="text-sm text-red-600 mt-1" style="display:none;"></div>
                        </form>

                        <!-- Full Name Update -->
                        <form id="changeFullNameForm" class="flex flex-col gap-2">
                            @csrf
                            <label for="full_name" class="text-md font-semibold">Full Name</label>
                            <input
                                    type="text"
                                    id="full_name"
                                    name="full_name"
                                    placeholder="Choose a new full name"
                                    class="px-3 py-2 border border-muted rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary sm:text-sm"
                                    value="{{ old('full_name', $user->full_name) }}"
                                    required
                            >
                            <button type="button" id="changeFullNameBtn" class="inline-flex items-center justify-center rounded-md transition-colors bg-primary text-white hover:bg-primary/90 px-6 py-2 text-base">
                                Change Full Name
                            </button>
                            <div id="fullNameError" class="text-sm text-red-600 mt-1" style="display:none;"></div>
                        </form>
                    </div>
                </div>

                <!-- Biography Section -->
                <form id="changeBioForm" class="flex flex-col items-center gap-4 mb-8">
                    @csrf
                    <label for="bio" class="block text-md mt-2 font-semibold">Biography</label>
                    <textarea
                            id="bio"
                            name="bio"
                            placeholder="Give other users some information about you!"
                            class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 resize-y"
                            rows="5"
                            required
                    >{{ old('bio', $user->bio) }}</textarea>
                    <button type="button" id="changeBioBtn" class="inline-flex items-center justify-center rounded-md transition-colors bg-primary text-white hover:bg-primary/90 px-6 py-2 text-base">
                        Change Biography
                    </button>
                    <div id="bioError" class="text-sm text-red-600 mt-1" style="display:none;"></div>
                </form>
            </div>

            <div>
                <h2 class="text-2xl font-bold mb-4 text-center">Dangerous Settings</h2>

                <div class="border border-red-600 rounded-lg divide-y divide-gray-700">
                    <!-- Change profile visibility -->
                    <div class="p-4 flex flex-wrap gap-4 items-center justify-between">
                        <div>
                            <h3 class="font-semibold">Change profile visibility</h3>
                            <p class="text-gray-400">This profile is currently {{$user->is_public ? 'public' : 'private'}}.</p>
                        </div>
                        <button class="inline-flex items-center justify-center rounded-md transition-colors bg-gray-200 text-gray-800 hover:bg-gray-300 px-6 py-2 text-base" id="change_profile_visibility">
                            Change Profile Visibility
                        </button>

                        <x-modal id="visibility_modal_profile" title="Profile Visibility" closeButtonText="Cancel" saveButtonText="Proceed" saveAction="changeProfileVisibility" activeButtonColor="bg-red-600" hoverButtonColor="bg-red-700">
                            <p>Are you sure you want to change the visibility to {{$user->is_public ? 'private' : 'public'}}?</p>
                        </x-modal>
                    </div>

                    <!-- Delete this profile -->
                    <div class="p-4 flex flex-wrap gap-4 items-center justify-between">
                        <div>
                            <h3 class="font-semibold">Delete this profile</h3>
                            <p class="text-gray-400">Once you delete a profile, there is no going back. Please be certain.</p>
                        </div>
                        <button class="inline-flex items-center justify-center rounded-md transition-colors bg-red-600 text-white hover:bg-red-700 px-6 py-2 text-base" id="delete_profile">
                            Delete this profile
                        </button>

                        <x-modal id="delete_modal_profile" title="Profile Deletion" closeButtonText="Don't delete" saveButtonText="DELETE" saveAction="deleteProfile" activeButtonColor="bg-red-600" hoverButtonColor="bg-red-700">
                            <p>This is the point of no return.</p>
                            <p>Are you sure you want to delete the profile?</p>
                        </x-modal>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('js/modal.js') }}"></script>
    <script src="{{ asset('sj/profile.js') }}"></script>
@endpush
