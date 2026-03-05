<?php
/**
 * User Management Controller for CyberNest Admin
 */

require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../config/database.php';

class UserController {
    private $user;
    private $db;
    private $init_error = null;

    public function __construct() {
        try {
            $database = new Database();
            $this->db = $database->getConnection();
            $this->user = new User($this->db);
        } catch (Exception $e) {
            $this->init_error = $e->getMessage();
        }
    }

    public function handleRequest() {
        header('Content-Type: application/json');
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
        header('Access-Control-Allow-Headers: Content-Type');

        if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
            exit(0);
        }

        if ($this->init_error) {
            $this->sendResponse([
                'success' => false, 
                'message' => 'Database initialization failed: ' . $this->init_error
            ], 500);
            return;
        }

        $action = $_GET['action'] ?? '';
        $endpoint = basename($_SERVER['PHP_SELF'], '.php');

        switch ($action) {
            case 'getAll':
                $this->getAllUsers();
                break;
            case 'getById':
                $this->getUserById();
                break;
            case 'create':
                $this->createUser();
                break;
            case 'update':
                $this->updateUser();
                break;
            case 'delete':
                $this->deleteUser();
                break;
            case 'ban':
                $this->banUser();
                break;
            case 'unban':
                $this->unbanUser();
                break;
            case 'changeRole':
                $this->changeUserRole();
                break;
            case 'stats':
                $this->getUserStats();
                break;
            default:
                $this->sendResponse(['success' => false, 'message' => 'Invalid action'], 404);
        }
    }

    private function getAllUsers() {
        try {
            $query = "SELECT id, username, email, display_name, role, is_active, created_at, last_login 
                      FROM users 
                      WHERE role != 'admin'
                      ORDER BY created_at DESC";
            
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            
            $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            // Add computed fields
            foreach ($users as &$user) {
                $user['status'] = $this->getUserStatus($user);
                $user['avatar'] = $this->generateAvatar($user['display_name']);
            }
            
            $this->sendResponse(['success' => true, 'users' => $users]);
        } catch (Exception $e) {
            $this->sendResponse(['success' => false, 'message' => 'Failed to fetch users: ' . $e->getMessage()], 500);
        }
    }

    private function getUserById() {
        $userId = $_GET['id'] ?? '';
        
        if (empty($userId)) {
            $this->sendResponse(['success' => false, 'message' => 'User ID required'], 400);
            return;
        }

        try {
            $query = "SELECT id, username, email, display_name, role, is_active, created_at, last_login 
                      FROM users 
                      WHERE id = :id 
                      LIMIT 1";
            
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':id', $userId);
            $stmt->execute();
            
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if ($user) {
                $user['status'] = $this->getUserStatus($user);
                $user['avatar'] = $this->generateAvatar($user['display_name']);
                $this->sendResponse(['success' => true, 'user' => $user]);
            } else {
                $this->sendResponse(['success' => false, 'message' => 'User not found'], 404);
            }
        } catch (Exception $e) {
            $this->sendResponse(['success' => false, 'message' => 'Failed to fetch user: ' . $e->getMessage()], 500);
        }
    }

    private function createUser() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->sendResponse(['success' => false, 'message' => 'Method not allowed'], 405);
            return;
        }

        $data = json_decode(file_get_contents('php://input'), true);

        if (!$data || !isset($data['username']) || !isset($data['email']) || !isset($data['password'])) {
            $this->sendResponse(['success' => false, 'message' => 'Missing required fields'], 400);
            return;
        }

        try {
            // Check if user exists
            if ($this->user->userExists($data['username'], $data['email'])) {
                $this->sendResponse(['success' => false, 'message' => 'Username or email already exists'], 400);
                return;
            }

            // Create user
            $result = $this->user->register(
                $data['username'],
                $data['email'],
                $data['password'],
                $data['display_name'] ?? $data['username']
            );

            if ($result['success']) {
                // Update role if specified
                if (isset($data['role']) && $data['role'] !== 'user') {
                    $this->updateUserRole($result['user_id'], $data['role']);
                }

                // Update status if specified
                if (isset($data['is_active']) && !$data['is_active']) {
                    $this->updateUserStatus($result['user_id'], false);
                }

                $this->sendResponse(['success' => true, 'message' => 'User created successfully']);
            } else {
                $this->sendResponse($result);
            }
        } catch (Exception $e) {
            $this->sendResponse(['success' => false, 'message' => 'Failed to create user: ' . $e->getMessage()], 500);
        }
    }

    private function updateUser() {
        if ($_SERVER['REQUEST_METHOD'] !== 'PUT') {
            $this->sendResponse(['success' => false, 'message' => 'Method not allowed'], 405);
            return;
        }

        $userId = $_GET['id'] ?? '';
        $data = json_decode(file_get_contents('php://input'), true);

        if (empty($userId) || !$data) {
            $this->sendResponse(['success' => false, 'message' => 'User ID and data required'], 400);
            return;
        }

        try {
            $updates = [];
            $params = [];

            if (isset($data['display_name'])) {
                $updates[] = "display_name = :display_name";
                $params[':display_name'] = $data['display_name'];
            }

            if (isset($data['email'])) {
                $updates[] = "email = :email";
                $params[':email'] = $data['email'];
            }

            if (isset($data['role'])) {
                $updates[] = "role = :role";
                $params[':role'] = $data['role'];
            }

            if (isset($data['is_active'])) {
                $updates[] = "is_active = :is_active";
                $params[':is_active'] = $data['is_active'];
            }

            if (isset($data['password']) && !empty($data['password'])) {
                $updates[] = "password_hash = :password_hash";
                $params[':password_hash'] = password_hash($data['password'], PASSWORD_DEFAULT);
            }

            if (empty($updates)) {
                $this->sendResponse(['success' => false, 'message' => 'No valid fields to update'], 400);
                return;
            }

            $updates[] = "updated_at = CURRENT_TIMESTAMP";
            $params[':id'] = $userId;

            $sql = "UPDATE users SET " . implode(', ', $updates) . " WHERE id = :id";
            $stmt = $this->db->prepare($sql);
            
            foreach ($params as $key => $value) {
                $stmt->bindValue($key, $value);
            }

            if ($stmt->execute()) {
                $this->sendResponse(['success' => true, 'message' => 'User updated successfully']);
            } else {
                $this->sendResponse(['success' => false, 'message' => 'Failed to update user'], 500);
            }
        } catch (Exception $e) {
            $this->sendResponse(['success' => false, 'message' => 'Failed to update user: ' . $e->getMessage()], 500);
        }
    }

    private function deleteUser() {
        if ($_SERVER['REQUEST_METHOD'] !== 'DELETE') {
            $this->sendResponse(['success' => false, 'message' => 'Method not allowed'], 405);
            return;
        }

        $userId = $_GET['id'] ?? '';

        if (empty($userId)) {
            $this->sendResponse(['success' => false, 'message' => 'User ID required'], 400);
            return;
        }

        try {
            // Don't allow deletion of admin users
            $checkQuery = "SELECT role FROM users WHERE id = :id LIMIT 1";
            $stmt = $this->db->prepare($checkQuery);
            $stmt->bindParam(':id', $userId);
            $stmt->execute();
            
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if ($user && $user['role'] === 'admin') {
                $this->sendResponse(['success' => false, 'message' => 'Cannot delete admin users'], 403);
                return;
            }

            // Delete user
            $query = "DELETE FROM users WHERE id = :id";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':id', $userId);
            
            if ($stmt->execute()) {
                $this->sendResponse(['success' => true, 'message' => 'User deleted successfully']);
            } else {
                $this->sendResponse(['success' => false, 'message' => 'Failed to delete user'], 500);
            }
        } catch (Exception $e) {
            $this->sendResponse(['success' => false, 'message' => 'Failed to delete user: ' . $e->getMessage()], 500);
        }
    }

    private function banUser() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->sendResponse(['success' => false, 'message' => 'Method not allowed'], 405);
            return;
        }

        $userId = $_GET['id'] ?? '';

        if (empty($userId)) {
            $this->sendResponse(['success' => false, 'message' => 'User ID required'], 400);
            return;
        }

        try {
            $this->updateUserStatus($userId, false);
            $this->sendResponse(['success' => true, 'message' => 'User banned successfully']);
        } catch (Exception $e) {
            $this->sendResponse(['success' => false, 'message' => 'Failed to ban user: ' . $e->getMessage()], 500);
        }
    }

    private function unbanUser() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->sendResponse(['success' => false, 'message' => 'Method not allowed'], 405);
            return;
        }

        $userId = $_GET['id'] ?? '';

        if (empty($userId)) {
            $this->sendResponse(['success' => false, 'message' => 'User ID required'], 400);
            return;
        }

        try {
            $this->updateUserStatus($userId, true);
            $this->sendResponse(['success' => true, 'message' => 'User unbanned successfully']);
        } catch (Exception $e) {
            $this->sendResponse(['success' => false, 'message' => 'Failed to unban user: ' . $e->getMessage()], 500);
        }
    }

    private function changeUserRole() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->sendResponse(['success' => false, 'message' => 'Method not allowed'], 405);
            return;
        }

        $userId = $_GET['id'] ?? '';
        $data = json_decode(file_get_contents('php://input'), true);

        if (empty($userId) || !isset($data['role'])) {
            $this->sendResponse(['success' => false, 'message' => 'User ID and role required'], 400);
            return;
        }

        try {
            $this->updateUserRole($userId, $data['role']);
            $this->sendResponse(['success' => true, 'message' => 'User role updated successfully']);
        } catch (Exception $e) {
            $this->sendResponse(['success' => false, 'message' => 'Failed to update user role: ' . $e->getMessage()], 500);
        }
    }

    private function getUserStats() {
        try {
            $stats = [];
            
            // Total users (excluding admins)
            $stmt = $this->db->query("SELECT COUNT(*) as total FROM users WHERE role != 'admin'");
            $stats['total_users'] = $stmt->fetch(PDO::FETCH_ASSOC)['total'];
            
            // Active users (excluding admins)
            $stmt = $this->db->query("SELECT COUNT(*) as active FROM users WHERE is_active = 1 AND role != 'admin'");
            $stats['active_users'] = $stmt->fetch(PDO::FETCH_ASSOC)['active'];
            
            // Users by role (excluding admins)
            $stmt = $this->db->query("SELECT role, COUNT(*) as count FROM users WHERE role != 'admin' GROUP BY role");
            $stats['by_role'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            // Recent registrations (last 24 hours, excluding admins)
            $stmt = $this->db->query("SELECT COUNT(*) as recent FROM users WHERE created_at > DATE_SUB(NOW(), INTERVAL 24 HOUR) AND role != 'admin'");
            $stats['recent_registrations'] = $stmt->fetch(PDO::FETCH_ASSOC)['recent'];
            
            $this->sendResponse(['success' => true, 'stats' => $stats]);
        } catch (Exception $e) {
            $this->sendResponse(['success' => false, 'message' => 'Failed to fetch stats: ' . $e->getMessage()], 500);
        }
    }

    private function updateUserStatus($userId, $isActive) {
        $query = "UPDATE users SET is_active = :is_active, updated_at = CURRENT_TIMESTAMP WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':is_active', $isActive, PDO::PARAM_BOOL);
        $stmt->bindParam(':id', $userId);
        $stmt->execute();
    }

    private function updateUserRole($userId, $role) {
        $query = "UPDATE users SET role = :role, updated_at = CURRENT_TIMESTAMP WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':role', $role);
        $stmt->bindParam(':id', $userId);
        $stmt->execute();
    }

    private function getUserStatus($user) {
        if (!$user['is_active']) {
            return 'banned';
        }
        
        // Check if user is online (has recent session)
        $query = "SELECT COUNT(*) as count FROM user_sessions 
                  WHERE user_id = :user_id AND expires_at > NOW() 
                  LIMIT 1";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':user_id', $user['id']);
        $stmt->execute();
        
        $hasSession = $stmt->fetch(PDO::FETCH_ASSOC)['count'] > 0;
        
        return $hasSession ? 'online' : 'offline';
    }

    private function generateAvatar($displayName) {
        $names = explode(' ', $displayName);
        $initials = '';
        
        foreach ($names as $name) {
            if (!empty($name)) {
                $initials .= strtoupper(substr($name, 0, 1));
            }
        }
        
        return substr($initials, 0, 2);
    }

    private function sendResponse($data, $http_code = 200) {
        http_response_code($http_code);
        echo json_encode($data);
        exit;
    }
}
?>
