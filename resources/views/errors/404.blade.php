@extends('layouts.app')

@section('title', 'Page Not Found')

@section('content')
<div class="flex flex-col items-center justify-center min-h-[60vh] px-4 py-16">
    <div class="text-center">
        <h1 class="text-9xl font-bold text-red-600">404</h1>
        <h2 class="text-3xl font-semibold mt-4 mb-6">Page Not Found</h2>
        <p class="text-lg text-gray-600 mb-8">
            The page you are looking for doesn't exist or has been moved.
        </p>
        <div class="space-x-4">
            <a href="{{ route('home') }}" class="inline-block bg-red-600 text-white px-6 py-3 rounded-full hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2">
                Return to Home
            </a>
            <a href="{{ route('products.index') }}" class="inline-block bg-gray-200 text-gray-800 px-6 py-3 rounded-full hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
                Browse Menu
            </a>
        </div>
    </div>
</div>
@endsection
