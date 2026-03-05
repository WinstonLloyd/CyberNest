<?php
// Test script to verify user challenges API works
require_once 'backend/api/challenges.php';

echo "Testing User Challenges API\n";
echo "========================\n\n";

// Test getAll action
echo "1. Testing getAll action:\n";
$ch_url = 'http://localhost/backend/api/challenges.php?action=getAll';
$ch_response = file_get_contents($ch_url);
echo "Response: " . $ch_response . "\n\n";

// Test submitFlag action (with known challenge)
echo "2. Testing submitFlag action:\n";
$submit_data = [
    'challenge_id' => 1,
    'flag' => 'CYBERNEST{buffer_overflow_master}'
];

$options = [
    'http' => [
        'header'  => "Content-Type: application/json\r\n",
        'method'  => 'POST',
        'content' => json_encode($submit_data)
    ]
];

$context = stream_context_create($options);
$submit_url = 'http://localhost/backend/api/challenges.php?action=submitFlag';
$submit_response = file_get_contents($submit_url, false, $context);
echo "Response: " . $submit_response . "\n\n";

echo "Test completed!\n";
?>
