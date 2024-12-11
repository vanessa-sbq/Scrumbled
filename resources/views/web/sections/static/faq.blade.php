@extends('web.layout')

@section('content')
    <!-- Features Section -->
    <section class="container mx-auto px-6 py-16">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-gray-800">Features</h2>
            <p class="text-gray-600 mt-4">Discover the amazing features that make MyApp the best choice for project
                management.</p>
        </div>
        <div class="flex flex-wrap -mx-6">
            <div class="w-full md:w-1/3 px-6 mb-12">
                <div class="bg-white shadow-md rounded-lg p-6 text-center">
                    <h3 class="text-xl font-bold text-gray-800">Feature One</h3>
                    <p class="text-gray-600 mt-4">Description of feature one.</p>
                </div>
            </div>
            <div class="w-full md:w-1/3 px-6 mb-12">
                <div class="bg-white shadow-md rounded-lg p-6 text-center">
                    <h3 class="text-xl font-bold text-gray-800">Feature Two</h3>
                    <p class="text-gray-600 mt-4">Description of feature two.</p>
                </div>
            </div>
            <div class="w-full md:w-1/3 px-6 mb-12">
                <div class="bg-white shadow-md rounded-lg p-6 text-center">
                    <h3 class="text-xl font-bold text-gray-800">Feature Three</h3>
                    <p class="text-gray-600 mt-4">Description of feature three.</p>
                </div>
            </div>
        </div>
    </section>
@endsection
