<?php
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
            case 'uploadProfilePicture':
                $this->uploadProfilePicture();
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
            $query = "SELECT u.id, u.username, u.email, u.display_name, u.role, u.is_active, u.created_at, u.last_login,
                             COALESCE(user_points.total_points, 0) as points,
                             COALESCE(user_points.completed_challenges, 0) as challenges_completed,
                             CASE 
                                 WHEN COALESCE(user_points.total_points, 0) >= 1000 THEN 'Expert'
                                 WHEN COALESCE(user_points.total_points, 0) >= 500 THEN 'Advanced'
                                 WHEN COALESCE(user_points.total_points, 0) >= 100 THEN 'Intermediate'
                                 ELSE 'Beginner'
                             END as rank
                      FROM users u
                      LEFT JOIN (
                          SELECT 
                              ca.user_id,
                              SUM(CASE WHEN ca.completed = 1 THEN ca.points ELSE 0 END) as total_points,
                              COUNT(CASE WHEN ca.completed = 1 THEN 1 END) as completed_challenges
                          FROM challenge_attempts ca
                          GROUP BY ca.user_id
                      ) user_points ON u.id = user_points.user_id
                      WHERE u.role != 'admin'
                      ORDER BY points DESC, u.created_at DESC";
            
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            
            $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
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
            $query = "SELECT u.id, u.username, u.email, u.display_name, u.role, u.is_active, u.created_at, u.last_login,
                             COALESCE(user_points.total_points, 0) as points,
                             COALESCE(user_points.completed_challenges, 0) as challenges_completed,
                             CASE 
                                 WHEN COALESCE(user_points.total_points, 0) >= 1000 THEN 'Expert'
                                 WHEN COALESCE(user_points.total_points, 0) >= 500 THEN 'Advanced'
                                 WHEN COALESCE(user_points.total_points, 0) >= 100 THEN 'Intermediate'
                                 ELSE 'Beginner'
                             END as rank
                      FROM users u
                      LEFT JOIN (
                          SELECT 
                              ca.user_id,
                              SUM(CASE WHEN ca.completed = 1 THEN ca.points ELSE 0 END) as total_points,
                              COUNT(CASE WHEN ca.completed = 1 THEN 1 END) as completed_challenges
                          FROM challenge_attempts ca
                          GROUP BY ca.user_id
                      ) user_points ON u.id = user_points.user_id
                      WHERE u.id = :id 
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
            if ($this->user->userExists($data['username'], $data['email'])) {
                $this->sendResponse(['success' => false, 'message' => 'Username or email already exists'], 400);
                return;
            }

            $result = $this->user->register(
                $data['username'],
                $data['email'],
                $data['password'],
                $data['display_name'] ?? $data['username']
            );

            if ($result['success']) {
                if (isset($data['role']) && $data['role'] !== 'user') {
                    $this->updateUserRole($result['user_id'], $data['role']);
                }

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
            $checkQuery = "SELECT role FROM users WHERE id = :id LIMIT 1";
            $stmt = $this->db->prepare($checkQuery);
            $stmt->bindParam(':id', $userId);
            $stmt->execute();
            
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if ($user && $user['role'] === 'admin') {
                $this->sendResponse(['success' => false, 'message' => 'Cannot delete admin users'], 403);
                return;
            }

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
            
            $stmt = $this->db->query("SELECT COUNT(*) as total FROM users WHERE role != 'admin'");
            $stats['total_users'] = $stmt->fetch(PDO::FETCH_ASSOC)['total'];
            
            $stmt = $this->db->query("SELECT COUNT(*) as active FROM users WHERE is_active = 1 AND role != 'admin'");
            $stats['active_users'] = $stmt->fetch(PDO::FETCH_ASSOC)['active'];
            
            $stmt = $this->db->query("SELECT role, COUNT(*) as count FROM users WHERE role != 'admin' GROUP BY role");
            $stats['by_role'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
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

    private function getUserIdFromSession() {
        // Get session token from cybernest_session cookie (same as ChallengeController)
        $sessionToken = $_COOKIE['cybernest_session'] ?? null;
        
        if (!$sessionToken) {
            return null;
        }

        try {
            $query = "SELECT user_id FROM user_sessions 
                      WHERE session_token = :session_token AND expires_at > NOW() 
                      LIMIT 1";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':session_token', $sessionToken);
            $stmt->execute();
            
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result ? $result['user_id'] : null;
            
        } catch (Exception $e) {
            return null;
        }
    }

    private function uploadProfilePicture() {
        try {
            // Check if file was uploaded
            if (!isset($_FILES['profile_picture']) || $_FILES['profile_picture']['error'] !== UPLOAD_ERR_OK) {
                $this->sendResponse(['success' => false, 'message' => 'No file uploaded or upload error'], 400);
                return;
            }

            $file = $_FILES['profile_picture'];
            
            // Validate file type
            $allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif'];
            $finfo = finfo_open(FILEINFO_MIME_TYPE);
            $mimeType = finfo_file($finfo, $file['tmp_name']);
            finfo_close($finfo);
            
            if (!in_array($mimeType, $allowedTypes)) {
                $this->sendResponse(['success' => false, 'message' => 'Invalid file type. Only JPG, PNG, and GIF are allowed'], 400);
                return;
            }

            // Validate file size (5MB max)
            $maxSize = 5 * 1024 * 1024; // 5MB
            if ($file['size'] > $maxSize) {
                $this->sendResponse(['success' => false, 'message' => 'File too large. Maximum size is 5MB'], 400);
                return;
            }

            // Get current user ID from session
            $userId = $this->getUserIdFromSession();
            if (!$userId) {
                $this->sendResponse(['success' => false, 'message' => 'User not authenticated'], 401);
                return;
            }

            // Create uploads directory if it doesn't exist
            $uploadDir = __DIR__ . '/../../uploads/profile_pictures/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }

            // Generate unique filename
            $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
            $filename = 'user_' . $userId . '_' . time() . '.' . $extension;
            $filepath = $uploadDir . $filename;

            // Move uploaded file
            if (!move_uploaded_file($file['tmp_name'], $filepath)) {
                $this->sendResponse(['success' => false, 'message' => 'Failed to save uploaded file'], 500);
                return;
            }

            // Update user's profile picture in database
            $profilePictureUrl = '/uploads/profile_pictures/' . $filename;
            $query = "UPDATE users SET profile_picture = :profile_picture WHERE id = :user_id";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':profile_picture', $profilePictureUrl);
            $stmt->bindParam(':user_id', $userId);
            
            if (!$stmt->execute()) {
                // Remove uploaded file if database update fails
                unlink($filepath);
                $this->sendResponse(['success' => false, 'message' => 'Failed to update database'], 500);
                return;
            }

            // Delete old profile picture if exists
            $query = "SELECT profile_picture FROM users WHERE id = :user_id";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':user_id', $userId);
            $stmt->execute();
            $oldPicture = $stmt->fetch(PDO::FETCH_ASSOC)['profile_picture'];
            
            if ($oldPicture && $oldPicture !== $profilePictureUrl) {
                $oldFilepath = __DIR__ . '/../../' . ltrim($oldPicture, '/');
                if (file_exists($oldFilepath)) {
                    unlink($oldFilepath);
                }
            }

            $this->sendResponse([
                'success' => true,
                'message' => 'Profile picture uploaded successfully',
                'profile_picture_url' => $profilePictureUrl
            ]);

        } catch (Exception $e) {
            $this->sendResponse(['success' => false, 'message' => 'Upload failed: ' . $e->getMessage()], 500);
        }
    }

    private function sendResponse($data, $http_code = 200) {
        http_response_code($http_code);
        echo json_encode($data);
        exit;
    }
}
?>
