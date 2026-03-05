<?php
// Script to insert sample challenges into database
require_once 'backend/config/database.php';

try {
    $database = new Database();
    $conn = $database->getConnection();
    
    // Clear existing challenges first
    $conn->exec("DELETE FROM challenges");
    echo "Cleared existing challenges\n";
    
    // Sample challenges data
    $sample_challenges = [
        [
            'title' => 'Buffer Overflow Basics',
            'description' => 'Learn fundamentals of buffer overflow vulnerabilities. This challenge covers stack-based buffer overflows, memory layout, and basic exploitation techniques.',
            'difficulty' => 'beginner',
            'points' => 150,
            'category' => 'binary',
            'status' => 'active',
            'flag' => 'CYBERNEST{buffer_overflow_master}',
            'tags' => 'buffer-overflow,stack,memory,beginner'
        ],
        [
            'title' => 'SQL Injection Mastery',
            'description' => 'Master SQL injection techniques including UNION-based attacks, blind SQL injection, and advanced bypass methods. Test your skills against realistic web applications.',
            'difficulty' => 'intermediate',
            'points' => 300,
            'category' => 'web',
            'status' => 'active',
            'flag' => 'CYBERNEST{sql_injection_expert}',
            'tags' => 'sql-injection,database,web,intermediate'
        ],
        [
            'title' => 'Advanced ROP Exploitation',
            'description' => 'Advanced Return-Oriented Programming (ROP) exploitation techniques. Learn to bypass modern security protections like ASLR and NX using sophisticated ROP chains.',
            'difficulty' => 'expert',
            'points' => 500,
            'category' => 'binary',
            'status' => 'inactive',
            'flag' => 'CYBERNEST{rop_expert_ninja}',
            'tags' => 'rop,exploitation,binary,expert'
        ],
        [
            'title' => 'Web Security Fundamentals',
            'description' => 'Introduction to web security vulnerabilities including XSS, CSRF, and basic authentication bypasses. Perfect for beginners starting their cybersecurity journey.',
            'difficulty' => 'beginner',
            'points' => 100,
            'category' => 'web',
            'status' => 'draft',
            'flag' => 'CYBERNEST{web_security_basics}',
            'tags' => 'xss,csrf,web,beginner'
        ],
        [
            'title' => 'Binary Reverse Engineering',
            'description' => 'Learn to reverse engineer binary executables. This challenge covers assembly language basics, disassembly tools, and program analysis techniques.',
            'difficulty' => 'intermediate',
            'points' => 250,
            'category' => 'reverse',
            'status' => 'inactive',
            'flag' => 'CYBERNEST{reverse_engineering_pro}',
            'tags' => 'reverse-engineering,assembly,binary,intermediate'
        ]
    ];
    
    // Insert sample challenges
    foreach ($sample_challenges as $challenge) {
        $stmt = $conn->prepare("INSERT INTO challenges (title, description, difficulty, points, category, status, flag, tags) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([
            $challenge['title'],
            $challenge['description'],
            $challenge['difficulty'],
            $challenge['points'],
            $challenge['category'],
            $challenge['status'],
            $challenge['flag'],
            $challenge['tags']
        ]);
        echo "Inserted: {$challenge['title']}\n";
    }
    
    echo "\nSuccessfully inserted " . count($sample_challenges) . " sample challenges!\n";
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
?>
