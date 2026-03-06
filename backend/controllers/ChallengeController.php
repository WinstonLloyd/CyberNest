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
            case 'getUserChallenges':
                $this->getUserChallenges();
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

    private function getUserChallenges() {
        try {
            // For now, we'll use a hardcoded user ID (in a real app, this would come from session/auth)
            $userId = 1; // This should be replaced with actual user authentication
            
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
            
            $challenges = $this->challenge->getChallengesForUser($userId, $filters);
            
            $this->sendResponse(['success' => true, 'challenges' => $challenges]);
        } catch (Exception $e) {
            $this->sendResponse(['success' => false, 'message' => 'Failed to fetch user challenges: ' . $e->getMessage()], 500);
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
            
            // For now, we'll use a hardcoded user ID (in a real app, this would come from session/auth)
            $userId = 1; // This should be replaced with actual user authentication

            // Get challenge details to compare flag
            $challenge = $this->challenge->getChallengeById($challengeId);
            
            if (!$challenge) {
                $this->sendResponse(['success' => false, 'message' => 'Challenge not found'], 404);
                return;
            }

            // Check if user has already completed this challenge
            $existingAttempt = $this->getChallengeAttempt($userId, $challengeId);
            
            if ($existingAttempt && $existingAttempt['completed']) {
                $this->sendResponse([
                    'success' => true,
                    'correct' => true,
                    'already_completed' => true,
                    'message' => 'You have already completed this challenge!'
                ]);
                return;
            }

            // Compare submitted flag with actual flag
            $isCorrect = $submittedFlag === $challenge['flag'];
            
            // Log the attempt
            $this->logChallengeAttempt($userId, $challengeId, $isCorrect);
            
            if ($isCorrect) {
                // Update user points and statistics
                $this->updateUserStats($userId, $challenge['points']);
                
                $this->sendResponse([
                    'success' => true,
                    'correct' => true,
                    'message' => 'Correct! Challenge completed successfully!',
                    'points_earned' => $challenge['points']
                ]);
            } else {
                $this->sendResponse([
                    'success' => true,
                    'correct' => false,
                    'message' => 'Incorrect flag. Try again!'
                ]);
            }
            
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

    private function getChallengeAttempt($userId, $challengeId) {
        try {
            $query = "SELECT * FROM challenge_attempts WHERE user_id = :user_id AND challenge_id = :challenge_id LIMIT 1";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':user_id', $userId);
            $stmt->bindParam(':challenge_id', $challengeId);
            $stmt->execute();
            
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            throw new Exception("Failed to get challenge attempt: " . $e->getMessage());
        }
    }

    private function logChallengeAttempt($userId, $challengeId, $isCorrect) {
        try {
            $existingAttempt = $this->getChallengeAttempt($userId, $challengeId);
            
            if ($existingAttempt) {
                // Update existing attempt
                $query = "UPDATE challenge_attempts 
                          SET attempt_count = attempt_count + 1,
                              completed = :completed,
                              points = CASE WHEN :completed = 1 AND points = 0 THEN (SELECT points FROM challenges WHERE id = :challenge_id) ELSE points END,
                              completed_at = CASE WHEN :completed = 1 THEN NOW() ELSE completed_at END
                          WHERE user_id = :user_id AND challenge_id = :challenge_id";
                
                $stmt = $this->db->prepare($query);
                $stmt->bindParam(':user_id', $userId);
                $stmt->bindParam(':challenge_id', $challengeId);
                $stmt->bindParam(':completed', $isCorrect, PDO::PARAM_BOOL);
                $stmt->execute();
            } else {
                // Create new attempt record
                $points = $isCorrect ? $this->getChallengePoints($challengeId) : 0;
                $query = "INSERT INTO challenge_attempts 
                          (user_id, challenge_id, completed, attempt_count, points, completed_at) 
                          VALUES (:user_id, :challenge_id, :completed, 1, :points, :completed_at)";
                
                $completedAt = $isCorrect ? date('Y-m-d H:i:s') : null;
                $stmt = $this->db->prepare($query);
                $stmt->bindParam(':user_id', $userId);
                $stmt->bindParam(':challenge_id', $challengeId);
                $stmt->bindParam(':completed', $isCorrect, PDO::PARAM_BOOL);
                $stmt->bindParam(':points', $points);
                $stmt->bindParam(':completed_at', $completedAt);
                $stmt->execute();
            }
        } catch (Exception $e) {
            throw new Exception("Failed to log challenge attempt: " . $e->getMessage());
        }
    }

    private function getChallengePoints($challengeId) {
        try {
            $query = "SELECT points FROM challenges WHERE id = :challenge_id LIMIT 1";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':challenge_id', $challengeId);
            $stmt->execute();
            
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result ? $result['points'] : 0;
        } catch (Exception $e) {
            throw new Exception("Failed to get challenge points: " . $e->getMessage());
        }
    }

    private function updateUserStats($userId, $points) {
        try {
            // Update user profile points and completed challenges
            $query = "UPDATE user_profiles 
                      SET points = points + :points,
                          challenges_completed = challenges_completed + 1,
                          updated_at = NOW()
                      WHERE user_id = :user_id
                      ON DUPLICATE KEY UPDATE 
                          points = points + :points,
                          challenges_completed = challenges_completed + 1,
                          updated_at = NOW()";
            
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':user_id', $userId);
            $stmt->bindParam(':points', $points);
            $stmt->execute();
            
            // Update user rank based on points
            $this->updateUserRank($userId);
            
        } catch (Exception $e) {
            throw new Exception("Failed to update user stats: " . $e->getMessage());
        }
    }

    private function updateUserRank($userId) {
        try {
            // Get user's current points
            $stmt = $this->db->prepare("SELECT points FROM user_profiles WHERE user_id = :user_id");
            $stmt->bindParam(':user_id', $userId);
            $stmt->execute();
            $userProfile = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if (!$userProfile) {
                return;
            }
            
            $points = $userProfile['points'];
            
            // Determine rank based on points
            $rank = 'Beginner';
            if ($points >= 10000) {
                $rank = 'Elite';
            } elseif ($points >= 5000) {
                $rank = 'Master';
            } elseif ($points >= 2500) {
                $rank = 'Expert';
            } elseif ($points >= 1000) {
                $rank = 'Advanced';
            } elseif ($points >= 500) {
                $rank = 'Intermediate';
            } elseif ($points >= 100) {
                $rank = 'Novice';
            }
            
            // Update user rank
            $stmt = $this->db->prepare("UPDATE user_profiles SET rank = :rank WHERE user_id = :user_id");
            $stmt->bindParam(':user_id', $userId);
            $stmt->bindParam(':rank', $rank);
            $stmt->execute();
            
        } catch (Exception $e) {
            throw new Exception("Failed to update user rank: " . $e->getMessage());
        }
    }

    private function sendResponse($data, $http_code = 200) {
        http_response_code($http_code);
        echo json_encode($data);
        exit;
    }
}

?>
