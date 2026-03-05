<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CyberNest Admin - Challenges</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../../css/admin/dashboard.css">
    <style>
        .challenges-container {
            background: linear-gradient(135deg, rgba(0, 255, 0, 0.05) 0%, rgba(0, 255, 0, 0.02) 100%);
            border: 1px solid var(--primary-color);
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 20px;
        }

        .challenges-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 15px;
        }

        .challenges-header {
            text-align: center;
            margin-bottom: 25px;
        }

        .challenges-title {
            color: var(--primary-color);
            font-size: 1.8rem;
            font-weight: bold;
            text-shadow: 0 0 15px rgba(0, 255, 0, 0.5);
            margin-bottom: 8px;
        }

        .challenges-subtitle {
            color: var(--muted-text);
            font-size: 0.9rem;
        }

        .challenge-card {
            background: rgba(0, 0, 0, 0.8);
            border: 1px solid var(--primary-color);
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 15px;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .challenge-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(45deg, transparent 30%, rgba(0, 255, 0, 0.05) 50%, transparent 70%);
            animation: card-scan 3s linear infinite;
            pointer-events: none;
        }

        @keyframes card-scan {
            0% { transform: translateX(-100%); }
            100% { transform: translateX(100%); }
        }

        .challenge-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(0, 255, 0, 0.3);
            border-color: var(--secondary-color);
        }

        .difficulty-badge {
            padding: 4px 12px;
            border-radius: 15px;
            font-size: 0.7rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .difficulty-beginner {
            background: rgba(0, 255, 0, 0.2);
            color: var(--primary-color);
            border: 1px solid var(--primary-color);
        }

        .difficulty-intermediate {
            background: rgba(255, 165, 0, 0.2);
            color: #ffa500;
            border: 1px solid #ffa500;
        }

        .difficulty-expert {
            background: rgba(255, 0, 0, 0.2);
            color: #ff0000;
            border: 1px solid #ff0000;
        }

        .challenge-stats {
            display: flex;
            gap: 12px;
            margin: 10px 0;
        }

        .stat-item {
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .stat-icon {
            color: var(--primary-color);
            font-size: 0.9rem;
        }

        .stat-value {
            color: var(--light-text);
            font-weight: 600;
            font-size: 0.85rem;
        }

        .challenge-description {
            color: var(--muted-text);
            margin: 10px 0;
            line-height: 1.4;
            font-size: 0.85rem;
        }

        .challenge-tags {
            display: flex;
            flex-wrap: wrap;
            gap: 6px;
            margin: 10px 0;
        }

        .tag {
            padding: 3px 8px;
            border-radius: 12px;
            font-size: 0.7rem;
            background: rgba(0, 255, 0, 0.1);
            color: var(--primary-color);
            border: 1px solid rgba(0, 255, 0, 0.3);
        }

        .action-buttons {
            display: flex;
            gap: 6px;
            margin-top: 15px;
        }

        .btn-action {
            padding: 6px 12px;
            border-radius: 4px;
            border: 1px solid var(--primary-color);
            background: transparent;
            color: var(--primary-color);
            font-size: 0.8rem;
            transition: all 0.3s ease;
            text-decoration: none;
        }

        .btn-action:hover {
            background: rgba(0, 255, 0, 0.2);
            transform: scale(1.05);
            color: var(--primary-color);
        }

        .btn-action.danger {
            border-color: #ff0000;
            color: #ff0000;
        }

        .btn-action.danger:hover {
            background: rgba(255, 0, 0, 0.2);
            color: #ff0000;
        }

        .filter-section {
            background: rgba(0, 255, 0, 0.05);
            border: 1px solid var(--primary-color);
            border-radius: 6px;
            padding: 15px;
            margin-bottom: 20px;
        }

        .search-box {
            position: relative;
            max-width: 250px;
        }

        .search-box input {
            background: rgba(0, 0, 0, 0.8);
            border: 1px solid var(--primary-color);
            color: var(--primary-color);
            padding: 8px 12px;
            border-radius: 6px;
            width: 100%;
            font-size: 0.85rem;
        }

        .search-box input:focus {
            outline: none;
            box-shadow: 0 0 10px rgba(0, 255, 0, 0.3);
            border-color: var(--primary-color);
        }

        .search-box i {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--primary-color);
            font-size: 0.85rem;
        }

        .filter-select {
            background: rgba(0, 0, 0, 0.8);
            border: 1px solid var(--primary-color);
            color: var(--primary-color);
            padding: 8px 12px;
            border-radius: 6px;
            font-size: 0.85rem;
        }

        .filter-select:focus {
            outline: none;
            box-shadow: 0 0 10px rgba(0, 255, 0, 0.3);
            border-color: var(--primary-color);
        }

        .filter-select option {
            background: var(--darker-bg);
            color: var(--primary-color);
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 15px;
            margin-bottom: 20px;
        }

        .stat-card {
            background: linear-gradient(135deg, rgba(0, 255, 0, 0.1) 0%, rgba(0, 255, 0, 0.05) 100%);
            border: 1px solid var(--primary-color);
            border-radius: 8px;
            padding: 15px;
            text-align: center;
            transition: all 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(0, 255, 0, 0.3);
        }

        .stat-number {
            font-size: 1.5rem;
            font-weight: bold;
            color: var(--primary-color);
            text-shadow: 0 0 8px rgba(0, 255, 0, 0.5);
        }

        .stat-label {
            color: var(--muted-text);
            font-size: 0.8rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .add-challenge-btn {
            position: fixed;
            bottom: 30px;
            right: 30px;
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background: var(--primary-color);
            color: var(--darker-bg);
            border: none;
            font-size: 1.5rem;
            box-shadow: 0 4px 20px rgba(0, 255, 0, 0.4);
            transition: all 0.3s ease;
            z-index: 1000;
        }

        .add-challenge-btn:hover {
            transform: scale(1.1);
            box-shadow: 0 6px 30px rgba(0, 255, 0, 0.6);
        }

        .modal-content {
            background: var(--darker-bg);
            border: 1px solid var(--primary-color);
        }

        .modal-header {
            background: rgba(0, 255, 0, 0.1);
            border-bottom: 1px solid var(--primary-color);
        }

        .modal-title {
            color: var(--primary-color);
        }

        .modal-body {
            color: var(--light-text);
        }

        .form-control, .form-select {
            background: rgba(0, 0, 0, 0.8);
            border: 1px solid var(--primary-color);
            color: var(--primary-color);
        }

        .form-control:focus, .form-select:focus {
            background: rgba(0, 0, 0, 0.8);
            border-color: var(--primary-color);
            box-shadow: 0 0 10px rgba(0, 255, 0, 0.3);
            color: var(--primary-color);
        }

        .form-label {
            color: var(--primary-color);
        }

        .btn-close {
            filter: invert(1);
        }

        .trophy-icon {
            font-size: 3rem;
            color: var(--primary-color);
            margin-bottom: 20px;
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0% { opacity: 1; transform: scale(1); }
            50% { opacity: 0.7; transform: scale(1.1); }
            100% { opacity: 1; transform: scale(1); }
        }

        @media (max-width: 768px) {
            .challenges-title {
                font-size: 2rem;
            }
            
            .stats-grid {
                grid-template-columns: 1fr;
            }
            
            .filter-section {
                text-align: center;
            }
            
            .search-box {
                max-width: 100%;
                margin-bottom: 15px;
            }
            
            .challenge-stats {
                flex-direction: column;
                gap: 10px;
            }
            
            .action-buttons {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <nav class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <h3><i class="fas fa-shield-alt me-2"></i>CYBERNEST</h3>
            <small class="text-muted">Admin Panel</small>
        </div>
        <div class="sidebar-menu">
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link" href="dashboard.php">
                        <i class="fas fa-tachometer-alt"></i>
                        Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" target="_blank" href="../terminal.html">
                        <i class="fas fa-terminal"></i>
                        Terminal
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="challenges.php">
                        <i class="fas fa-trophy"></i>
                        Challenges
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="leaderboard.php">
                        <i class="fas fa-chart-line"></i>
                        Leaderboard
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="users.php">
                        <i class="fas fa-users"></i>
                        Users
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="settings.php">
                        <i class="fas fa-cog"></i>
                        Settings
                    </a>
                </li>
                <li class="nav-item mt-3">
                    <a class="nav-link" href="../../index.html">
                        <i class="fas fa-sign-out-alt"></i>
                        Logout
                    </a>
                </li>
            </ul>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="main-content">
        <!-- Top Header -->
        <header class="top-header">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="h3 mb-0">Challenges</h1>
                    <small class="text-muted">Manage hacking challenges & competitions</small>
                </div>
                <div class="d-flex align-items-center">
                    <div class="me-3">
                        <span class="badge bg-success pulse">System Online</span>
                    </div>
                    <div class="dropdown">
                        <button class="btn btn-outline-success btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown">
                            <i class="fas fa-user-circle me-2"></i>Admin
                        </button>
                        <ul class="dropdown-menu dropdown-menu-dark dropdown-menu-end">
                            <li><a class="dropdown-item" href="#profile">Profile</a></li>
                            <li><a class="dropdown-item" href="#settings">Settings</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="#logout">Logout</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </header>

        <!-- Challenges Content -->
        <div class="container-fluid">
            <!-- Header -->
            <div class="challenges-header">
                <i class="fas fa-trophy trophy-icon"></i>
                <h2 class="challenges-title">CYBERNEST CHALLENGES</h2>
                <p class="challenges-subtitle">Manage hacking challenges and competitions</p>
            </div>

            <!-- Stats Grid -->
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-number">45</div>
                    <div class="stat-label">Total Challenges</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number">12</div>
                    <div class="stat-label">Beginner</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number">18</div>
                    <div class="stat-label">Intermediate</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number">15</div>
                    <div class="stat-label">Expert</div>
                </div>
            </div>

            <!-- Filter Section -->
            <div class="filter-section">
                <div class="row align-items-center">
                    <div class="col-md-4">
                        <div class="search-box">
                            <input type="text" id="searchInput" placeholder="Search challenges...">
                            <i class="fas fa-search"></i>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <select class="filter-select" id="difficultyFilter">
                            <option value="all">All Difficulties</option>
                            <option value="beginner">Beginner</option>
                            <option value="intermediate">Intermediate</option>
                            <option value="expert">Expert</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <select class="filter-select" id="statusFilter">
                            <option value="all">All Status</option>
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                            <option value="draft">Draft</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <button class="btn btn-success w-100" onclick="refreshChallenges()">
                            <i class="fas fa-sync-alt me-2"></i>Refresh
                        </button>
                    </div>
                </div>
            </div>

            <!-- Challenges List -->
            <div class="challenges-container">
                <div class="challenges-grid">
                    <!-- Challenge 1 -->
                    <div class="challenge-card">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div>
                                <h5 class="text-success mb-2">Buffer Overflow Basics</h5>
                                <span class="difficulty-badge difficulty-beginner">Beginner</span>
                            </div>
                            <div class="text-end">
                                <div class="badge bg-success">Active</div>
                            </div>
                        </div>
                        
                        <div class="challenge-stats">
                            <div class="stat-item">
                                <i class="fas fa-users stat-icon"></i>
                                <span class="stat-value">234 attempts</span>
                            </div>
                            <div class="stat-item">
                                <i class="fas fa-check-circle stat-icon"></i>
                                <span class="stat-value">89 solved</span>
                            </div>
                            <div class="stat-item">
                                <i class="fas fa-trophy stat-icon"></i>
                                <span class="stat-value">150 points</span>
                            </div>
                        </div>
                        
                        <div class="challenge-description">
                            Learn the fundamentals of buffer overflow vulnerabilities. This challenge covers stack-based buffer overflows, memory layout, and basic exploitation techniques.
                        </div>
                        
                        <div class="challenge-tags">
                            <span class="tag">buffer-overflow</span>
                            <span class="tag">stack</span>
                            <span class="tag">memory</span>
                            <span class="tag">beginner</span>
                        </div>
                        
                        <div class="action-buttons">
                            <a href="#" class="btn-action" onclick="viewChallenge('buffer-overflow-basics')">
                                <i class="fas fa-eye me-2"></i>View
                            </a>
                            <a href="#" class="btn-action" onclick="editChallenge('buffer-overflow-basics')">
                                <i class="fas fa-edit me-2"></i>Edit
                            </a>
                            <a href="#" class="btn-action danger" onclick="deleteChallenge('buffer-overflow-basics')">
                                <i class="fas fa-trash me-2"></i>Delete
                            </a>
                        </div>
                    </div>

                    <!-- Challenge 2 -->
                    <div class="challenge-card">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div>
                                <h5 class="text-success mb-2">SQL Injection Mastery</h5>
                                <span class="difficulty-badge difficulty-intermediate">Intermediate</span>
                            </div>
                            <div class="text-end">
                                <div class="badge bg-success">Active</div>
                            </div>
                        </div>
                        
                        <div class="challenge-stats">
                            <div class="stat-item">
                                <i class="fas fa-users stat-icon"></i>
                                <span class="stat-value">156 attempts</span>
                            </div>
                            <div class="stat-item">
                                <i class="fas fa-check-circle stat-icon"></i>
                                <span class="stat-value">45 solved</span>
                            </div>
                            <div class="stat-item">
                                <i class="fas fa-trophy stat-icon"></i>
                                <span class="stat-value">300 points</span>
                            </div>
                        </div>
                        
                        <div class="challenge-description">
                            Master SQL injection techniques including UNION-based attacks, blind SQL injection, and advanced bypass methods. Test your skills against realistic web applications.
                        </div>
                        
                        <div class="challenge-tags">
                            <span class="tag">sql-injection</span>
                            <span class="tag">database</span>
                            <span class="tag">web</span>
                            <span class="tag">intermediate</span>
                        </div>
                        
                        <div class="action-buttons">
                            <a href="#" class="btn-action" onclick="viewChallenge('sql-injection-mastery')">
                                <i class="fas fa-eye me-2"></i>View
                            </a>
                            <a href="#" class="btn-action" onclick="editChallenge('sql-injection-mastery')">
                                <i class="fas fa-edit me-2"></i>Edit
                            </a>
                            <a href="#" class="btn-action danger" onclick="deleteChallenge('sql-injection-mastery')">
                                <i class="fas fa-trash me-2"></i>Delete
                            </a>
                        </div>
                    </div>

                    <!-- Challenge 3 -->
                    <div class="challenge-card">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div>
                                <h5 class="text-success mb-2">Advanced ROP Exploitation</h5>
                                <span class="difficulty-badge difficulty-expert">Expert</span>
                            </div>
                            <div class="text-end">
                                <div class="badge bg-success">Active</div>
                            </div>
                        </div>
                        
                        <div class="challenge-stats">
                            <div class="stat-item">
                                <i class="fas fa-users stat-icon"></i>
                                <span class="stat-value">67 attempts</span>
                            </div>
                            <div class="stat-item">
                                <i class="fas fa-check-circle stat-icon"></i>
                                <span class="stat-value">12 solved</span>
                            </div>
                            <div class="stat-item">
                                <i class="fas fa-trophy stat-icon"></i>
                                <span class="stat-value">500 points</span>
                            </div>
                        </div>
                        
                        <div class="challenge-description">
                            Advanced Return-Oriented Programming (ROP) exploitation techniques. Learn to bypass modern security protections like ASLR and NX using sophisticated ROP chains.
                        </div>
                        
                        <div class="challenge-tags">
                            <span class="tag">rop</span>
                            <span class="tag">aslr</span>
                            <span class="tag">nx</span>
                            <span class="tag">expert</span>
                        </div>
                        
                        <div class="action-buttons">
                            <a href="#" class="btn-action" onclick="viewChallenge('advanced-rop-exploitation')">
                                <i class="fas fa-eye me-2"></i>View
                            </a>
                            <a href="#" class="btn-action" onclick="editChallenge('advanced-rop-exploitation')">
                                <i class="fas fa-edit me-2"></i>Edit
                            </a>
                            <a href="#" class="btn-action danger" onclick="deleteChallenge('advanced-rop-exploitation')">
                                <i class="fas fa-trash me-2"></i>Delete
                            </a>
                        </div>
                    </div>

                    <!-- Challenge 4 -->
                    <div class="challenge-card">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div>
                                <h5 class="text-success mb-2">Web Security Fundamentals</h5>
                                <span class="difficulty-badge difficulty-beginner">Beginner</span>
                            </div>
                            <div class="text-end">
                                <div class="badge bg-warning">Draft</div>
                            </div>
                        </div>
                        
                        <div class="challenge-stats">
                            <div class="stat-item">
                                <i class="fas fa-users stat-icon"></i>
                                <span class="stat-value">0 attempts</span>
                            </div>
                            <div class="stat-item">
                                <i class="fas fa-check-circle stat-icon"></i>
                                <span class="stat-value">0 solved</span>
                            </div>
                            <div class="stat-item">
                                <i class="fas fa-trophy stat-icon"></i>
                                <span class="stat-value">100 points</span>
                            </div>
                        </div>
                        
                        <div class="challenge-description">
                            Introduction to web security vulnerabilities including XSS, CSRF, and basic authentication bypasses. Perfect for beginners starting their cybersecurity journey.
                        </div>
                        
                        <div class="challenge-tags">
                            <span class="tag">xss</span>
                            <span class="tag">csrf</span>
                            <span class="tag">web</span>
                            <span class="tag">beginner</span>
                        </div>
                        
                        <div class="action-buttons">
                            <a href="#" class="btn-action" onclick="viewChallenge('web-security-fundamentals')">
                                <i class="fas fa-eye me-2"></i>View
                            </a>
                            <a href="#" class="btn-action" onclick="editChallenge('web-security-fundamentals')">
                                <i class="fas fa-edit me-2"></i>Edit
                            </a>
                            <a href="#" class="btn-action" onclick="publishChallenge('web-security-fundamentals')">
                                <i class="fas fa-rocket me-2"></i>Publish
                            </a>
                            <a href="#" class="btn-action danger" onclick="deleteChallenge('web-security-fundamentals')">
                                <i class="fas fa-trash me-2"></i>Delete
                            </a>
                        </div>
                    </div>

                    <!-- Challenge 5 -->
                    <div class="challenge-card">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div>
                                <h5 class="text-success mb-2">Binary Reverse Engineering</h5>
                                <span class="difficulty-badge difficulty-intermediate">Intermediate</span>
                            </div>
                            <div class="text-end">
                                <div class="badge bg-danger">Inactive</div>
                            </div>
                        </div>
                        
                        <div class="challenge-stats">
                            <div class="stat-item">
                                <i class="fas fa-users stat-icon"></i>
                                <span class="stat-value">89 attempts</span>
                            </div>
                            <div class="stat-item">
                                <i class="fas fa-check-circle stat-icon"></i>
                                <span class="stat-value">23 solved</span>
                            </div>
                            <div class="stat-item">
                                <i class="fas fa-trophy stat-icon"></i>
                                <span class="stat-value">250 points</span>
                            </div>
                        </div>
                        
                        <div class="challenge-description">
                            Learn to reverse engineer binary executables. This challenge covers assembly language basics, disassembly tools, and program analysis techniques.
                        </div>
                        
                        <div class="challenge-tags">
                            <span class="tag">reverse-engineering</span>
                            <span class="tag">assembly</span>
                            <span class="tag">binary</span>
                            <span class="tag">intermediate</span>
                        </div>
                        
                        <div class="action-buttons">
                            <a href="#" class="btn-action" onclick="viewChallenge('binary-reverse-engineering')">
                                <i class="fas fa-eye me-2"></i>View
                            </a>
                            <a href="#" class="btn-action" onclick="editChallenge('binary-reverse-engineering')">
                                <i class="fas fa-edit me-2"></i>Edit
                            </a>
                            <a href="#" class="btn-action" onclick="activateChallenge('binary-reverse-engineering')">
                                <i class="fas fa-power-off me-2"></i>Activate
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Add Challenge Button -->
    <button class="add-challenge-btn" data-bs-toggle="modal" data-bs-target="#addChallengeModal">
        <i class="fas fa-plus"></i>
    </button>

    <!-- Add Challenge Modal -->
    <div class="modal fade" id="addChallengeModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add New Challenge</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="addChallengeForm">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Challenge Name</label>
                                <input type="text" class="form-control" id="challengeName" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Difficulty</label>
                                <select class="form-select" id="challengeDifficulty" required>
                                    <option value="">Select difficulty</option>
                                    <option value="beginner">Beginner</option>
                                    <option value="intermediate">Intermediate</option>
                                    <option value="expert">Expert</option>
                                </select>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Description</label>
                            <textarea class="form-control" id="challengeDescription" rows="3" required></textarea>
                        </div>
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Points</label>
                                <input type="number" class="form-control" id="challengePoints" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Category</label>
                                <select class="form-select" id="challengeCategory" required>
                                    <option value="">Select category</option>
                                    <option value="web">Web Security</option>
                                    <option value="binary">Binary Exploitation</option>
                                    <option value="crypto">Cryptography</option>
                                    <option value="forensics">Digital Forensics</option>
                                </select>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Status</label>
                                <select class="form-select" id="challengeStatus" required>
                                    <option value="draft">Draft</option>
                                    <option value="active">Active</option>
                                    <option value="inactive">Inactive</option>
                                </select>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Tags (comma-separated)</label>
                            <input type="text" class="form-control" id="challengeTags" placeholder="xss, sql-injection, web">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-success" onclick="saveChallenge()">Save Challenge</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../../javascript/admin-dashboard.js"></script>
    <script>
        // Challenges specific functionality
        document.addEventListener('DOMContentLoaded', function() {
            // Search functionality
            const searchInput = document.getElementById('searchInput');
            if (searchInput) {
                searchInput.addEventListener('input', function() {
                    const searchTerm = this.value.toLowerCase();
                    const challenges = document.querySelectorAll('.challenge-card');
                    
                    challenges.forEach(challenge => {
                        const title = challenge.querySelector('h4').textContent.toLowerCase();
                        const description = challenge.querySelector('.challenge-description').textContent.toLowerCase();
                        const tags = Array.from(challenge.querySelectorAll('.tag')).map(tag => tag.textContent.toLowerCase()).join(' ');
                        
                        if (title.includes(searchTerm) || description.includes(searchTerm) || tags.includes(searchTerm)) {
                            challenge.style.display = '';
                        } else {
                            challenge.style.display = 'none';
                        }
                    });
                });
            }

            // Filter functionality
            const difficultyFilter = document.getElementById('difficultyFilter');
            const statusFilter = document.getElementById('statusFilter');
            
            if (difficultyFilter) {
                difficultyFilter.addEventListener('change', function() {
                    filterChallenges();
                });
            }

            if (statusFilter) {
                statusFilter.addEventListener('change', function() {
                    filterChallenges();
                });
            }

            function filterChallenges() {
                const difficulty = difficultyFilter.value;
                const status = statusFilter.value;
                const challenges = document.querySelectorAll('.challenge-card');
                
                challenges.forEach(challenge => {
                    let show = true;
                    
                    if (difficulty !== 'all') {
                        const difficultyBadge = challenge.querySelector('.difficulty-badge');
                        if (!difficultyBadge || !difficultyBadge.textContent.toLowerCase().includes(difficulty)) {
                            show = false;
                        }
                    }
                    
                    if (status !== 'all') {
                        const statusBadge = challenge.querySelector('.badge');
                        if (!statusBadge || !statusBadge.textContent.toLowerCase().includes(status)) {
                            show = false;
                        }
                    }
                    
                    challenge.style.display = show ? '' : 'none';
                });
            }

            // Refresh challenges
            window.refreshChallenges = function() {
                console.log('Refreshing challenges...');
                const refreshBtn = event.target;
                refreshBtn.innerHTML = '<i class="fas fa-sync-alt fa-spin me-2"></i>Refreshing...';
                refreshBtn.disabled = true;
                
                setTimeout(() => {
                    refreshBtn.innerHTML = '<i class="fas fa-sync-alt me-2"></i>Refresh';
                    refreshBtn.disabled = false;
                    console.log('Challenges refreshed');
                }, 2000);
            };

            // Challenge actions
            window.viewChallenge = function(challengeId) {
                console.log('Viewing challenge:', challengeId);
                alert(`Viewing challenge: ${challengeId}`);
            };

            window.editChallenge = function(challengeId) {
                console.log('Editing challenge:', challengeId);
                alert(`Editing challenge: ${challengeId}`);
            };

            window.viewSubmissions = function(challengeId) {
                console.log('Viewing submissions for:', challengeId);
                alert(`Viewing submissions for: ${challengeId}`);
            };

            window.deleteChallenge = function(challengeId) {
                if (confirm(`Are you sure you want to delete challenge "${challengeId}"?`)) {
                    console.log('Deleting challenge:', challengeId);
                    alert(`Challenge "${challengeId}" deleted successfully!`);
                }
            };

            window.publishChallenge = function(challengeId) {
                if (confirm(`Are you sure you want to publish challenge "${challengeId}"?`)) {
                    console.log('Publishing challenge:', challengeId);
                    alert(`Challenge "${challengeId}" published successfully!`);
                }
            };

            window.activateChallenge = function(challengeId) {
                if (confirm(`Are you sure you want to activate challenge "${challengeId}"?`)) {
                    console.log('Activating challenge:', challengeId);
                    alert(`Challenge "${challengeId}" activated successfully!`);
                }
            };

            // Save challenge
            window.saveChallenge = function() {
                const form = document.getElementById('addChallengeForm');
                if (form.checkValidity()) {
                    console.log('Saving new challenge...');
                    const modal = bootstrap.Modal.getInstance(document.getElementById('addChallengeModal'));
                    modal.hide();
                    form.reset();
                    alert('Challenge saved successfully!');
                } else {
                    form.reportValidity();
                }
            };

            // Simulate real-time updates
            setInterval(() => {
                const stats = document.querySelectorAll('.stat-value');
                stats.forEach(stat => {
                    if (stat.textContent.includes('attempts') || stat.textContent.includes('solved')) {
                        const currentValue = parseInt(stat.textContent);
                        const change = Math.floor(Math.random() * 3) - 1;
                        const newValue = Math.max(0, currentValue + change);
                        stat.textContent = newValue + ' ' + (stat.textContent.includes('attempts') ? 'attempts' : 'solved');
                    }
                });
            }, 15000);
        });
    </script>
</body>
</html>