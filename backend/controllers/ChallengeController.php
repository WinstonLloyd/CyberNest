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
        ob_clean();
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
            case 'getUserTotalPoints':
                $this->getUserTotalPoints();
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
            case 'attempts_by_day':
                $this->getAttemptsByDay();
                break;
            case 'topPerformers':
                $this->getTopPerformers();
                break;
            case 'getRealTimeAttempts':
                $this->getRealTimeAttempts();
                break;
            case 'getPlatformStats':
                $this->getPlatformStats();
                break;
            case 'getRecentActivity':
                $this->getRecentActivity();
                break;
            case 'getTopHackers':
                $this->getTopHackers();
                break;
            case 'getUserProfile':
                $this->getUserProfile();
                break;
            case 'getUserSkills':
                $this->getUserSkills();
                break;
            case 'updateUserSettings':
                $this->updateUserSettings();
                break;
            default:
                $this->sendResponse(['success' => false, 'message' => 'Invalid action'], 404);
        }
    }

    private function getAllChallenges() {
        try {
            $filters = [];
            
            if (!empty($_GET['category'])) {
                $filters['category'] = $_GET['category'];
            }
            
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
            $userId = $this->getUserIdFromSession();
            
            if (!$userId) {
                $this->sendResponse(['success' => false, 'message' => 'User not authenticated'], 401);
                return;
            }
            
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

    private function getUserTotalPoints() {
        try {
            $userId = $this->getUserIdFromSession();
            
            if (!$userId) {
                $this->sendResponse(['success' => false, 'message' => 'User not authenticated'], 401);
                return;
            }
            
            $query = "SELECT COALESCE(points, 0) as total_points 
                      FROM user_profiles 
                      WHERE user_id = :user_id";
            
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':user_id', $userId);
            $stmt->execute();
            
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            $totalPoints = $result ? (int)$result['total_points'] : 0;
            
            $this->sendResponse(['success' => true, 'total_points' => $totalPoints]);
            
        } catch (Exception $e) {
            $this->sendResponse(['success' => false, 'message' => 'Failed to fetch user points: ' . $e->getMessage()], 500);
        }
    }

    private function createChallenge() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->sendResponse(['success' => false, 'message' => 'Method not allowed'], 405);
            return;
        }

        $contentType = $_SERVER['CONTENT_TYPE'] ?? '';
        
        if (strpos($contentType, 'application/json') !== false) {
            $data = json_decode(file_get_contents('php://input'), true);
        } else {
            $data = json_decode($_POST['challengeData'] ?? '[]', true);
        }

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

            $file_path = null;
            if (isset($_FILES['file']) && $_FILES['file']['error'] === UPLOAD_ERR_OK) {
                $file = $_FILES['file'];
                $upload_dir = __DIR__ . '/../../uploads/challenges/';
                
                if (!is_dir($upload_dir)) {
                    mkdir($upload_dir, 0755, true);
                }
                
                $file_extension = pathinfo($file['name'], PATHINFO_EXTENSION);
                $file_name = 'challenge_' . time() . '_' . uniqid() . '.' . $file_extension;
                $file_path = 'uploads/challenges/' . $file_name;
                
                if (!move_uploaded_file($file['tmp_name'], $upload_dir . $file_name)) {
                    error_log('Failed to move uploaded file from: ' . $file['tmp_name'] . ' to: ' . $upload_dir . $file_name);
                    $this->sendResponse(['success' => false, 'message' => 'Failed to upload file'], 500);
                    return;
                }
                
                $challenge_data['file_path'] = $file_path;
                $challenge_data['original_filename'] = $file['name'];
            }

            $challenge_id = $this->challenge->createChallenge($challenge_data);
            
            $this->sendResponse([
                'success' => true, 
                'message' => 'Challenge created successfully',
                'challenge_id' => $challenge_id,
                'file_uploaded' => $file_path ? true : false
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

        $contentType = $_SERVER['CONTENT_TYPE'] ?? '';
        
        if (strpos($contentType, 'application/json') !== false) {
            $data = json_decode(file_get_contents('php://input'), true);
        } else {
            $data = json_decode($_POST['challengeData'] ?? '[]', true);
        }

        if (!$data) {
            $this->sendResponse(['success' => false, 'message' => 'Invalid data'], 400);
            return;
        }

        if (empty($data['id'])) {
            $this->sendResponse(['success' => false, 'message' => 'Challenge ID is required'], 400);
            return;
        }

        try {
            $existing_challenge = $this->challenge->getChallengeById($data['id']);
            
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

            $file_path = null;
            if (isset($_FILES['file']) && $_FILES['file']['error'] === UPLOAD_ERR_OK) {
                $file = $_FILES['file'];
                $upload_dir = __DIR__ . '/../../uploads/challenges/';
                
                if (!is_dir($upload_dir)) {
                    mkdir($upload_dir, 0755, true);
                }
                
                $file_extension = pathinfo($file['name'], PATHINFO_EXTENSION);
                $file_name = 'challenge_' . time() . '_' . uniqid() . '.' . $file_extension;
                $file_path = 'uploads/challenges/' . $file_name;
                
                if (!move_uploaded_file($file['tmp_name'], $upload_dir . $file_name)) {
                    $this->sendResponse(['success' => false, 'message' => 'Failed to upload file'], 500);
                    return;
                }
                
                $challenge_data['file_path'] = $file_path;
                $challenge_data['original_filename'] = $file['name'];
                
                // Delete old file if it exists
                if ($existing_challenge && !empty($existing_challenge['file_path'])) {
                    $old_file_path = __DIR__ . '/../../' . $existing_challenge['file_path'];
                    if (file_exists($old_file_path)) {
                        if (!unlink($old_file_path)) {
                            error_log('Failed to delete old file: ' . $old_file_path);
                            // Continue with update even if old file deletion fails
                        }
                    }
                }
            } else {
                // No new file uploaded, keep existing file data
                if ($existing_challenge) {
                    $challenge_data['file_path'] = $existing_challenge['file_path'] ?? null;
                    $challenge_data['original_filename'] = $existing_challenge['original_filename'] ?? null;
                }
            }

            $success = $this->challenge->updateChallenge($data['id'], $challenge_data);
            
            if ($success) {
                $this->sendResponse([
                    'success' => true, 
                    'message' => 'Challenge updated successfully',
                    'file_uploaded' => $file_path ? true : false
                ]);
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
            
            $userId = $this->getUserIdFromSession();
            
            if (!$userId) {
                $this->sendResponse(['success' => false, 'message' => 'User not authenticated'], 401);
                return;
            }

            $challenge = $this->challenge->getChallengeById($challengeId);
            
            if (!$challenge) {
                $this->sendResponse(['success' => false, 'message' => 'Challenge not found'], 404);
                return;
            }

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

            $isCorrect = $submittedFlag === $challenge['flag'];
            
            $this->logChallengeAttempt($userId, $challengeId, $isCorrect);
            
            if ($isCorrect) {
                $this->updateUserStats($userId, $challenge['points']);
                
                $this->sendResponse([
                    'success' => true,
                    'correct' => true,
                    'message' => 'Challenge completed successfully!',
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
            $challenge = $this->challenge->getChallengeById($id);
            
            if ($challenge && !empty($challenge['file_path'])) {
                $file_path = __DIR__ . '/../../' . $challenge['file_path'];
                if (file_exists($file_path)) {
                    if (!unlink($file_path)) {
                        error_log('Failed to delete file: ' . $file_path);
                    }
                }
            }
            
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

    private function getPlatformStats() {
        try {
            $query = "SELECT COUNT(*) as total_challenges FROM challenges WHERE status = 'active'";
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            $totalChallenges = $stmt->fetch(PDO::FETCH_ASSOC)['total_challenges'];

            $query = "SELECT COUNT(DISTINCT ca.user_id) as total_hackers 
                      FROM challenge_attempts ca 
                      WHERE ca.completed = 1 AND ca.points > 0";
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            $totalHackers = $stmt->fetch(PDO::FETCH_ASSOC)['total_hackers'];

            $query = "SELECT COUNT(*) as total_completed FROM challenge_attempts WHERE completed = 1";
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            $totalCompleted = $stmt->fetch(PDO::FETCH_ASSOC)['total_completed'];

            $query = "SELECT COUNT(DISTINCT user_id) as active_today 
                      FROM challenge_attempts 
                      WHERE created_at >= DATE_SUB(NOW(), INTERVAL 24 HOUR)";
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            $activeToday = $stmt->fetch(PDO::FETCH_ASSOC)['active_today'];

            $userId = $this->getUserIdFromSession();
            $userCompleted = 0;
            if ($userId) {
                $query = "SELECT COUNT(*) as user_completed FROM challenge_attempts WHERE user_id = :user_id AND completed = 1";
                $stmt = $this->db->prepare($query);
                $stmt->bindParam(':user_id', $userId);
                $stmt->execute();
                $userCompleted = $stmt->fetch(PDO::FETCH_ASSOC)['user_completed'];
            }

            $this->sendResponse([
                'success' => true,
                'stats' => [
                    'total_challenges' => (int)$totalChallenges,
                    'total_hackers' => (int)$totalHackers,
                    'total_completed' => (int)$totalCompleted,
                    'active_today' => (int)$activeToday,
                    'user_completed' => (int)$userCompleted
                ]
            ]);
        } catch (Exception $e) {
            $this->sendResponse(['success' => false, 'message' => 'Failed to fetch platform stats: ' . $e->getMessage()], 500);
        }
    }

    private function getRecentActivity() {
        try {
            $limit = $_GET['limit'] ?? 10;
            
            $query = "SELECT ca.challenge_id, ca.completed_at, c.title, u.username,
                             CASE WHEN ca.completed = 1 THEN 'completed' ELSE 'attempted' END as activity_type
                      FROM challenge_attempts ca
                      JOIN challenges c ON ca.challenge_id = c.id
                      JOIN users u ON ca.user_id = u.id
                      ORDER BY ca.completed_at DESC
                      LIMIT :limit";
            
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
            $stmt->execute();
            
            $activities = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            $formattedActivities = [];
            foreach ($activities as $activity) {
                $timeAgo = $this->getTimeAgo($activity['completed_at']);
                
                if ($activity['activity_type'] === 'completed') {
                    $formattedActivities[] = [
                        'icon' => 'fas fa-flag-checkered',
                        'title' => 'Challenge Completed',
                        'description' => $activity['username'] . ' completed ' . $activity['title'],
                        'time' => $timeAgo,
                        'type' => 'success'
                    ];
                } else {
                    $formattedActivities[] = [
                        'icon' => 'fas fa-clock',
                        'title' => 'Challenge Attempted',
                        'description' => $activity['username'] . ' attempted ' . $activity['title'],
                        'time' => $timeAgo,
                        'type' => 'info'
                    ];
                }
            }
            
            $this->sendResponse(['success' => true, 'activities' => $formattedActivities]);
        } catch (Exception $e) {
            $this->sendResponse(['success' => false, 'message' => 'Failed to fetch recent activity: ' . $e->getMessage()], 500);
        }
    }

    private function getTopHackers() {
        try {
            $limit = $_GET['limit'] ?? 5;
            
            $query = "SELECT u.username, 
                             COALESCE(SUM(CASE WHEN ca.completed = 1 THEN ca.points ELSE 0 END), 0) as points,
                             COALESCE(COUNT(CASE WHEN ca.completed = 1 THEN 1 END), 0) as challenges_completed,
                             COALESCE(COUNT(ca.id), 0) as total_attempts,
                             MAX(ca.completed_at) as last_activity
                      FROM users u
                      LEFT JOIN challenge_attempts ca ON u.id = ca.user_id
                      GROUP BY u.id, u.username
                      HAVING points > 0
                      ORDER BY points DESC, challenges_completed DESC
                      LIMIT :limit";
            
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
            $stmt->execute();
            
            $hackers = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            $formattedHackers = [];
            foreach ($hackers as $index => $hacker) {
                $rank = $index + 1;
                $lastActivity = $hacker['last_activity'] ? $this->getTimeAgo($hacker['last_activity']) : 'Never';
                
                $successRate = $hacker['total_attempts'] > 0 ? 
                    round(($hacker['challenges_completed'] / $hacker['total_attempts']) * 100, 1) : 0;
                
                $formattedHackers[] = [
                    'rank' => $rank,
                    'username' => $hacker['username'],
                    'points' => (int)$hacker['points'],
                    'challenges_completed' => (int)$hacker['challenges_completed'],
                    'total_attempts' => (int)$hacker['total_attempts'],
                    'success_rate' => $successRate,
                    'last_activity' => $lastActivity
                ];
            }
            
            $this->sendResponse(['success' => true, 'hackers' => $formattedHackers]);
        } catch (Exception $e) {
            $this->sendResponse(['success' => false, 'message' => 'Failed to fetch top hackers: ' . $e->getMessage()], 500);
        }
    }

    private function getUserProfile() {
        ob_clean();
        try {
            $userId = $this->getUserIdFromSession();
            if (!$userId) {
                $this->sendResponse(['success' => false, 'message' => 'User not authenticated'], 401);
                return;
            }

            $query = "SELECT u.username, u.email, u.created_at, u.bio, u.location, u.website, u.display_name, u.profile_picture
                      FROM users u
                      WHERE u.id = :user_id
                      LIMIT 1";
            
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':user_id', $userId);
            $stmt->execute();
            
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if (!$user) {
                $this->sendResponse(['success' => false, 'message' => 'User not found'], 404);
                return;
            }

            $query = "SELECT 
                        COUNT(CASE WHEN ca.completed = 1 THEN 1 END) as challenges_completed,
                        COUNT(ca.id) as total_attempts,
                        COALESCE(SUM(CASE WHEN ca.completed = 1 THEN ca.points ELSE 0 END), 0) as points_earned,
                        MAX(ca.completed_at) as last_activity
                      FROM challenge_attempts ca
                      WHERE ca.user_id = :user_id";
            
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':user_id', $userId);
            $stmt->execute();
            
            $stats = $stmt->fetch(PDO::FETCH_ASSOC);

            $successRate = $stats['total_attempts'] > 0 ? 
                round(($stats['challenges_completed'] / $stats['total_attempts']) * 100, 1) : 0;

            $rankQuery = "SELECT COUNT(*) + 1 as rank_position
                          FROM (
                              SELECT u2.id, COALESCE(SUM(CASE WHEN ca2.completed = 1 THEN ca2.points ELSE 0 END), 0) as total_points
                              FROM users u2
                              LEFT JOIN challenge_attempts ca2 ON u2.id = ca2.user_id
                              GROUP BY u2.id
                              HAVING total_points > COALESCE((SELECT SUM(CASE WHEN ca3.completed = 1 THEN ca3.points ELSE 0 END)
                                                              FROM challenge_attempts ca3
                                                              WHERE ca3.user_id = :user_id), 0)
                          ) as rankings";
            
            $stmt = $this->db->prepare($rankQuery);
            $stmt->bindParam(':user_id', $userId);
            $stmt->execute();
            
            $rankResult = $stmt->fetch(PDO::FETCH_ASSOC);
            $rankPosition = $rankResult['rank_position'];

            $activityQuery = "SELECT ca.challenge_id, ca.completed_at, c.title,
                                     CASE WHEN ca.completed = 1 THEN 'completed' ELSE 'attempted' END as activity_type
                              FROM challenge_attempts ca
                              JOIN challenges c ON ca.challenge_id = c.id
                              WHERE ca.user_id = :user_id
                              ORDER BY ca.completed_at DESC
                              LIMIT 10";
            
            $stmt = $this->db->prepare($activityQuery);
            $stmt->bindParam(':user_id', $userId);
            $stmt->execute();
            
            $activities = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $formattedActivities = [];
            foreach ($activities as $activity) {
                $timeAgo = $this->getTimeAgo($activity['completed_at']);
                
                if ($activity['activity_type'] === 'completed') {
                    $formattedActivities[] = [
                        'icon' => 'fas fa-trophy',
                        'title' => 'Challenge Completed',
                        'description' => "Completed {$activity['title']}",
                        'time' => $timeAgo,
                        'type' => 'success'
                    ];
                } else {
                    $formattedActivities[] = [
                        'icon' => 'fas fa-code',
                        'title' => 'Challenge Attempted',
                        'description' => "Attempted {$activity['title']}",
                        'time' => $timeAgo,
                        'type' => 'info'
                    ];
                }
            }

            $this->sendResponse([
                'success' => true,
                'profile' => [
                    'username' => $user['username'],
                    'email' => $user['email'],
                    'display_name' => $user['display_name'] ?? $user['username'],
                    'bio' => $user['bio'] ?? '',
                    'location' => $user['location'] ?? '',
                    'website' => $user['website'] ?? '',
                    'profile_picture' => $user['profile_picture'] ?? '',
                    'rank' => 'Beginner',
                    'joined_date' => $user['created_at'],
                    'challenges_completed' => (int)$stats['challenges_completed'],
                    'total_attempts' => (int)$stats['total_attempts'],
                    'points_earned' => (int)$stats['points_earned'],
                    'success_rate' => $successRate,
                    'rank_position' => $rankPosition,
                    'last_activity' => $stats['last_activity'] ? $this->getTimeAgo($stats['last_activity']) : 'Never',
                    'recent_activities' => $formattedActivities
                ]
            ]);
        } catch (Exception $e) {
            $this->sendResponse(['success' => false, 'message' => 'Failed to fetch user profile: ' . $e->getMessage()], 500);
        }
    }

    private function getUserSkills() {
        try {
            $userId = $this->getUserIdFromSession();
            if (!$userId) {
                $this->sendResponse(['success' => false, 'message' => 'User not authenticated'], 401);
                return;
            }

            $query = "SELECT 
                        c.category as skill_name,
                        COUNT(CASE WHEN ca.completed = 1 THEN 1 END) as completed_challenges,
                        COUNT(ca.id) as total_challenges,
                        COALESCE(SUM(CASE WHEN ca.completed = 1 THEN ca.points ELSE 0 END), 0) as points_earned,
                        MAX(ca.completed_at) as last_activity
                      FROM challenges c
                      LEFT JOIN challenge_attempts ca ON c.id = ca.challenge_id AND ca.user_id = :user_id
                      GROUP BY c.category
                      ORDER BY completed_challenges DESC, points_earned DESC";
            
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':user_id', $userId);
            $stmt->execute();
            
            $skills = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $totalQuery = "SELECT category, COUNT(*) as total_category_challenges
                           FROM challenges
                           GROUP BY category";
            
            $stmt = $this->db->prepare($totalQuery);
            $stmt->execute();
            
            $totals = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            $totalLookup = [];
            foreach ($totals as $total) {
                $totalLookup[$total['category']] = $total['total_category_challenges'];
            }

            $formattedSkills = [];
            foreach ($skills as $skill) {
                $totalChallenges = $totalLookup[$skill['skill_name']] ?? 1;
                $progressPercentage = $totalChallenges > 0 ? 
                    round(($skill['completed_challenges'] / $totalChallenges) * 100, 1) : 0;
                
                $skillLevel = $this->calculateSkillLevel($progressPercentage, $skill['points_earned']);
                
                $formattedSkills[] = [
                    'skill_name' => $skill['skill_name'],
                    'completed_challenges' => (int)$skill['completed_challenges'],
                    'total_challenges' => $totalChallenges,
                    'points_earned' => (int)$skill['points_earned'],
                    'progress_percentage' => $progressPercentage,
                    'skill_level' => $skillLevel,
                    'last_activity' => $skill['last_activity'] ? $this->getTimeAgo($skill['last_activity']) : 'Never'
                ];
            }

            $this->sendResponse([
                'success' => true,
                'skills' => $formattedSkills
            ]);
        } catch (Exception $e) {
            $this->sendResponse(['success' => false, 'message' => 'Failed to fetch user skills: ' . $e->getMessage()], 500);
        }
    }

    private function calculateSkillLevel($progressPercentage, $pointsEarned) {
        if ($progressPercentage >= 90 && $pointsEarned >= 1000) {
            return 'Expert';
        } elseif ($progressPercentage >= 70 && $pointsEarned >= 500) {
            return 'Advanced';
        } elseif ($progressPercentage >= 50 && $pointsEarned >= 200) {
            return 'Intermediate';
        } elseif ($progressPercentage >= 25 && $pointsEarned >= 100) {
            return 'Beginner';
        } else {
            return 'Novice';
        }
    }

    private function updateUserSettings() {
        try {
            $userId = $this->getUserIdFromSession();
            if (!$userId) {
                $this->sendResponse(['success' => false, 'message' => 'User not authenticated'], 401);
                return;
            }

            $input = json_decode(file_get_contents('php://input'), true);
            
            if (!$input) {
                $this->sendResponse(['success' => false, 'message' => 'Invalid JSON data'], 400);
                return;
            }

            $username = trim($input['username'] ?? '');
            $displayName = trim($input['displayName'] ?? '');
            $email = trim($input['email'] ?? '');
            $bio = trim($input['bio'] ?? '');
            $location = trim($input['location'] ?? '');
            $website = trim($input['website'] ?? '');

            if (empty($username)) {
                $this->sendResponse(['success' => false, 'message' => 'Username is required'], 400);
                return;
            }

            if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $this->sendResponse(['success' => false, 'message' => 'Valid email is required'], 400);
                return;
            }

            $checkQuery = "SELECT id FROM users WHERE username = :username AND id != :user_id";
            $stmt = $this->db->prepare($checkQuery);
            $stmt->bindParam(':username', $username);
            $stmt->bindParam(':user_id', $userId);
            $stmt->execute();
            
            if ($stmt->fetch()) {
                $this->sendResponse(['success' => false, 'message' => 'Username is already taken'], 400);
                return;
            }

            $checkQuery = "SELECT id FROM users WHERE email = :email AND id != :user_id";
            $stmt = $this->db->prepare($checkQuery);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':user_id', $userId);
            $stmt->execute();
            
            if ($stmt->fetch()) {
                $this->sendResponse(['success' => false, 'message' => 'Email is already taken'], 400);
                return;
            }

            $updateQuery = "UPDATE users SET username = :username, email = :email, bio = :bio, location = :location, website = :website WHERE id = :user_id";
            $stmt = $this->db->prepare($updateQuery);
            $stmt->bindParam(':username', $username);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':bio', $bio);
            $stmt->bindParam(':location', $location);
            $stmt->bindParam(':website', $website);
            $stmt->bindParam(':user_id', $userId);
            $stmt->execute();

            if (!empty($input['currentPassword']) && !empty($input['newPassword'])) {
                $currentPassword = $input['currentPassword'];
                $newPassword = $input['newPassword'];
                
                $passwordQuery = "SELECT password FROM users WHERE id = :user_id";
                $stmt = $this->db->prepare($passwordQuery);
                $stmt->bindParam(':user_id', $userId);
                $stmt->execute();
                
                $user = $stmt->fetch(PDO::FETCH_ASSOC);
                
                if (!password_verify($currentPassword, $user['password'])) {
                    $this->sendResponse(['success' => false, 'message' => 'Current password is incorrect'], 400);
                    return;
                }
                
                $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
                $passwordUpdateQuery = "UPDATE users SET password = :password WHERE id = :user_id";
                $stmt = $this->db->prepare($passwordUpdateQuery);
                $stmt->bindParam(':password', $hashedPassword);
                $stmt->bindParam(':user_id', $userId);
                $stmt->execute();
            }

            $this->sendResponse([
                'success' => true,
                'message' => 'Settings updated successfully',
                'data' => [
                    'username' => $username,
                    'displayName' => $displayName,
                    'email' => $email,
                    'bio' => $bio,
                    'location' => $location,
                    'website' => $website
                ]
            ]);
        } catch (Exception $e) {
            $this->sendResponse(['success' => false, 'message' => 'Failed to update settings: ' . $e->getMessage()], 500);
        }
    }

    private function getTimeAgo($datetime) {
        try {
            $time = strtotime($datetime);
            $now = time();
            $diff = $now - $time;
            
            if ($diff < 60) {
                return 'Just now';
            } elseif ($diff < 3600) {
                $minutes = floor($diff / 60);
                return $minutes . ' minute' . ($minutes > 1 ? 's' : '') . ' ago';
            } elseif ($diff < 86400) {
                $hours = floor($diff / 3600);
                return $hours . ' hour' . ($hours > 1 ? 's' : '') . ' ago';
            } elseif ($diff < 604800) {
                $days = floor($diff / 86400);
                return $days . ' day' . ($days > 1 ? 's' : '') . ' ago';
            } else {
                return date('M j, Y', $time);
            }
        } catch (Exception $e) {
            return 'Unknown time';
        }
    }

    private function getRealTimeAttempts() {
        try {
            $userId = $this->getUserIdFromSession();
            
            if (!$userId) {
                $this->sendResponse(['success' => false, 'message' => 'User not authenticated'], 401);
                return;
            }

            $challengeId = $_GET['challenge_id'] ?? '';
            
            if (empty($challengeId)) {
                $query = "SELECT ca.challenge_id, ca.attempt_count, ca.completed, c.title 
                          FROM challenge_attempts ca
                          JOIN challenges c ON ca.challenge_id = c.id
                          WHERE ca.user_id = :user_id";
                
                $stmt = $this->db->prepare($query);
                $stmt->bindParam(':user_id', $userId);
                $stmt->execute();
                
                $attempts = $stmt->fetchAll(PDO::FETCH_ASSOC);
                $this->sendResponse(['success' => true, 'attempts' => $attempts]);
            } else {
                $query = "SELECT ca.attempt_count, ca.completed, c.title 
                          FROM challenge_attempts ca
                          JOIN challenges c ON ca.challenge_id = c.id
                          WHERE ca.user_id = :user_id AND ca.challenge_id = :challenge_id
                          LIMIT 1";
                
                $stmt = $this->db->prepare($query);
                $stmt->bindParam(':user_id', $userId);
                $stmt->bindParam(':challenge_id', $challengeId);
                $stmt->execute();
                
                $attempt = $stmt->fetch(PDO::FETCH_ASSOC);
                
                if ($attempt) {
                    $this->sendResponse(['success' => true, 'attempt' => $attempt]);
                } else {
                    $this->sendResponse(['success' => true, 'attempt' => ['attempt_count' => 0, 'completed' => 0]]);
                }
            }
            
        } catch (Exception $e) {
            $this->sendResponse(['success' => false, 'message' => 'Failed to fetch real-time attempts: ' . $e->getMessage()], 500);
        }
    }

    private function getUserIdFromSession() {
        try {
            if (!isset($_COOKIE['cybernest_session'])) {
                return null;
            }
            
            $sessionToken = $_COOKIE['cybernest_session'];
            
            $query = "SELECT user_id FROM user_sessions 
                      WHERE session_token = :session_token 
                      AND expires_at > NOW() 
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
            $query = "UPDATE user_profiles 
                      SET points = points + :points,
                          challenges_completed = challenges_completed + 1,
                          updated_at = NOW()
                      WHERE user_id = :user_id";
            
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':user_id', $userId);
            $stmt->bindParam(':points', $points);
            $stmt->execute();
            
            $this->updateUserRank($userId);
            
        } catch (Exception $e) {
            throw new Exception("Failed to update user stats: " . $e->getMessage());
        }
    }

    private function updateUserRank($userId) {
        try {
            $stmt = $this->db->prepare("SELECT points FROM user_profiles WHERE user_id = :user_id");
            $stmt->bindParam(':user_id', $userId);
            $stmt->execute();
            $userProfile = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if (!$userProfile) {
                return;
            }
            
            $points = $userProfile['points'];
            
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
            
            $stmt = $this->db->prepare("UPDATE user_profiles SET rank = :rank WHERE user_id = :user_id");
            $stmt->bindParam(':user_id', $userId);
            $stmt->bindParam(':rank', $rank);
            $stmt->execute();
            
        } catch (Exception $e) {
            throw new Exception("Failed to update user rank: " . $e->getMessage());
        }
    }

    private function getAttemptsByDay() {
        try {
            $query = "SELECT 
                        DAYNAME(ca.created_at) as day_name,
                        DAYOFWEEK(ca.created_at) as day_of_week,
                        COUNT(CASE WHEN ca.completed = 1 THEN 1 END) as solved_challenges,
                        COUNT(ca.id) as total_attempts
                      FROM challenge_attempts ca
                      WHERE ca.created_at >= DATE_SUB(CURDATE(), INTERVAL 7 DAY)
                      GROUP BY DAYNAME(ca.created_at), DAYOFWEEK(ca.created_at)
                      ORDER BY DAYOFWEEK(ca.created_at)";
            
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
            $solvedChallenges = array_fill(0, 7, 0);
            $totalAttempts = array_fill(0, 7, 0);
            
            foreach ($results as $row) {
                $dayIndex = ($row['day_of_week'] - 2 + 7) % 7;
                $solvedChallenges[$dayIndex] = (int)$row['solved_challenges'];
                $totalAttempts[$dayIndex] = (int)$row['total_attempts'];
            }
            
            $this->sendResponse([
                'success' => true,
                'attempts' => [
                    'labels' => $days,
                    'solved_challenges' => $solvedChallenges,
                    'total_attempts' => $totalAttempts
                ]
            ]);
            
        } catch (Exception $e) {
            $this->sendResponse([
                'success' => false,
                'message' => 'Failed to get attempts by day: ' . $e->getMessage()
            ], 500);
        }
    }

    private function sendResponse($data, $http_code = 200) {
        ob_clean();
        http_response_code($http_code);
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }
}

?>
