<?php
// Direct API test file to bypass Laravel routing
header('Content-Type: application/json');

echo json_encode([
    'success' => true,
    'message' => 'API test endpoint is working directly',
    'time' => date('Y-m-d H:i:s'),
    'server' => $_SERVER['SERVER_NAME'],
    'request_uri' => $_SERVER['REQUEST_URI']
]);
