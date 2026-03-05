<?php
/**
 * Login API Endpoint for CyberNest
 */

// Enable error reporting but prevent HTML output
error_reporting(E_ALL);
ini_set('display_errors', 0);

// Start output buffering to catch any unwanted output
ob_start();

try {
    require_once __DIR__ . '/controllers/AuthController.php';
    $auth = new AuthController();
    $auth->handleRequest();
} catch (Exception $e) {
    // Clean any output that might have been generated
    ob_clean();
    
    // Send JSON error response
    header('Content-Type: application/json');
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Server error: ' . $e->getMessage()
    ]);
}

// Clean output buffer
ob_end_flush();
?>
