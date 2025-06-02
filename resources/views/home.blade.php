@extends('layouts.app')

@section('title', 'Home')

@section('content')
<!-- Activity Logger Component -->
@livewire('activity-logger')

<div class="pt-8 pb-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Hero Section -->
        <style>
            .hero-image {
                width: 100%;
                height: 650px;
                object-fit: cover;
                object-position: center;
                filter: brightness(0.65);
            }
            .hero-text {
                text-shadow: 2px 2px 4px rgba(0,0,0,0.8);
            }
        </style>
        <div class="relative overflow-hidden mb-12 shadow-2xl -mx-4 sm:-mx-6 lg:-mx-8 -mt-8 rounded-xl">
            <img src="https://images.unsplash.com/photo-1513104890138-7c749659a591" alt="Pizza Hero" class="hero-image">
            <div class="absolute inset-0 z-20 flex flex-col justify-center items-center text-center p-4">
                <h1 class="text-4xl md:text-5xl font-bold text-white mb-4 hero-text">Delicious Pizza Delivered</h1>
                <p class="text-xl text-white mb-2 max-w-2xl hero-text">Order your favorite pizza online and skip the queue</p>
            </div>
        </div>

        <!-- Featured Pizzas Section -->
        <section class="py-0">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <h2 class="text-3xl font-bold text-center mb-8">Featured Pizzas</h2>

                <!-- Admin features removed -->

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mx-auto max-w-6xl">
                    @forelse ($products as $product)
                    <div class="bg-white rounded-xl shadow-lg overflow-hidden w-full max-w-sm" data-card-id="{{ $product->id }}">
                        <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="w-full h-64 object-cover">
                        <div class="p-6">
                            <div class="flex justify-between items-start mb-2">
                                <h3 class="text-xl font-bold">{{ $product->name }}</h3>
                                <span class="text-lg font-bold">${{ number_format($product->price, 2) }}</span>
                            </div>
                            <p class="text-gray-600 mb-4">{{ $product->description }}</p>
                            
                            <div class="flex items-center justify-between">
                                @if($product->veg === 'Yes')
                                <span class="px-3 py-1 bg-green-100 text-green-800 rounded-full text-xs font-semibold">Vegetarian</span>
                                @else
                                <span class="px-3 py-1 bg-red-100 text-red-800 rounded-full text-xs font-semibold">Non-Vegetarian</span>
                                @endif
                                
                                <form action="{{ route('products.addToCart', $product->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded-full hover:bg-red-700 text-sm">
                                        Add to Cart
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                    @empty
                    <p class="text-gray-600">No featured products available.</p>
                    @endforelse
                </div>
            </div>
        </section>
    </div>
</div>
@endsection

@section('scripts')
<!-- Admin scripts removed -->
@endsection
