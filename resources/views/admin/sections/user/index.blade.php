@extends('admin.layout')

@section('content')
    <div class="container mx-auto">
        <div class="mx-auto card" id="profileList">

            <input type="text" id="search-input"
                class="w-full px-3 py-2 mb-4 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary sm:text-sm"
                placeholder="Search users...">
            <div class="flex items-center justify-between">
                <select id="filter-input" name="status" class="border p-2 rounded mr-2">
                    <option value="ANY">Any Status</option>
                    <option value="ACTIVE" {{ request('status') == 'ACTIVE' ? 'selected' : '' }}>Active</option>
                    <option value="NEEDS_CONFIRMATION" {{ request('status') == 'NEEDS_CONFIRMATION' ? 'selected' : '' }}>
                        Needs
                        Confirmation</option>
                    <option value="BANNED" {{ request('status') == 'BANNED' ? 'selected' : '' }}>Banned</option>
                </select>
                <a href="{{ route('admin.users.showCreate') }}"
                    class="inline-block px-4 py-2 mb-4 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-primary border border-transparent rounded-md shadow-md hover:bg-primary-dark focus:outline-none focus:ring-primary focus:border-primary-dark">
                    Create User
                </a>
            </div>
            <div class="overflow-x-auto bg-white shadow-md rounded-lg p-6 mb-6">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-white border-b border-black rounded-t-lg">
                        <tr>
                            <th
                                class="px-6 py-3 text-left text-lg font-bold text-primary uppercase tracking-wider rounded-tl-lg">
                                Full Name
                            </th>
                            <th
                                class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider hidden md:table-cell">
                                Email</th>
                            <th
                                class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider hidden md:table-cell">
                                Account Status</th>
                            <th
                                class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider hidden md:table-cell">
                                Actions</th>
                            <th
                                class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider rounded-tr-lg hidden md:table-cell">
                                Profile</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200" id="results-container">
                        @include('admin.components._user', ['users' => $users])
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@once
    @push('scripts')
        <script src="{{ asset('js/search.js') }}"></script>
    @endpush
@endonce
