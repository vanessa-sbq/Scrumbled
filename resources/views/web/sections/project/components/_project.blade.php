<div class="bg-white shadow-md rounded-lg p-6">
    <h2 class="text-2xl font-semibold mb-2">{{ $project->title }}</h2>
    <p class="text-gray-700 mb-4">{{ $project->description }}</p>
    <a href="{{ route('projects.show', $project->slug) }}" class="text-blue-500 hover:underline">View Project</a>
</div>
