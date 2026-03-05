<?php
/**
 * Database Configuration for CyberNest
 */

class Database {
    private $host = 'localhost';
    private $db_name = 'cybernest';
    private $username = 'root';
    private $password = '';
    private $conn;

    public function getConnection() {
        $this->conn = null;

        try {
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->conn->exec("set names utf8");
        } catch(PDOException $exception) {
            // Don't output HTML error, just throw exception
            throw new Exception("Database connection failed: " . $exception->getMessage());
        }

        return $this->conn;
    }

    public function createTables() {
        try {
            $conn = $this->getConnection();
            
            // Create database if it doesn't exist
            $conn->exec("CREATE DATABASE IF NOT EXISTS " . $this->db_name);
            $conn->exec("USE " . $this->db_name);
            
            // Check if users table exists and has correct structure
            $users_table_exists = false;
            $profiles_table_exists = false;
            $correct_structure = false;
            
            try {
                $result = $conn->query("DESCRIBE users");
                if ($result->rowCount() > 0) {
                    $users_table_exists = true;
                    
                    // Check if required columns exist
                    $columns = [];
                    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                        $columns[] = $row['Field'];
                    }
                    
                    // Check for both password_hash and role columns
                    if (in_array('password_hash', $columns) && in_array('role', $columns)) {
                        $correct_structure = true;
                    }
                }
                
                // Check if user_profiles table exists
                try {
                    $result = $conn->query("DESCRIBE user_profiles");
                    if ($result->rowCount() > 0) {
                        $profiles_table_exists = true;
                    }
                } catch (Exception $e) {
                    // Table doesn't exist
                }
            } catch (Exception $e) {
                // Table doesn't exist, will create it
            }
            
            // Only drop and recreate if structure is incorrect
            if ($users_table_exists && !$correct_structure) {
                $conn->exec("DROP TABLE IF EXISTS user_sessions");
                $conn->exec("DROP TABLE IF EXISTS user_profiles");
                $conn->exec("DROP TABLE IF EXISTS users");
                $profiles_table_exists = false;
            }
            
            // Create users table only if it doesn't exist or was dropped
            if (!$users_table_exists || !$correct_structure) {
                $sql = "CREATE TABLE users (
                    id INT(11) AUTO_INCREMENT PRIMARY KEY,
                    username VARCHAR(50) UNIQUE NOT NULL,
                    email VARCHAR(100) UNIQUE NOT NULL,
                    password_hash VARCHAR(255) NOT NULL,
                    display_name VARCHAR(100),
                    role ENUM('admin', 'user') DEFAULT 'user' NOT NULL,
                    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                    is_active BOOLEAN DEFAULT TRUE,
                    last_login TIMESTAMP NULL
                )";
                
                $conn->exec($sql);
                
                // Create user profiles table for statistics
                $sql = "CREATE TABLE user_profiles (
                    user_id INT(11) PRIMARY KEY,
                    points INT(11) DEFAULT 0,
                    challenges_completed INT(11) DEFAULT 0,
                    rank VARCHAR(20) DEFAULT 'N/A',
                    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
                )";
                
                $conn->exec($sql);
                
                // Create sessions table
                $sql = "CREATE TABLE user_sessions (
                    id INT(11) AUTO_INCREMENT PRIMARY KEY,
                    user_id INT(11) NOT NULL,
                    session_token VARCHAR(255) UNIQUE NOT NULL,
                    expires_at TIMESTAMP NOT NULL,
                    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
                )";
                
                $conn->exec($sql);
                
                // Auto-insert admin account
                $username = 'CyberNest';
                $email = 'admin@cybernest.local';
                $password = 'admin123';
                $password_hash = password_hash($password, PASSWORD_DEFAULT);
                $display_name = 'System Administrator';
                $role = 'admin';
                
                $stmt = $conn->prepare("INSERT INTO users (username, email, password_hash, display_name, role) VALUES (?, ?, ?, ?, ?)");
                $stmt->execute([$username, $email, $password_hash, $display_name, $role]);
                
                // Create admin profile
                $admin_id = $conn->lastInsertId();
                $stmt = $conn->prepare("INSERT INTO user_profiles (user_id, points, challenges_completed, rank) VALUES (?, ?, ?, ?)");
                $stmt->execute([$admin_id, 10000, 50, 'Admin']);
            } elseif (!$profiles_table_exists) {
                // Create only user_profiles table if it doesn't exist
                $sql = "CREATE TABLE user_profiles (
                    user_id INT(11) PRIMARY KEY,
                    points INT(11) DEFAULT 0,
                    challenges_completed INT(11) DEFAULT 0,
                    rank VARCHAR(20) DEFAULT 'N/A',
                    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
                )";
                
                $conn->exec($sql);
                
                // Create profiles for existing users
                $stmt = $conn->query("SELECT id FROM users WHERE role != 'admin'");
                $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
                
                foreach ($users as $user) {
                    $stmt = $conn->prepare("INSERT INTO user_profiles (user_id) VALUES (?)");
                    $stmt->execute([$user['id']]);
                }
            }
        } catch (Exception $e) {
            throw new Exception("Failed to create tables: " . $e->getMessage());
        }
    }
}
?>
