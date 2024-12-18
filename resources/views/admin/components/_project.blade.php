@foreach ($projects as $project)
    <div class="bg-white shadow-md rounded-md p-4 flex flex-col sm:flex-row justify-between items-start md:items-center gap-3 sm:gap-2">
        <div class="flex flex-col gap-2 w-full items-center sm:items-start">
            <h3 class="text-lg font-bold text-primary">{{ $project->title }}</h3>
            <p class="text-sm text-gray-500">Slug: {{ $project->slug }}</p>
            <div class="flex gap-1 flex-row">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium max-w-min
                                    @if ($project->is_public) bg-green-100 text-green-800 @else bg-gray-100 text-gray-800 @endif">
                                    {{ $project->is_public ? 'Public' : 'Private' }}
                                </span>
                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium max-w-min
                                    @if ($project->is_archived) bg-red-100 text-red-800 @else bg-gray-100 text-gray-800 @endif">
                                    {{ $project->is_archived ? 'Archived' : 'Active' }}
                                </span>
            </div>
        </div>
        <div class="flex flex-col gap-2 w-full">
            <div class="flex gap-1 justify-center sm:justify-end flex-wrap">
                <a href="{{ "route('admin.projects.show', $project->id)" }}" class="bg-primary text-white px-4 py-1 rounded-md shadow-sm hover:bg-blue-600">View</a>
                <a href="{{ "route('admin.projects.edit', $project->id)" }}" class="bg-yellow-400 text-white px-4 py-1 rounded-md hover:bg-yellow-500 transition">Edit</a>
            </div>
            <div class="flex gap-1 justify-center sm:justify-end flex-wrap">
                <button data-project-slug="{{$project->slug}}" class="archive-project-button bg-red-500 text-white px-3 py-1 rounded-md hover:bg-red-600 transition">{{ $project->is_archived ? 'Unarchive' : 'Archive' }}</button>
                <button data-project-slug="{{$project->slug}}" class="delete-project-button bg-red-500 text-white px-3 py-1 rounded-md hover:bg-red-600 transition">Delete</button>
            </div>
        </div>
    </div>
@endforeach