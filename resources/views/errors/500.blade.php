@extends('layouts.app')

@section('title', 'Server Error')

@section('content')
<div class="flex flex-col items-center justify-center min-h-[60vh] px-4 py-16">
    <div class="text-center">
        <h1 class="text-9xl font-bold text-red-600">500</h1>
        <h2 class="text-3xl font-semibold mt-4 mb-6">Server Error</h2>
        <p class="text-lg text-gray-600 mb-8">
            Something went wrong on our end. Please try again later.
        </p>
        <div class="space-x-4">
            <a href="{{ route('home') }}" class="inline-block bg-red-600 text-white px-6 py-3 rounded-full hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2">
                Return to Home
            </a>
            <a href="javascript:history.back()" class="inline-block bg-gray-200 text-gray-800 px-6 py-3 rounded-full hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
                Go Back
            </a>
        </div>
    </div>
</div>
@endsection
