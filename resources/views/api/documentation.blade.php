@extends('layouts.app')

@section('title', 'API Documentation')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <h1 class="text-3xl font-bold text-gray-900 mb-8">API Documentation</h1>

    <div class="space-y-12">
        <!-- Introduction -->
        <div>
            <h2 class="text-2xl font-bold text-gray-900 mb-4">Introduction</h2>
            <p class="text-lg text-gray-600 mb-4">
                This documentation provides information about the Pizza Shop API endpoints. 
                The API allows you to access product data and manage products if you have admin privileges.
            </p>
            <p class="text-lg text-gray-600 mb-4">
                Base URL: <code class="bg-gray-100 px-2 py-1 rounded">{{ url('/api') }}</code>
            </p>
        </div>

        <!-- Authentication -->
        <div>
            <h2 class="text-2xl font-bold text-gray-900 mb-4">Authentication</h2>
            <p class="text-lg text-gray-600 mb-4">
                The API uses Laravel Sanctum for authentication. To access protected endpoints, 
                you need to obtain an API token by sending a POST request to the <code class="bg-gray-100 px-2 py-1 rounded">/api/tokens</code> endpoint.
            </p>

            <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                <h3 class="text-xl font-semibold mb-4">Create API Token</h3>
                <p class="mb-4"><span class="font-semibold">Endpoint:</span> <code class="bg-gray-100 px-2 py-1 rounded">POST /api/tokens</code></p>
                <p class="mb-4"><span class="font-semibold">Description:</span> Creates a new API token for the user</p>
                <p class="mb-4"><span class="font-semibold">Request Body:</span></p>
                <pre class="bg-gray-100 p-4 rounded-lg mb-4">
{
    "email": "user@example.com",
    "password": "your_password",
    "device_name": "My Device"
}
                </pre>
                <p class="mb-4"><span class="font-semibold">Response:</span></p>
                <pre class="bg-gray-100 p-4 rounded-lg">
{
    "success": true,
    "token": "your_api_token",
    "user": {
        "id": 1,
        "first_name": "John",
        "last_name": "Doe",
        "email": "user@example.com",
        ...
    }
}
                </pre>
            </div>

            <p class="text-lg text-gray-600 mb-4">
                For authenticated requests, include the token in the Authorization header:
                <code class="bg-gray-100 px-2 py-1 rounded">Authorization: Bearer your_api_token</code>
            </p>
        </div>

        <!-- Products Endpoints -->
        <div>
            <h2 class="text-2xl font-bold text-gray-900 mb-4">Products Endpoints</h2>

            <!-- Get All Products -->
            <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                <h3 class="text-xl font-semibold mb-4">Get All Products</h3>
                <p class="mb-4"><span class="font-semibold">Endpoint:</span> <code class="bg-gray-100 px-2 py-1 rounded">GET /api/products</code></p>
                <p class="mb-4"><span class="font-semibold">Description:</span> Returns a list of all products</p>
                <p class="mb-4"><span class="font-semibold">Query Parameters:</span></p>
                <ul class="list-disc pl-8 mb-4">
                    <li><code class="bg-gray-100 px-2 py-1 rounded">filter</code> - Filter products by category (veg, non-veg, featured)</li>
                </ul>
                <p class="mb-4"><span class="font-semibold">Response:</span></p>
                <pre class="bg-gray-100 p-4 rounded-lg">
{
    "success": true,
    "data": [
        {
            "id": 1,
            "name": "Margherita Pizza",
            "description": "Classic cheese pizza with tomato sauce",
            "price": 9.99,
            "image_url": "https://example.com/pizza.jpg",
            "veg": "Yes",
            "featured": "Yes",
            "created_at": "2025-05-29T20:04:58.000000Z",
            "updated_at": "2025-05-29T20:04:58.000000Z"
        },
        ...
    ]
}
                </pre>
            </div>

            <!-- Get Single Product -->
            <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                <h3 class="text-xl font-semibold mb-4">Get Single Product</h3>
                <p class="mb-4"><span class="font-semibold">Endpoint:</span> <code class="bg-gray-100 px-2 py-1 rounded">GET /api/products/{id}</code></p>
                <p class="mb-4"><span class="font-semibold">Description:</span> Returns details of a specific product</p>
                <p class="mb-4"><span class="font-semibold">Response:</span></p>
                <pre class="bg-gray-100 p-4 rounded-lg">
{
    "success": true,
    "data": {
        "id": 1,
        "name": "Margherita Pizza",
        "description": "Classic cheese pizza with tomato sauce",
        "price": 9.99,
        "image_url": "https://example.com/pizza.jpg",
        "veg": "Yes",
        "featured": "Yes",
        "created_at": "2025-05-29T20:04:58.000000Z",
        "updated_at": "2025-05-29T20:04:58.000000Z"
    }
}
                </pre>
            </div>

            <!-- Create Product (Admin Only) -->
            <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                <h3 class="text-xl font-semibold mb-4">Create Product (Admin Only)</h3>
                <p class="mb-4"><span class="font-semibold">Endpoint:</span> <code class="bg-gray-100 px-2 py-1 rounded">POST /api/products</code></p>
                <p class="mb-4"><span class="font-semibold">Description:</span> Creates a new product (requires admin privileges)</p>
                <p class="mb-4"><span class="font-semibold">Request Body:</span></p>
                <pre class="bg-gray-100 p-4 rounded-lg mb-4">
{
    "name": "New Pizza",
    "description": "Delicious new pizza",
    "price": 12.99,
    "image_url": "https://example.com/new-pizza.jpg",
    "veg": "Yes",
    "featured": "No"
}
                </pre>
                <p class="mb-4"><span class="font-semibold">Response:</span></p>
                <pre class="bg-gray-100 p-4 rounded-lg">
{
    "success": true,
    "message": "Product created successfully",
    "data": {
        "id": 2,
        "name": "New Pizza",
        "description": "Delicious new pizza",
        "price": 12.99,
        "image_url": "https://example.com/new-pizza.jpg",
        "veg": "Yes",
        "featured": "No",
        "created_at": "2025-05-30T02:04:58.000000Z",
        "updated_at": "2025-05-30T02:04:58.000000Z"
    }
}
                </pre>
            </div>

            <!-- Update Product (Admin Only) -->
            <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                <h3 class="text-xl font-semibold mb-4">Update Product (Admin Only)</h3>
                <p class="mb-4"><span class="font-semibold">Endpoint:</span> <code class="bg-gray-100 px-2 py-1 rounded">PUT /api/products/{id}</code></p>
                <p class="mb-4"><span class="font-semibold">Description:</span> Updates an existing product (requires admin privileges)</p>
                <p class="mb-4"><span class="font-semibold">Request Body:</span></p>
                <pre class="bg-gray-100 p-4 rounded-lg mb-4">
{
    "name": "Updated Pizza",
    "price": 14.99,
    "featured": "Yes"
}
                </pre>
                <p class="mb-4"><span class="font-semibold">Response:</span></p>
                <pre class="bg-gray-100 p-4 rounded-lg">
{
    "success": true,
    "message": "Product updated successfully",
    "data": {
        "id": 2,
        "name": "Updated Pizza",
        "description": "Delicious new pizza",
        "price": 14.99,
        "image_url": "https://example.com/new-pizza.jpg",
        "veg": "Yes",
        "featured": "Yes",
        "created_at": "2025-05-30T02:04:58.000000Z",
        "updated_at": "2025-05-30T02:05:30.000000Z"
    }
}
                </pre>
            </div>

            <!-- Delete Product (Admin Only) -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="text-xl font-semibold mb-4">Delete Product (Admin Only)</h3>
                <p class="mb-4"><span class="font-semibold">Endpoint:</span> <code class="bg-gray-100 px-2 py-1 rounded">DELETE /api/products/{id}</code></p>
                <p class="mb-4"><span class="font-semibold">Description:</span> Deletes a product (requires admin privileges)</p>
                <p class="mb-4"><span class="font-semibold">Response:</span></p>
                <pre class="bg-gray-100 p-4 rounded-lg">
{
    "success": true,
    "message": "Product deleted successfully"
}
                </pre>
            </div>
        </div>
    </div>
</div>
@endsection
