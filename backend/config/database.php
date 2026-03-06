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

    public static function getInstance() {
        static $instance = null;
        if ($instance === null) {
            $instance = new self();
        }
        return $instance->getConnection();
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
            $challenges_table_exists = false;
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
                
                // Check if challenges table exists
                try {
                    $result = $conn->query("DESCRIBE challenges");
                    if ($result->rowCount() > 0) {
                        $challenges_table_exists = true;
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
                $conn->exec("DROP TABLE IF EXISTS challenge_attempts");
                $conn->exec("DROP TABLE IF EXISTS challenges");
                $conn->exec("DROP TABLE IF EXISTS user_profiles");
                $conn->exec("DROP TABLE IF EXISTS users");
                $profiles_table_exists = false;
                $challenges_table_exists = false;
            }
            
            // Create users table only if it doesn't exist or was dropped
            if (!$users_table_exists || !$correct_structure) {
                $sql = "CREATE TABLE users (
                    id INT(11) AUTO_INCREMENT PRIMARY KEY,
                    username VARCHAR(50) UNIQUE NOT NULL,
                    email VARCHAR(100) UNIQUE NOT NULL,
                    password_hash VARCHAR(255) NOT NULL,
                    display_name VARCHAR(100),
                    bio TEXT,
                    location VARCHAR(255),
                    website VARCHAR(255),
                    profile_picture VARCHAR(255) DEFAULT NULL,
                    role ENUM('admin', 'user') DEFAULT 'user' NOT NULL,
                    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                    is_active BOOLEAN DEFAULT TRUE,
                    last_login TIMESTAMP NULL
                )";
                
                $conn->exec($sql);
                
                // Add profile_picture column if it doesn't exist (for existing databases)
                $column_check = $conn->query("SHOW COLUMNS FROM users LIKE 'profile_picture'");
                if ($column_check->rowCount() == 0) {
                    $conn->exec("ALTER TABLE users ADD COLUMN profile_picture VARCHAR(255) DEFAULT NULL AFTER website");
                }
                
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
                
                // Create challenges table
                $sql = "CREATE TABLE challenges (
                    id INT(11) AUTO_INCREMENT PRIMARY KEY,
                    title VARCHAR(255) NOT NULL,
                    description TEXT,
                    difficulty ENUM('beginner', 'intermediate', 'expert') NOT NULL,
                    points INT(11) NOT NULL DEFAULT 0,
                    category ENUM('web', 'binary', 'crypto', 'forensics', 'reverse') NOT NULL,
                    status ENUM('draft', 'active', 'inactive') NOT NULL DEFAULT 'draft',
                    flag VARCHAR(255),
                    tags VARCHAR(500),
                    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
                )";
                
                $conn->exec($sql);
                
                // Create challenge_attempts table
                $sql = "CREATE TABLE challenge_attempts (
                    id INT(11) AUTO_INCREMENT PRIMARY KEY,
                    user_id INT(11) NOT NULL,
                    challenge_id INT(11) NOT NULL,
                    completed BOOLEAN DEFAULT FALSE,
                    attempt_count INT(11) DEFAULT 1,
                    points INT(11) DEFAULT 0,
                    completed_at TIMESTAMP NULL,
                    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
                    FOREIGN KEY (challenge_id) REFERENCES challenges(id) ON DELETE CASCADE,
                    UNIQUE KEY unique_user_challenge (user_id, challenge_id)
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
                
                // Insert sample challenges
                // $sample_challenges = [
                //     [
                //         'title' => 'Buffer Overflow Basics',
                //         'description' => 'Learn the fundamentals of buffer overflow vulnerabilities. This challenge covers stack-based buffer overflows, memory layout, and basic exploitation techniques.',
                //         'difficulty' => 'beginner',
                //         'points' => 150,
                //         'category' => 'binary',
                //         'status' => 'active',
                //         'tags' => 'buffer-overflow,stack,memory,beginner'
                //     ],
                //     [
                //         'title' => 'SQL Injection Mastery',
                //         'description' => 'Master SQL injection techniques including UNION-based attacks, blind SQL injection, and advanced bypass methods. Test your skills against realistic web applications.',
                //         'difficulty' => 'intermediate',
                //         'points' => 300,
                //         'category' => 'web',
                //         'status' => 'active',
                //         'tags' => 'sql-injection,database,web,intermediate'
                //     ],
                //     [
                //         'title' => 'Advanced ROP Exploitation',
                //         'description' => 'Advanced Return-Oriented Programming (ROP) exploitation techniques. Learn to bypass modern security protections like ASLR and NX using sophisticated ROP chains.',
                //         'difficulty' => 'expert',
                //         'points' => 500,
                //         'category' => 'binary',
                //         'status' => 'active',
                //         'tags' => 'rop,aslr,nx,expert'
                //     ],
                //     [
                //         'title' => 'Web Security Fundamentals',
                //         'description' => 'Introduction to web security vulnerabilities including XSS, CSRF, and basic authentication bypasses. Perfect for beginners starting their cybersecurity journey.',
                //         'difficulty' => 'beginner',
                //         'points' => 100,
                //         'category' => 'web',
                //         'status' => 'draft',
                //         'tags' => 'xss,csrf,web,beginner'
                //     ],
                //     [
                //         'title' => 'Binary Reverse Engineering',
                //         'description' => 'Learn to reverse engineer binary executables. This challenge covers assembly language basics, disassembly tools, and program analysis techniques.',
                //         'difficulty' => 'intermediate',
                //         'points' => 250,
                //         'category' => 'reverse',
                //         'status' => 'inactive',
                //         'tags' => 'reverse-engineering,assembly,binary,intermediate'
                //     ]
                // ];
                
                // foreach ($sample_challenges as $challenge) {
                //     $stmt = $conn->prepare("INSERT INTO challenges (title, description, difficulty, points, category, status, tags) VALUES (?, ?, ?, ?, ?, ?, ?)");
                //     $stmt->execute([
                //         $challenge['title'],
                //         $challenge['description'],
                //         $challenge['difficulty'],
                //         $challenge['points'],
                //         $challenge['category'],
                //         $challenge['status'],
                //         $challenge['tags']
                //     ]);
                // }
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
            
            // Create challenges table if it doesn't exist
            if (!$challenges_table_exists) {
                $sql = "CREATE TABLE challenges (
                    id INT(11) AUTO_INCREMENT PRIMARY KEY,
                    title VARCHAR(255) NOT NULL,
                    description TEXT,
                    difficulty ENUM('beginner', 'intermediate', 'expert') NOT NULL,
                    points INT(11) NOT NULL DEFAULT 0,
                    category ENUM('web', 'binary', 'crypto', 'forensics', 'reverse') NOT NULL,
                    status ENUM('draft', 'active', 'inactive') NOT NULL DEFAULT 'draft',
                    flag VARCHAR(255),
                    tags VARCHAR(500),
                    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
                )";
                
                $conn->exec($sql);
                
                // Create challenge_attempts table
                $sql = "CREATE TABLE challenge_attempts (
                    id INT(11) AUTO_INCREMENT PRIMARY KEY,
                    user_id INT(11) NOT NULL,
                    challenge_id INT(11) NOT NULL,
                    completed BOOLEAN DEFAULT FALSE,
                    attempt_count INT(11) DEFAULT 1,
                    points INT(11) DEFAULT 0,
                    completed_at TIMESTAMP NULL,
                    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
                    FOREIGN KEY (challenge_id) REFERENCES challenges(id) ON DELETE CASCADE,
                    UNIQUE KEY unique_user_challenge (user_id, challenge_id)
                )";
                
                $conn->exec($sql);
                
                // Insert sample challenges
                // $sample_challenges = [
                //     [
                //         'title' => 'Buffer Overflow Basics',
                //         'description' => 'Learn fundamentals of buffer overflow vulnerabilities. This challenge covers stack-based buffer overflows, memory layout, and basic exploitation techniques.',
                //         'difficulty' => 'beginner',
                //         'points' => 150,
                //         'category' => 'binary',
                //         'status' => 'active',
                //         'flag' => 'CYBERNEST{buffer_overflow_master}',
                //         'tags' => 'buffer-overflow,stack,memory,beginner'
                //     ],
                //     [
                //         'title' => 'SQL Injection Mastery',
                //         'description' => 'Master SQL injection techniques including UNION-based attacks, blind SQL injection, and advanced bypass methods. Test your skills against realistic web applications.',
                //         'difficulty' => 'intermediate',
                //         'points' => 300,
                //         'category' => 'web',
                //         'status' => 'active',
                //         'flag' => 'CYBERNEST{sql_injection_expert}',
                //         'tags' => 'sql-injection,database,web,intermediate'
                //     ],
                //     [
                //         'title' => 'Advanced ROP Exploitation',
                //         'description' => 'Advanced Return-Oriented Programming (ROP) exploitation techniques. Learn to bypass modern security protections like ASLR and NX using sophisticated ROP chains.',
                //         'difficulty' => 'expert',
                //         'points' => 500,
                //         'category' => 'binary',
                //         'status' => 'active',
                //         'flag' => 'CYBERNEST{rop_chains_are_fun}',
                //         'tags' => 'rop,aslr,nx,expert'
                //     ],
                //     [
                //         'title' => 'Web Security Fundamentals',
                //         'description' => 'Introduction to web security vulnerabilities including XSS, CSRF, and basic authentication bypasses. Perfect for beginners starting their cybersecurity journey.',
                //         'difficulty' => 'beginner',
                //         'points' => 100,
                //         'category' => 'web',
                //         'status' => 'draft',
                //         'flag' => 'CYBERNEST{web_security_basics}',
                //         'tags' => 'xss,csrf,web,beginner'
                //     ],
                //     [
                //         'title' => 'Binary Reverse Engineering',
                //         'description' => 'Learn to reverse engineer binary executables. This challenge covers assembly language basics, disassembly tools, and program analysis techniques.',
                //         'difficulty' => 'intermediate',
                //         'points' => 250,
                //         'category' => 'reverse',
                //         'status' => 'inactive',
                //         'flag' => 'CYBERNEST{reverse_engineering_pro}',
                //         'tags' => 'reverse-engineering,assembly,binary,intermediate'
                //     ]
                // ];
                
                // foreach ($sample_challenges as $challenge) {
                //     $stmt = $conn->prepare("INSERT INTO challenges (title, description, difficulty, points, category, status, flag, tags) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
                //     $stmt->execute([
                //         $challenge['title'],
                //         $challenge['description'],
                //         $challenge['difficulty'],
                //         $challenge['points'],
                //         $challenge['category'],
                //         $challenge['status'],
                //         $challenge['flag'],
                //         $challenge['tags']
                //     ]);
                // }
            }
        } catch (Exception $e) {
            throw new Exception("Failed to create tables: " . $e->getMessage());
        }
    }
}
?>
