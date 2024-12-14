@extends('web.layout')

@section('content')
    <div class="max-w-lg container pt-6">

        <h2 class="text-center text-4xl font-bold mb-6">Edit Sprint</h2>

        <form class="bg-white rounded-card shadow-md flex flex-col gap-6 p-8"
            action="{{ route('sprint.update', $sprint->id) }}" method="POST">
            @csrf
            @method('POST')

            <div>
                <label for="name" class="block text-gray-700">Name</label>
                <input type="text" id="name" name="name" class="w-full px-3 py-2 border rounded"
                    value="{{ old('name', $sprint->name) }}" placeholder="Enter the sprint name">
                @error('name')
                    <div class="text-red-500 mt-2">{{ $message }}</div>
                @enderror
            </div>

            {{-- Start Date --}}
            <div>
                <label for="start_date" class="block text-gray-700">Start Date</label>
                <input type="date" id="start_date" name="start_date" class="w-full px-3 py-2 border rounded"
                    value="{{ old('start_date', $sprint->start_date ? \Illuminate\Support\Carbon::parse($sprint->start_date)->format('Y-m-d') : '') }}"
                    placeholder="Select start date">
                @error('start_date')
                    <div class="text-red-500 mt-2">{{ $message }}</div>
                @enderror
            </div>

            {{-- End Date --}}
            <div>
                <label for="end_date" class="block text-gray-700">End Date</label>
                <input type="date" id="end_date" name="end_date" class="w-full px-3 py-2 border rounded"
                    value="{{ old('end_date', $sprint->end_date ? \Illuminate\Support\Carbon::parse($sprint->end_date)->format('Y-m-d') : '') }}"
                    placeholder="Select end date">
                @error('end_date')
                    <div class="text-red-500 mt-2">{{ $message }}</div>
                @enderror
            </div>


            <button type="submit" class="px-4 py-2 bg-primary text-white rounded hover:bg-blue-700">
                Update Sprint
            </button>
            <a class="px-4 py-2 bg-red-600 text-white hover:bg-red-800 rounded text-center"
                href="{{ route('sprint.show', $sprint->id) }}">
                Cancel
            </a>
        </form>
    </div>
@endsection
