<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CyberNest - Challenges</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../../css/admin/dashboard.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        body {
            background: linear-gradient(135deg, #0a0a0a 0%, #1a1a1a 100%);
            color: var(--light-text);
            font-family: 'Courier New', monospace;
            min-height: 100vh;
        }

        .hero-section {
            background: linear-gradient(135deg, rgba(0, 255, 0, 0.1) 0%, rgba(0, 255, 0, 0.05) 100%);
            border: 1px solid var(--primary-color);
            border-radius: 15px;
            padding: 60px 30px;
            margin: 30px 0;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .hero-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(45deg, transparent 30%, rgba(0, 255, 0, 0.05) 50%, transparent 70%);
            animation: hero-scan 4s linear infinite;
            pointer-events: none;
        }

        @keyframes hero-scan {
            0% { transform: translateX(-100%); }
            100% { transform: translateX(100%); }
        }

        .hero-title {
            font-size: 3.5rem;
            font-weight: bold;
            color: var(--primary-color);
            text-shadow: 0 0 20px rgba(0, 255, 0, 0.8);
            margin-bottom: 20px;
            animation: glow 2s ease-in-out infinite alternate;
        }

        @keyframes glow {
            from { text-shadow: 0 0 20px rgba(0, 255, 0, 0.8); }
            to { text-shadow: 0 0 30px rgba(0, 255, 0, 1), 0 0 40px rgba(0, 255, 0, 0.6); }
        }

        .hero-subtitle {
            font-size: 1.3rem;
            color: var(--muted-text);
            margin-bottom: 30px;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 25px;
            margin: 30px 0;
            justify-content: center;
            text-align: center;
        }

        .stat-card {
            background: linear-gradient(135deg, rgba(0, 255, 0, 0.1) 0%, rgba(0, 255, 0, 0.05) 100%);
            border: 1px solid var(--primary-color);
            border-radius: 12px;
            padding: 30px 20px;
            text-align: center;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .stat-card::before {
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

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 40px rgba(0, 255, 0, 0.4);
            border-color: var(--secondary-color);
        }

        .stat-icon {
            font-size: 3rem;
            color: var(--primary-color);
            margin-bottom: 15px;
        }

        .stat-number {
            font-size: 2.5rem;
            font-weight: bold;
            color: var(--primary-color);
            text-shadow: 0 0 10px rgba(0, 255, 0, 0.5);
            margin-bottom: 10px;
        }

        .stat-label {
            color: var(--muted-text);
            font-size: 1rem;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .filter-section {
            background: rgba(0, 0, 0, 0.8);
            border: 1px solid var(--primary-color);
            border-radius: 12px;
            padding: 25px;
        }

        .filter-row {
            display: flex;
            gap: 20px;
            align-items: center;
            justify-content: center;
            flex-wrap: wrap;
        }

        .filter-group {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .filter-label {
            color: var(--primary-color);
            font-size: 0.9rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .filter-select, .search-box {
            background: rgba(0, 0, 0, 0.8);
            border: 1px solid var(--primary-color);
            color: var(--primary-color);
            padding: 10px 15px;
            border-radius: 6px;
            font-size: 0.9rem;
            transition: all 0.3s ease;
        }

        .filter-select:focus, .search-box:focus {
            outline: none;
            box-shadow: 0 0 10px rgba(0, 255, 0, 0.3);
            border-color: var(--primary-color);
        }

        .search-box {
            width: 100%;
        }

        .challenges-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 20px;
            margin: 50px 0;
            justify-content: center;
        }

        .challenge-card {
            background: rgba(0, 0, 0, 0.8);
            border: 1px solid var(--primary-color);
            border-radius: 12px;
            padding: 18px;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            cursor: pointer;
        }

        .challenge-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(45deg, transparent 30%, rgba(0, 255, 0, 0.05) 50%, transparent 70%);
            animation: challenge-scan 3s linear infinite;
            pointer-events: none;
        }

        @keyframes challenge-scan {
            0% { transform: translateX(-100%); }
            100% { transform: translateX(100%); }
        }

        .challenge-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 40px rgba(0, 255, 0, 0.3);
            border-color: var(--secondary-color);
        }

        .challenge-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 10px;
        }

        .challenge-title {
            color: var(--primary-color);
            font-size: 1.1rem;
            font-weight: bold;
            margin-bottom: 8px;
            flex: 1;
        }

        .difficulty-badge {
            padding: 5px 12px;
            border-radius: 15px;
            font-size: 0.8rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            white-space: nowrap;
        }

        .difficulty-easy {
            background: linear-gradient(135deg, rgba(40, 167, 69, 0.2), rgba(40, 167, 69, 0.1));
            color: #28a745;
            border: 1px solid #28a745;
        }

        .difficulty-beginner {
            background: linear-gradient(135deg, rgba(40, 167, 69, 0.2), rgba(40, 167, 69, 0.1));
            color: #28a745;
            border: 1px solid #28a745;
        }

        .difficulty-intermediate {
            background: linear-gradient(135deg, rgba(255, 193, 7, 0.2), rgba(255, 193, 7, 0.1));
            color: #ffc107;
            border: 1px solid #ffc107;
        }

        .difficulty-medium {
            background: linear-gradient(135deg, rgba(255, 165, 0, 0.2), rgba(255, 165, 0, 0.1));
            color: #ff8c00;
            border: 1px solid #ff8c00;
        }

        .difficulty-expert {
            background: linear-gradient(135deg, rgba(220, 53, 69, 0.2), rgba(220, 53, 69, 0.1));
            color: #dc3545;
            border: 1px solid #dc3545;
        }

        .difficulty-insane {
            background: linear-gradient(135deg, rgba(128, 0, 128, 0.2), rgba(128, 0, 128, 0.1));
            color: #800080;
            border: 1px solid #800080;
        }

        .challenge-description {
            color: var(--muted-text);
            font-size: 0.85rem;
            line-height: 1.4;
            margin-bottom: 12px;
        }

        .challenge-stats {
            display: flex;
            gap: 15px;
            margin-bottom: 12px;
        }

        .stat-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            flex: 1;
        }

        .stat-value {
            color: var(--primary-color);
            font-weight: bold;
            font-size: 1.1rem;
            margin-bottom: 3px;
        }

        .stat-label {
            color: var(--muted-text);
            font-size: 0.8rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .challenge-tags {
            display: flex;
            flex-wrap: wrap;
            gap: 6px;
            margin-bottom: 12px;
        }

        .tag {
            background: rgba(0, 255, 0, 0.1);
            border: 1px solid var(--primary-color);
            color: var(--primary-color);
            padding: 3px 10px;
            border-radius: 12px;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .challenge-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-top: 10px;
            border-top: 1px solid rgba(0, 255, 0, 0.1);
        }

        .challenge-points {
            color: var(--primary-color);
            font-weight: bold;
            font-size: 1.2rem;
        }

        .challenge-status {
            padding: 5px 12px;
            border-radius: 15px;
            font-size: 0.8rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .status-completed {
            background: linear-gradient(135deg, rgba(40, 167, 69, 0.2), rgba(40, 167, 69, 0.1));
            color: #28a745;
            border: 1px solid #28a745;
        }

        .status-attempted {
            background: linear-gradient(135deg, rgba(255, 193, 7, 0.2), rgba(255, 193, 7, 0.1));
            color: #ffc107;
            border: 1px solid #ffc107;
        }

        .status-active {
            background: linear-gradient(135deg, rgba(0, 255, 0, 0.2), rgba(0, 255, 0, 0.1));
            color: #00ff00;
            border: 1px solid #00ff00;
        }

        .status-inactive {
            background: linear-gradient(135deg, rgba(220, 53, 69, 0.2), rgba(220, 53, 69, 0.1));
            color: #dc3545;
            border: 1px solid #dc3545;
        }

        .status-draft {
            background: linear-gradient(135deg, rgba(108, 117, 125, 0.2), rgba(108, 117, 125, 0.1));
            color: #6c757d;
            border: 1px solid #6c757d;
        }

        .navbar-custom {
            background: linear-gradient(135deg, #1a1a1a 0%, #2a2a2a 100%);
            border-bottom: 2px solid var(--primary-color);
            padding: 15px 0;
            box-shadow: 0 0 20px rgba(0, 255, 0, 0.2);
        }

        .navbar-brand {
            color: var(--primary-color) !important;
            font-size: 1.5rem;
            font-weight: bold;
            text-shadow: 0 0 10px rgba(0, 255, 0, 0.5);
        }

        .nav-link-custom {
            color: var(--light-text) !important;
            padding: 10px 20px;
            border-radius: 6px;
            transition: all 0.3s ease;
            border: 1px solid transparent;
        }

        .nav-link-custom:hover {
            background: rgba(0, 255, 0, 0.1);
            border-color: var(--primary-color);
            color: var(--primary-color) !important;
            transform: translateY(-2px);
        }

        .nav-link-custom.active {
            background: rgba(0, 255, 0, 0.2);
            border-color: var(--primary-color);
            color: var(--primary-color) !important;
        }

        .user-dropdown {
            position: relative;
        }

        .user-avatar-nav {
            width: 35px;
            height: 35px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--darker-bg);
            font-weight: bold;
            border: 2px solid var(--primary-color);
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .user-avatar-nav:hover {
            transform: scale(1.1);
            box-shadow: 0 0 15px rgba(0, 255, 0, 0.5);
        }

        .pagination-container {
            display: flex;
            justify-content: center;
            margin-bottom: 20px;
        }

        .pagination-custom {
            display: flex;
            gap: 5px;
        }

        .page-btn {
            padding: 10px 15px;
            background: rgba(0, 0, 0, 0.8);
            border: 1px solid var(--primary-color);
            color: var(--primary-color);
            border-radius: 6px;
            cursor: pointer;
            transition: all 0.3s ease;
            font-weight: 600;
        }

        .page-btn:hover {
            background: rgba(0, 255, 0, 0.2);
            transform: translateY(-2px);
        }

        .page-btn.active {
            background: var(--primary-color);
            color: var(--darker-bg);
        }

        @media (max-width: 768px) {
            .hero-title {
                font-size: 2.5rem;
            }
            
            .hero-subtitle {
                font-size: 1.1rem;
            }
            
            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
            }
            
            .filter-row {
                flex-direction: column;
                align-items: stretch;
            }
            
            .search-box {
                width: 100%;
            }
            
            .challenges-grid {
                grid-template-columns: 1fr;
            }
            
            .challenge-header {
                flex-direction: column;
                gap: 10px;
            }
            
            .challenge-stats {
                flex-direction: column;
                gap: 10px;
            }
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-custom">
        <div class="container">
            <a class="navbar-brand" href="home.html">
                <i class="fas fa-shield-alt me-2"></i>CYBERNEST
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon" style="filter: invert(1);"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link nav-link-custom" href="home.php">
                            <i class="fas fa-home me-2"></i>Home
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link nav-link-custom active" href="challenges.php">
                            <i class="fas fa-trophy me-2"></i>Challenges
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link nav-link-custom" target="_blank" href="../terminal.html">
                            <i class="fas fa-terminal me-2"></i>Terminal
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link nav-link-custom" href="leaderboard.php">
                            <i class="fas fa-chart-line me-2"></i>Leaderboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link nav-link-custom" href="profile.php">
                            <i class="fas fa-user me-2"></i>Profile
                        </a>
                    </li>
                </ul>
                <div class="navbar-nav">
                    <div class="nav-item dropdown user-dropdown">
                        <div class="user-avatar-nav" data-bs-toggle="dropdown">
                            JD
                        </div>
                        <ul class="dropdown-menu dropdown-menu-dark dropdown-menu-end">
                            <li><a class="dropdown-item" href="profile.php"><i class="fas fa-user me-2"></i>Profile</a></li>
                            <li><a class="dropdown-item" href="settings.php"><i class="fas fa-cog me-2"></i>Settings</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="#" onclick="logout()"><i class="fas fa-sign-out-alt me-2"></i>Logout</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="container">
        <div class="hero-section">
            <h1 class="hero-title">CHALLENGES</h1>
            <p class="hero-subtitle">Test your cybersecurity skills and become a master hacker</p>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="stats-section container">
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-trophy"></i>
                </div>
                <div class="stat-number">45</div>
                <div class="stat-label">Total Challenges</div>
            </div>
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div class="stat-number">12</div>
                <div class="stat-label">Completed</div>
            </div>
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-fire"></i>
                </div>
                <div class="stat-number">3</div>
                <div class="stat-label">In Progress</div>
            </div>
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-star"></i>
                </div>
                <div class="stat-number" id="totalPointsDisplay">Loading...</div>
                <div class="stat-label">Points Earned</div>
            </div>
        </div>
    </section>

    <!-- Filter Section -->
    <section class="filter-section container">
        <div class="filter-row">
            <div class="filter-group">
                <label class="filter-label">Search</label>
                <input type="text" class="search-box" id="searchInput" placeholder="Search challenges...">
            </div>
            <div class="filter-group">
                <label class="filter-label">Difficulty</label>
                <select class="filter-select" id="difficultyFilter">
                    <option value="all">All Difficulties</option>
                    <option value="easy">Easy</option>
                    <option value="medium">Medium</option>
                    <option value="hard">Hard</option>
                    <option value="expert">Expert</option>
                    <option value="insane">Insane</option>
                </select>
            </div>
            <div class="filter-group">
                <label class="filter-label">Category</label>
                <select class="filter-select" id="categoryFilter">
                    <option value="all">All Categories</option>
                    <option value="web">Web Security</option>
                    <option value="crypto">Cryptography</option>
                    <option value="reverse">Reverse Engineering</option>
                    <option value="forensics">Digital Forensics</option>
                    <option value="network">Network Security</option>
                    <option value="mobile">Mobile Security</option>
                </select>
            </div>
            <div class="filter-group">
                <label class="filter-label">Status</label>
                <select class="filter-select" id="statusFilter">
                    <option value="all">All Status</option>
                    <option value="available">Available</option>
                    <option value="attempted">Attempted</option>
                    <option value="completed">Completed</option>
                </select>
            </div>
        </div>
    </section>

    <!-- Challenges Section -->
    <section class="challenges-section container">
        <div class="challenges-grid" id="challengesGrid">
            <!-- Challenges will be loaded dynamically from backend -->
            <div class="text-center py-5">
                <i class="fas fa-spinner fa-spin fa-3x mb-3 text-success"></i>
                <h4 class="text-success">Loading challenges...</h4>
            </div>
        </div>
    </section>

    <!-- Pagination -->
    <div class="pagination-container container">
        <div class="pagination-custom">
            <button class="page-btn" onclick="changePage('prev')">
                <i class="fas fa-chevron-left"></i>
            </button>
            <button class="page-btn active" onclick="changePage(1)">1</button>
            <button class="page-btn" onclick="changePage(2)">2</button>
            <button class="page-btn" onclick="changePage(3)">3</button>
            <button class="page-btn" onclick="changePage(4)">4</button>
            <button class="page-btn" onclick="changePage(5)">5</button>
            <button class="page-btn" onclick="changePage('next')">
                <i class="fas fa-chevron-right"></i>
            </button>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            loadChallenges();
            loadUserTotalPoints();
            startRealTimeUpdates();
            
            const searchInput = document.getElementById('searchInput');
            if (searchInput) {
                searchInput.addEventListener('input', function() {
                    const searchTerm = this.value.toLowerCase();
                    const cards = document.querySelectorAll('.challenge-card');
                    
                    cards.forEach(card => {
                        const title = card.querySelector('.challenge-title').textContent.toLowerCase();
                        const description = card.querySelector('.challenge-description').textContent.toLowerCase();
                        const tags = Array.from(card.querySelectorAll('.tag')).map(tag => tag.textContent.toLowerCase()).join(' ');
                        
                        if (title.includes(searchTerm) || description.includes(searchTerm) || tags.includes(searchTerm)) {
                            card.style.display = '';
                        } else {
                            card.style.display = 'none';
                        }
                    });
                });
            }

            const difficultyFilter = document.getElementById('difficultyFilter');
            const categoryFilter = document.getElementById('categoryFilter');
            const statusFilter = document.getElementById('statusFilter');
            
            function applyFilters() {
                const difficulty = difficultyFilter.value;
                const category = categoryFilter.value;
                const status = statusFilter.value;
                const cards = document.querySelectorAll('.challenge-card');
                
                cards.forEach(card => {
                    let show = true;
                    
                    if (difficulty !== 'all' && card.dataset.difficulty !== difficulty) {
                        show = false;
                    }
                    
                    if (category !== 'all' && card.dataset.category !== category) {
                        show = false;
                    }
                    
                    if (status !== 'all' && card.dataset.status !== status) {
                        show = false;
                    }
                    
                    card.style.display = show ? '' : 'none';
                });
            }
            
            if (difficultyFilter) difficultyFilter.addEventListener('change', applyFilters);
            if (categoryFilter) categoryFilter.addEventListener('change', applyFilters);
            if (statusFilter) statusFilter.addEventListener('change', applyFilters);

            const observerOptions = {
                threshold: 0.5,
                rootMargin: '0px'
            };

            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        animateStats();
                        observer.unobserve(entry.target);
                    }
                });
            }, observerOptions);

            const statsSection = document.querySelector('.stats-section');
            if (statsSection) {
                observer.observe(statsSection);
            }

            function animateStats() {
                const statNumbers = document.querySelectorAll('.stat-number');
                statNumbers.forEach(stat => {
                    const target = stat.textContent;
                    if (target.includes(',')) {
                        const num = parseInt(target.replace(',', ''));
                        let current = 0;
                        const increment = num / 50;
                        const timer = setInterval(() => {
                            current += increment;
                            if (current >= num) {
                                current = num;
                                clearInterval(timer);
                            }
                            stat.textContent = Math.floor(current).toLocaleString();
                        }, 30);
                    }
                });
            }
        });

        function loadChallenges() {
            fetch('/backend/api/challenges.php?action=getUserChallenges')
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        displayChallenges(data.challenges);
                        updateStats(data.challenges);
                    } else {
                        console.error('Failed to load challenges:', data.message);
                        showError('Failed to load challenges');
                    }
                })
                .catch(error => {
                    console.error('Error loading challenges:', error);
                    showError('Error loading challenges');
                });
        }

        function loadUserTotalPoints() {
            fetch('/backend/api/challenges.php?action=getUserTotalPoints')
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const pointsDisplay = document.getElementById('totalPointsDisplay');
                        if (pointsDisplay) {
                            pointsDisplay.textContent = data.total_points.toLocaleString();
                        }
                    } else {
                        console.error('Failed to load user points:', data.message);
                    }
                })
                .catch(error => {
                    console.error('Error loading user points:', error);
                });
        }

        function displayChallenges(challenges) {
            const container = document.getElementById('challengesGrid');
            
            if (challenges.length === 0) {
                container.innerHTML = `
                    <div class="text-center py-5">
                        <i class="fas fa-trophy fa-3x mb-3 text-muted"></i>
                        <h4 class="text-muted">No challenges found</h4>
                        <p class="text-muted">Check back later for new challenges!</p>
                    </div>
                `;
                return;
            }
            
            container.innerHTML = challenges.map(challenge => createChallengeCard(challenge)).join('');
            
            addChallengeCardHandlers();
        }

        function createChallengeCard(challenge) {
            const difficultyClass = `difficulty-${challenge.difficulty}`;
            const statusBadge = getStatusBadge(challenge.status);
            const tags = challenge.tags ? challenge.tags.split(',').map(tag => `<span class="tag">${tag.trim()}</span>`).join('') : '';

            let userStatusClass = '';
            let userStatusText = '';
            let userStatusIcon = '';
            
            if (challenge.status === 'inactive') {
                userStatusClass = 'status-inactive';
                userStatusText = 'Unavailable';
                userStatusIcon = '<i class="fas fa-times-circle"></i>';
            } else if (challenge.status === 'draft') {
                userStatusClass = 'status-draft';
                userStatusText = 'Draft';
                userStatusIcon = '<i class="fas fa-edit"></i>';
            } else if (challenge.user_completed == 1) {
                userStatusClass = 'status-completed';
                userStatusText = 'Completed';
                userStatusIcon = '<i class="fas fa-check-circle"></i>';
            } else if (challenge.user_attempts > 0) {
                userStatusClass = 'status-attempted';
                userStatusText = 'Attempted';
                userStatusIcon = '<i class="fas fa-clock"></i>';
            } else {
                userStatusClass = 'status-active';
                userStatusText = 'Available';
                userStatusIcon = '<i class="fas fa-play-circle"></i>';
            }
            
            return `
                <div class="challenge-card" data-difficulty="${challenge.difficulty}" data-category="${challenge.category}" data-status="${challenge.status}" data-id="${challenge.id}" data-user-completed="${challenge.user_completed}">
                    <div class="challenge-header">
                        <div>
                            <h3 class="challenge-title">${challenge.title}</h3>
                        </div>
                        <span class="difficulty-badge ${difficultyClass}">${challenge.difficulty}</span>
                    </div>
                    <p class="challenge-description">${challenge.description}</p>
                    <div class="challenge-stats">
                        <div class="stat-item">
                            <div class="stat-value">${challenge.attempts || 0}</div>
                            <div class="stat-label">Total Attempts</div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-value">${challenge.solved_count || 0}</div>
                            <div class="stat-label">Solved</div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-value">${challenge.user_attempts || 0}</div>
                            <div class="stat-label">Your Attempts</div>
                        </div>
                    </div>
                    <div class="challenge-tags">
                        ${tags}
                    </div>
                    <div class="challenge-footer">
                        <div class="challenge-points">${challenge.points} pts</div>
                        <span class="challenge-status ${userStatusClass}">${userStatusIcon} ${userStatusText}</span>
                    </div>
                </div>
            `;
        }

        function getStatusBadge(status) {
            const badges = {
                'active': 'Available',
                'inactive': 'Unavailable',
                'draft': 'Draft'
            };
            return badges[status] || 'Unknown';
        }

        function updateStats(challenges) {
            const totalChallenges = challenges.length;
            const activeChallenges = challenges.filter(c => c.status === 'active').length;
            const completedChallenges = challenges.filter(c => c.user_completed == 1).length;
            const attemptedChallenges = challenges.filter(c => c.user_attempts > 0 && c.user_completed == 0).length;
            const earnedPoints = challenges.filter(c => c.user_completed == 1).reduce((sum, c) => sum + c.points, 0);
            
            const statCards = document.querySelectorAll('.stat-card');
            if (statCards.length >= 4) {
                statCards[0].querySelector('.stat-number').textContent = totalChallenges;
                statCards[1].querySelector('.stat-number').textContent = completedChallenges;
                statCards[2].querySelector('.stat-number').textContent = attemptedChallenges;
                statCards[3].querySelector('.stat-number').textContent = earnedPoints.toLocaleString();
            }
        }

        function addChallengeCardHandlers() {
            const challengeCards = document.querySelectorAll('.challenge-card');
            challengeCards.forEach(card => {
                card.addEventListener('click', function() {
                    const title = this.querySelector('.challenge-title').textContent;
                    const difficulty = this.querySelector('.difficulty-badge').textContent;
                    const status = this.dataset.status;
                    const userCompleted = this.dataset.userCompleted;
                    const challengeId = this.dataset.id;
                    
                    if (status === 'inactive') {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Challenge Inactive',
                            text: 'This challenge is currently inactive and cannot be attempted.',
                            confirmButtonColor: '#00ff00',
                            background: '#1a1a1a',
                            color: '#00ff00',
                            border: '1px solid #00ff00'
                        });
                        return;
                    }
                    
                    if (status === 'draft') {
                        Swal.fire({
                            icon: 'info',
                            title: 'Challenge in Draft',
                            text: 'This challenge is still in draft mode and not available.',
                            confirmButtonColor: '#00ff00',
                            background: '#1a1a1a',
                            color: '#00ff00',
                            border: '1px solid #00ff00'
                        });
                        return;
                    }
                    
                    if (userCompleted === '1') {
                        Swal.fire({
                            icon: 'success',
                            title: 'Already Completed',
                            text: 'You have already completed this challenge!',
                            confirmButtonColor: '#00ff00',
                            background: '#1a1a1a',
                            color: '#00ff00',
                            border: '1px solid #00ff00'
                        });
                        return;
                    }
                    
                    showFlagModal(title, difficulty, challengeId);
                });
            });
        }

        function showFlagModal(challengeTitle, difficulty, challengeId) {
            const modalHtml = `
                <div class="modal fade" id="flagModal" tabindex="-1">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content" style="background: #1a1a1a; border: 1px solid #00ff00;">
                            <div class="modal-header" style="border-bottom: 1px solid #00ff00;">
                                <h5 class="modal-title" style="color: #00ff00;">
                                    <i class="fas fa-flag me-2"></i>Submit Flag
                                </h5>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <div class="mb-3">
                                    <h6 style="color: #00ff00; margin-bottom: 15px;">Challenge: ${challengeTitle}</h6>
                                    <h6 style="color: #00ff00; margin-bottom: 20px;">Difficulty: ${difficulty}</h6>
                                </div>
                                <div class="mb-3">
                                    <label for="flagInput" style="color: #00ff00; display: block; margin-bottom: 8px;">Enter Flag:</label>
                                    <input type="text" class="form-control" id="flagInput" 
                                           placeholder="e.g., CYBERNEST{flag_here}" 
                                           style="background: rgba(0,0,0,0.8); border: 1px solid #00ff00; color: #00ff00;">
                                    <small style="color: #888;">Enter the correct flag to complete this challenge</small>
                                </div>
                            </div>
                            <div class="modal-footer" style="border-top: 1px solid #00ff00;">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" 
                                        style="background: transparent; border: 1px solid #6c757d; color: #6c757d;">Cancel</button>
                                <button type="button" class="btn btn-success" onclick="submitFlag(${challengeId})" 
                                        style="background: #00ff00; border: 1px solid #00ff00; color: #000;">Submit Flag</button>
                            </div>
                        </div>
                    </div>
                </div>
            `;
            
            const existingModal = document.getElementById('flagModal');
            if (existingModal) {
                existingModal.remove();
            }
            
            document.body.insertAdjacentHTML('beforeend', modalHtml);
            
            const modal = new bootstrap.Modal(document.getElementById('flagModal'));
            modal.show();
            
            setTimeout(() => {
                document.getElementById('flagInput').focus();
            }, 500);
        }

        window.submitFlag = function(challengeId) {
            const flagInput = document.getElementById('flagInput');
            const flag = flagInput.value.trim();
            
            if (!flag) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Flag Required',
                    text: 'Please enter a flag to submit.',
                    confirmButtonColor: '#00ff00',
                    background: '#1a1a1a',
                    color: '#00ff00',
                    border: '1px solid #00ff00'
                });
                return;
            }
            
            fetch('/backend/api/challenges.php?action=submitFlag', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    challenge_id: challengeId,
                    flag: flag
                })
            })
            .then(response => response.json())
            .then(data => {
                const modal = bootstrap.Modal.getInstance(document.getElementById('flagModal'));
                modal.hide();
                
                if (data.success) {
                    if (data.already_completed) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Already Completed',
                            text: data.message,
                            confirmButtonColor: '#00ff00',
                            background: '#1a1a1a',
                            color: '#00ff00',
                            border: '1px solid #00ff00'
                        });
                    } else if (data.correct) {
                        let message = '🎉 ' + data.message;
                        if (data.points_earned) {
                            message += '\n\n🏆 Points earned: ' + data.points_earned;
                        }
                        Swal.fire({
                            icon: 'success',
                            title: 'Challenge Completed!',
                            html: message,
                            confirmButtonColor: '#00ff00',
                            background: '#1a1a1a',
                            color: '#00ff00',
                            border: '1px solid #00ff00'
                        }).then(() => {
                            loadChallenges();
                            loadUserTotalPoints();
                            updateRealTimeAttempts();
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Incorrect Flag',
                            text: data.message,
                            confirmButtonColor: '#00ff00',
                            background: '#1a1a1a',
                            color: '#00ff00',
                            border: '1px solid #00ff00'
                        }).then(() => {
                            updateRealTimeAttempts();
                        });
                    }
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Submission Error',
                        text: data.message,
                        confirmButtonColor: '#00ff00',
                        background: '#1a1a1a',
                        color: '#00ff00',
                        border: '1px solid #00ff00'
                    });
                }
            })
            .catch(error => {
                console.error('Error submitting flag:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error Submitting Flag',
                    text: 'An error occurred while submitting the flag. Please try again.',
                    confirmButtonColor: '#00ff00',
                    background: '#1a1a1a',
                    color: '#00ff00',
                    border: '1px solid #00ff00'
                });
            });
        };

        function showError(message) {
            const container = document.getElementById('challengesGrid');
            container.innerHTML = `
                <div class="text-center py-5">
                    <i class="fas fa-exclamation-triangle fa-3x mb-3 text-danger"></i>
                    <h4 class="text-danger">Error</h4>
                    <p class="text-muted">${message}</p>
                </div>
            `;
        }

        window.changePage = function(page) {
            console.log('Changing to page:', page);
            const buttons = document.querySelectorAll('.page-btn');
            buttons.forEach(btn => btn.classList.remove('active'));
            
            if (page === 'prev' || page === 'next') {
                const activeBtn = document.querySelector('.page-btn.active');
                const currentPage = parseInt(activeBtn.textContent);
                const newPage = page === 'prev' ? Math.max(1, currentPage - 1) : Math.min(5, currentPage + 1);
                buttons[newPage - 1].classList.add('active');
            } else {
                buttons[page - 1].classList.add('active');
            }
        };

        let realTimeInterval;
        let lastAttemptCounts = {};
        
        function startRealTimeUpdates() {
            realTimeInterval = setInterval(updateRealTimeAttempts, 5000);
            
            document.addEventListener('visibilitychange', function() {
                if (!document.hidden) {
                    updateRealTimeAttempts();
                }
            });
        }
        
        function updateRealTimeAttempts() {
            fetch('/backend/api/challenges.php?action=getRealTimeAttempts')
                .then(response => response.json())
                .then(data => {
                    if (data.success && data.attempts) {
                        data.attempts.forEach(attempt => {
                            const challengeId = attempt.challenge_id;
                            const newCount = attempt.attempt_count;
                            
                            if (lastAttemptCounts[challengeId] !== undefined && 
                                lastAttemptCounts[challengeId] < newCount) {
                                showAttemptUpdate(challengeId, newCount, attempt.completed);
                            }
                            
                            lastAttemptCounts[challengeId] = newCount;
                            
                            updateChallengeAttemptCount(challengeId, newCount, attempt.completed);
                        });
                    }
                })
                .catch(error => {
                    console.error('Error updating real-time attempts:', error);
                });
        }
        
        function updateChallengeAttemptCount(challengeId, attemptCount, completed) {
            const challengeCard = document.querySelector(`[data-id="${challengeId}"]`);
            if (challengeCard) {
                const yourAttemptsElement = challengeCard.querySelector('.challenge-stats .stat-item:nth-child(3) .stat-value');
                if (yourAttemptsElement) {
                    const oldCount = parseInt(yourAttemptsElement.textContent);
                    yourAttemptsElement.textContent = attemptCount;
                    
                    yourAttemptsElement.style.transition = 'all 0.3s ease';
                    yourAttemptsElement.style.transform = 'scale(1.2)';
                    yourAttemptsElement.style.color = '#00ff00';
                    
                    setTimeout(() => {
                        yourAttemptsElement.style.transform = 'scale(1)';
                        yourAttemptsElement.style.color = '';
                    }, 300);
                }
                
                if (completed) {
                    const statusElement = challengeCard.querySelector('.challenge-status');
                    if (statusElement) {
                        statusElement.className = 'challenge-status status-completed';
                        statusElement.innerHTML = '<i class="fas fa-check-circle"></i> Completed';
                    }
                    
                    challengeCard.dataset.userCompleted = '1';
                }
            }
        }
        
        function showAttemptUpdate(challengeId, newCount, completed) {
            const challengeCard = document.querySelector(`[data-id="${challengeId}"]`);
            if (challengeCard) {
                const notification = document.createElement('div');
                notification.style.cssText = `
                    position: absolute;
                    top: 10px;
                    right: 10px;
                    background: rgba(0, 255, 0, 0.9);
                    color: #000;
                    padding: 8px 12px;
                    border-radius: 6px;
                    font-size: 0.8rem;
                    font-weight: bold;
                    z-index: 1000;
                    animation: slideInRight 0.3s ease;
                    box-shadow: 0 4px 12px rgba(0, 255, 0, 0.4);
                `;
                
                if (completed) {
                    notification.innerHTML = `<i class="fas fa-check-circle"></i> Challenge Completed!`;
                    notification.style.background = 'rgba(40, 167, 69, 0.9)';
                } else {
                    notification.innerHTML = `<i class="fas fa-clock"></i> Attempt ${newCount}`;
                }
                
                challengeCard.style.position = 'relative';
                challengeCard.appendChild(notification);
                
                setTimeout(() => {
                    notification.style.animation = 'slideOutRight 0.3s ease';
                    setTimeout(() => {
                        if (notification.parentNode) {
                            notification.parentNode.removeChild(notification);
                        }
                    }, 300);
                }, 3000);
            }
        }
        
        const style = document.createElement('style');
        style.textContent = `
            @keyframes slideInRight {
                from {
                    transform: translateX(100%);
                    opacity: 0;
                }
                to {
                    transform: translateX(0);
                    opacity: 1;
                }
            }
            
            @keyframes slideOutRight {
                from {
                    transform: translateX(0);
                    opacity: 1;
                }
                to {
                    transform: translateX(100%);
                    opacity: 0;
                }
            }
        `;
        document.head.appendChild(style);
        
        window.addEventListener('beforeunload', function() {
            if (realTimeInterval) {
                clearInterval(realTimeInterval);
            }
        });

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
                color: '#00ff00',
                border: '1px solid #00ff00'
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
                                border: '1px solid #00ff00'
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
                                border: '1px solid #00ff00'
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
                            color: '#00ff00',
                            border: '1px solid #00ff00'
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