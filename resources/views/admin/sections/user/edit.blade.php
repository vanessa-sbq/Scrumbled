@extends('admin.layout')

@section('content')
    <section class="container p-4 md:py-16">
        <h1 class="text-4xl font-bold text-center">Edit User: {{ $user->full_name }}</h1>
    </section>
@endsection