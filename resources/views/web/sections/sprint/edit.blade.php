@extends('web.layout')

@section('content')
    <div class="max-w-lg container pt-6">

        <h2 class="text-center text-4xl font-bold mb-6">Edit Sprint</h2>

        <x-form :action="route('sprint.update', $sprint->id)" method="POST">
            @csrf
            @method('POST')

            <x-input type="text" name="name" label="Name" value="{{ old('name', $sprint->name) }}"
                    placeholder="Enter the sprint name" required/>

            <x-input type="date" name="start_date" label="Start Date"
                    value="{{ old('start_date', $sprint->start_date ? \Illuminate\Support\Carbon::parse($sprint->start_date)->format('Y-m-d') : '') }}"
                    required/>

            <x-input type="date" name="end_date" label="End Date"
                    value="{{ old('end_date', $sprint->end_date ? \Illuminate\Support\Carbon::parse($sprint->end_date)->format('Y-m-d') : '') }}"
                    required/>
        </x-form>
    </div>
@endsection
