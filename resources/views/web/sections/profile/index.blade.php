@extends('web.layout')

@section('content')
    <div class="container mx-auto py-8">
        <h1 class="text-4xl font-bold mb-8 text-center">User Profiles</h1>

        <div class="max-w-xl mx-auto card" id="profileList">
            <input type="text" id="search-input"
                class="w-full px-3 py-2 mb-4 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary sm:text-sm"
                placeholder="Search users...">

            <div id="results-container" class="space-y-4">
                @include('web.sections.profile.components._user', ['users' => $users])
            </div>
            <div id="pagination-container" class="mt-4">
                {{ $users->links() }} <!-- Pagination links -->
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('js/search.js') }}"></script>
    <script src="{{ asset('js/dropdown.js') }}"></script>
@endpush
