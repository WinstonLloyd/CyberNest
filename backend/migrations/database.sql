CREATE TABLE IF NOT EXISTS users (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password_hash VARCHAR(255) NOT NULL,
    display_name VARCHAR(100),
    bio TEXT,
    location VARCHAR(255),
    website VARCHAR(255),
    profile_picture VARCHAR(255) DEFAULT NULL,
    role ENUM('admin', 'user') DEFAULT 'user' NOT NULL,
    is_active BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    last_login TIMESTAMP NULL
);

CREATE TABLE IF NOT EXISTS challenges (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    description TEXT,
    difficulty ENUM('beginner', 'intermediate', 'expert') NOT NULL,
    points INT(11) NOT NULL DEFAULT 0,
    category ENUM('web', 'binary', 'crypto', 'forensics', 'reverse', 'osint') NOT NULL,
    status ENUM('draft', 'active', 'inactive') NOT NULL DEFAULT 'draft',
    flag VARCHAR(255),
    tags VARCHAR(500),
    file_path VARCHAR(500) NULL,
    original_filename VARCHAR(255) NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS user_profiles (
    user_id INT(11) PRIMARY KEY,
    points INT(11) DEFAULT 0,
    challenges_completed INT(11) DEFAULT 0,
    rank VARCHAR(20) DEFAULT 'N/A',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS challenge_attempts (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    user_id INT(11) NOT NULL,
    challenge_id INT(11) NOT NULL,
    completed BOOLEAN DEFAULT FALSE,
    attempt_count INT(11) DEFAULT 1,
    points INT(11) DEFAULT 0,
    completed_at TIMESTAMP NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (challenge_id) REFERENCES challenges(id) ON DELETE CASCADE,
    UNIQUE KEY unique_user_challenge (user_id, challenge_id)
);

CREATE TABLE IF NOT EXISTS user_sessions (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    user_id INT(11) NOT NULL,
    session_token VARCHAR(255) UNIQUE NOT NULL,
    expires_at TIMESTAMP NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

INSERT INTO challenges (title, description, difficulty, points, category, status, flag, tags) VALUES 
('Buffer Overflow Basics',
 'Learn fundamentals of buffer overflow vulnerabilities. This challenge covers stack-based buffer overflows, memory layout, and basic exploitation techniques.',
 'beginner'
 , 150, 
 'binary', 
 'active', 
 'CYBERNEST{buffer_overflow_master}', 'buffer-overflow,stack,memory,beginner'),
('SQL Injection Mastery',
 'Master SQL injection techniques including UNION-based attacks, blind SQL injection, and advanced bypass methods. Test your skills against realistic web applications.',
 'intermediate'
 , 300, 
 'web', 
 'active', 
 'CYBERNEST{sql_injection_expert}', 
 'sql-injection,database,web,intermediate'),
('Advanced ROP Exploitation',
 'Advanced Return-Oriented Programming (ROP) exploitation techniques. Learn to bypass modern security protections like ASLR and NX using sophisticated ROP chains.',
 'expert'
 , 500, 
 'binary', 
 'active', 
 'CYBERNEST{rop_chains_are_fun}', 
 'rop,aslr,nx,expert'),
('Web Security Fundamentals',
 'Introduction to web security vulnerabilities including XSS, CSRF, and basic authentication bypasses. Perfect for beginners starting their cybersecurity journey.',
 'beginner'
 , 100, 
 'web', 
 'draft', 
 'CYBERNEST{web_security_basics}', 
 'xss,csrf,web,beginner'),
('Binary Reverse Engineering',
 'Learn to reverse engineer binary executables. This challenge covers assembly language basics, disassembly tools, and program analysis techniques.',
 'intermediate'
 , 250, 
 'reverse', 
 'inactive', 
 'CYBERNEST{reverse_engineering_pro}', 
 'reverse-engineering,assembly,binary,intermediate');