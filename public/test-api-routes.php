<?php
// This script tests API endpoints directly without relying on Laravel's routing system

// Set up basic variables
$baseUrl = 'http://localhost/ssp-sem2/public/index.php/api';
$results = [];

// Function to test an endpoint
function testEndpoint($url, $method = 'GET', $data = null, $token = null) {
    global $baseUrl;
    $fullUrl = $baseUrl . $url;
    
    $ch = curl_init($fullUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
    
    $headers = ['Accept: application/json'];
    
    if ($token) {
        $headers[] = 'Authorization: Bearer ' . $token;
    }
    
    if ($data && ($method === 'POST' || $method === 'PUT')) {
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        $headers[] = 'Content-Type: application/json';
    }
    
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $error = curl_error($ch);
    curl_close($ch);
    
    return [
        'url' => $fullUrl,
        'method' => $method,
        'status' => $httpCode,
        'response' => $response ? substr($response, 0, 500) : null,
        'error' => $error
    ];
}

// Test public endpoints
$results[] = testEndpoint('/products');
$results[] = testEndpoint('/products/1');
$results[] = testEndpoint('/test');

// Output results in a readable format
echo '<html><head><title>API Test Results</title>';
echo '<style>
    body { font-family: Arial, sans-serif; margin: 20px; }
    h1 { color: #333; }
    .endpoint { margin-bottom: 20px; border: 1px solid #ddd; padding: 15px; border-radius: 5px; }
    .success { background-color: #d4edda; }
    .error { background-color: #f8d7da; }
    .neutral { background-color: #e2e3e5; }
    pre { background: #f4f4f4; padding: 10px; overflow: auto; }
</style>';
echo '</head><body>';
echo '<h1>API Endpoint Test Results</h1>';

foreach ($results as $result) {
    $class = 'neutral';
    if ($result['status'] >= 200 && $result['status'] < 300) {
        $class = 'success';
    } else if ($result['status'] >= 400) {
        $class = 'error';
    }
    
    echo "<div class='endpoint {$class}'>";
    echo "<h3>{$result['method']} {$result['url']}</h3>";
    echo "<p>Status Code: {$result['status']}</p>";
    
    if ($result['error']) {
        echo "<p>Error: {$result['error']}</p>";
    }
    
    if ($result['response']) {
        echo "<p>Response:</p>";
        echo "<pre>" . htmlspecialchars($result['response']) . "</pre>";
    }
    
    echo "</div>";
}

echo '</body></html>';
