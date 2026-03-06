<?php
error_reporting(E_ALL);
ini_set('display_errors', 0);

ob_start();

try {
    require_once __DIR__ . '/../controllers/SettingsController.php';
    $settingsController = new SettingsController();
    $settingsController->handleRequest();
} catch (Exception $e) {
    ob_clean();
    
    header('Content-Type: application/json');
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Server error: ' . $e->getMessage()
    ]);
}

ob_end_flush();
?>
