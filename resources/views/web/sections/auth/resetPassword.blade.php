@extends('web.layout')

@section('content')
<div class="container mx-auto py-8">

    <nav>
        <a href="{{ route('login') }}" class="text-gray-600 hover:underline">Login</a>
        <span class="mx-2 text-gray-400">/</span>
        <span class="font-bold text-gray-800">Reset Password</span>
    </nav>
    <h1 class="text-4xl font-bold mb-8 text-center">Reset Password</h1>
    <x-form :action="route('login.resetPassword')" method="POST" label="Reset Password">
        <input type="hidden" name="token" value="{{ request()->token }}">
        
        {{-- Email Field --}}
        <x-input type="email" name="email" label="E-Mail" placeholder="Enter your email" required autofocus />

        {{-- Password --}}
            <x-input type="password" name="password" label="Password" placeholder="Enter your password" required />

        {{-- Confirm Password --}}
            <x-input type="password" name="password_confirmation" label="Confirm Password" placeholder="Confirm your password" required />
    </x-form>
</div>
@endsection