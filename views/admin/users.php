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
                    <a class="nav-link" href="dashboard.html">
                        <i class="fas fa-tachometer-alt"></i>
                        Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="challenges.html">
                        <i class="fas fa-trophy"></i>
                        Challenges
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="leaderboard.html">
                        <i class="fas fa-chart-line"></i>
                        Leaderboard
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="users.html">
                        <i class="fas fa-users"></i>
                        Users
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="settings.html">
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
                    <div class="stat-number">1,247</div>
                    <div class="stat-label">Total Users</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number">892</div>
                    <div class="stat-label">Active</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number">234</div>
                    <div class="stat-label">Online Now</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number">45</div>
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
                    <div class="col-md-3">
                        <select class="filter-select" id="roleFilter">
                            <option value="all">All Roles</option>
                            <option value="admin">Admin</option>
                            <option value="user">User</option>
                            <option value="moderator">Moderator</option>
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
                <div class="users-grid">
                    <!-- User 1 -->
                    <div class="user-card">
                        <div class="user-header">
                            <div class="user-avatar">JD</div>
                            <div class="user-info">
                                <div class="user-name">John Doe</div>
                                <div class="user-email">john.doe@cybernest.com</div>
                            </div>
                        </div>
                        
                        <div class="user-stats">
                            <div class="stat-box">
                                <div class="stat-value">1,234</div>
                                <div class="stat-label">Points</div>
                            </div>
                            <div class="stat-box">
                                <div class="stat-value">45</div>
                                <div class="stat-label">Challenges</div>
                            </div>
                            <div class="stat-box">
                                <div class="stat-value">12</div>
                                <div class="stat-label">Rank</div>
                            </div>
                        </div>
                        
                        <div class="user-status">
                            <span class="status-badge status-online">Online</span>
                            <span class="user-role">User</span>
                        </div>
                        
                        <div class="action-buttons">
                            <a href="#" class="btn-action" onclick="viewUser('john-doe')">
                                <i class="fas fa-eye me-2"></i>View
                            </a>
                            <a href="#" class="btn-action" onclick="editUser('john-doe')">
                                <i class="fas fa-edit me-2"></i>Edit
                            </a>
                            <a href="#" class="btn-action danger" onclick="banUser('john-doe')">
                                <i class="fas fa-ban me-2"></i>Ban
                            </a>
                        </div>
                    </div>

                    <!-- User 2 -->
                    <div class="user-card">
                        <div class="user-header">
                            <div class="user-avatar">AS</div>
                            <div class="user-info">
                                <div class="user-name">Alice Smith</div>
                                <div class="user-email">alice.smith@cybernest.com</div>
                            </div>
                        </div>
                        
                        <div class="user-stats">
                            <div class="stat-box">
                                <div class="stat-value">2,567</div>
                                <div class="stat-label">Points</div>
                            </div>
                            <div class="stat-box">
                                <div class="stat-value">67</div>
                                <div class="stat-label">Challenges</div>
                            </div>
                            <div class="stat-box">
                                <div class="stat-value">5</div>
                                <div class="stat-label">Rank</div>
                            </div>
                        </div>
                        
                        <div class="user-status">
                            <span class="status-badge status-online">Online</span>
                            <span class="user-role">User</span>
                        </div>
                        
                        <div class="action-buttons">
                            <a href="#" class="btn-action" onclick="viewUser('alice-smith')">
                                <i class="fas fa-eye me-2"></i>View
                            </a>
                            <a href="#" class="btn-action" onclick="editUser('alice-smith')">
                                <i class="fas fa-edit me-2"></i>Edit
                            </a>
                            <a href="#" class="btn-action danger" onclick="banUser('alice-smith')">
                                <i class="fas fa-ban me-2"></i>Ban
                            </a>
                        </div>
                    </div>

                    <!-- User 3 -->
                    <div class="user-card">
                        <div class="user-header">
                            <div class="user-avatar">BJ</div>
                            <div class="user-info">
                                <div class="user-name">Bob Johnson</div>
                                <div class="user-email">bob.johnson@cybernest.com</div>
                            </div>
                        </div>
                        
                        <div class="user-stats">
                            <div class="stat-box">
                                <div class="stat-value">987</div>
                                <div class="stat-label">Points</div>
                            </div>
                            <div class="stat-box">
                                <div class="stat-value">34</div>
                                <div class="stat-label">Challenges</div>
                            </div>
                            <div class="stat-box">
                                <div class="stat-value">18</div>
                                <div class="stat-label">Rank</div>
                            </div>
                        </div>
                        
                        <div class="user-status">
                            <span class="status-badge status-offline">Offline</span>
                            <span class="user-role">User</span>
                        </div>
                        
                        <div class="action-buttons">
                            <a href="#" class="btn-action" onclick="viewUser('bob-johnson')">
                                <i class="fas fa-eye me-2"></i>View
                            </a>
                            <a href="#" class="btn-action" onclick="editUser('bob-johnson')">
                                <i class="fas fa-edit me-2"></i>Edit
                            </a>
                            <a href="#" class="btn-action danger" onclick="banUser('bob-johnson')">
                                <i class="fas fa-ban me-2"></i>Ban
                            </a>
                        </div>
                    </div>

                    <!-- User 4 -->
                    <div class="user-card">
                        <div class="user-header">
                            <div class="user-avatar">EM</div>
                            <div class="user-info">
                                <div class="user-name">Emma Martinez</div>
                                <div class="user-email">emma.martinez@cybernest.com</div>
                            </div>
                        </div>
                        
                        <div class="user-stats">
                            <div class="stat-box">
                                <div class="stat-value">3,456</div>
                                <div class="stat-label">Points</div>
                            </div>
                            <div class="stat-box">
                                <div class="stat-value">89</div>
                                <div class="stat-label">Challenges</div>
                            </div>
                            <div class="stat-box">
                                <div class="stat-value">3</div>
                                <div class="stat-label">Rank</div>
                            </div>
                        </div>
                        
                        <div class="user-status">
                            <span class="status-badge status-online">Online</span>
                            <span class="user-role">Moderator</span>
                        </div>
                        
                        <div class="action-buttons">
                            <a href="#" class="btn-action" onclick="viewUser('emma-martinez')">
                                <i class="fas fa-eye me-2"></i>View
                            </a>
                            <a href="#" class="btn-action" onclick="editUser('emma-martinez')">
                                <i class="fas fa-edit me-2"></i>Edit
                            </a>
                            <a href="#" class="btn-action danger" onclick="banUser('emma-martinez')">
                                <i class="fas fa-ban me-2"></i>Ban
                            </a>
                        </div>
                    </div>

                    <!-- User 5 -->
                    <div class="user-card">
                        <div class="user-header">
                            <div class="user-avatar">MW</div>
                            <div class="user-info">
                                <div class="user-name">Michael Wilson</div>
                                <div class="user-email">michael.wilson@cybernest.com</div>
                            </div>
                        </div>
                        
                        <div class="user-stats">
                            <div class="stat-box">
                                <div class="stat-value">567</div>
                                <div class="stat-label">Points</div>
                            </div>
                            <div class="stat-box">
                                <div class="stat-value">23</div>
                                <div class="stat-label">Challenges</div>
                            </div>
                            <div class="stat-box">
                                <div class="stat-value">25</div>
                                <div class="stat-label">Rank</div>
                            </div>
                        </div>
                        
                        <div class="user-status">
                            <span class="status-badge status-banned">Banned</span>
                            <span class="user-role">User</span>
                        </div>
                        
                        <div class="action-buttons">
                            <a href="#" class="btn-action" onclick="viewUser('michael-wilson')">
                                <i class="fas fa-eye me-2"></i>View
                            </a>
                            <a href="#" class="btn-action" onclick="editUser('michael-wilson')">
                                <i class="fas fa-edit me-2"></i>Edit
                            </a>
                            <a href="#" class="btn-action" onclick="unbanUser('michael-wilson')">
                                <i class="fas fa-check me-2"></i>Unban
                            </a>
                        </div>
                    </div>

                    <!-- User 6 -->
                    <div class="user-card">
                        <div class="user-header">
                            <div class="user-avatar">SA</div>
                            <div class="user-info">
                                <div class="user-name">Sarah Anderson</div>
                                <div class="user-email">sarah.anderson@cybernest.com</div>
                            </div>
                        </div>
                        
                        <div class="user-stats">
                            <div class="stat-box">
                                <div class="stat-value">4,123</div>
                                <div class="stat-label">Points</div>
                            </div>
                            <div class="stat-box">
                                <div class="stat-value">102</div>
                                <div class="stat-label">Challenges</div>
                            </div>
                            <div class="stat-box">
                                <div class="stat-value">2</div>
                                <div class="stat-label">Rank</div>
                            </div>
                        </div>
                        
                        <div class="user-status">
                            <span class="status-badge status-online">Online</span>
                            <span class="user-role">Admin</span>
                        </div>
                        
                        <div class="action-buttons">
                            <a href="#" class="btn-action" onclick="viewUser('sarah-anderson')">
                                <i class="fas fa-eye me-2"></i>View
                            </a>
                            <a href="#" class="btn-action" onclick="editUser('sarah-anderson')">
                                <i class="fas fa-edit me-2"></i>Edit
                            </a>
                            <a href="#" class="btn-action" onclick="changeRole('sarah-anderson')">
                                <i class="fas fa-user-shield me-2"></i>Role
                            </a>
                        </div>
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
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">First Name</label>
                                <input type="text" class="form-control" id="firstName" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Last Name</label>
                                <input type="text" class="form-control" id="lastName" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" required>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Username</label>
                                <input type="text" class="form-control" id="username" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Password</label>
                                <input type="password" class="form-control" id="password" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Role</label>
                                <select class="form-select" id="role" required>
                                    <option value="">Select role</option>
                                    <option value="user">User</option>
                                    <option value="moderator">Moderator</option>
                                    <option value="admin">Admin</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Initial Points</label>
                                <input type="number" class="form-control" id="points" value="0">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Status</label>
                            <select class="form-select" id="status" required>
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                                <option value="banned">Banned</option>
                            </select>
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
    <script>
        // Users specific functionality
        document.addEventListener('DOMContentLoaded', function() {
            // Search functionality
            const searchInput = document.getElementById('searchInput');
            if (searchInput) {
                searchInput.addEventListener('input', function() {
                    const searchTerm = this.value.toLowerCase();
                    const users = document.querySelectorAll('.user-card');
                    
                    users.forEach(user => {
                        const name = user.querySelector('.user-name').textContent.toLowerCase();
                        const email = user.querySelector('.user-email').textContent.toLowerCase();
                        
                        if (name.includes(searchTerm) || email.includes(searchTerm)) {
                            user.style.display = '';
                        } else {
                            user.style.display = 'none';
                        }
                    });
                });
            }

            // Filter functionality
            const statusFilter = document.getElementById('statusFilter');
            const roleFilter = document.getElementById('roleFilter');
            
            if (statusFilter) {
                statusFilter.addEventListener('change', function() {
                    filterUsers();
                });
            }

            if (roleFilter) {
                roleFilter.addEventListener('change', function() {
                    filterUsers();
                });
            }

            function filterUsers() {
                const status = statusFilter.value;
                const role = roleFilter.value;
                const users = document.querySelectorAll('.user-card');
                
                users.forEach(user => {
                    let show = true;
                    
                    if (status !== 'all') {
                        const statusBadge = user.querySelector('.status-badge');
                        if (!statusBadge || !statusBadge.textContent.toLowerCase().includes(status)) {
                            show = false;
                        }
                    }
                    
                    if (role !== 'all') {
                        const roleBadge = user.querySelector('.user-role');
                        if (!roleBadge || !roleBadge.textContent.toLowerCase().includes(role)) {
                            show = false;
                        }
                    }
                    
                    user.style.display = show ? '' : 'none';
                });
            }

            // Refresh users
            window.refreshUsers = function() {
                console.log('Refreshing users...');
                const refreshBtn = event.target;
                refreshBtn.innerHTML = '<i class="fas fa-sync-alt fa-spin me-2"></i>Refreshing...';
                refreshBtn.disabled = true;
                
                setTimeout(() => {
                    refreshBtn.innerHTML = '<i class="fas fa-sync-alt me-2"></i>Refresh';
                    refreshBtn.disabled = false;
                    console.log('Users refreshed');
                }, 2000);
            };

            // User actions
            window.viewUser = function(userId) {
                console.log('Viewing user:', userId);
                alert(`Viewing user: ${userId}`);
            };

            window.editUser = function(userId) {
                console.log('Editing user:', userId);
                alert(`Editing user: ${userId}`);
            };

            window.banUser = function(userId) {
                if (confirm(`Are you sure you want to ban user "${userId}"?`)) {
                    console.log('Banning user:', userId);
                    alert(`User "${userId}" banned successfully!`);
                }
            };

            window.unbanUser = function(userId) {
                if (confirm(`Are you sure you want to unban user "${userId}"?`)) {
                    console.log('Unbanning user:', userId);
                    alert(`User "${userId}" unbanned successfully!`);
                }
            };

            window.changeRole = function(userId) {
                console.log('Changing role for:', userId);
                alert(`Changing role for user: ${userId}`);
            };

            // Save user
            window.saveUser = function() {
                const form = document.getElementById('addUserForm');
                if (form.checkValidity()) {
                    console.log('Saving new user...');
                    const modal = bootstrap.Modal.getInstance(document.getElementById('addUserModal'));
                    modal.hide();
                    form.reset();
                    alert('User saved successfully!');
                } else {
                    form.reportValidity();
                }
            };

            // Simulate real-time updates
            setInterval(() => {
                const statNumbers = document.querySelectorAll('.stat-number');
                statNumbers.forEach(stat => {
                    if (stat.textContent.includes(',')) {
                        const currentValue = parseInt(stat.textContent.replace(',', ''));
                        const change = Math.floor(Math.random() * 5) - 2;
                        const newValue = Math.max(0, currentValue + change);
                        stat.textContent = newValue.toLocaleString();
                    }
                });
            }, 20000);
        });
    </script>
</body>
</html>