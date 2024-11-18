@extends('web.layout')

@section('content')
    <div class="container mx-auto py-8">
        <h1 class="text-4xl font-bold mb-8 text-center">Login</h1>

        <form method="POST" action="{{ route('login') }}" class="max-w-lg mx-auto bg-white p-8 rounded-card shadow-md">
            {{ csrf_field() }}

            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-muted-foreground">E-Mail</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                    class="mt-1 block w-full px-3 py-2 border border-muted rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary sm:text-sm">
                @if ($errors->has('email'))
                    <span class="text-red-500 text-sm">{{ $errors->first('email') }}</span>
                @endif
            </div>

            <div class="mb-4">
                <label for="password" class="block text-sm font-medium text-muted-foreground">Password</label>
                <input id="password" type="password" name="password" required
                    class="mt-1 block w-full px-3 py-2 border border-muted rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary sm:text-sm">
                @if ($errors->has('password'))
                    <span class="text-red-500 text-sm">{{ $errors->first('password') }}</span>
                @endif
            </div>

            <div class="mb-4 flex items-center">
                <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}
                    class="h-4 w-4 text-blue-600 focus:ring-primary border-muted rounded">
                <label for="remember" class="ml-2 block text-sm ">Remember Me</label>
            </div>

            <div class="flex items-center justify-between">
                <button type="submit"
                    class="w-full bg-primary text-white px-4 py-2 rounded-md shadow-sm hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">
                    Login
                </button>
            </div>

            <div class="mt-4 text-center">
                <a class="text-primary hover:underline" href="{{ route('register') }}">Don't have an account yet?
                    Register</a>
            </div>

            @if (session('success'))
                <p class="text-green-500 text-sm mt-4">
                    {{ session('success') }}
                </p>
            @endif
        </form>
    </div>
@endsection
