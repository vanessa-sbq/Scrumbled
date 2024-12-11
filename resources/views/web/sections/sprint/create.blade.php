@extends('web.layout')

@section('content')
    <div class="container py-8">
        <h1 class="text-4xl font-bold mb-8 text-center">Create Sprint</h1>

        <form method="POST" action="{{ route('sprint.store', $project->slug) }}" class="max-w-lg mx-auto card">
            @csrf

            @if ($errors->has('error'))
                <div class="bg-red-100 text-red-600 p-4 mb-6 rounded-md flex items-center justify-between">
                    <span class="flex-grow font-semibold">{{ $errors->first('error') }}</span>
                    <a href="{{ route('projects.show', $project->slug) }}"
                        class="bg-red-500 text-white px-3 py-1 text-sm rounded-md shadow-sm hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 ml-4">
                        Close Active Sprint
                    </a>
                </div>
            @endif

            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-muted-foreground">Name</label>
                <input id="name" type="text" name="name" value="{{ old('name') }}" required
                    placeholder="Enter sprint name"
                    class="mt-1 block w-full px-3 py-2 border border-muted rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary sm:text-sm">
                @error('name')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <!-- Start Date -->
            <div class="mb-4">
                <label for="start_date" class="block text-sm font-medium text-muted-foreground">Start Date</label>
                <input id="start_date" type="date" name="start_date" value="{{ old('start_date') }}" required
                    placeholder="Select start date"
                    class="mt-1 block w-full px-3 py-2 border border-muted rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary sm:text-sm">
                @error('start_date')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <!-- End Date -->
            <div class="mb-4">
                <label for="end_date" class="block text-sm font-medium text-muted-foreground">End Date</label>
                <input id="end_date" type="date" name="end_date" value="{{ old('end_date') }}" required
                    placeholder="Select end date"
                    class="mt-1 block w-full px-3 py-2 border border-muted rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary sm:text-sm">
                @error('end_date')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <!-- Is Open -->
            <div class="mb-4">
                <label for="is_archived" class="block text-sm font-medium text-muted-foreground">Is Archived</label>
                <select id="is_archived" name="is_archived"
                    class="mt-1 block w-full px-3 py-2 border border-muted rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary sm:text-sm">
                    <option value="0" {{ old('is_archived') == 0 ? 'selected' : '' }}>No</option>
                    <option value="1" {{ old('is_archived') == 1 ? 'selected' : '' }}>Yes</option>
                </select>
                @error('is_archived')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div class="flex items-center justify-between">
                <button type="submit"
                    class="w-full bg-primary text-white px-4 py-2 rounded-md shadow-sm hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">
                    Create Sprint
                </button>
            </div>
        </form>
    </div>
@endsection
