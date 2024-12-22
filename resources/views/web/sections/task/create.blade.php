@extends('web.layout')

@section('content')
    <div class="container mx-auto py-8">
        <h1 class="text-4xl font-bold mb-8 text-center">Create Task</h1>
        <form method="POST" action="{{ route('tasks.createNew', ['slug' => $slug]) }}" class="max-w-lg mx-auto card">
            @csrf

            <!-- Title -->
            <div class="mb-4">
                <label for="title" class="block text-sm font-medium text-muted-foreground">Title</label>
                <input id="title" type="text" name="title" value="{{ old('title') }}" required autofocus
                    class="mt-1 block w-full px-3 py-2 border border-muted rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary sm:text-sm"
                    placeholder="Enter the task title"
                    maxlength="50">
                @error('title')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <!-- Description -->
            <div class="mb-4">
                <label for="description" class="block text-sm font-medium text-muted-foreground">Description</label>
                <textarea id="description" name="description"
                    maxlength="2000"
                    class="mt-1 block w-full px-3 py-2 border border-muted rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary sm:text-sm"
                    placeholder="Provide a brief description">{{ old('description') }}</textarea>
                @error('description')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <!-- Value -->
            <div class="mb-4">
                <label for="value" class="block text-sm font-medium text-muted-foreground">Value</label>
                <select id="value" name="value" required
                    class="mt-1 block w-full px-3 py-2 border border-muted rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary sm:text-sm">
                    <option value="MUST_HAVE" {{ old('value') == 'MUST_HAVE' ? 'selected' : '' }}>Must Have</option>
                    <option value="SHOULD_HAVE" {{ old('value') == 'SHOULD_HAVE' ? 'selected' : '' }}>Should Have</option>
                    <option value="COULD_HAVE" {{ old('value') == 'COULD_HAVE' ? 'selected' : '' }}>Could Have</option>
                    <option value="WILL_NOT_HAVE" {{ old('value') == 'WILL_NOT_HAVE' ? 'selected' : '' }}>Will Not Have
                    </option>
                </select>
                @error('value')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <!-- Effort -->
            <div class="mb-4">
                <label for="effort" class="block text-sm font-medium text-muted-foreground">Effort</label>
                <select id="effort" name="effort" required
                    class="mt-1 block w-full px-3 py-2 border border-muted rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary sm:text-sm">
                    <option value="1" {{ old('effort') == '1' ? 'selected' : '' }}>1</option>
                    <option value="2" {{ old('effort') == '2' ? 'selected' : '' }}>2</option>
                    <option value="3" {{ old('effort') == '3' ? 'selected' : '' }}>3</option>
                    <option value="5" {{ old('effort') == '5' ? 'selected' : '' }}>5</option>
                    <option value="8" {{ old('effort') == '8' ? 'selected' : '' }}>8</option>
                    <option value="13" {{ old('effort') == '13' ? 'selected' : '' }}>13</option>
                </select>
                @error('effort')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <!-- Button -->
            <div class="flex justify-center">
                <button type="submit" class="px-4 py-2 bg-primary text-white rounded-md hover:bg-primary-dark">Create
                    Task</button>
            </div>
        </form>
    </div>
@endsection
