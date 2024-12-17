@extends('web.layout')

@section('content')
<div class="container mx-auto py-8">
    <nav>
        <a href="{{ route('login') }}" class="text-gray-600 hover:underline">Login</a>
        <span class="mx-2 text-gray-400">/</span>
        <span class="font-bold text-gray-800">Reset Password</span>
    </nav>
    <h1 class="text-4xl font-bold mb-8 text-center">Reset Password</h1>
    <x-form :action="route('login.resetPassword')" method="POST" label="Send Reset Link">
        {{-- Email Field --}}
        <x-input type="email" name="email" label="E-Mail" placeholder="Enter your email" required autofocus />
            @if (!empty(session('success')))
                <div class="mb-4 text-primary" role="alert">
                    Your password was reset! Check your email.
                </div>
            @elseif (!empty(session('error')))
                <div class="mb-4 text-red-600" role="alert">
                    No account with this email was found.
                </div>
        @endif
    </x-form>
</div>
@endsection