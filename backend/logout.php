<?php
/**
 * Logout API Endpoint for CyberNest
 */

// Enable error reporting but prevent HTML output
error_reporting(E_ALL);
ini_set('display_errors', 0);

// Start session
session_start();

// Start output buffering to catch any unwanted output
ob_start();

try {
    // Clear session cookie
    if (isset($_COOKIE['cybernest_session'])) {
        unset($_COOKIE['cybernest_session']);
        setcookie('cybernest_session', '', time() - 3600, '/'); // Empty value and expiration in the past
    }
    
    // Clear session data
    session_destroy();
    
    // Remove session from database
    require_once __DIR__ . '/config/database.php';
    $database = new Database();
    $conn = $database->getConnection();
    
    if ($conn && isset($_COOKIE['cybernest_session'])) {
        $stmt = $conn->prepare("DELETE FROM user_sessions WHERE session_token = ?");
        $stmt->execute([$_COOKIE['cybernest_session']]);
    }
    
    // Send success response
    header('Content-Type: application/json');
    echo json_encode([
        'success' => true,
        'message' => 'Logged out successfully'
    ]);
    
} catch (Exception $e) {
    // Clean any output that might have been generated
    ob_clean();
    
    // Send JSON error response
    header('Content-Type: application/json');
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Logout error: ' . $e->getMessage()
    ]);
}

// Clean output buffer
ob_end_flush();
?>
