@extends('web.layout')

@section('content')
    <div class="container mx-auto py-8">
        <h1 class="text-4xl font-bold mb-8 text-center">Create Project</h1>

        <form method="POST" action="{{ route('projects.store') }}"
              class="max-w-lg mx-auto bg-white p-8 rounded-card shadow-md">
            @csrf

            {{-- Project Title --}}
            <div class="mb-4">
                <label for="title" class="block text-sm font-medium text-muted-foreground">Title</label>
                <input id="title" type="text" name="title" value="{{ old('title') }}" required autofocus
                       placeholder="Enter the project title"
                       class="mt-1 block w-full px-3 py-2 border border-muted rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary sm:text-sm">
                @error('title')
                <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            {{-- Project Description --}}
            <div class="mb-4">
                <label for="description" class="block text-sm font-medium text-muted-foreground">Description</label>
                <textarea id="description" name="description" required
                          placeholder="Provide a brief description of the project"
                          class="mt-1 block w-full px-3 py-2 border border-muted rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary sm:text-sm">{{ old('description') }}</textarea>
                @error('description')
                <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            {{-- Public Visibility --}}
            <div class="mb-4">
                <label for="is_public" class="block text-sm font-medium text-muted-foreground">Public Visibility</label>
                <select id="is_public" name="is_public" required
                        class="mt-1 block w-full px-3 py-2 border border-muted rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary sm:text-sm">
                    <option value="1" {{ old('is_public') == 1 ? 'selected' : '' }}>Yes</option>
                    <option value="0" {{ old('is_public') == 0 ? 'selected' : '' }}>No</option>
                </select>
                @error('is_public')
                <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            {{-- Archived Status --}}
            <div class="mb-4">
                <label for="is_archived" class="block text-sm font-medium text-muted-foreground">Archived</label>
                <select id="is_archived" name="is_archived" required
                        class="mt-1 block w-full px-3 py-2 border border-muted rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary sm:text-sm">
                    <option value="0" {{ old('is_archived') == 0 ? 'selected' : '' }}>No</option>
                    <option value="1" {{ old('is_archived') == 1 ? 'selected' : '' }}>Yes</option>
                </select>
                @error('is_archived')
                <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            {{-- Submit Button --}}
            <div class="flex items-center justify-between">
                <button type="submit"
                        class="w-full bg-primary text-white px-4 py-2 rounded-md shadow-sm hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">
                    Create Project
                </button>
            </div>
        </form>
    </div>
@endsection
