<?php
// Simple test to check if challenges API is working
echo "Testing Challenges API\n";
echo "====================\n";

// Test by including the API directly
$_GET['action'] = 'getAll';

// Capture output
ob_start();
include 'backend/api/challenges.php';
$output = ob_get_clean();

echo "API Response: " . $output . "\n";
?>
