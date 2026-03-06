<?php
require_once __DIR__ . '/../config/database.php';

class SettingsController {
    private $db;
    private $init_error = null;

    public function __construct() {
        try {
            $database = new Database();
            $this->db = $database->getConnection();
        } catch (Exception $e) {
            $this->init_error = $e->getMessage();
        }
    }

    public function handleRequest() {
        header('Content-Type: application/json');
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: GET, POST, PUT, OPTIONS');
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

        switch ($action) {
            case 'getSiteName':
                $this->getSiteName();
                break;
            case 'getAll':
                $this->getAllSettings();
                break;
            case 'save':
                $this->saveSettings();
                break;
            default:
                $this->sendResponse(['success' => false, 'message' => 'Invalid action'], 404);
        }
    }

    private function getSiteName() {
        try {
            $query = "SELECT username FROM users WHERE role = 'admin' LIMIT 1";
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if ($result) {
                $siteName = strtoupper($result['username']);
                $this->sendResponse(['success' => true, 'siteName' => $siteName]);
            } else {
                $this->sendResponse(['success' => true, 'siteName' => 'CYBERNEST']);
            }
        } catch (Exception $e) {
            $this->sendResponse(['success' => false, 'message' => 'Failed to fetch site name: ' . $e->getMessage()], 500);
        }
    }

    private function getAllSettings() {
        try {
            $settings = [];
            
            $query = "SELECT username, email FROM users WHERE role = 'admin' LIMIT 1";
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            
            $admin = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if ($admin) {
                $settings['siteName'] = strtoupper($admin['username']);
                $settings['adminEmail'] = $admin['email'];
            } else {
                $settings['siteName'] = 'CYBERNEST';
                $settings['adminEmail'] = 'admin@cybernest.com';
            }
            
            $settings['defaultLanguage'] = 'en';
            $settings['timezone'] = 'UTC';
            $settings['sessionTimeout'] = 30;
            $settings['passwordMinLength'] = 8;
            $settings['primaryColor'] = '#00ff00';
            $settings['secondaryColor'] = '#00cc00';
            $settings['theme'] = 'cyber';
            $settings['fontSize'] = 'medium';
            $settings['notificationEmail'] = $settings['adminEmail'];
            $settings['notificationFrequency'] = 'immediate';
            
            $this->sendResponse(['success' => true, 'settings' => $settings]);
        } catch (Exception $e) {
            $this->sendResponse(['success' => false, 'message' => 'Failed to fetch settings: ' . $e->getMessage()], 500);
        }
    }

    private function saveSettings() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->sendResponse(['success' => false, 'message' => 'Method not allowed'], 405);
            return;
        }

        $data = json_decode(file_get_contents('php://input'), true);

        if (!$data) {
            $this->sendResponse(['success' => false, 'message' => 'Invalid data'], 400);
            return;
        }

        try {
            if (isset($data['adminEmail'])) {
                $query = "UPDATE users SET email = :email, updated_at = CURRENT_TIMESTAMP WHERE role = 'admin'";
                $stmt = $this->db->prepare($query);
                $stmt->bindParam(':email', $data['adminEmail']);
                $stmt->execute();
            }
            
            $this->sendResponse(['success' => true, 'message' => 'Settings saved successfully']);
        } catch (Exception $e) {
            $this->sendResponse(['success' => false, 'message' => 'Failed to save settings: ' . $e->getMessage()], 500);
        }
    }

    private function sendResponse($data, $http_code = 200) {
        http_response_code($http_code);
        echo json_encode($data);
        exit;
    }
}
?>
