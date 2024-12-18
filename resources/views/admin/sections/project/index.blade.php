@extends('admin.layout')

@section('content')
    <div class="container mx-auto">
        <div class="mx-auto card" id="projectList">
            <div class="flex justify-center flex-wrap md:flex-nowrap gap-4 items-center mb-4">
                <input type="text" id="search-input"
                       class="w-full px-3 py-2 mb-4 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary sm:text-sm"
                       placeholder="Search projects...">
                <div class="flex justify-center gap-2 flex-wrap md:flex-nowrap items-center mb-4">
                    <select id="filter-input-visibility" name="status" class="border p-2 rounded mr-2">
                        <option value="ANY">Any Visibility</option>
                        <option value="PUBLIC" {{ request('status') == 'PUBLIC' ? 'selected' : '' }}>Public</option>
                        <option value="PRIVATE" {{ request('status') == 'PRIVATE' ? 'selected' : '' }}>Private</option>
                    </select>
                    <select id="filter-input-archival" name="status" class="border p-2 rounded mr-2">
                        <option value="ANY">Any Archival Status</option>
                        <option value="ACTIVE" {{ request('status') == 'ACTIVE' ? 'selected' : '' }}>Active</option>
                        <option value="ARCHIVED" {{ request('status') == 'ARCHIVED' ? 'selected' : '' }}>Archived</option>
                    </select>
                </div>
            </div>
            <div class="flex flex-col space-y-4" id="results-container">
                @include('admin.components._project', compact('projects'))
            </div>
        </div>
    </div>
@endsection

@once
    @push('scripts')
        <script src="{{ asset('js/admin-project.js') }}"></script>
    @endpush
@endonce
