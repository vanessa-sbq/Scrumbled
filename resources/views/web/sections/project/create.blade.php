@extends('web.layout')

@section('content')
    <div class="container mx-auto py-8">
        <h1 class="text-4xl font-bold mb-8 text-center">Create Project</h1>

        <x-form :action="route('projects.store')">
            <x-input type="text" name="title" label="Title" value="{{ old('title') }}"
                placeholder="Enter the project title" required autofocus />
            <x-input type="textarea" name="description" label="Description"
                placeholder="Provide a brief description of the project" required />
            <x-input type="select" name="is_public" label="Public Visibility" :options="['1' => 'Yes', '0' => 'No']"
                value="{{ old('is_public') }}" required />
            <x-input type="select" name="is_archived" label="Archived" :options="['0' => 'No', '1' => 'Yes']" value="{{ old('is_archived') }}"
                required />
        </x-form>
    </div>
@endsection
