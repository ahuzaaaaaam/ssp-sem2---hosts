# PizzApp API Documentation

## Overview

This document provides documentation for the PizzApp API. The API allows you to interact with products, manage authentication, and log user activities.

## Base URL

All API endpoints are prefixed with `/api`. For local development, the base URL is:

```
http://localhost:8000/api
```

## Authentication

The API uses Laravel Sanctum for token-based authentication. To access protected endpoints, you need to include the token in the Authorization header:

```
Authorization: Bearer YOUR_API_TOKEN
```

### Obtaining a Token

**Endpoint:** `POST /api/tokens`

**Request Body:**
```json
{
  "email": "user@example.com",
  "password": "your_password",
  "device_name": "device_description"
}
```

**Response:**
```json
{
  "success": true,
  "token": "YOUR_API_TOKEN"
}
```

### Revoking All Tokens

**Endpoint:** `DELETE /api/tokens`

**Headers:**
- Authorization: Bearer YOUR_API_TOKEN

**Response:**
```json
{
  "success": true,
  "message": "All tokens revoked successfully"
}
```

### Revoking a Specific Token

**Endpoint:** `DELETE /api/tokens/{tokenId}`

**Headers:**
- Authorization: Bearer YOUR_API_TOKEN

**Response:**
```json
{
  "success": true,
  "message": "Token revoked successfully"
}
```

## Products

### Get All Products

**Endpoint:** `GET /api/products`

**Response:**
```json
{
  "success": true,
  "data": [
    {
      "id": 1,
      "name": "Margherita",
      "description": "Classic cheese pizza",
      "price": 9.99,
      "image": "margherita.jpg",
      "created_at": "2025-01-01T00:00:00.000000Z",
      "updated_at": "2025-01-01T00:00:00.000000Z"
    },
    // More products...
  ]
}
```

### Get a Specific Product

**Endpoint:** `GET /api/products/{id}`

**Response:**
```json
{
  "success": true,
  "data": {
    "id": 1,
    "name": "Margherita",
    "description": "Classic cheese pizza",
    "price": 9.99,
    "image": "margherita.jpg",
    "created_at": "2025-01-01T00:00:00.000000Z",
    "updated_at": "2025-01-01T00:00:00.000000Z"
  }
}
```

## Activity Logging

### Log a Product Activity

**Endpoint:** `POST /api/product-activity`

**Request Body:**
```json
{
  "activity": "view",
  "product_id": 1
}
```

Valid activity types:
- `view` - User viewed a product
- `add_to_cart` - User added product to cart
- `purchase` - User purchased a product
- `login` - User logged in
- `logout` - User logged out
- `page_visit` - User visited a page
- `wishlist_add` - User added product to wishlist
- `search` - User performed a search
- `review` - User reviewed a product

For login/logout activities, `product_id` can be null.

**Response:**
```json
{
  "success": true,
  "message": "Activity logged successfully",
  "data": {
    "user_id": 1,
    "product_id": 1,
    "activity": "view",
    "ip": "127.0.0.1",
    "user_agent": "Mozilla/5.0...",
    "created_at": "2025-06-02T14:00:00.000000Z"
  }
}
```

### Get Most Viewed Products

**Endpoint:** `GET /api/product-activity/most-viewed`

**Response:**
```json
{
  "success": true,
  "data": [
    {
      "_id": "1",
      "views": 10
    },
    {
      "_id": "2",
      "views": 8
    },
    // More products...
  ]
}
```

## Protected User Endpoints

These endpoints require authentication with a valid API token.

### Get Current User

**Endpoint:** `GET /api/user`

**Headers:**
- Authorization: Bearer YOUR_API_TOKEN

**Response:**
```json
{
  "id": 1,
  "name": "John Doe",
  "email": "john@example.com",
  "email_verified_at": "2025-01-01T00:00:00.000000Z",
  "created_at": "2025-01-01T00:00:00.000000Z",
  "updated_at": "2025-01-01T00:00:00.000000Z"
}
```

## Error Responses

The API returns appropriate HTTP status codes along with error messages:

- `400 Bad Request` - The request was malformed
- `401 Unauthorized` - Authentication failed
- `403 Forbidden` - The authenticated user doesn't have permission
- `404 Not Found` - The requested resource was not found
- `422 Unprocessable Entity` - Validation errors
- `500 Server Error` - An unexpected error occurred

Example error response:
```json
{
  "success": false,
  "message": "Error message",
  "errors": {
    "field": [
      "Error description"
    ]
  }
}
```

## Testing the API

You can test the API using tools like Postman, cURL, or any HTTP client. For example, to test the products endpoint using cURL:

```bash
curl -X GET http://localhost:8000/api/products
```

To test authenticated endpoints:

```bash
curl -X GET \
  http://localhost:8000/api/user \
  -H 'Authorization: Bearer YOUR_API_TOKEN'
```
