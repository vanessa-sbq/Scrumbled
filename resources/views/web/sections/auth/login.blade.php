@extends('web.layout')

@section('content')
    <div class="container mx-auto py-8">
        <h1 class="text-4xl font-bold mb-8 text-center">Login</h1>

        <x-form :action="route('login')" method="POST" label="Login">
            {{-- Email Field --}}
            <x-input type="email" name="email" label="E-Mail" placeholder="Enter your email" required autofocus />

            {{-- Password Field --}}
            <x-input type="password" name="password" label="Password" placeholder="Enter your password" required />

            {{-- Remember Me --}}
            <div class="flex justify-between">
                <div class="mb-4">
                    <label for="remember" class="inline-flex items-center">
                        <input type="checkbox" name="remember" id="remember" class="rounded border-gray-300 text-primary shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50">
                        <span class="ml-2 text-sm text-muted-foreground">Remember Me</span>
                    </label>
                </div>

                {{-- Recover Password --}}
                <a href="{{ route('login.forgotPassword') }}" class="ml-2 text-sm text-muted-foreground hover:underline">Forgot password?</a>
            </div>
        </x-form>
    
    </div>
@endsection
