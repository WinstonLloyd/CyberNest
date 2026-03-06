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
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            loadChallenges();
            loadChallengeStats();
            
            const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            const tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });
            
            const addChallengeModal = document.getElementById('addChallengeModal');
            addChallengeModal.addEventListener('hidden.bs.modal', function () {
                const form = document.getElementById('addChallengeForm');
                delete form.dataset.editingId;
                form.reset();
                document.querySelector('#addChallengeModal .modal-title').textContent = 'Add New Challenge';
            });
        });

        let allChallenges = [];

        function loadChallenges(filters = {}) {
            const params = new URLSearchParams();
            
            if (filters.difficulty && filters.difficulty !== 'all') {
                params.append('difficulty', filters.difficulty);
            }
            
            if (filters.status && filters.status !== 'all') {
                params.append('status', filters.status);
            }
            
            if (filters.search) {
                params.append('search', filters.search);
            }
            
            const url = '/backend/api/challenges.php?action=getAll' + (params.toString() ? '&' + params.toString() : '');
            
            fetch(url)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        allChallenges = data.challenges;
                        displayChallenges(data.challenges);
                    } else {
                        console.error('Failed to load challenges:', data.message);
                    }
                })
                .catch(error => {
                    console.error('Error loading challenges:', error);
                });
        }

        function loadChallengeStats() {
            fetch('/backend/api/challenges.php?action=stats')
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        updateStatsDisplay(data.stats);
                    }
                })
                .catch(error => {
                    console.error('Error loading stats:', error);
                });
        }

        function displayChallenges(challenges) {
            const container = document.querySelector('.challenges-grid');
            
            if (challenges.length === 0) {
                container.innerHTML = `
                    <div class="col-12 text-center py-5">
                        <i class="fas fa-trophy fa-3x mb-3 text-muted"></i>
                        <h4 class="text-muted">No challenges found</h4>
                        <p class="text-muted">Try adjusting your filters or create a new challenge.</p>
                    </div>
                `;
                return;
            }
            
            container.innerHTML = challenges.map(challenge => createChallengeCard(challenge)).join('');
        }

        function createChallengeCard(challenge) {
            const difficultyClass = `difficulty-${challenge.difficulty}`;
            const statusBadge = getStatusBadge(challenge.status);
            const tags = challenge.tags ? challenge.tags.split(',').map(tag => `<span class="tag">${tag.trim()}</span>`).join('') : '';
            
            return `
                <div class="challenge-card">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div>
                            <h5 class="text-success mb-2">${challenge.title}</h5>
                            <span class="difficulty-badge ${difficultyClass}">${challenge.difficulty}</span>
                        </div>
                        <div class="text-end">
                            ${statusBadge}
                        </div>
                    </div>
                    
                    <div class="challenge-stats">
                        <div class="stat-item">
                            <i class="fas fa-users stat-icon"></i>
                            <span class="stat-value">${challenge.attempts || 0} attempts</span>
                        </div>
                        <div class="stat-item">
                            <i class="fas fa-check-circle stat-icon"></i>
                            <span class="stat-value">${challenge.solved_count || 0} solved</span>
                        </div>
                        <div class="stat-item">
                            <i class="fas fa-trophy stat-icon"></i>
                            <span class="stat-value">${challenge.points} points</span>
                        </div>
                    </div>
                    
                    <div class="challenge-description">
                        ${challenge.description}
                    </div>
                    
                    <div class="challenge-tags">
                        ${tags}
                    </div>
                    
                    <div class="action-buttons">
                        <a href="#" class="btn-action" onclick="viewChallenge(${challenge.id})">
                            <i class="fas fa-eye me-2"></i>View
                        </a>
                        <a href="#" class="btn-action" onclick="editChallenge(${challenge.id})">
                            <i class="fas fa-edit me-2"></i>Edit
                        </a>
                        ${getAdditionalActions(challenge)}
                        <a href="#" class="btn-action danger" onclick="deleteChallenge(${challenge.id})">
                            <i class="fas fa-trash me-2"></i>Delete
                        </a>
                    </div>
                </div>
            `;
        }

        function getStatusBadge(status) {
            const badges = {
                'active': '<div class="badge bg-success">Active</div>',
                'inactive': '<div class="badge bg-danger">Inactive</div>',
                'draft': '<div class="badge bg-warning">Draft</div>'
            };
            return badges[status] || '<div class="badge bg-secondary">Unknown</div>';
        }

        function getAdditionalActions(challenge) {
            if (challenge.status === 'draft') {
                return `<a href="#" class="btn-action" onclick="publishChallenge(${challenge.id})">
                    <i class="fas fa-rocket me-2"></i>Publish
                </a>`;
            } else if (challenge.status === 'inactive') {
                return `<a href="#" class="btn-action" onclick="activateChallenge(${challenge.id})">
                    <i class="fas fa-power-off me-2"></i>Activate
                </a>`;
            }
            return '';
        }

        function updateStatsDisplay(stats) {
            const totalChallenges = stats.total_challenges || 0;
            const byDifficulty = stats.by_difficulty || [];
            
            document.querySelector('.stats-grid').innerHTML = `
                <div class="stat-card">
                    <div class="stat-number">${totalChallenges}</div>
                    <div class="stat-label">Total Challenges</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number">${byDifficulty.find(d => d.difficulty === 'beginner')?.count || 0}</div>
                    <div class="stat-label">Beginner</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number">${byDifficulty.find(d => d.difficulty === 'intermediate')?.count || 0}</div>
                    <div class="stat-label">Intermediate</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number">${byDifficulty.find(d => d.difficulty === 'expert')?.count || 0}</div>
                    <div class="stat-label">Expert</div>
                </div>
            `;
        }

        window.refreshChallenges = function() {
            const refreshBtn = event.target;
            refreshBtn.innerHTML = '<i class="fas fa-sync-alt fa-spin me-2"></i>Refreshing...';
            refreshBtn.disabled = true;
            
            loadChallenges();
            loadChallengeStats();
            
            setTimeout(() => {
                refreshBtn.innerHTML = '<i class="fas fa-sync-alt me-2"></i>Refresh';
                refreshBtn.disabled = false;
            }, 1000);
        };

        document.getElementById('searchInput').addEventListener('input', function() {
            const searchTerm = this.value;
            const filters = {
                search: searchTerm,
                difficulty: document.getElementById('difficultyFilter').value,
                status: document.getElementById('statusFilter').value
            };
            loadChallenges(filters);
        });

        document.getElementById('difficultyFilter').addEventListener('change', function() {
            const filters = {
                search: document.getElementById('searchInput').value,
                difficulty: this.value,
                status: document.getElementById('statusFilter').value
            };
            loadChallenges(filters);
        });

        document.getElementById('statusFilter').addEventListener('change', function() {
            const filters = {
                search: document.getElementById('searchInput').value,
                difficulty: document.getElementById('difficultyFilter').value,
                status: this.value
            };
            loadChallenges(filters);
        });

        window.viewChallenge = function(challengeId) {
            fetch(`/backend/api/challenges.php?action=getById&id=${challengeId}`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire({
                            title: data.challenge.title,
                            html: `
                                <div style="text-align: left;">
                                    <p><strong>Description:</strong><br>${data.challenge.description}</p>
                                    <p><strong>Difficulty:</strong> ${data.challenge.difficulty}</p>
                                    <p><strong>Points:</strong> ${data.challenge.points}</p>
                                    <p><strong>Category:</strong> ${data.challenge.category}</p>
                                    <p><strong>Status:</strong> ${data.challenge.status}</p>
                                    <p><strong>Flag:</strong> <code>${data.challenge.flag || 'Not set'}</code></p>
                                </div>
                            `,
                            icon: 'info',
                            confirmButtonColor: '#28a745',
                            background: '#1a1a1a',
                            color: '#00ff00',
                            confirmButtonText: 'Close'
                        });
                    }
                })
                .catch(error => {
                    console.error('Error fetching challenge:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Failed to fetch challenge details',
                        background: '#1a1a1a',
                        color: '#00ff00',
                        confirmButtonColor: '#dc3545'
                    });
                });
        };

        window.editChallenge = function(challengeId) {
            fetch(`/backend/api/challenges.php?action=getById&id=${challengeId}`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const challenge = data.challenge;
                        const form = document.getElementById('addChallengeForm');
                        
                        document.getElementById('challengeName').value = challenge.title;
                        document.getElementById('challengeDifficulty').value = challenge.difficulty;
                        document.getElementById('challengeDescription').value = challenge.description;
                        document.getElementById('challengePoints').value = challenge.points;
                        document.getElementById('challengeCategory').value = challenge.category;
                        document.getElementById('challengeStatus').value = challenge.status;
                        document.getElementById('challengeFlag').value = challenge.flag || '';
                        document.getElementById('challengeTags').value = challenge.tags || '';
                        
                        form.dataset.editingId = challengeId;
                        
                        document.querySelector('#addChallengeModal .modal-title').textContent = 'Edit Challenge';
                        
                        const modal = new bootstrap.Modal(document.getElementById('addChallengeModal'));
                        modal.show();
                    }
                })
                .catch(error => {
                    console.error('Error fetching challenge:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Failed to fetch challenge details for editing',
                        background: '#1a1a1a',
                        color: '#00ff00',
                        confirmButtonColor: '#dc3545'
                    });
                });
        };

        window.deleteChallenge = function(challengeId) {
            Swal.fire({
                title: 'Delete Challenge?',
                text: 'Are you sure you want to delete this challenge? This action cannot be undone.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                background: '#1a1a1a',
                color: '#00ff00',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Delete',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch(`/backend/api/challenges.php?action=delete&id=${challengeId}`, {
                        method: 'DELETE'
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Deleted!',
                                text: 'Challenge deleted successfully!',
                                confirmButtonColor: '#28a745',
                                background: '#1a1a1a',
                                color: '#00ff00'
                            });
                            loadChallenges();
                            loadChallengeStats();
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Delete Failed',
                                text: 'Failed to delete challenge: ' + data.message,
                                background: '#1a1a1a',
                                color: '#00ff00',
                                confirmButtonColor: '#dc3545'
                            });
                        }
                    })
                    .catch(error => {
                        console.error('Error deleting challenge:', error);
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Failed to delete challenge. Please try again.',
                            background: '#1a1a1a',
                            color: '#00ff00',
                            confirmButtonColor: '#dc3545'
                        });
                    });
                }
            });
        };

        window.publishChallenge = function(challengeId) {
            Swal.fire({
                title: 'Publish Challenge?',
                text: 'Are you sure you want to publish this challenge?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Publish',
                background: '#1a1a1a',
                color: '#00ff00',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch(`/backend/api/challenges.php?action=getById&id=${challengeId}`)
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                const challenge = data.challenge;
                                challenge.status = 'active';
                                
                                return fetch('/backend/api/challenges.php?action=update', {
                                    method: 'POST',
                                    headers: {
                                        'Content-Type': 'application/json'
                                    },
                                    body: JSON.stringify(challenge)
                                });
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Published!',
                                    text: 'Challenge published successfully!',
                                    background: '#1a1a1a',
                                    color: '#00ff00',
                                    confirmButtonColor: '#28a745'
                                });
                                loadChallenges();
                                loadChallengeStats();
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Publish Failed',
                                    text: 'Failed to publish challenge: ' + data.message,
                                    background: '#1a1a1a',
                            color: '#00ff00',
                                    confirmButtonColor: '#dc3545'
                                });
                            }
                        })
                        .catch(error => {
                            console.error('Error publishing challenge:', error);
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'Failed to publish challenge. Please try again.',
                                background: '#1a1a1a',
                                color: '#00ff00',
                                confirmButtonColor: '#dc3545'
                            });
                        });
                }
            });
        };

        window.activateChallenge = function(challengeId) {
            Swal.fire({
                title: 'Activate Challenge?',
                text: 'Are you sure you want to activate this challenge?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Activate',
                background: '#1a1a1a',
                color: '#00ff00',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch(`/backend/api/challenges.php?action=getById&id=${challengeId}`)
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                const challenge = data.challenge;
                                challenge.status = 'active';
                                
                                return fetch('/backend/api/challenges.php?action=update', {
                                    method: 'POST',
                                    headers: {
                                        'Content-Type': 'application/json'
                                    },
                                    body: JSON.stringify(challenge)
                                });
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Activated!',
                                    text: 'Challenge activated successfully!',
                                    background: '#1a1a1a',
                                    color: '#00ff00',
                                    confirmButtonColor: '#28a745'
                                });
                                loadChallenges();
                                loadChallengeStats();
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Activate Failed',
                                    text: 'Failed to activate challenge: ' + data.message,
                                    background: '#1a1a1a',
                                    color: '#00ff00',
                                    confirmButtonColor: '#dc3545'
                                });
                            }
                        })
                        .catch(error => {
                            console.error('Error activating challenge:', error);
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'Failed to activate challenge. Please try again.',
                                background: '#1a1a1a',
                                color: '#00ff00',
                                confirmButtonColor: '#dc3545'
                            });
                        });
                }
            });
        };

        window.saveChallenge = function() {
            const form = document.getElementById('addChallengeForm');
            if (!form.checkValidity()) {
                form.reportValidity();
                return;
            }
            
            const challengeData = {
                title: document.getElementById('challengeName').value,
                difficulty: document.getElementById('challengeDifficulty').value,
                description: document.getElementById('challengeDescription').value,
                points: parseInt(document.getElementById('challengePoints').value),
                category: document.getElementById('challengeCategory').value,
                status: document.getElementById('challengeStatus').value,
                flag: document.getElementById('challengeFlag').value,
                tags: document.getElementById('challengeTags').value
            };
            
            const isEditing = form.dataset.editingId;
            
            if (isEditing) {
                challengeData.id = parseInt(isEditing);
                fetch('/backend/api/challenges.php?action=update', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(challengeData)
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const modal = bootstrap.Modal.getInstance(document.getElementById('addChallengeModal'));
                        modal.hide();
                        form.reset();
                        delete form.dataset.editingId;
                        
                        document.querySelector('#addChallengeModal .modal-title').textContent = 'Add New Challenge';
                        
                        Swal.fire({
                            icon: 'success',
                            title: 'Updated!',
                            text: 'Challenge updated successfully!',
                            background: '#1a1a1a',
                            color: '#00ff00',
                            confirmButtonColor: '#28a745'
                        });
                        loadChallenges();
                        loadChallengeStats();
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Update Failed',
                            text: 'Failed to update challenge: ' + data.message,
                            background: '#1a1a1a',
                            color: '#00ff00',
                            confirmButtonColor: '#dc3545'
                        });
                    }
                })
                .catch(error => {
                    console.error('Error updating challenge:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Failed to update challenge. Please try again.',
                        background: '#1a1a1a',
                        color: '#00ff00',
                        confirmButtonColor: '#dc3545'
                    });
                });
            } else {
                fetch('/backend/api/challenges.php?action=create', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(challengeData)
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const modal = bootstrap.Modal.getInstance(document.getElementById('addChallengeModal'));
                        modal.hide();
                        form.reset();
                        Swal.fire({
                            icon: 'success',
                            title: 'Saved!',
                            text: 'Challenge saved successfully!',
                            background: '#1a1a1a',
                            color: '#00ff00',
                            confirmButtonColor: '#28a745'
                        });
                        loadChallenges();
                        loadChallengeStats();
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Save Failed',
                            text: 'Failed to save challenge: ' + data.message,
                            background: '#1a1a1a',
                            color: '#00ff00',
                            confirmButtonColor: '#dc3545'
                        });
                    }
                })
                .catch(error => {
                    console.error('Error saving challenge:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Failed to save challenge. Please try again.',
                        background: '#1a1a1a',
                        color: '#00ff00',
                        confirmButtonColor: '#dc3545'
                    });
                });
            }
        };
        function logout() {
            Swal.fire({
                title: 'Logout Confirmation',
                text: 'Are you sure you want to logout?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#00ff00',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Yes, logout',
                cancelButtonText: 'Cancel',
                background: '#1a1a1a',
                color: '#00ff00'
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch('/backend/logout.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            Swal.fire({
                                title: 'Logout Successful',
                                text: 'You have been logged out successfully.',
                                icon: 'success',
                                confirmButtonColor: '#00ff00',
                                background: '#1a1a1a',
                                color: '#00ff00',
                                timer: 2000,
                                showConfirmButton: false
                            }).then(() => {
                                window.location.href = '../../index.php';
                            });
                        } else {
                            Swal.fire({
                                title: 'Logout Failed',
                                text: 'Logout failed: ' + data.message,
                                icon: 'error',
                                confirmButtonColor: '#00ff00',
                                background: '#1a1a1a',
                                color: '#00ff00',
                                timer: 3000,
                                showConfirmButton: false
                            }).then(() => {
                                window.location.href = '../../index.php';
                            });
                        }
                    })
                    .catch(error => {
                        console.error('Logout error:', error);
                        Swal.fire({
                            title: 'Redirecting',
                            text: 'Logging out...',
                            icon: 'info',
                            timer: 1500,
                            showConfirmButton: false,
                            background: '#1a1a1a',
                            color: '#00ff00'
                        }).then(() => {
                            window.location.href = '../../index.php';
                        });
                    });
                }
            });
        }
</script>
</body>
</html>