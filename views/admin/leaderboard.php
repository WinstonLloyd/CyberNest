<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CyberNest Admin - Leaderboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../../css/admin/dashboard.css">
    <style>
        .leaderboard-container {
            background: linear-gradient(135deg, rgba(0, 255, 0, 0.05) 0%, rgba(0, 255, 0, 0.02) 100%);
            border: 1px solid var(--primary-color);
            border-radius: 12px;
            padding: 30px;
            margin-bottom: 30px;
        }

        .leaderboard-header {
            text-align: center;
            margin-bottom: 40px;
        }

        .leaderboard-title {
            color: var(--primary-color);
            font-size: 2.5rem;
            font-weight: bold;
            text-shadow: 0 0 20px rgba(0, 255, 0, 0.5);
            margin-bottom: 10px;
        }

        .leaderboard-subtitle {
            color: var(--muted-text);
            font-size: 1.1rem;
        }

        .filter-section {
            background: rgba(0, 255, 0, 0.05);
            border: 1px solid var(--primary-color);
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 30px;
        }

        .leaderboard-table {
            background: rgba(0, 0, 0, 0.8);
            border: 1px solid var(--primary-color);
            border-radius: 12px;
            overflow: hidden;
        }

        .leaderboard-table th {
            background: rgba(0, 255, 0, 0.1);
            border-color: var(--primary-color);
            color: var(--primary-color);
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            font-size: 0.9rem;
        }

        .leaderboard-table td {
            border-color: rgba(0, 255, 0, 0.2);
            vertical-align: middle;
            padding: 15px;
        }

        .leaderboard-table tbody tr:hover {
            background: rgba(0, 255, 0, 0.1);
        }

        .rank-badge {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            font-size: 1.1rem;
        }

        .rank-1 {
            background: linear-gradient(135deg, #ffd700, #ffed4e);
            color: #000;
            box-shadow: 0 0 20px rgba(255, 215, 0, 0.5);
        }

        .rank-2 {
            background: linear-gradient(135deg, #c0c0c0, #e8e8e8);
            color: #000;
            box-shadow: 0 0 15px rgba(192, 192, 192, 0.5);
        }

        .rank-3 {
            background: linear-gradient(135deg, #cd7f32, #e4a852);
            color: #000;
            box-shadow: 0 0 15px rgba(205, 127, 50, 0.5);
        }

        .rank-other {
            background: rgba(0, 255, 0, 0.2);
            color: var(--primary-color);
            border: 1px solid var(--primary-color);
        }

        .user-info {
            display: flex;
            align-items: center;
        }

        .user-avatar {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            margin-right: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: var(--darker-bg);
            font-weight: bold;
            font-size: 1.2rem;
        }

        .user-details h5 {
            color: var(--light-text);
            margin: 0;
            font-size: 1rem;
        }

        .user-details small {
            color: var(--muted-text);
            font-size: 0.85rem;
        }

        .score-display {
            font-size: 1.5rem;
            font-weight: bold;
            color: var(--primary-color);
            text-shadow: 0 0 10px rgba(0, 255, 0, 0.5);
        }

        .level-badge {
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
            background: rgba(0, 255, 0, 0.2);
            color: var(--primary-color);
            border: 1px solid var(--primary-color);
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: linear-gradient(135deg, rgba(0, 255, 0, 0.1) 0%, rgba(0, 255, 0, 0.05) 100%);
            border: 1px solid var(--primary-color);
            border-radius: 12px;
            padding: 20px;
            text-align: center;
            transition: all 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(0, 255, 0, 0.3);
        }

        .stat-number {
            font-size: 2rem;
            font-weight: bold;
            color: var(--primary-color);
            text-shadow: 0 0 10px rgba(0, 255, 0, 0.5);
        }

        .stat-label {
            color: var(--muted-text);
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .action-buttons {
            display: flex;
            gap: 10px;
        }

        .btn-action {
            padding: 6px 12px;
            border-radius: 6px;
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

        .search-box {
            position: relative;
            max-width: 300px;
        }

        .search-box input {
            background: rgba(0, 0, 0, 0.8);
            border: 1px solid var(--primary-color);
            color: var(--primary-color);
            padding: 10px 15px;
            border-radius: 8px;
            width: 100%;
        }

        .search-box input:focus {
            outline: none;
            box-shadow: 0 0 10px rgba(0, 255, 0, 0.3);
            border-color: var(--primary-color);
        }

        .search-box i {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--primary-color);
        }

        .filter-select {
            background: rgba(0, 0, 0, 0.8);
            border: 1px solid var(--primary-color);
            color: var(--primary-color);
            padding: 10px 15px;
            border-radius: 8px;
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

        .pagination {
            justify-content: center;
            margin-top: 30px;
        }

        .page-link {
            background: transparent;
            border: 1px solid var(--primary-color);
            color: var(--primary-color);
            margin: 0 5px;
            border-radius: 8px;
            padding: 8px 16px;
            transition: all 0.3s ease;
        }

        .page-link:hover {
            background: rgba(0, 255, 0, 0.2);
            color: var(--primary-color);
        }

        .page-link.active {
            background: var(--primary-color);
            color: var(--darker-bg);
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
            .leaderboard-title {
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
            
            .leaderboard-table {
                font-size: 0.9rem;
            }
            
            .user-avatar {
                width: 40px;
                height: 40px;
                font-size: 1rem;
            }
            
            .score-display {
                font-size: 1.2rem;
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
                    <a class="nav-link" href="users.php">
                        <i class="fas fa-users"></i>
                        Users
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="challenges.php">
                        <i class="fas fa-trophy"></i>
                        Challenges
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="leaderboard.php">
                        <i class="fas fa-chart-line"></i>
                        Leaderboard
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="settings.php">
                        <i class="fas fa-cog"></i>
                        Settings
                    </a>
                </li>
                <li class="nav-item mt-3">
                    <a class="nav-link" href="#logout">
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
                    <h1 class="h3 mb-0">Leaderboard</h1>
                    <small class="text-muted">User Rankings & Performance</small>
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

        <!-- Leaderboard Content -->
        <div class="container-fluid">
            <!-- Header -->
            <div class="leaderboard-header">
                <i class="fas fa-trophy trophy-icon"></i>
                <h2 class="leaderboard-title">CYBERNEST LEADERBOARD</h2>
                <p class="leaderboard-subtitle">Top performers and rankings</p>
            </div>

            <!-- Stats Grid -->
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-number">1,234</div>
                    <div class="stat-label">Total Players</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number">892</div>
                    <div class="stat-label">Active Today</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number">45</div>
                    <div class="stat-label">Challenges</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number">156K</div>
                    <div class="stat-label">Total Points</div>
                </div>
            </div>

            <!-- Filter Section -->
            <div class="filter-section">
                <div class="row align-items-center">
                    <div class="col-md-4">
                        <div class="search-box">
                            <input type="text" id="searchInput" placeholder="Search players...">
                            <i class="fas fa-search"></i>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <select class="filter-select" id="timeFilter">
                            <option value="all">All Time</option>
                            <option value="today">Today</option>
                            <option value="week">This Week</option>
                            <option value="month">This Month</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <select class="filter-select" id="challengeFilter">
                            <option value="all">All Challenges</option>
                            <option value="beginner">Beginner</option>
                            <option value="intermediate">Intermediate</option>
                            <option value="expert">Expert</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <button class="btn btn-success w-100" onclick="refreshLeaderboard()">
                            <i class="fas fa-sync-alt me-2"></i>Refresh
                        </button>
                    </div>
                </div>
            </div>

            <!-- Leaderboard Table -->
            <div class="leaderboard-table">
                <table class="table table-dark table-hover">
                    <thead>
                        <tr>
                            <th>Rank</th>
                            <th>Player</th>
                            <th>Level</th>
                            <th>Score</th>
                            <th>Challenges</th>
                    <th>Win Rate</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="leaderboardBody">
                        <tr>
                            <td>
                                <div class="rank-badge rank-1">1</div>
                            </td>
                            <td>
                                <div class="user-info">
                                    <div class="user-avatar">JD</div>
                                    <div class="user-details">
                                        <h5>JohnDoe</h5>
                                        <small>Level 42</small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="level-badge">Expert</span>
                            </td>
                            <td>
                                <div class="score-display">15,420</div>
                            </td>
                            <td>89</td>
                            <td>87.5%</td>
                            <td>
                                <div class="action-buttons">
                                    <a href="#" class="btn-action">View</a>
                                    <a href="#" class="btn-action">Edit</a>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="rank-badge rank-2">2</div>
                            </td>
                            <td>
                                <div class="user-info">
                                    <div class="user-avatar">JS</div>
                                    <div class="user-details">
                                        <h5>JaneSmith</h5>
                                        <small>Level 38</small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="level-badge">Expert</span>
                            </td>
                            <td>
                                <div class="score-display">14,890</div>
                            </td>
                            <td>76</td>
                            <td>82.4%</td>
                            <td>
                                <div class="action-buttons">
                                    <a href="#" class="btn-action">View</a>
                                    <a href="#" class="btn-action">Edit</a>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="rank-badge rank-3">3</div>
                            </td>
                            <td>
                                <div class="user-info">
                                    <div class="user-avatar">BJ</div>
                                    <div class="user-details">
                                        <h5>BobJohnson</h5>
                                        <small>Level 35</small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="level-badge">Intermediate</span>
                            </td>
                            <td>
                                <div class="score-display">12,450</div>
                            </td>
                            <td>68</td>
                            <td>79.4%</td>
                            <td>
                                <div class="action-buttons">
                                    <a href="#" class="btn-action">View</a>
                                    <a href="#" class="btn-action">Edit</a>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="rank-badge rank-other">4</div>
                            </td>
                            <td>
                                <div class="user-info">
                                    <div class="user-avatar">AW</div>
                                    <div class="user-details">
                                        <h5>AliceWalker</h5>
                                        <small>Level 32</small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="level-badge">Intermediate</span>
                            </td>
                            <td>
                                <div class="score-display">10,230</div>
                            </td>
                            <td>55</td>
                            <td>76.4%</td>
                            <td>
                                <div class="action-buttons">
                                    <a href="#" class="btn-action">View</a>
                                    <a href="#" class="btn-action">Edit</a>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="rank-badge rank-other">5</div>
                            </td>
                            <td>
                                <div class="user-info">
                                    <div class="user-avatar">CM</div>
                                    <div class="user-details">
                                        <h5>CharlieMiller</h5>
                                        <small>Level 28</small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="level-badge">Beginner</span>
                            </td>
                            <td>
                                <div class="score-display">8,920</div>
                            </td>
                            <td>42</td>
                            <td>73.8%</td>
                            <td>
                                <div class="action-buttons">
                                    <a href="#" class="btn-action">View</a>
                                    <a href="#" class="btn-action">Edit</a>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="rank-badge rank-other">6</div>
                            </td>
                            <td>
                                <div class="user-info">
                                    <div class="user-avatar">DB</div>
                                    <div class="user-details">
                                        <h5>DianaBrown</h5>
                                        <small>Level 25</small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="level-badge">Beginner</span>
                            </td>
                            <td>
                                <div class="score-display">7,650</div>
                            </td>
                            <td>38</td>
                            <td>71.1%</td>
                            <td>
                                <div class="action-buttons">
                                    <a href="#" class="btn-action">View</a>
                                    <a href="#" class="btn-action">Edit</a>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="rank-badge rank-other">7</div>
                            </td>
                            <td>
                                <div class="user-info">
                                    <div class="user-avatar">EG</div>
                                    <div class="user-details">
                                        <h5>EveGreen</h5>
                                        <small>Level 22</small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="level-badge">Beginner</span>
                            </td>
                            <td>
                                <div class="score-display">6,890</div>
                            </td>
                            <td>35</td>
                            <td>68.6%</td>
                            <td>
                                <div class="action-buttons">
                                    <a href="#" class="btn-action">View</a>
                                    <a href="#" class="btn-action">Edit</a>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="rank-badge rank-other">8</div>
                            </td>
                            <td>
                                <div class="user-info">
                                    <div class="user-avatar">FH</div>
                                    <div class="user-details">
                                        <h5>FrankHarris</h5>
                                        <small>Level 20</small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="level-badge">Beginner</span>
                            </td>
                            <td>
                                <div class="score-display">5,430</div>
                            </td>
                            <td>32</td>
                            <td>65.6%</td>
                            <td>
                                <div class="action-buttons">
                                    <a href="#" class="btn-action">View</a>
                                    <a href="#" class="btn-action">Edit</a>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="rank-badge rank-other">9</div>
                            </td>
                            <td>
                                <div class="user-info">
                                    <div class="user-avatar">GI</div>
                                    <div class="user-details">
                                        <h5>GraceIvy</h5>
                                        <small>Level 18</small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="level-badge">Beginner</span>
                            </td>
                            <td>
                                <div class="score-display">4,210</div>
                            </td>
                            <td>28</td>
                            <td>62.9%</td>
                            <td>
                                <div class="action-buttons">
                                    <a href="#" class="btn-action">View</a>
                                    <a href="#" class="btn-action">Edit</a>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="rank-badge rank-other">10</div>
                            </td>
                            <td>
                                <div class="user-info">
                                    <div class="user-avatar">HK</div>
                                    <div class="user-details">
                                        <h5>HenryKing</h5>
                                        <small>Level 15</small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="level-badge">Beginner</span>
                            </td>
                            <td>
                                <div class="score-display">3,890</div>
                            </td>
                            <td>25</td>
                            <td>60.0%</td>
                            <td>
                                <div class="action-buttons">
                                    <a href="#" class="btn-action">View</a>
                                    <a href="#" class="btn-action">Edit</a>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <nav aria-label="Leaderboard pagination">
                <ul class="pagination">
                    <li class="page-item">
                        <a class="page-link" href="#" aria-label="Previous">
                            <span aria-hidden="true">&laquo;</span>
                        </a>
                    </li>
                    <li class="page-item active"><a class="page-link" href="#">1</a></li>
                    <li class="page-item"><a class="page-link" href="#">2</a></li>
                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                    <li class="page-item">
                        <a class="page-link" href="#" aria-label="Next">
                            <span aria-hidden="true">&raquo;</span>
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../../javascript/admin-dashboard.js"></script>
    <script>
        // Leaderboard specific functionality
        document.addEventListener('DOMContentLoaded', function() {
            // Search functionality
            const searchInput = document.getElementById('searchInput');
            if (searchInput) {
                searchInput.addEventListener('input', function() {
                    const searchTerm = this.value.toLowerCase();
                    const rows = document.querySelectorAll('#leaderboardBody tr');
                    
                    rows.forEach(row => {
                        const playerName = row.querySelector('.user-details h5').textContent.toLowerCase();
                        const playerEmail = row.querySelector('.user-details small').textContent.toLowerCase();
                        
                        if (playerName.includes(searchTerm) || playerEmail.includes(searchTerm)) {
                            row.style.display = '';
                        } else {
                            row.style.display = 'none';
                        }
                    });
                });
            }

            // Filter functionality
            const timeFilter = document.getElementById('timeFilter');
            const challengeFilter = document.getElementById('challengeFilter');
            
            if (timeFilter) {
                timeFilter.addEventListener('change', function() {
                    console.log('Time filter changed to:', this.value);
                    // Add filtering logic here
                });
            }

            if (challengeFilter) {
                challengeFilter.addEventListener('change', function() {
                    console.log('Challenge filter changed to:', this.value);
                    // Add filtering logic here
                });
            }

            // Refresh leaderboard
            window.refreshLeaderboard = function() {
                console.log('Refreshing leaderboard...');
                // Add refresh logic here
                const refreshBtn = event.target;
                refreshBtn.innerHTML = '<i class="fas fa-sync-alt fa-spin me-2"></i>Refreshing...';
                refreshBtn.disabled = true;
                
                setTimeout(() => {
                    refreshBtn.innerHTML = '<i class="fas fa-sync-alt me-2"></i>Refresh';
                    refreshBtn.disabled = false;
                    console.log('Leaderboard refreshed');
                }, 2000);
            };

            // Action buttons
            const actionButtons = document.querySelectorAll('.btn-action');
            actionButtons.forEach(btn => {
                btn.addEventListener('click', function(e) {
                    e.preventDefault();
                    const action = this.textContent.toLowerCase();
                    const userRow = this.closest('tr');
                    const userName = userRow.querySelector('.user-details h5').textContent;
                    
                    if (action === 'view') {
                        console.log('Viewing user:', userName);
                        alert(`Viewing profile for: ${userName}`);
                    } else if (action === 'edit') {
                        console.log('Editing user:', userName);
                        alert(`Editing profile for: ${userName}`);
                    }
                });
            });

            // Pagination
            const pageLinks = document.querySelectorAll('.page-link');
            pageLinks.forEach(link => {
                link.addEventListener('click', function(e) {
                    e.preventDefault();
                    const pageNumber = this.textContent;
                    
                    // Remove active class from all links
                    pageLinks.forEach(l => l.classList.remove('active'));
                    
                    // Add active class to clicked link
                    if (pageNumber !== '«' && pageNumber !== '»') {
                        this.classList.add('active');
                    }
                    
                    console.log('Loading page:', pageNumber);
                    // Add pagination logic here
                });
            });

            // Simulate real-time updates
            setInterval(() => {
                const scores = document.querySelectorAll('.score-display');
                scores.forEach(score => {
                    const currentScore = parseInt(score.textContent.replace(/,/g, ''));
                    const change = Math.floor(Math.random() * 100) - 50;
                    const newScore = Math.max(0, currentScore + change);
                    score.textContent = newScore.toLocaleString();
                });
            }, 10000);
        });
    </script>
</body>
</html>