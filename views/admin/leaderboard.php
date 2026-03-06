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
                            <li><a class="dropdown-item" href="#" onclick="logout()">Logout</a></li>
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
                    <div class="stat-number" id="totalPlayersCount">0</div>
                    <div class="stat-label">Total Players</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number" id="activeTodayCount">0</div>
                    <div class="stat-label">Active Today</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number" id="totalChallengesCount">0</div>
                    <div class="stat-label">Challenges</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number" id="totalPointsCount">0</div>
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
                            <td colspan="7" class="text-center py-5">
                                <i class="fas fa-spinner fa-spin fa-2x mb-3"></i>
                                <p>Loading leaderboard data...</p>
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="../../javascript/admin-dashboard.js"></script>
    <script>
        let allLeaderboardData = [];
        let filteredLeaderboardData = [];

        document.addEventListener('DOMContentLoaded', function() {
            loadLeaderboardData();
            loadLeaderboardStats();
            
            // Setup event listeners
            const searchInput = document.getElementById('searchInput');
            if (searchInput) {
                searchInput.addEventListener('input', filterLeaderboard);
            }

            const timeFilter = document.getElementById('timeFilter');
            if (timeFilter) {
                timeFilter.addEventListener('change', filterLeaderboard);
            }

            const challengeFilter = document.getElementById('challengeFilter');
            if (challengeFilter) {
                challengeFilter.addEventListener('change', filterLeaderboard);
            }
        });

        function loadLeaderboardData() {
            fetch('/backend/api/users.php?action=getAll')
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        allLeaderboardData = data.users.sort((a, b) => b.points - a.points);
                        filteredLeaderboardData = [...allLeaderboardData];
                        renderLeaderboard();
                    } else {
                        Swal.fire({
                            title: 'Error',
                            text: 'Failed to load leaderboard data: ' + data.message,
                            icon: 'error',
                            confirmButtonColor: '#00ff00',
                            background: '#1a1a1a',
                            color: '#00ff00'
                        });
                    }
                })
                .catch(error => {
                    console.error('Error loading leaderboard:', error);
                    Swal.fire({
                        title: 'Error',
                        text: 'Failed to load leaderboard data',
                        icon: 'error',
                        confirmButtonColor: '#00ff00',
                        background: '#1a1a1a',
                        color: '#00ff00'
                    });
                });
        }

        function loadLeaderboardStats() {
            fetch('/backend/api/users.php?action=stats')
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        document.getElementById('totalPlayersCount').textContent = data.stats.total_users.toLocaleString();
                    }
                })
                .catch(error => {
                    console.error('Error loading total players:', error);
                });

            fetch('/backend/api/users.php?action=getAll')
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const users = data.users;
                        const activeToday = users.filter(u => {
                            const lastLogin = new Date(u.last_login);
                            const today = new Date();
                            return lastLogin.toDateString() === today.toDateString();
                        }).length;
                        const totalChallenges = users.reduce((sum, u) => sum + (u.challenges_completed || 0), 0);
                        const totalPoints = users.reduce((sum, u) => sum + (u.points || 0), 0);
                        
                        document.getElementById('activeTodayCount').textContent = activeToday.toLocaleString();
                        document.getElementById('totalChallengesCount').textContent = totalChallenges.toLocaleString();
                        document.getElementById('totalPointsCount').textContent = totalPoints > 1000 ? 
                            (totalPoints / 1000).toFixed(1) + 'K' : 
                            totalPoints.toLocaleString();
                    }
                })
                .catch(error => {
                    console.error('Error loading user stats:', error);
                });
        }

        function renderLeaderboard() {
            const leaderboardBody = document.getElementById('leaderboardBody');
            if (!leaderboardBody) return;

            leaderboardBody.innerHTML = '';

            if (filteredLeaderboardData.length === 0) {
                leaderboardBody.innerHTML = `
                    <tr>
                        <td colspan="7" class="text-center py-5">
                            <i class="fas fa-users fa-2x mb-3"></i>
                            <p>No players found</p>
                            <small>Try adjusting your filters</small>
                        </td>
                    </tr>
                `;
                return;
            }

            filteredLeaderboardData.forEach((user, index) => {
                const row = createLeaderboardRow(user, index + 1);
                leaderboardBody.appendChild(row);
            });
        }

        function createLeaderboardRow(user, rank) {
            const row = document.createElement('tr');
            
            const rankClass = rank === 1 ? 'rank-1' : 
                              rank === 2 ? 'rank-2' : 
                              rank === 3 ? 'rank-3' : 'rank-other';
            
            const avatar = generateAvatar(user.display_name);
            const winRate = user.challenges_completed > 0 ? 
                ((user.challenges_completed / (user.challenges_completed + 5)) * 100).toFixed(1) : '0.0';

            row.innerHTML = `
                <td>
                    <div class="rank-badge ${rankClass}">${rank}</div>
                </td>
                <td>
                    <div class="user-info">
                        <div class="user-avatar">${avatar}</div>
                        <div class="user-details">
                            <h5>${user.display_name}</h5>
                            <small>${user.rank}</small>
                        </div>
                    </div>
                </td>
                <td>
                    <span class="level-badge">${user.rank}</span>
                </td>
                <td>
                    <div class="score-display">${(user.points || 0).toLocaleString()}</div>
                </td>
                <td>${user.challenges_completed || 0}</td>
                <td>${winRate}%</td>
                <td>
                    <div class="action-buttons">
                        <a href="#" class="btn-action" onclick="viewPlayer(${user.id})">View</a>
                        <a href="#" class="btn-action" onclick="editPlayer(${user.id})">Edit</a>
                    </div>
                </td>
            `;

            return row;
        }

        function generateAvatar(displayName) {
            const names = displayName.split(' ');
            let initials = '';
            
            names.forEach(name => {
                if (name) {
                    initials += name.charAt(0).toUpperCase();
                }
            });
            
            return initials.substring(0, 2);
        }

        function filterLeaderboard() {
            const searchTerm = document.getElementById('searchInput').value.toLowerCase();
            const timeFilter = document.getElementById('timeFilter').value;
            const challengeFilter = document.getElementById('challengeFilter').value;

            filteredLeaderboardData = allLeaderboardData.filter(user => {
                // Search filter
                const matchesSearch = !searchTerm || 
                    user.display_name.toLowerCase().includes(searchTerm) ||
                    user.email.toLowerCase().includes(searchTerm) ||
                    user.username.toLowerCase().includes(searchTerm);

                // Time filter
                let matchesTime = true;
                if (timeFilter !== 'all') {
                    const createdDate = new Date(user.created_at);
                    const today = new Date();
                    
                    switch(timeFilter) {
                        case 'today':
                            matchesTime = createdDate.toDateString() === today.toDateString();
                            break;
                        case 'week':
                            const weekAgo = new Date(today.getTime() - 7 * 24 * 60 * 60 * 1000);
                            matchesTime = createdDate >= weekAgo;
                            break;
                        case 'month':
                            const monthAgo = new Date(today.getTime() - 30 * 24 * 60 * 60 * 1000);
                            matchesTime = createdDate >= monthAgo;
                            break;
                    }
                }

                // Challenge filter
                const matchesChallenge = challengeFilter === 'all' || user.rank === challengeFilter;

                return matchesSearch && matchesTime && matchesChallenge;
            });

            renderLeaderboard();
        }

        window.refreshLeaderboard = function() {
            const refreshBtn = event.target;
            refreshBtn.innerHTML = '<i class="fas fa-sync-alt fa-spin me-2"></i>Refreshing...';
            refreshBtn.disabled = true;
            
            loadLeaderboardData();
            loadLeaderboardStats();
            
            setTimeout(() => {
                refreshBtn.innerHTML = '<i class="fas fa-sync-alt me-2"></i>Refresh';
                refreshBtn.disabled = false;
            }, 2000);
        };

        window.viewPlayer = function(userId) {
            const user = allLeaderboardData.find(u => u.id === userId);
            if (user) {
                Swal.fire({
                    title: 'Player Profile',
                    html: `
                        <div style="text-align: left;">
                            <p><strong>ID:</strong> ${user.id}</p>
                            <p><strong>Username:</strong> ${user.username}</p>
                            <p><strong>Display Name:</strong> ${user.display_name}</p>
                            <p><strong>Email:</strong> ${user.email}</p>
                            <p><strong>Rank:</strong> ${user.rank}</p>
                            <p><strong>Points:</strong> ${user.points || 0}</p>
                            <p><strong>Challenges Completed:</strong> ${user.challenges_completed || 0}</p>
                            <p><strong>Created:</strong> ${new Date(user.created_at).toLocaleDateString()}</p>
                            <p><strong>Last Login:</strong> ${user.last_login ? new Date(user.last_login).toLocaleDateString() : 'Never'}</p>
                        </div>
                    `,
                    icon: 'info',
                    confirmButtonColor: '#00ff00',
                    background: '#1a1a1a',
                    color: '#00ff00'
                });
            }
        };

        window.editPlayer = function(userId) {
            const user = allLeaderboardData.find(u => u.id === userId);
            if (user) {
                Swal.fire({
                    title: 'Edit Player',
                    html: `
                        <input id="swal-display-name" class="swal2-input" placeholder="Display Name" value="${user.display_name}">
                        <input id="swal-email" class="swal2-input" type="email" placeholder="Email" value="${user.email}">
                    `,
                    confirmButtonText: 'Update',
                    confirmButtonColor: '#00ff00',
                    background: '#1a1a1a',
                    color: '#00ff00',
                    preConfirm: () => {
                        const displayName = document.getElementById('swal-display-name').value;
                        const email = document.getElementById('swal-email').value;
                        
                        if (!displayName || !email) {
                            Swal.showValidationMessage('Please fill in all fields');
                            return false;
                        }
                        
                        return { displayName, email };
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        fetch(`/backend/api/users.php?action=update&id=${userId}`, {
                            method: 'PUT',
                            headers: {
                                'Content-Type': 'application/json',
                            },
                            body: JSON.stringify(result.value)
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                Swal.fire({
                                    title: 'Success',
                                    text: 'Player updated successfully',
                                    icon: 'success',
                                    confirmButtonColor: '#00ff00',
                                    background: '#1a1a1a',
                                    color: '#00ff00'
                                });
                                loadLeaderboardData();
                            } else {
                                Swal.fire({
                                    title: 'Error',
                                    text: 'Failed to update player: ' + data.message,
                                    icon: 'error',
                                    confirmButtonColor: '#00ff00',
                                    background: '#1a1a1a',
                                    color: '#00ff00'
                                });
                            }
                        })
                        .catch(error => {
                            console.error('Error updating player:', error);
                        });
                    }
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