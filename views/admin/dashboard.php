<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CyberNest Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../../css/admin/dashboard.css">
</head>
<body>
    <!-- Toggle Sidebar Button -->
    <button class="toggle-sidebar" id="toggleSidebar">
        <i class="fas fa-bars"></i>
    </button>

    <!-- Sidebar -->
    <nav class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <h3><i class="fas fa-shield-alt me-2"></i>CYBERNEST</h3>
            <small class="text-muted">Admin Panel</small>
        </div>
        <div class="sidebar-menu">
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link active" href="dashboard.html">
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
                    <a class="nav-link" href="users.php">
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
                    <h1 class="h3 mb-0">Admin Dashboard</h1>
                    <small class="text-muted">System Overview & Management</small>
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

        <!-- Dashboard Content -->
        <div class="dashboard-content">
            <!-- Statistics Cards -->
            <div class="row mb-4">
                <div class="col-lg-3 col-md-6">
                    <div class="stat-card">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <div class="stat-number">1,234</div>
                                <div class="stat-label">Total Users</div>
                            </div>
                            <div class="text-success">
                                <i class="fas fa-users fa-2x"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="stat-card">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <div class="stat-number">892</div>
                                <div class="stat-label">Active Sessions</div>
                            </div>
                            <div class="text-success">
                                <i class="fas fa-signal fa-2x"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="stat-card">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <div class="stat-number">45</div>
                                <div class="stat-label">Security Events</div>
                            </div>
                            <div class="text-success">
                                <i class="fas fa-shield-alt fa-2x"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="stat-card">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <div class="stat-number">99.9%</div>
                                <div class="stat-label">Uptime</div>
                            </div>
                            <div class="text-success">
                                <i class="fas fa-server fa-2x"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Charts Row -->
            <div class="row mb-4">
                <div class="col-lg-8">
                    <div class="chart-container">
                        <div class="chart-placeholder">
                            <i class="fas fa-chart-line fa-3x mb-3"></i>
                            <div>User Activity Chart</div>
                            <small class="text-muted">Real-time user activity monitoring</small>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="chart-container">
                        <div class="chart-placeholder">
                            <i class="fas fa-chart-pie fa-3x mb-3"></i>
                            <div>System Resources</div>
                            <small class="text-muted">CPU, Memory, Disk usage</small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Users Table -->
            <div class="row mb-4">
                <div class="col-lg-8">
                    <div class="user-table">
                        <div class="p-3 border-bottom border-success">
                            <h5 class="mb-0"><i class="fas fa-users me-2"></i>Recent Users</h5>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-dark table-hover">
                                <thead>
                                    <tr>
                                        <th>User</th>
                                        <th>Email</th>
                                        <th>Status</th>
                                        <th>Last Activity</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="bg-success rounded-circle me-2" style="width: 30px; height: 30px; display: flex; align-items: center; justify-content: center;">
                                                    <i class="fas fa-user fa-sm"></i>
                                                </div>
                                                John Doe
                                            </div>
                                        </td>
                                        <td>john@example.com</td>
                                        <td><span class="status-badge status-online">Online</span></td>
                                        <td>2 mins ago</td>
                                        <td>
                                            <button class="action-btn me-1">View</button>
                                            <button class="action-btn">Edit</button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="bg-success rounded-circle me-2" style="width: 30px; height: 30px; display: flex; align-items: center; justify-content: center;">
                                                    <i class="fas fa-user fa-sm"></i>
                                                </div>
                                                Jane Smith
                                            </div>
                                        </td>
                                        <td>jane@example.com</td>
                                        <td><span class="status-badge status-online">Online</span></td>
                                        <td>5 mins ago</td>
                                        <td>
                                            <button class="action-btn me-1">View</button>
                                            <button class="action-btn">Edit</button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="bg-secondary rounded-circle me-2" style="width: 30px; height: 30px; display: flex; align-items: center; justify-content: center;">
                                                    <i class="fas fa-user fa-sm"></i>
                                                </div>
                                                Bob Johnson
                                            </div>
                                        </td>
                                        <td>bob@example.com</td>
                                        <td><span class="status-badge status-offline">Offline</span></td>
                                        <td>1 hour ago</td>
                                        <td>
                                            <button class="action-btn me-1">View</button>
                                            <button class="action-btn">Edit</button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="chart-container" style="height: auto;">
                        <div class="p-3 border-bottom border-success">
                            <h5 class="mb-0"><i class="fas fa-history me-2"></i>Recent Activity</h5>
                        </div>
                        <div class="p-3">
                            <div class="activity-item">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div>
                                        <strong>New user registration</strong>
                                        <div class="activity-time">10 minutes ago</div>
                                    </div>
                                    <i class="fas fa-user-plus text-success"></i>
                                </div>
                            </div>
                            <div class="activity-item">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div>
                                        <strong>Security alert triggered</strong>
                                        <div class="activity-time">25 minutes ago</div>
                                    </div>
                                    <i class="fas fa-exclamation-triangle text-warning"></i>
                                </div>
                            </div>
                            <div class="activity-item">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div>
                                        <strong>System backup completed</strong>
                                        <div class="activity-time">1 hour ago</div>
                                    </div>
                                    <i class="fas fa-check-circle text-success"></i>
                                </div>
                            </div>
                            <div class="activity-item">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div>
                                        <strong>Database optimization</strong>
                                        <div class="activity-time">2 hours ago</div>
                                    </div>
                                    <i class="fas fa-database text-info"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../../javascript/admin-dashboard.js"></script>
    <script>
        function logout() {
            if (confirm('Are you sure you want to logout?')) {
                fetch('/backend/logout.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Redirect to login page
                        window.location.href = '../../index.php';
                    } else {
                        alert('Logout failed: ' + data.message);
                    }
                })
                .catch(error => {
                    console.error('Logout error:', error);
                    // Still redirect on error
                    window.location.href = '../../index.php';
                });
            }
        }
    </script>
</body>
</html>