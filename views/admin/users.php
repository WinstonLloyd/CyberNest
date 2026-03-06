<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CyberNest Admin - Users</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../../css/admin/dashboard.css">
    <style>
        .users-container {
            background: linear-gradient(135deg, rgba(0, 255, 0, 0.05) 0%, rgba(0, 255, 0, 0.02) 100%);
            border: 1px solid var(--primary-color);
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 20px;
        }

        .users-header {
            text-align: center;
            margin-bottom: 25px;
        }

        .users-title {
            color: var(--primary-color);
            font-size: 1.8rem;
            font-weight: bold;
            text-shadow: 0 0 15px rgba(0, 255, 0, 0.5);
            margin-bottom: 8px;
        }

        .users-subtitle {
            color: var(--muted-text);
            font-size: 0.9rem;
        }

        .users-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 15px;
        }

        .user-card {
            background: rgba(0, 0, 0, 0.8);
            border: 1px solid var(--primary-color);
            border-radius: 8px;
            padding: 15px;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .user-card::before {
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

        .user-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(0, 255, 0, 0.3);
            border-color: var(--secondary-color);
        }

        .user-header {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 15px;
        }

        .user-avatar {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--darker-bg);
            font-weight: bold;
            font-size: 1.2rem;
            border: 2px solid var(--primary-color);
        }

        .user-info {
            flex: 1;
        }

        .user-name {
            color: var(--primary-color);
            font-weight: 600;
            font-size: 1rem;
            margin-bottom: 2px;
        }

        .user-email {
            color: var(--muted-text);
            font-size: 0.8rem;
        }

        .user-stats {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 10px;
            margin: 15px 0;
        }

        .stat-box {
            background: rgba(0, 255, 0, 0.1);
            border: 1px solid rgba(0, 255, 0, 0.3);
            border-radius: 6px;
            padding: 10px;
            text-align: center;
        }

        .stat-value {
            color: var(--primary-color);
            font-weight: bold;
            font-size: 1.1rem;
        }

        .stat-label {
            color: var(--muted-text);
            font-size: 0.7rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .user-status {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin: 10px 0;
        }

        .status-badge {
            padding: 4px 12px;
            border-radius: 15px;
            font-size: 0.7rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .status-online {
            background: rgba(0, 255, 0, 0.2);
            color: var(--primary-color);
            border: 1px solid var(--primary-color);
        }

        .status-offline {
            background: rgba(255, 0, 0, 0.2);
            color: #ff0000;
            border: 1px solid #ff0000;
        }

        .status-banned {
            background: rgba(255, 165, 0, 0.2);
            color: #ffa500;
            border: 1px solid #ffa500;
        }

        .user-role {
            padding: 4px 12px;
            border-radius: 15px;
            font-size: 0.7rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
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
            flex: 1;
            text-align: center;
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

        .add-user-btn {
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

        .add-user-btn:hover {
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

        .users-icon {
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
            .users-title {
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
            
            .user-stats {
                grid-template-columns: 1fr;
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
                    <a class="nav-link" href="challenges.php">
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
                    <a class="nav-link active" href="users.php">
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
                    <h1 class="h3 mb-0">Users</h1>
                    <small class="text-muted">Manage user accounts & permissions</small>
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

        <!-- Users Content -->
        <div class="container-fluid">
            <!-- Header -->
            <div class="users-header">
                <i class="fas fa-users users-icon"></i>
                <h2 class="users-title">CYBERNEST USERS</h2>
                <p class="users-subtitle">Manage user accounts and system permissions</p>
            </div>

            <!-- Stats Grid -->
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-number" id="totalUsersCount">0</div>
                    <div class="stat-label">Total Users</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number" id="activeUsersCount">0</div>
                    <div class="stat-label">Active</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number" id="onlineUsersCount">0</div>
                    <div class="stat-label">Online Now</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number" id="newUsersCount">0</div>
                    <div class="stat-label">New Today</div>
                </div>
            </div>

            <!-- Filter Section -->
            <div class="filter-section">
                <div class="row align-items-center">
                    <div class="col-md-4">
                        <div class="search-box">
                            <input type="text" id="searchInput" placeholder="Search users...">
                            <i class="fas fa-search"></i>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <select class="filter-select" id="statusFilter">
                            <option value="all">All Status</option>
                            <option value="online">Online</option>
                            <option value="offline">Offline</option>
                            <option value="banned">Banned</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <button class="btn btn-success w-100" onclick="refreshUsers()">
                            <i class="fas fa-sync-alt me-2"></i>Refresh
                        </button>
                    </div>
                </div>
            </div>

            <!-- Users List -->
            <div class="users-container">
                <div class="users-grid" id="usersGrid">
                    <!-- Users will be loaded dynamically from backend -->
                    <div class="text-center text-muted py-5">
                        <i class="fas fa-spinner fa-spin fa-2x mb-3"></i>
                        <p>Loading users...</p>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Add User Button -->
    <button class="add-user-btn" data-bs-toggle="modal" data-bs-target="#addUserModal">
        <i class="fas fa-plus"></i>
    </button>

    <!-- Add User Modal -->
    <div class="modal fade" id="addUserModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add New User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="addUserForm">
                        <div class="mb-3">
                            <label class="form-label">CallSign</label>
                            <input type="text" class="form-control" id="username" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Confirm Password</label>
                            <input type="password" class="form-control" id="confirmPassword" required>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-success" onclick="saveUser()">Save User</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../../javascript/admin-dashboard.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        let allUsers = [];
        let filteredUsers = [];

        document.addEventListener('DOMContentLoaded', function() {
            loadUsers();
            loadUserStats();
            
            const searchInput = document.getElementById('searchInput');
            if (searchInput) {
                searchInput.addEventListener('input', function() {
                    filterUsers();
                });
            }

            const statusFilter = document.getElementById('statusFilter');
            
            if (statusFilter) {
                statusFilter.addEventListener('change', function() {
                    filterUsers();
                });
            }
        });

        function loadUsers() {
            fetch('/backend/api/users.php?action=getAll')
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        allUsers = data.users;
                        filteredUsers = [...allUsers];
                        renderUsers();
                        updateUserStats();
                    } else {
                        Swal.fire({
                            title: 'Error',
                            text: 'Failed to load users: ' + data.message,
                            icon: 'error',
                            confirmButtonColor: '#00ff00',
                            background: '#1a1a1a',
                            color: '#00ff00',
                            border: '1px solid #00ff00'
                        });
                    }
                })
                .catch(error => {
                    console.error('Error loading users:', error);
                    Swal.fire({
                        title: 'Error',
                        text: 'Failed to load users',
                        icon: 'error',
                        confirmButtonColor: '#00ff00',
                        background: '#1a1a1a',
                        color: '#00ff00',
                        border: '1px solid #00ff00'
                    });
                });
        }

        function loadUserStats() {
            fetch('/backend/api/users.php?action=stats')
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        updateUserStatsDisplay(data.stats);
                    }
                })
                .catch(error => {
                    console.error('Error loading stats:', error);
                });
        }

        function updateUserStatsDisplay(stats) {
            document.getElementById('totalUsersCount').textContent = stats.total_users.toLocaleString();
            document.getElementById('activeUsersCount').textContent = stats.active_users.toLocaleString();
            document.getElementById('onlineUsersCount').textContent = Math.floor(stats.active_users * 0.3).toLocaleString();
            document.getElementById('newUsersCount').textContent = stats.recent_registrations.toLocaleString();
        }

        function updateUserStats() {
            const totalUsers = allUsers.length;
            const activeUsers = allUsers.filter(u => u.status !== 'banned').length;
            const onlineUsers = allUsers.filter(u => u.status === 'online').length;
            const newToday = allUsers.filter(u => {
                const createdDate = new Date(u.created_at);
                const today = new Date();
                return createdDate.toDateString() === today.toDateString();
            }).length;

            document.getElementById('totalUsersCount').textContent = totalUsers.toLocaleString();
            document.getElementById('activeUsersCount').textContent = activeUsers.toLocaleString();
            document.getElementById('onlineUsersCount').textContent = onlineUsers.toLocaleString();
            document.getElementById('newUsersCount').textContent = newToday.toLocaleString();
        }

        function renderUsers() {
            const usersGrid = document.getElementById('usersGrid');
            if (!usersGrid) return;

            usersGrid.innerHTML = '';

            if (filteredUsers.length === 0) {
                usersGrid.innerHTML = `
                    <div class="text-center text-muted py-5">
                        <i class="fas fa-users fa-2x mb-3"></i>
                        <p>No users found</p>
                        <small>Try adjusting your search or filters</small>
                    </div>
                `;
                return;
            }

            filteredUsers.forEach(user => {
                const userCard = createUserCard(user);
                usersGrid.appendChild(userCard);
            });
        }

        function createUserCard(user) {
            const card = document.createElement('div');
            card.className = 'user-card';
            card.dataset.userId = user.id;

            const statusClass = user.status === 'online' ? 'status-online' : 
                              user.status === 'offline' ? 'status-offline' : 'status-banned';
            
            const roleClass = user.role === 'admin' ? 'admin' : 'user';

            card.innerHTML = `
                <div class="user-header">
                    <div class="user-avatar">${user.avatar}</div>
                    <div class="user-info">
                        <div class="user-name">${user.display_name}</div>
                        <div class="user-email">${user.email}</div>
                    </div>
                </div>
                
                <div class="user-stats">
                    <div class="stat-box">
                        <div class="stat-value">${user.points || 0}</div>
                        <div class="stat-label">Points</div>
                    </div>
                    <div class="stat-box">
                        <div class="stat-value">${user.challenges_completed || 0}</div>
                        <div class="stat-label">Challenges</div>
                    </div>
                    <div class="stat-box">
                        <div class="stat-value">${user.rank || 'N/A'}</div>
                        <div class="stat-label">Rank</div>
                    </div>
                </div>
                
                <div class="user-status">
                    <span class="status-badge ${statusClass}">${user.status}</span>
                    <span class="user-role">${user.role}</span>
                </div>
                
                <div class="action-buttons">
                    <a href="#" class="btn-action" onclick="viewUser(${user.id})">
                        <i class="fas fa-eye me-2"></i>View
                    </a>
                    <a href="#" class="btn-action" onclick="editUser(${user.id})">
                        <i class="fas fa-edit me-2"></i>Edit
                    </a>
                    ${user.status === 'banned' ? 
                        `<a href="#" class="btn-action" onclick="unbanUser(${user.id})">
                            <i class="fas fa-check me-2"></i>Unban
                        </a>` :
                        `<a href="#" class="btn-action danger" onclick="banUser(${user.id})">
                            <i class="fas fa-ban me-2"></i>Ban
                        </a>`
                    }
                </div>
            `;

            return card;
        }

        function filterUsers() {
            const searchTerm = document.getElementById('searchInput').value.toLowerCase();
            const statusFilter = document.getElementById('statusFilter').value;

            filteredUsers = allUsers.filter(user => {
                const matchesSearch = !searchTerm || 
                    user.display_name.toLowerCase().includes(searchTerm) ||
                    user.email.toLowerCase().includes(searchTerm) ||
                    user.username.toLowerCase().includes(searchTerm);
                
                const matchesStatus = statusFilter === 'all' || user.status === statusFilter;

                return matchesSearch && matchesStatus;
            });

            renderUsers();
        }

        window.refreshUsers = function() {
            const refreshBtn = event.target;
            refreshBtn.innerHTML = '<i class="fas fa-sync-alt fa-spin me-2"></i>Refreshing...';
            refreshBtn.disabled = true;
            
            loadUsers();
            
            setTimeout(() => {
                refreshBtn.innerHTML = '<i class="fas fa-sync-alt me-2"></i>Refresh';
                refreshBtn.disabled = false;
            }, 1000);
        };

        window.viewUser = function(userId) {
            fetch(`/backend/api/users.php?action=getById&id=${userId}`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const user = data.user;
                        Swal.fire({
                            title: 'User Details',
                            html: `
                                <div style="text-align: left;">
                                    <p><strong>ID:</strong> ${user.id}</p>
                                    <p><strong>Username:</strong> ${user.username}</p>
                                    <p><strong>Display Name:</strong> ${user.display_name}</p>
                                    <p><strong>Email:</strong> ${user.email}</p>
                                    <p><strong>Role:</strong> ${user.role}</p>
                                    <p><strong>Status:</strong> ${user.status}</p>
                                    <p><strong>Created:</strong> ${new Date(user.created_at).toLocaleDateString()}</p>
                                    <p><strong>Last Login:</strong> ${user.last_login ? new Date(user.last_login).toLocaleDateString() : 'Never'}</p>
                                </div>
                            `,
                            icon: 'info',
                            confirmButtonColor: '#00ff00',
                            background: '#1a1a1a',
                            color: '#00ff00',
                            border: '1px solid #00ff00'
                        });
                    } else {
                        Swal.fire({
                            title: 'Error',
                            text: 'Failed to load user details',
                            icon: 'error',
                            confirmButtonColor: '#00ff00',
                            background: '#1a1a1a',
                            color: '#00ff00',
                            border: '1px solid #00ff00'
                        });
                    }
                })
                .catch(error => {
                    console.error('Error viewing user:', error);
                });
        };

        window.editUser = function(userId) {
            Swal.fire({
                title: 'Edit User',
                html: `
                    <input id="swal-display-name" class="swal2-input" placeholder="Display Name">
                    <input id="swal-email" class="swal2-input" type="email" placeholder="Email">
                `,
                confirmButtonText: 'Update',
                confirmButtonColor: '#00ff00',
                background: '#1a1a1a',
                color: '#00ff00',
                border: '1px solid #00ff00',
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
                                text: 'User updated successfully',
                                icon: 'success',
                                confirmButtonColor: '#00ff00',
                                background: '#1a1a1a',
                                color: '#00ff00',
                                border: '1px solid #00ff00'
                            });
                            loadUsers();
                        } else {
                            Swal.fire({
                                title: 'Error',
                                text: 'Failed to update user: ' + data.message,
                                icon: 'error',
                                confirmButtonColor: '#00ff00',
                                background: '#1a1a1a',
                                color: '#00ff00',
                                border: '1px solid #00ff00'
                            });
                        }
                    })
                    .catch(error => {
                        console.error('Error updating user:', error);
                    });
                }
            });
        };

        window.banUser = function(userId) {
            Swal.fire({
                title: 'Ban User',
                text: 'Are you sure you want to ban this user?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ff0000',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Yes, ban',
                cancelButtonText: 'Cancel',
                background: '#1a1a1a',
                color: '#00ff00',
                border: '1px solid #00ff00'
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch(`/backend/api/users.php?action=ban&id=${userId}`, {
                        method: 'POST'
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            Swal.fire({
                                title: 'Success',
                                text: 'User banned successfully',
                                icon: 'success',
                                confirmButtonColor: '#00ff00',
                                background: '#1a1a1a',
                                color: '#00ff00',
                                border: '1px solid #00ff00'
                            });
                            loadUsers();
                        } else {
                            Swal.fire({
                                title: 'Error',
                                text: 'Failed to ban user: ' + data.message,
                                icon: 'error',
                                confirmButtonColor: '#00ff00',
                                background: '#1a1a1a',
                                color: '#00ff00',
                                border: '1px solid #00ff00'
                            });
                        }
                    })
                    .catch(error => {
                        console.error('Error banning user:', error);
                    });
                }
            });
        };

        window.unbanUser = function(userId) {
            Swal.fire({
                title: 'Unban User',
                text: 'Are you sure you want to unban this user?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#00ff00',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Yes, unban',
                cancelButtonText: 'Cancel',
                background: '#1a1a1a',
                color: '#00ff00',
                border: '1px solid #00ff00'
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch(`/backend/api/users.php?action=unban&id=${userId}`, {
                        method: 'POST'
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            Swal.fire({
                                title: 'Success',
                                text: 'User unbanned successfully',
                                icon: 'success',
                                confirmButtonColor: '#00ff00',
                                background: '#1a1a1a',
                                color: '#00ff00',
                                border: '1px solid #00ff00'
                            });
                            loadUsers();
                        } else {
                            Swal.fire({
                                title: 'Error',
                                text: 'Failed to unban user: ' + data.message,
                                icon: 'error',
                                confirmButtonColor: '#00ff00',
                                background: '#1a1a1a',
                                color: '#00ff00',
                                border: '1px solid #00ff00'
                            });
                        }
                    })
                    .catch(error => {
                        console.error('Error unbanning user:', error);
                    });
                }
            });
        };

        window.saveUser = function() {
            const form = document.getElementById('addUserForm');
            const username = document.getElementById('username').value;
            const email = document.getElementById('email').value;
            const password = document.getElementById('password').value;
            const confirmPassword = document.getElementById('confirmPassword').value;
            
            if (password !== confirmPassword) {
                Swal.fire({
                    title: 'Error',
                    text: 'Passwords do not match',
                    icon: 'error',
                    confirmButtonColor: '#00ff00',
                    background: '#1a1a1a',
                    color: '#00ff00',
                    border: '1px solid #00ff00'
                });
                return;
            }
            
            const userData = {
                username: username,
                email: email,
                password: password,
                display_name: username,
                role: 'user',
                is_active: true
            };

            fetch('/backend/api/users.php?action=create', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(userData)
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire({
                        title: 'Success',
                        text: 'User created successfully',
                        icon: 'success',
                        confirmButtonColor: '#00ff00',
                        background: '#1a1a1a',
                        color: '#00ff00',
                        border: '1px solid #00ff00',
                        timer: 2000,
                        showConfirmButton: false
                    }).then(() => {
                        const modal = bootstrap.Modal.getInstance(document.getElementById('addUserModal'));
                        modal.hide();
                        form.reset();
                        loadUsers();
                    });
                } else {
                    Swal.fire({
                        title: 'Error',
                        text: 'Failed to create user: ' + data.message,
                        icon: 'error',
                        confirmButtonColor: '#00ff00',
                        background: '#1a1a1a',
                        color: '#00ff00',
                        border: '1px solid #00ff00'
                    });
                }
            })
            .catch(error => {
                console.error('Error creating user:', error);
                Swal.fire({
                    title: 'Error',
                    text: 'Failed to create user',
                    icon: 'error',
                    confirmButtonColor: '#00ff00',
                    background: '#1a1a1a',
                    color: '#00ff00',
                    border: '1px solid #00ff00'
                });
            });
        };

        function updateUserStats() {
            const totalUsers = allUsers.length;
            const activeUsers = allUsers.filter(u => u.status !== 'banned').length;
            const onlineUsers = allUsers.filter(u => u.status === 'online').length;
            const newToday = allUsers.filter(u => {
                const createdDate = new Date(u.created_at);
                const today = new Date();
                return createdDate.toDateString() === today.toDateString();
            }).length;

            const statNumbers = document.querySelectorAll('.stat-number');
            if (statNumbers[0]) statNumbers[0].textContent = totalUsers.toLocaleString();
            if (statNumbers[1]) statNumbers[1].textContent = activeUsers.toLocaleString();
            if (statNumbers[2]) statNumbers[2].textContent = onlineUsers.toLocaleString();
            if (statNumbers[3]) statNumbers[3].textContent = newToday.toLocaleString();
        }

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
                                border: '1px solid #00ff00',
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
                                border: '1px solid #00ff00',
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