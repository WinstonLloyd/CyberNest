<?php
/**
 * Challenge Management Controller for CyberNest Admin
 */

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/Challenge.php';

class ChallengeController {
    private $db;
    private $challenge;
    private $init_error = null;

    public function __construct() {
        try {
            $database = new Database();
            $this->db = $database->getConnection();
            $this->challenge = new Challenge($database);
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

        switch ($action) {
            case 'getAll':
                $this->getAllChallenges();
                break;
            case 'getById':
                $this->getChallengeById();
                break;
            case 'create':
                $this->createChallenge();
                break;
            case 'update':
                $this->updateChallenge();
                break;
            case 'submitFlag':
                $this->submitFlag();
                break;
            case 'delete':
                $this->deleteChallenge();
                break;
            case 'stats':
                $this->getChallengeStats();
                break;
            case 'topPerformers':
                $this->getTopPerformers();
                break;
            default:
                $this->sendResponse(['success' => false, 'message' => 'Invalid action'], 404);
        }
    }

    private function getAllChallenges() {
        try {
            $filters = [];
            
            if (!empty($_GET['difficulty'])) {
                $filters['difficulty'] = $_GET['difficulty'];
            }
            
            if (!empty($_GET['status'])) {
                $filters['status'] = $_GET['status'];
            }
            
            if (!empty($_GET['search'])) {
                $filters['search'] = $_GET['search'];
            }
            
            $challenges = $this->challenge->getAllChallenges($filters);
            
            $this->sendResponse(['success' => true, 'challenges' => $challenges]);
        } catch (Exception $e) {
            $this->sendResponse(['success' => false, 'message' => 'Failed to fetch challenges: ' . $e->getMessage()], 500);
        }
    }

    private function getChallengeById() {
        try {
            $id = $_GET['id'] ?? '';
            
            if (empty($id)) {
                $this->sendResponse(['success' => false, 'message' => 'Challenge ID is required'], 400);
                return;
            }
            
            $challenge = $this->challenge->getChallengeById($id);
            
            if ($challenge) {
                $this->sendResponse(['success' => true, 'challenge' => $challenge]);
            } else {
                $this->sendResponse(['success' => false, 'message' => 'Challenge not found'], 404);
            }
        } catch (Exception $e) {
            $this->sendResponse(['success' => false, 'message' => 'Failed to fetch challenge: ' . $e->getMessage()], 500);
        }
    }

    private function createChallenge() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->sendResponse(['success' => false, 'message' => 'Method not allowed'], 405);
            return;
        }

        $data = json_decode(file_get_contents('php://input'), true);

        if (!$data) {
            $this->sendResponse(['success' => false, 'message' => 'Invalid data'], 400);
            return;
        }

        $required_fields = ['title', 'description', 'difficulty', 'points', 'category', 'status'];
        foreach ($required_fields as $field) {
            if (empty($data[$field])) {
                $this->sendResponse(['success' => false, 'message' => "Field '$field' is required"], 400);
                return;
            }
        }

        try {
            $challenge_data = [
                'title' => $data['title'],
                'description' => $data['description'],
                'difficulty' => $data['difficulty'],
                'points' => $data['points'],
                'category' => $data['category'],
                'status' => $data['status'],
                'flag' => $data['flag'] ?? '',
                'tags' => $data['tags'] ?? ''
            ];

            $challenge_id = $this->challenge->createChallenge($challenge_data);
            
            $this->sendResponse([
                'success' => true, 
                'message' => 'Challenge created successfully',
                'challenge_id' => $challenge_id
            ]);
        } catch (Exception $e) {
            $this->sendResponse(['success' => false, 'message' => 'Failed to create challenge: ' . $e->getMessage()], 500);
        }
    }

    private function updateChallenge() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST' && $_SERVER['REQUEST_METHOD'] !== 'PUT') {
            $this->sendResponse(['success' => false, 'message' => 'Method not allowed'], 405);
            return;
        }

        $data = json_decode(file_get_contents('php://input'), true);

        if (!$data) {
            $this->sendResponse(['success' => false, 'message' => 'Invalid data'], 400);
            return;
        }

        if (empty($data['id'])) {
            $this->sendResponse(['success' => false, 'message' => 'Challenge ID is required'], 400);
            return;
        }

        try {
            $challenge_data = [
                'title' => $data['title'],
                'description' => $data['description'],
                'difficulty' => $data['difficulty'],
                'points' => $data['points'],
                'category' => $data['category'],
                'status' => $data['status'],
                'flag' => $data['flag'] ?? '',
                'tags' => $data['tags'] ?? ''
            ];

            $success = $this->challenge->updateChallenge($data['id'], $challenge_data);
            
            if ($success) {
                $this->sendResponse(['success' => true, 'message' => 'Challenge updated successfully']);
            } else {
                $this->sendResponse(['success' => false, 'message' => 'Failed to update challenge'], 500);
            }
        } catch (Exception $e) {
            $this->sendResponse(['success' => false, 'message' => 'Failed to update challenge: ' . $e->getMessage()], 500);
        }
    }

    private function submitFlag() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->sendResponse(['success' => false, 'message' => 'Method not allowed'], 405);
            return;
        }

        $data = json_decode(file_get_contents('php://input'), true);

        if (!$data) {
            $this->sendResponse(['success' => false, 'message' => 'Invalid data'], 400);
            return;
        }

        if (empty($data['challenge_id']) || empty($data['flag'])) {
            $this->sendResponse(['success' => false, 'message' => 'Challenge ID and flag are required'], 400);
            return;
        }

        try {
            $challengeId = $data['challenge_id'];
            $submittedFlag = $data['flag'];

            // Get challenge details to compare flag
            $challenge = $this->challenge->getChallengeById($challengeId);
            
            if (!$challenge) {
                $this->sendResponse(['success' => false, 'message' => 'Challenge not found'], 404);
                return;
            }

            // Compare submitted flag with actual flag
            $isCorrect = $submittedFlag === $challenge['flag'];
            
            // For now, we'll just return the comparison result
            // In a real application, you would also:
            // - Log the attempt
            // - Update user points if correct
            // - Mark challenge as completed for the user
            // - Track attempt statistics
            
            $this->sendResponse([
                'success' => true,
                'correct' => $isCorrect,
                'message' => $isCorrect ? 'Flag submitted successfully!' : 'Incorrect flag'
            ]);
            
        } catch (Exception $e) {
            $this->sendResponse(['success' => false, 'message' => 'Failed to submit flag: ' . $e->getMessage()], 500);
        }
    }

    private function deleteChallenge() {
        if ($_SERVER['REQUEST_METHOD'] !== 'DELETE') {
            $this->sendResponse(['success' => false, 'message' => 'Method not allowed'], 405);
            return;
        }

        $id = $_GET['id'] ?? '';

        if (empty($id)) {
            $this->sendResponse(['success' => false, 'message' => 'Challenge ID is required'], 400);
            return;
        }

        try {
            $success = $this->challenge->deleteChallenge($id);
            
            if ($success) {
                $this->sendResponse(['success' => true, 'message' => 'Challenge deleted successfully']);
            } else {
                $this->sendResponse(['success' => false, 'message' => 'Failed to delete challenge'], 500);
            }
        } catch (Exception $e) {
            $this->sendResponse(['success' => false, 'message' => 'Failed to delete challenge: ' . $e->getMessage()], 500);
        }
    }

    private function getChallengeStats() {
        try {
            $stats = $this->challenge->getChallengeStats();
            $this->sendResponse(['success' => true, 'stats' => $stats]);
        } catch (Exception $e) {
            $this->sendResponse(['success' => false, 'message' => 'Failed to fetch challenge stats: ' . $e->getMessage()], 500);
        }
    }

    private function getTopPerformers() {
        try {
            $limit = $_GET['limit'] ?? 10;
            $performers = $this->challenge->getTopPerformers($limit);
            $this->sendResponse(['success' => true, 'performers' => $performers]);
        } catch (Exception $e) {
            $this->sendResponse(['success' => false, 'message' => 'Failed to fetch top performers: ' . $e->getMessage()], 500);
        }
    }

    private function sendResponse($data, $http_code = 200) {
        http_response_code($http_code);
        echo json_encode($data);
        exit;
    }
}
?>
