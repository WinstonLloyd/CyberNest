<?php
class Challenge {
    private $db;
    private $conn;

    public function __construct($database) {
        $this->db = $database;
        $this->conn = $this->db->getConnection();
    }

    public function getAllChallenges($filters = []) {
        try {
            $query = "SELECT c.*, 
                             COUNT(DISTINCT ca.user_id) as attempts,
                             COUNT(DISTINCT CASE WHEN ca.completed = 1 THEN ca.user_id END) as solved_count
                      FROM challenges c
                      LEFT JOIN challenge_attempts ca ON c.id = ca.challenge_id";
            
            $where_clauses = [];
            $params = [];
            
            if (!empty($filters['difficulty'])) {
                $where_clauses[] = "c.difficulty = :difficulty";
                $params[':difficulty'] = $filters['difficulty'];
            }
            
            if (!empty($filters['status'])) {
                $where_clauses[] = "c.status = :status";
                $params[':status'] = $filters['status'];
            }
            
            if (!empty($filters['search'])) {
                $where_clauses[] = "(c.title LIKE :search OR c.description LIKE :search OR c.tags LIKE :search)";
                $params[':search'] = '%' . $filters['search'] . '%';
            }
            
            if (!empty($where_clauses)) {
                $query .= " WHERE " . implode(' AND ', $where_clauses);
            }
            
            $query .= " GROUP BY c.id ORDER BY c.points DESC, c.created_at DESC";
            
            $stmt = $this->conn->prepare($query);
            $stmt->execute($params);
            
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            throw new Exception("Failed to fetch challenges: " . $e->getMessage());
        }
    }

    public function getChallengeById($id) {
        try {
            $query = "SELECT c.*, 
                             COUNT(DISTINCT ca.user_id) as attempts,
                             COUNT(DISTINCT CASE WHEN ca.completed = 1 THEN ca.user_id END) as solved_count
                      FROM challenges c
                      LEFT JOIN challenge_attempts ca ON c.id = ca.challenge_id
                      WHERE c.id = :id
                      GROUP BY c.id
                      LIMIT 1";
            
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            throw new Exception("Failed to fetch challenge: " . $e->getMessage());
        }
    }

    public function createChallenge($data) {
        try {
            $query = "INSERT INTO challenges (title, description, difficulty, points, category, status, flag, tags, file_path, original_filename, created_at) 
                      VALUES (:title, :description, :difficulty, :points, :category, :status, :flag, :tags, :file_path, :original_filename, NOW())";
            
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':title', $data['title']);
            $stmt->bindParam(':description', $data['description']);
            $stmt->bindParam(':difficulty', $data['difficulty']);
            $stmt->bindParam(':points', $data['points']);
            $stmt->bindParam(':category', $data['category']);
            $stmt->bindParam(':status', $data['status']);
            $stmt->bindParam(':flag', $data['flag']);
            $stmt->bindParam(':tags', $data['tags']);
            
            $file_path = $data['file_path'] ?? null;
            $original_filename = $data['original_filename'] ?? null;
            $stmt->bindParam(':file_path', $file_path);
            $stmt->bindParam(':original_filename', $original_filename);
            
            $stmt->execute();
            return $this->conn->lastInsertId();
        } catch (Exception $e) {
            throw new Exception("Failed to create challenge: " . $e->getMessage());
        }
    }

    public function updateChallenge($id, $data) {
        try {
            $query = "UPDATE challenges 
                      SET title = :title, description = :description, difficulty = :difficulty, 
                          points = :points, category = :category, status = :status, flag = :flag, tags = :tags,
                          file_path = :file_path, original_filename = :original_filename, updated_at = NOW()
                      WHERE id = :id";
            
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':id', $id);
            $stmt->bindParam(':title', $data['title']);
            $stmt->bindParam(':description', $data['description']);
            $stmt->bindParam(':difficulty', $data['difficulty']);
            $stmt->bindParam(':points', $data['points']);
            $stmt->bindParam(':category', $data['category']);
            $stmt->bindParam(':status', $data['status']);
            $stmt->bindParam(':flag', $data['flag']);
            $stmt->bindParam(':tags', $data['tags']);
            
            $file_path = $data['file_path'] ?? null;
            $original_filename = $data['original_filename'] ?? null;
            $stmt->bindParam(':file_path', $file_path);
            $stmt->bindParam(':original_filename', $original_filename);
            
            return $stmt->execute();
        } catch (Exception $e) {
            throw new Exception("Failed to update challenge: " . $e->getMessage());
        }
    }

    public function deleteChallenge($id) {
        try {
            $query = "DELETE FROM challenge_attempts WHERE challenge_id = :id";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            
            $query = "DELETE FROM challenges WHERE id = :id";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':id', $id);
            
            return $stmt->execute();
        } catch (Exception $e) {
            throw new Exception("Failed to delete challenge: " . $e->getMessage());
        }
    }

    public function getChallengeStats() {
        try {
            $stats = [];
            
            $stmt = $this->conn->query("SELECT COUNT(*) as total FROM challenges");
            $stats['total_challenges'] = $stmt->fetch(PDO::FETCH_ASSOC)['total'];
            
            $stmt = $this->conn->query("SELECT difficulty, COUNT(*) as count FROM challenges GROUP BY difficulty");
            $stats['by_difficulty'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            $stmt = $this->conn->query("SELECT status, COUNT(*) as count FROM challenges GROUP BY status");
            $stats['by_status'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            $stmt = $this->conn->query("SELECT COUNT(*) as total FROM challenge_attempts");
            $stats['total_attempts'] = $stmt->fetch(PDO::FETCH_ASSOC)['total'];
            
            $stmt = $this->conn->query("SELECT COUNT(*) as total FROM challenge_attempts WHERE completed = 1");
            $stats['total_solves'] = $stmt->fetch(PDO::FETCH_ASSOC)['total'];
            
            return $stats;
        } catch (Exception $e) {
            throw new Exception("Failed to fetch challenge stats: " . $e->getMessage());
        }
    }

    public function getChallengesForUser($userId, $filters = []) {
        try {
            $query = "SELECT c.*, 
                             COALESCE(ca.completed, 0) as user_completed,
                             COALESCE(ca.attempt_count, 0) as user_attempts,
                             COALESCE(ca.points, 0) as user_points,
                             ca.completed_at as user_completed_at,
                             COUNT(DISTINCT ca2.user_id) as attempts,
                             COUNT(DISTINCT CASE WHEN ca2.completed = 1 THEN ca2.user_id END) as solved_count
                      FROM challenges c
                      LEFT JOIN challenge_attempts ca ON c.id = ca.challenge_id AND ca.user_id = :user_id
                      LEFT JOIN challenge_attempts ca2 ON c.id = ca2.challenge_id";
            
            $where_clauses = [];
            $params = [':user_id' => $userId];
            
            if (!empty($filters['difficulty'])) {
                $where_clauses[] = "c.difficulty = :difficulty";
                $params[':difficulty'] = $filters['difficulty'];
            }
            
            if (!empty($filters['status'])) {
                $where_clauses[] = "c.status = :status";
                $params[':status'] = $filters['status'];
            }
            
            if (!empty($filters['search'])) {
                $where_clauses[] = "(c.title LIKE :search OR c.description LIKE :search OR c.tags LIKE :search)";
                $params[':search'] = '%' . $filters['search'] . '%';
            }
            
            if (!empty($where_clauses)) {
                $query .= " WHERE " . implode(' AND ', $where_clauses);
            }
            
            $query .= " GROUP BY c.id ORDER BY c.points DESC, c.created_at DESC";
            
            $stmt = $this->conn->prepare($query);
            $stmt->execute($params);
            
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            throw new Exception("Failed to fetch user challenges: " . $e->getMessage());
        }
    }

    public function getTopPerformers($limit = 10) {
        try {
            $query = "SELECT u.username, u.display_name, 
                             COUNT(DISTINCT ca.challenge_id) as challenges_solved,
                             SUM(c.points) as total_points
                      FROM challenge_attempts ca
                      JOIN challenges c ON ca.challenge_id = c.id
                      JOIN users u ON ca.user_id = u.id
                      WHERE ca.completed = 1
                      GROUP BY u.id, u.username, u.display_name
                      ORDER BY total_points DESC, challenges_solved DESC
                      LIMIT :limit";
            
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
            $stmt->execute();
            
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            throw new Exception("Failed to fetch top performers: " . $e->getMessage());
        }
    }
}
?>
