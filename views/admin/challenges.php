<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CyberNest Admin - Challenges</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../../css/admin/dashboard.css">
    <link rel="stylesheet" href="../../css/admin/challenges.css">
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
                    <a class="nav-link" target="_blank" href="../terminals.html">
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
                    <a class="nav-link" href="#" onclick="logout()">
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
                            <li><a class="dropdown-item" href="#l" onclick="logout()">Logout</a></li>
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
                <!-- Stats will be loaded dynamically here -->
            </div>

            <!-- Filter Section -->
            <div class="filter-section">
                <div class="row align-items-center">
                    <div class="col-md-3">
                        <div class="search-box">
                            <input type="text" id="searchInput" placeholder="Search challenges...">
                            <i class="fas fa-search"></i>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <select class="filter-select" id="categoryFilter">
                            <option value="all">All Categories</option>
                            <option value="web">Web Security</option>
                            <option value="binary">Binary Exploitation</option>
                            <option value="crypto">Cryptography</option>
                            <option value="forensics">Digital Forensics</option>
                            <option value="reverse">Reverse Engineering</option>
                            <option value="osint">OSINT</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <select class="filter-select" id="difficultyFilter">
                            <option value="all">All Difficulties</option>
                            <option value="beginner">Beginner</option>
                            <option value="intermediate">Intermediate</option>
                            <option value="expert">Expert</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <select class="filter-select" id="statusFilter">
                            <option value="all">All Status</option>
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                            <option value="draft">Draft</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <button class="btn btn-success w-100" onclick="refreshChallenges()">
                            <i class="fas fa-sync-alt me-2"></i>Refresh
                        </button>
                    </div>
                </div>
            </div>

            <div class="challenges-container">
                <div class="challenges-grid">
                    <!-- Challenges will be loaded dynamically here -->
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
                                    <option value="reverse">Reverse Engineering</option>
                                    <option value="osint">OSINT</option>
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
                            <label class="form-label">Flag</label>
                            <input type="text" class="form-control" id="challengeFlag" placeholder="Enter the challenge flag (e.g., CYBERNEST{flag_here})" required>
                            <small class="text-muted">The flag users need to submit to complete this challenge</small>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Tags (comma-separated)</label>
                            <input type="text" class="form-control" id="challengeTags" placeholder="xss, sql-injection, web">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Challenge File</label>
                            <input type="file" class="form-control" id="challengeFile" accept=".zip,.tar,.tar.gz,.txt,.pdf,.doc,.docx,.jpg,.jpeg,.png,.gif,.bmp,.webp,.svg">
                            <small class="text-muted">Upload challenge files (optional). Supported formats: ZIP, TAR, TXT, PDF, DOC, DOCX, JPG, PNG, GIF, BMP, WEBP, SVG</small>
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="../../javascript/admin/challenges.js"></script>
</body>
</html>