@extends('web.layout')

@section('content')
    <div class="container mx-auto py-8">
        <h1 class="text-4xl font-bold mb-8 text-center">Register</h1>

        <x-form :action="route('register')" method="POST" label="Register" enctype="multipart/form-data" class="">
            {{ csrf_field() }}

            {{-- Username --}}
            <x-input type="text" name="username" label="Username" placeholder="Enter your username" required autofocus />

            {{-- Email --}}
            <x-input type="email" name="email" label="E-Mail" placeholder="Enter your email" required />

            {{-- Password --}}
            <x-input type="password" name="password" label="Password" placeholder="Enter your password" required />

            {{-- Confirm Password --}}
            <x-input type="password" name="password_confirmation" label="Confirm Password"
                placeholder="Confirm your password" required />

            {{-- Profile Picture --}}
            <div class="mb-4">
                <label for="picture" class="block text-sm font-medium text-muted-foreground">Profile Picture</label>
                <input id="picture" type="file" name="picture"
                    class="mt-1 block w-full px-3 py-2 border border-muted rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary sm:text-sm">
                @if ($errors->has('picture'))
                    <span class="text-red-500 text-sm">{{ $errors->first('picture') }}</span>
                @endif
            </div>
        </x-form>
    </div>
@endsection
