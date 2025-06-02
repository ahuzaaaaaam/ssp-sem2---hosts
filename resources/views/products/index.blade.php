@extends('layouts.app')

@section('title', 'Menu')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <h1 class="text-3xl font-bold text-gray-900 mb-8">Our Menu</h1>

    <!-- Livewire Product Search Component -->
    @livewire('product-search')

    <!-- Activity Logger Component -->
    @livewire('activity-logger')

    <!-- Admin features removed -->

    <!-- Products are now displayed by the Livewire component -->
</div>
@endsection

@section('scripts')
<!-- Admin scripts removed -->
@endsection
