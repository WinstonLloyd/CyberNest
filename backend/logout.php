<?php
error_reporting(E_ALL);
ini_set('display_errors', 0);

session_start();

ob_start();

try {
    if (isset($_COOKIE['cybernest_session'])) {
        unset($_COOKIE['cybernest_session']);
        setcookie('cybernest_session', '', time() - 3600, '/');
    }
    
    session_destroy();
    
    require_once __DIR__ . '/config/database.php';
    $database = new Database();
    $conn = $database->getConnection();
    
    if ($conn && isset($_COOKIE['cybernest_session'])) {
        $stmt = $conn->prepare("DELETE FROM user_sessions WHERE session_token = ?");
        $stmt->execute([$_COOKIE['cybernest_session']]);
    }
    
    header('Content-Type: application/json');
    echo json_encode([
        'success' => true,
        'message' => 'Logged out successfully'
    ]);
    
} catch (Exception $e) {
    ob_clean();
    
    header('Content-Type: application/json');
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Logout error: ' . $e->getMessage()
    ]);
}

ob_end_flush();
?>
