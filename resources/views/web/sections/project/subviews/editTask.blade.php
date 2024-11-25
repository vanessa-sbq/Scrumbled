@extends('web.layout')

@section('content')
    <div class="container mx-auto py-8">
        <h1 class="text-4xl font-bold mb-8 text-center">Edit Task</h1>
        <form action="{{ route('tasks.editTask', ['slug' => $slug, 'id' => $task->id]) }}" method="POST" class="max-w-lg mx-auto bg-white p-8 rounded-card shadow-md">
            @csrf

            <div class="mb-4">
                <label for="title" class="block text-gray-700 text-sm font-bold mb-2">Title:</label>
                <input type="text" name="title" id="title" value="{{ $task->title }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            </div>
            <div class="mb-4">
                <label for="description" class="block text-gray-700 text-sm font-bold mb-2">Description:</label>
                <textarea name="description" id="description" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">{{ $task->description }}</textarea>
            </div>

            <!-- Value -->
            <div class="mb-4">
            <label for="value" class="block text-sm font-medium text-muted-foreground">Value</label>
            <select id="value" name="value" required class="mt-1 block w-full px-3 py-2 border border-muted rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary sm:text-sm">
                <option value="MUST_HAVE" {{ old('value', $task->value) == 'MUST_HAVE' ? 'selected' : '' }}>Must Have</option>
                <option value="SHOULD_HAVE" {{ old('value', $task->value) == 'SHOULD_HAVE' ? 'selected' : '' }}>Should Have</option>
                <option value="COULD_HAVE" {{ old('value', $task->value) == 'COULD_HAVE' ? 'selected' : '' }}>Could Have</option>
                <option value="WILL_NOT_HAVE" {{ old('value', $task->value) == 'WILL_NOT_HAVE' ? 'selected' : '' }}>Will Not Have</option>
            </select>
            @error('value')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
            </div>
            <!-- Effort -->
            <div class="mb-4">
            <label for="effort" class="block text-sm font-medium text-muted-foreground">Effort</label>
            <select id="effort" name="effort" required class="mt-1 block w-full px-3 py-2 border border-muted rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary sm:text-sm">
                <option value="1" {{ old('effort', $task->effort) == '1' ? 'selected' : '' }}>1</option>
                <option value="2" {{ old('effort', $task->effort) == '2' ? 'selected' : '' }}>2</option>
                <option value="3" {{ old('effort', $task->effort) == '3' ? 'selected' : '' }}>3</option>
                <option value="5" {{ old('effort', $task->effort) == '5' ? 'selected' : '' }}>5</option>
                <option value="8" {{ old('effort', $task->effort) == '8' ? 'selected' : '' }}>8</option>
                <option value="13" {{ old('effort', $task->effort) == '13' ? 'selected' : '' }}>13</option>
            </select>
            @error('effort')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
            </div>

            <!-- Button -->
            <div class="flex justify-center">
                <button type="submit" class="px-4 py-2 bg-primary text-white rounded-md hover:bg-primary-dark">Save</button>
            </div>
        </form>
    </div>
@endsection
