<?php
/**
 * Authentication Controller for CyberNest
 */

require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../config/database.php';

class AuthController {
    private $user;
    private $db;
    private $init_error = null;

    public function __construct() {
        try {
            $database = new Database();
            $this->db = $database->getConnection();
            $this->user = new User($this->db);
            
            // Create tables if they don't exist
            $database->createTables();
        } catch (Exception $e) {
            // Store error for later use in handleRequest
            $this->init_error = $e->getMessage();
        }
    }

    public function handleRequest() {
        header('Content-Type: application/json');
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: POST, OPTIONS');
        header('Access-Control-Allow-Headers: Content-Type');

        if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
            exit(0);
        }

        // Check if there was an initialization error
        if ($this->init_error) {
            $this->sendResponse([
                'success' => false, 
                'message' => 'Database initialization failed: ' . $this->init_error
            ], 500);
            return;
        }

        $action = $_GET['action'] ?? '';
        $endpoint = basename($_SERVER['PHP_SELF'], '.php');

        switch ($endpoint) {
            case 'login':
                $this->handleLogin();
                break;
            case 'register':
                $this->handleRegister();
                break;
            default:
                $this->sendResponse(['success' => false, 'message' => 'Invalid endpoint'], 404);
        }
    }

    private function handleLogin() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->sendResponse(['success' => false, 'message' => 'Method not allowed'], 405);
            return;
        }

        $data = json_decode(file_get_contents('php://input'), true);

        if (!$data || !isset($data['username']) || !isset($data['password'])) {
            $this->sendResponse(['success' => false, 'message' => 'Missing required fields'], 400);
            return;
        }

        $username = trim($data['username']);
        $password = $data['password'];
        $remember = isset($data['remember']) ? $data['remember'] : false;

        if (empty($username) || empty($password)) {
            $this->sendResponse(['success' => false, 'message' => 'Username and password are required'], 400);
            return;
        }

        $result = $this->user->login($username, $password);

        if ($result['success']) {
            $session_token = $this->user->createSession($result['user']['id'], $remember);
            
            if ($session_token) {
                // Set session cookie
                $cookie_name = 'cybernest_session';
                $cookie_value = $session_token;
                $cookie_expire = $remember ? time() + (86400 * 30) : time() + (86400);
                $cookie_path = '/';
                $cookie_domain = '';
                $cookie_secure = false;
                $cookie_httponly = true;

                setcookie($cookie_name, $cookie_value, $cookie_expire, $cookie_path, $cookie_domain, $cookie_secure, $cookie_httponly);

                $this->sendResponse([
                    'success' => true,
                    'message' => 'Login successful',
                    'user' => $result['user'],
                    'session_token' => $session_token
                ]);
            } else {
                $this->sendResponse(['success' => false, 'message' => 'Failed to create session'], 500);
            }
        } else {
            $this->sendResponse($result);
        }
    }

    private function handleRegister() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->sendResponse(['success' => false, 'message' => 'Method not allowed'], 405);
            return;
        }

        $data = json_decode(file_get_contents('php://input'), true);

        if (!$data || !isset($data['username']) || !isset($data['email']) || !isset($data['password'])) {
            $this->sendResponse(['success' => false, 'message' => 'Missing required fields'], 400);
            return;
        }

        $username = trim($data['username']);
        $email = trim($data['email']);
        $password = $data['password'];
        $display_name = isset($data['display_name']) ? trim($data['display_name']) : $username;

        // Validation
        if (empty($username) || empty($email) || empty($password)) {
            $this->sendResponse(['success' => false, 'message' => 'All fields are required'], 400);
            return;
        }

        if (strlen($username) < 3) {
            $this->sendResponse(['success' => false, 'message' => 'Username must be at least 3 characters'], 400);
            return;
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->sendResponse(['success' => false, 'message' => 'Invalid email format'], 400);
            return;
        }

        if (strlen($password) < 8) {
            $this->sendResponse(['success' => false, 'message' => 'Password must be at least 8 characters'], 400);
            return;
        }

        $result = $this->user->register($username, $email, $password, $display_name);
        $this->sendResponse($result);
    }

    private function sendResponse($data, $http_code = 200) {
        http_response_code($http_code);
        echo json_encode($data);
        exit;
    }
}
?>
