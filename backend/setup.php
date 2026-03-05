<?php
/**
 * Database Setup Script for CyberNest
 * Run this script once to create the database and tables
 */

require_once __DIR__ . '/config/database.php';

echo "<h1>CyberNest Database Setup</h1>";

try {
    $database = new Database();
    $conn = $database->getConnection();
    
    if ($conn) {
        echo "<p style='color: green;'>✓ Database connection successful</p>";
        
        // Create database if it doesn't exist
        $conn->exec("CREATE DATABASE IF NOT EXISTS cybernest");
        $conn->exec("USE cybernest");
        
        // Create tables
        $database->createTables();
        
        echo "<p style='color: green;'>✓ Database tables created successfully</p>";
        
        // Check if tables exist
        $tables = ['users', 'user_sessions'];
        foreach ($tables as $table) {
            $result = $conn->query("SHOW TABLES LIKE '$table'");
            if ($result->rowCount() > 0) {
                echo "<p style='color: green;'>✓ Table '$table' exists</p>";
            } else {
                echo "<p style='color: red;'>✗ Table '$table' missing</p>";
            }
        }
        
        echo "<h2>Setup Complete!</h2>";
        echo "<p>Your CyberNest backend is ready to use.</p>";
        echo "<p><a href='../index.php'>Go to Login Page</a></p>";
        
    } else {
        echo "<p style='color: red;'>✗ Database connection failed</p>";
        echo "<p>Please check your database configuration in backend/config/database.php</p>";
    }
    
} catch (Exception $e) {
    echo "<p style='color: red;'>Error: " . $e->getMessage() . "</p>";
    echo "<p>Please make sure:</p>";
    echo "<ul>";
    echo "<li>MySQL/XAMPP is running</li>";
    echo "<li>Database credentials are correct in backend/config/database.php</li>";
    echo "<li>The database user has CREATE privileges</li>";
    echo "</ul>";
}
?>
