@extends('web.layout')

@section('content')
    <div class="container mx-auto py-8">
        <h1 class="text-4xl font-bold mb-8 text-center">Register</h1>

        <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data"
            class="max-w-lg mx-auto bg-white p-8 rounded-lg shadow-md">
            {{ csrf_field() }}

            <div class="mb-4">
                <label for="username" class="block text-sm font-medium text-gray-700">Username</label>
                <input id="username" type="text" name="username" value="{{ old('username') }}" required autofocus
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                @if ($errors->has('username'))
                    <span class="text-red-500 text-sm">{{ $errors->first('username') }}</span>
                @endif
            </div>

            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-gray-700">E-Mail Address</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                @if ($errors->has('email'))
                    <span class="text-red-500 text-sm">{{ $errors->first('email') }}</span>
                @endif
            </div>

            <div class="mb-4">
                <label for="full_name" class="block text-sm font-medium text-gray-700">Full Name</label>
                <input id="full_name" type="text" name="full_name" value="{{ old('full_name') }}"
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                @if ($errors->has('full_name'))
                    <span class="text-red-500 text-sm">{{ $errors->first('full_name') }}</span>
                @endif
            </div>

            <div class="mb-4">
                <label for="bio" class="block text-sm font-medium text-gray-700">Bio</label>
                <textarea id="bio" name="bio"
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">{{ old('bio') }}</textarea>
                @if ($errors->has('bio'))
                    <span class="text-red-500 text-sm">{{ $errors->first('bio') }}</span>
                @endif
            </div>

            <div class="mb-4">
                <label for="picture" class="block text-sm font-medium text-gray-700">Profile Picture</label>
                <input id="picture" type="file" name="picture"
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                @if ($errors->has('picture'))
                    <span class="text-red-500 text-sm">{{ $errors->first('picture') }}</span>
                @endif
            </div>

            <div class="mb-4">
                <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                <input id="password" type="password" name="password" required
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                @if ($errors->has('password'))
                    <span class="text-red-500 text-sm">{{ $errors->first('password') }}</span>
                @endif
            </div>

            <div class="mb-4">
                <label for="password-confirm" class="block text-sm font-medium text-gray-700">Confirm Password</label>
                <input id="password-confirm" type="password" name="password_confirmation" required
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
            </div>

            <div class="flex items-center justify-between">
                <button type="submit"
                    class="w-full bg-blue-500 text-white px-4 py-2 rounded-md shadow-sm hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Register
                </button>
            </div>

            <div class="mt-4 text-center">
                <a class="text-blue-500 hover:underline" href="{{ route('login') }}">Already have an account? Login</a>
            </div>
        </form>
    </div>
@endsection
