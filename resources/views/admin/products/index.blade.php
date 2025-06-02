@extends('layouts.app')

@section('content')
    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <h1 class="text-2xl font-bold text-gray-900 mb-6 px-4 sm:px-0">Product Management</h1>
            
            <div class="bg-white overflow-hidden shadow-md sm:rounded-lg">
                @livewire('admin.product-manager')
            </div>
        </div>
    </div>
@endsection
