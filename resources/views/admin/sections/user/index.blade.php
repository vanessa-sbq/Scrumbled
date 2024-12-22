@extends('admin.layout')

@section('content')
    <div class="container mx-auto">
        <div class="mx-auto card" id="profileList">
            <div class="flex gap-4 items-center mb-4">
                <input type="text" id="search-input" class="basis-7/9 flex-grow px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary sm:text-sm" placeholder="Search users...">
                <select id="filter-input" name="status" class="basis-1/9 border py-2 rounded">
                    <option value="ANY">Any Visibility</option>
                    <option value="ACTIVE" {{ request('status') == 'ACTIVE' ? 'selected' : '' }}>Active</option>
                    <option value="BANNED" {{ request('status') == 'BANNED' ? 'selected' : '' }}>Banned</option>
                </select>
            </div>
            <div class="overflow-x-auto bg-white rounded-lg ">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-white border-b border-black rounded-t-lg">
                        <tr>
                            <th class="px-6 py-3 text-left text-lg font-bold text-primary uppercase tracking-wider rounded-tl-lg">
                                Full Name
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider hidden md:table-cell">
                                Email
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider hidden md:table-cell">
                                Account Status
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider hidden md:table-cell">
                                Actions</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider flex md:table-cell items-center space-x-2">
                                <p>Profile</p>
                            </th>
                            <th class="py-3 text-left text-xs font-medium uppercase tracking-wider hidden md:table-cell">
                                <a href="{{ route('admin.users.createUser') }}" class="relative group">
                                    <x-lucide-user-plus class="text-gray-600 hover:text-primary transition-colors duration-300" width="20" height="20"/>
                                </a>
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200" id="results-container">
                        @include('admin.components._user', ['users' => $users])  
                    </tbody>
                </table>
                <x-modal id="delete_user_modal" data-user-id="" title="Delete user" closeButtonText="Cancel" saveButtonText="Delete" saveAction="deleteUser" activeButtonColor="bg-red-600" hoverButtonColor="bg-red-700">
                    <p class="font-bold">Read carefully:</p>
                    <p>According to the business rules the user's projects will:</p>
                    <div class="px-5 py-2">
                        <ul class="list-disc">
                        <li><p>Be deleted if the project is private.</p></li>
                        <li><p>Be archived if the project is public.</p></li>
                        </ul>
                    </div>
                    <p>Note that archived projects are read-only. They are projects that are frozen in time.</p>
                    <p>If the project has no Product Owner to unarchive the project the team has to get in contact with an admin.</p>
                    <p class="font-bold">Deleting a user without a reasonable cause may end your contract.</p>
                </x-modal>
            </div>
        </div>
    </div>
@endsection

@once
    @push('scripts')
        <script src="{{ asset('js/search.js') }}"></script>
        <script src=" {{ asset('js/modal.js') }} "></script>
        <script src=" {{ asset('js/admin.js') }} "></script>
    @endpush
@endonce
