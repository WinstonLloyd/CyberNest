<?php
/**
 * User Model for CyberNest
 */

require_once __DIR__ . '/../config/database.php';

class User {
    private $conn;
    private $table_name = "users";

    public function __construct($db) {
        $this->conn = $db;
    }

    public function login($username, $password) {
        $query = "SELECT id, username, email, password_hash, display_name, role, is_active 
                  FROM " . $this->table_name . " 
                  WHERE username = :username OR email = :username 
                  LIMIT 1";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':username', $username);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if ($row['is_active'] && password_verify($password, $row['password_hash'])) {
                // Update last login
                $this->updateLastLogin($row['id']);
                
                return [
                    'success' => true,
                    'user' => [
                        'id' => $row['id'],
                        'username' => $row['username'],
                        'email' => $row['email'],
                        'display_name' => $row['display_name'],
                        'role' => $row['role']
                    ]
                ];
            }
        }

        return ['success' => false, 'message' => 'Invalid credentials or account inactive'];
    }

    public function register($username, $email, $password, $display_name = null) {
        // Check if user exists
        if ($this->userExists($username, $email)) {
            return ['success' => false, 'message' => 'Username or email already exists'];
        }

        // Hash password
        $password_hash = password_hash($password, PASSWORD_DEFAULT);

        // Insert new user with 'user' role
        $query = "INSERT INTO " . $this->table_name . " 
                  (username, email, password_hash, display_name, role) 
                  VALUES (:username, :email, :password_hash, :display_name, :role)";

        $stmt = $this->conn->prepare($query);
        
        $display_name = $display_name ?: $username;
        $role = 'user'; // Auto-assign user role
        
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password_hash', $password_hash);
        $stmt->bindParam(':display_name', $display_name);
        $stmt->bindParam(':role', $role);

        if ($stmt->execute()) {
            return ['success' => true, 'message' => 'User registered successfully'];
        }

        return ['success' => false, 'message' => 'Registration failed'];
    }

    private function userExists($username, $email) {
        $query = "SELECT id FROM " . $this->table_name . " 
                  WHERE username = :username OR email = :email 
                  LIMIT 1";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        return $stmt->rowCount() > 0;
    }

    private function updateLastLogin($user_id) {
        $query = "UPDATE " . $this->table_name . " 
                  SET last_login = CURRENT_TIMESTAMP 
                  WHERE id = :user_id";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->execute();
    }

    public function createSession($user_id, $remember = false) {
        $session_token = bin2hex(random_bytes(32));
        $expires_at = date('Y-m-d H:i:s', strtotime($remember ? '+30 days' : '+24 hours'));

        $query = "INSERT INTO user_sessions (user_id, session_token, expires_at) 
                  VALUES (:user_id, :session_token, :expires_at)";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->bindParam(':session_token', $session_token);
        $stmt->bindParam(':expires_at', $expires_at);

        if ($stmt->execute()) {
            return $session_token;
        }

        return false;
    }
}
?>
