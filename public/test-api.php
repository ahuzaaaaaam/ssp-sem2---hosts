<?php

// Simple script to test API endpoints directly

$baseUrl = 'http://localhost:8000/api';

// Test GET /api/products
$ch = curl_init("$baseUrl/products");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

echo "Testing GET /api/products\n";
echo "HTTP Status: $httpCode\n";
echo "Response: " . substr($response, 0, 200) . "...\n\n";

// Test GET /api/products/1
$ch = curl_init("$baseUrl/products/1");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

echo "Testing GET /api/products/1\n";
echo "HTTP Status: $httpCode\n";
echo "Response: " . substr($response, 0, 200) . "...\n\n";

// Test POST /api/tokens (authentication)
$data = json_encode([
    'email' => 'admin@example.com',
    'password' => 'password',
    'device_name' => 'test-script'
]);

$ch = curl_init("$baseUrl/tokens");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Content-Type: application/json',
    'Accept: application/json'
]);
$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

echo "Testing POST /api/tokens\n";
echo "HTTP Status: $httpCode\n";
echo "Response: " . substr($response, 0, 200) . "...\n";
