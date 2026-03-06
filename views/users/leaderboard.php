<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CyberNest - Leaderboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../../css/admin/dashboard.css">
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

        .section-title {
            text-align: center;
            font-size: 2.5rem;
            color: var(--primary-color);
            text-shadow: 0 0 15px rgba(0, 255, 0, 0.5);
            margin-bottom: 50px;
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

        .leaderboard-container {
            background: rgba(0, 0, 0, 0.8);
            border: 1px solid var(--primary-color);
            border-radius: 12px;
            padding: 30px;
            margin: 30px 0;
            position: relative;
            overflow: hidden;
        }

        .leaderboard-container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(45deg, transparent 30%, rgba(0, 255, 0, 0.05) 50%, transparent 70%);
            animation: leaderboard-scan 4s linear infinite;
            pointer-events: none;
        }

        @keyframes leaderboard-scan {
            0% { transform: translateX(-100%); }
            100% { transform: translateX(100%); }
        }

        .leaderboard-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
        }

        .leaderboard-table thead th {
            background: rgba(0, 255, 0, 0.1);
            color: var(--primary-color);
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            padding: 15px;
            border-bottom: 2px solid var(--primary-color);
            text-align: center;
        }

        .leaderboard-table tbody tr {
            transition: all 0.3s ease;
            border-bottom: 1px solid rgba(0, 255, 0, 0.1);
        }

        .leaderboard-table tbody tr:hover {
            background: rgba(0, 255, 0, 0.05);
            transform: translateX(5px);
        }

        .leaderboard-table tbody td {
            padding: 15px;
            vertical-align: middle;
        }

        .rank-cell {
            text-align: center;
            width: 80px;
        }

        .rank-badge {
            width: 45px;
            height: 45px;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            font-size: 1.1rem;
            margin: 0 auto;
        }

        .rank-1 {
            background: linear-gradient(135deg, #ffd700, #ffed4e);
            color: #000;
            box-shadow: 0 0 20px rgba(255, 215, 0, 0.5);
        }

        .rank-2 {
            background: linear-gradient(135deg, #c0c0c0, #e8e8e8);
            color: #000;
            box-shadow: 0 0 20px rgba(192, 192, 192, 0.5);
        }

        .rank-3 {
            background: linear-gradient(135deg, #cd7f32, #e6a157);
            color: #000;
            box-shadow: 0 0 20px rgba(205, 127, 50, 0.5);
        }

        .rank-other {
            background: rgba(0, 255, 0, 0.1);
            border: 1px solid var(--primary-color);
            color: var(--primary-color);
        }

        .user-cell {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .user-avatar {
            width: 45px;
            height: 45px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--darker-bg);
            font-weight: bold;
            font-size: 1.1rem;
            border: 2px solid var(--primary-color);
            flex-shrink: 0;
        }

        .user-info {
            flex: 1;
        }

        .user-name {
            color: var(--primary-color);
            font-weight: 600;
            font-size: 1rem;
            margin-bottom: 3px;
        }

        .user-level {
            color: var(--muted-text);
            font-size: 0.85rem;
        }

        .stats-cell {
            text-align: center;
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

        .points-cell {
            text-align: center;
            font-weight: bold;
            color: var(--primary-color);
            font-size: 1.2rem;
        }

        .badge-cell {
            text-align: center;
        }

        .achievement-badge {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 5px 12px;
            border-radius: 15px;
            font-size: 0.8rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .badge-elite {
            background: linear-gradient(135deg, rgba(255, 215, 0, 0.2), rgba(255, 215, 0, 0.1));
            color: #ffd700;
            border: 1px solid #ffd700;
        }

        .badge-master {
            background: linear-gradient(135deg, rgba(0, 255, 0, 0.2), rgba(0, 255, 0, 0.1));
            color: var(--primary-color);
            border: 1px solid var(--primary-color);
        }

        .badge-expert {
            background: linear-gradient(135deg, rgba(0, 123, 255, 0.2), rgba(0, 123, 255, 0.1));
            color: #007bff;
            border: 1px solid #007bff;
        }

        .badge-advanced {
            background: linear-gradient(135deg, rgba(255, 165, 0, 0.2), rgba(255, 165, 0, 0.1));
            color: #ffa500;
            border: 1px solid #ffa500;
        }

        .badge-intermediate {
            background: linear-gradient(135deg, rgba(108, 117, 125, 0.2), rgba(108, 117, 125, 0.1));
            color: #6c757d;
            border: 1px solid #6c757d;
        }

        .badge-beginner {
            background: linear-gradient(135deg, rgba(40, 167, 69, 0.2), rgba(40, 167, 69, 0.1));
            color: #28a745;
            border: 1px solid #28a745;
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
            margin: 30px 0;
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
            
            .leaderboard-table {
                font-size: 0.9rem;
            }
            
            .leaderboard-table thead th,
            .leaderboard-table tbody td {
                padding: 10px 5px;
            }
            
            .user-cell {
                flex-direction: column;
                text-align: center;
                gap: 10px;
            }
            
            .rank-badge {
                width: 35px;
                height: 35px;
                font-size: 0.9rem;
            }
            
            .user-avatar {
                width: 35px;
                height: 35px;
                font-size: 0.9rem;
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
                        <a class="nav-link nav-link-custom" href="challenges.php">
                            <i class="fas fa-trophy me-2"></i>Challenges
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link nav-link-custom active" href="leaderboard.php">
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
                            <li><a class="dropdown-item" href="../index.html"><i class="fas fa-sign-out-alt me-2"></i>Logout</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="container">
        <div class="hero-section">
            <h1 class="hero-title">LEADERBOARD</h1>
            <p class="hero-subtitle">Top hackers and cybersecurity champions</p>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="stats-section container">
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-users"></i>
                </div>
                <div class="stat-number" id="totalHackers">Loading...</div>
                <div class="stat-label">Total Hackers</div>
            </div>
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-trophy"></i>
                </div>
                <div class="stat-number" id="totalChallenges">Loading...</div>
                <div class="stat-label">Challenges</div>
            </div>
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-flag-checkered"></i>
                </div>
                <div class="stat-number" id="totalCompleted">Loading...</div>
                <div class="stat-label">Completed</div>
            </div>
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-clock"></i>
                </div>
                <div class="stat-number" id="activeToday">Loading...</div>
                <div class="stat-label">Active Today</div>
            </div>
        </div>
    </section>

    <!-- Filter Section -->
    <section class="filter-section container">
        <div class="filter-row">
            <div class="filter-group">
                <label class="filter-label">Search</label>
                <input type="text" class="search-box" id="searchInput" placeholder="Search hackers...">
            </div>
            <div class="filter-group">
                <label class="filter-label">Rank</label>
                <select class="filter-select" id="rankFilter">
                    <option value="all">All Ranks</option>
                    <option value="1-10">Top 10</option>
                    <option value="1-25">Top 25</option>
                    <option value="1-50">Top 50</option>
                    <option value="1-100">Top 100</option>
                </select>
            </div>
            <div class="filter-group">
                <label class="filter-label">Level</label>
                <select class="filter-select" id="levelFilter">
                    <option value="all">All Levels</option>
                    <option value="elite">Elite</option>
                    <option value="master">Master</option>
                    <option value="expert">Expert</option>
                    <option value="advanced">Advanced</option>
                    <option value="intermediate">Intermediate</option>
                    <option value="beginner">Beginner</option>
                </select>
            </div>
            <div class="filter-group">
                <label class="filter-label">Time Period</label>
                <select class="filter-select" id="timeFilter">
                    <option value="all">All Time</option>
                    <option value="today">Today</option>
                    <option value="week">This Week</option>
                    <option value="month">This Month</option>
                    <option value="year">This Year</option>
                </select>
            </div>
        </div>
    </section>

    <!-- Leaderboard Section -->
    <section class="leaderboard-section container">
        <h2 class="section-title">TOP HACKERS</h2>
        
        <div class="leaderboard-container">
            <table class="leaderboard-table">
                <thead>
                    <tr>
                        <th>Rank</th>
                        <th>Hacker</th>
                        <th>Challenges</th>
                        <th>Success Rate</th>
                        <th>Points</th>
                        <th>Level</th>
                    </tr>
                </thead>
                <tbody id="leaderboardTableBody">
                    <tr>
                        <td colspan="6" class="text-center py-4">
                            <i class="fas fa-spinner fa-spin fa-2x mb-3 text-success"></i>
                            <p class="text-success">Loading leaderboard...</p>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="pagination-container">
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
    </section>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Leaderboard functionality
        document.addEventListener('DOMContentLoaded', function() {
            // Load real-time data
            loadPlatformStats();
            loadLeaderboard();
            startRealTimeUpdates();
            
            // Search functionality
            const searchInput = document.getElementById('searchInput');
            if (searchInput) {
                searchInput.addEventListener('input', function() {
                    const searchTerm = this.value.toLowerCase();
                    const rows = document.querySelectorAll('.leaderboard-table tbody tr');
                    
                    rows.forEach(row => {
                        const userName = row.querySelector('.user-name').textContent.toLowerCase();
                        if (userName.includes(searchTerm)) {
                            row.style.display = '';
                        } else {
                            row.style.display = 'none';
                        }
                    });
                });
            }

            // Filter functionality
            const rankFilter = document.getElementById('rankFilter');
            const levelFilter = document.getElementById('levelFilter');
            const timeFilter = document.getElementById('timeFilter');
            
            function applyFilters() {
                const rank = rankFilter.value;
                const level = levelFilter.value;
                const time = timeFilter.value;
                const rows = document.querySelectorAll('.leaderboard-table tbody tr');
                
                rows.forEach(row => {
                    let show = true;
                    
                    // Apply rank filter
                    if (rank !== 'all') {
                        const rankNum = parseInt(row.querySelector('.rank-badge').textContent);
                        if (rank === '1-10' && rankNum > 10) show = false;
                        if (rank === '1-25' && rankNum > 25) show = false;
                        if (rank === '1-50' && rankNum > 50) show = false;
                        if (rank === '1-100' && rankNum > 100) show = false;
                    }
                    
                    // Apply level filter
                    if (level !== 'all') {
                        const badge = row.querySelector('.achievement-badge');
                        if (!badge || !badge.textContent.toLowerCase().includes(level)) {
                            show = false;
                        }
                    }
                    
                    row.style.display = show ? '' : 'none';
                });
            }
            
            if (rankFilter) rankFilter.addEventListener('change', applyFilters);
            if (levelFilter) levelFilter.addEventListener('change', applyFilters);
            if (timeFilter) timeFilter.addEventListener('change', applyFilters);

            // Animate stats on scroll
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

            // Add hover effects to table rows
            const tableRows = document.querySelectorAll('.leaderboard-table tbody tr');
            tableRows.forEach(row => {
                row.addEventListener('mouseenter', function() {
                    this.style.transform = 'translateX(10px) scale(1.02)';
                });
                
                row.addEventListener('mouseleave', function() {
                    this.style.transform = 'translateX(0) scale(1)';
                });
            });

            // Simulate real-time updates
            setInterval(() => {
                const pointsCells = document.querySelectorAll('.points-cell');
                pointsCells.forEach((cell, index) => {
                    if (index < 3) { // Only update top 3
                        const currentPoints = parseInt(cell.textContent.replace(',', ''));
                        const change = Math.floor(Math.random() * 10) - 5;
                        const newPoints = Math.max(0, currentPoints + change);
                        cell.textContent = newPoints.toLocaleString();
                    }
                });
            }, 30000); // Update every 30 seconds
        });

        // Backend data loading functions
        function loadPlatformStats() {
            fetch('/backend/api/challenges.php?action=getPlatformStats')
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const stats = data.stats;
                        updateStatCard('totalHackers', stats.total_hackers);
                        updateStatCard('totalChallenges', stats.total_challenges);
                        updateStatCard('totalCompleted', stats.total_completed);
                        updateStatCard('activeToday', stats.active_today);
                    } else {
                        console.error('Failed to load platform stats:', data.message);
                    }
                })
                .catch(error => {
                    console.error('Error loading platform stats:', error);
                });
        }

        function loadLeaderboard() {
            fetch('/backend/api/challenges.php?action=getTopHackers&limit=50')
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        displayLeaderboard(data.hackers);
                    } else {
                        console.error('Failed to load leaderboard:', data.message);
                        // Show error message
                        const tbody = document.getElementById('leaderboardTableBody');
                        if (tbody) {
                            tbody.innerHTML = `
                                <tr>
                                    <td colspan="6" class="text-center py-4">
                                        <i class="fas fa-exclamation-triangle fa-2x mb-3 text-warning"></i>
                                        <p class="text-warning">Error loading leaderboard: ${data.message}</p>
                                    </td>
                                </tr>
                            `;
                        }
                    }
                })
                .catch(error => {
                    console.error('Error loading leaderboard:', error);
                    // Show error message
                    const tbody = document.getElementById('leaderboardTableBody');
                    if (tbody) {
                        tbody.innerHTML = `
                            <tr>
                                <td colspan="6" class="text-center py-4">
                                    <i class="fas fa-exclamation-triangle fa-2x mb-3 text-danger"></i>
                                    <p class="text-danger">Network error loading leaderboard</p>
                                </td>
                            </tr>
                        `;
                    }
                });
        }

        function updateStatCard(elementId, value) {
            const element = document.getElementById(elementId);
            if (element) {
                element.textContent = value.toLocaleString();
                
                // Add animation for the update
                element.style.transition = 'all 0.5s ease';
                element.style.transform = 'scale(1.1)';
                element.style.color = '#00ff00';
                
                setTimeout(() => {
                    element.style.transform = 'scale(1)';
                    element.style.color = '';
                }, 500);
            }
        }

        function displayLeaderboard(hackers) {
            const tbody = document.getElementById('leaderboardTableBody');
            if (!tbody) return;

            if (hackers.length === 0) {
                tbody.innerHTML = `
                    <tr>
                        <td colspan="6" class="text-center py-4">
                            <i class="fas fa-users fa-2x mb-3 text-muted"></i>
                            <p class="text-muted">No hackers found</p>
                        </td>
                    </tr>
                `;
                return;
            }

            tbody.innerHTML = hackers.map(hacker => {
                const rankClass = hacker.rank <= 3 ? `rank-${hacker.rank}` : 'rank-other';
                const levelBadge = getLevelBadge(hacker.points);
                const initials = getInitials(hacker.username);
                
                return `
                    <tr>
                        <td class="rank-cell">
                            <div class="rank-badge ${rankClass}">${hacker.rank}</div>
                        </td>
                        <td class="user-cell">
                            <div class="user-avatar">${initials}</div>
                            <div class="user-info">
                                <div class="user-name">${hacker.username}</div>
                                <div class="user-level">Level ${hacker.challenges_completed}</div>
                            </div>
                        </td>
                        <td class="stats-cell">
                            <div class="stat-value">${hacker.challenges_completed}</div>
                            <div class="stat-label">Completed</div>
                        </td>
                        <td class="stats-cell">
                            <div class="stat-value">${hacker.success_rate}%</div>
                            <div class="stat-label">Success</div>
                        </td>
                        <td class="points-cell">${hacker.points.toLocaleString()}</td>
                        <td class="badge-cell">
                            <span class="achievement-badge ${levelBadge.class}">
                                <i class="${levelBadge.icon}"></i> ${levelBadge.name}
                            </span>
                        </td>
                    </tr>
                `;
            }).join('');
        }

        function getLevelBadge(points) {
            if (points >= 4000) {
                return { class: 'badge-elite', name: 'Elite', icon: 'fas fa-crown' };
            } else if (points >= 3000) {
                return { class: 'badge-master', name: 'Master', icon: 'fas fa-medal' };
            } else if (points >= 2000) {
                return { class: 'badge-expert', name: 'Expert', icon: 'fas fa-star' };
            } else if (points >= 1000) {
                return { class: 'badge-advanced', name: 'Advanced', icon: 'fas fa-award' };
            } else if (points >= 500) {
                return { class: 'badge-intermediate', name: 'Intermediate', icon: 'fas fa-shield-alt' };
            } else {
                return { class: 'badge-beginner', name: 'Beginner', icon: 'fas fa-user' };
            }
        }

        function getInitials(username) {
            return username.split(' ')
                .map(word => word.charAt(0).toUpperCase())
                .join('')
                .substring(0, 2);
        }

        function startRealTimeUpdates() {
            // Update every 30 seconds
            setInterval(() => {
                loadPlatformStats();
                loadLeaderboard();
            }, 30000);

            // Also update when page becomes visible again
            document.addEventListener('visibilitychange', function() {
                if (!document.hidden) {
                    loadPlatformStats();
                    loadLeaderboard();
                }
            });
        }

        // Pagination functionality
        window.changePage = function(page) {
            console.log('Changing to page:', page);
            const buttons = document.querySelectorAll('.page-btn');
            buttons.forEach(btn => btn.classList.remove('active'));
            
            if (page === 'prev' || page === 'next') {
                // Handle prev/next navigation
                const activeBtn = document.querySelector('.page-btn.active');
                const currentPage = parseInt(activeBtn.textContent);
                const newPage = page === 'prev' ? Math.max(1, currentPage - 1) : Math.min(5, currentPage + 1);
                buttons[newPage].classList.add('active');
            } else {
                buttons[page].classList.add('active');
            }
        };
    </script>
</body>
</html>