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
    <button class="toggle-sidebar" id="toggleSidebar">
        <i class="fas fa-bars"></i>
    </button>

    <nav class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <h3><i class="fas fa-shield-alt me-2"></i>CYBERNEST</h3>
            <small class="text-muted">Admin Panel</small>
        </div>
        <div class="sidebar-menu">
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link active" href="dashboard.php">
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
                                <div class="stat-number" id="totalUsersCount">0</div>
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
                                <div class="stat-number" id="activeSessionsCount">0</div>
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
                                <div class="stat-number" id="totalChallengesCount">0</div>
                                <div class="stat-label">Total Challenges</div>
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
                                <div class="stat-number" id="systemUptime"></div>
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
                        <div class="p-3 border-bottom border-success">
                            <h5 class="mb-0"><i class="fas fa-chart-line me-2"></i>User Activity Chart</h5>
                        </div>
                        <div class="p-3">
                            <canvas id="userActivityChart" height="200"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="chart-container">
                        <div class="p-3 border-bottom border-success">
                            <h5 class="mb-0"><i class="fas fa-chart-pie me-2"></i>System Resources</h5>
                        </div>
                        <div class="p-3">
                            <canvas id="systemResourcesChart" height="200"></canvas>
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
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="../../javascript/admin-dashboard.js?v=<?php echo time(); ?>"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            loadDashboardStats();
            loadRecentUsers();
            initializeCharts();
            
            setInterval(loadDashboardStats, 30000);
            setInterval(loadRecentUsers, 30000);
            setInterval(updateCharts, 30000);
        });

        let userActivityChart = null;
        let systemResourcesChart = null;

        function initializeCharts() {
            const userActivityCtx = document.getElementById('userActivityChart').getContext('2d');
            userActivityChart = new Chart(userActivityCtx, {
                type: 'line',
                data: {
                    labels: [],
                    datasets: [{
                        label: 'Solved Challenges',
                        data: [],
                        borderColor: '#00ff00',
                        backgroundColor: 'rgba(0, 255, 0, 0.1)',
                        tension: 0.4,
                        fill: true
                    }, {
                        label: 'Total Attempts',
                        data: [],
                        borderColor: '#ff6b6b',
                        backgroundColor: 'rgba(255, 107, 107, 0.1)',
                        tension: 0.4,
                        fill: true
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            labels: {
                                color: '#00ff00'
                            }
                        }
                    },
                    scales: {
                        x: {
                            grid: {
                                color: 'rgba(0, 255, 0, 0.1)'
                            },
                            ticks: {
                                color: '#00ff00'
                            }
                        },
                        y: {
                            grid: {
                                color: 'rgba(0, 255, 0, 0.1)'
                            },
                            ticks: {
                                color: '#00ff00'
                            }
                        }
                    }
                }
            });

            const systemResourcesCtx = document.getElementById('systemResourcesChart').getContext('2d');
            systemResourcesChart = new Chart(systemResourcesCtx, {
                type: 'doughnut',
                data: {
                    labels: ['CPU Usage', 'Memory', 'Disk Space', 'Network'],
                    datasets: [{
                        data: [65, 45, 30, 25],
                        backgroundColor: [
                            '#00ff00',
                            '#ff6b6b',
                            '#4ecdc4',
                            '#f39c12'
                        ],
                        borderWidth: 2,
                        borderColor: '#1a1a1a'
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            labels: {
                                color: '#00ff00'
                            }
                        }
                    }
                }
            });

            loadChartData();
        }

        function loadChartData() {
            fetch('/backend/api/challenges.php?action=attempts_by_day')
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        updateChartWithChallengeData(data.attempts);
                    } else {
                        console.error('Failed to load challenge attempts data:', data.message);
                        if (userActivityChart) {
                            userActivityChart.data.labels = ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'];
                            userActivityChart.data.datasets[0].data = [0, 0, 0, 0, 0, 0, 0];
                            userActivityChart.data.datasets[1].data = [0, 0, 0, 0, 0, 0, 0];
                            userActivityChart.update();
                        }
                    }
                })
                .catch(error => {
                    console.error('Error loading challenge attempts data:', error);
                    if (userActivityChart) {
                        userActivityChart.data.labels = ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'];
                        userActivityChart.data.datasets[0].data = [0, 0, 0, 0, 0, 0, 0];
                        userActivityChart.data.datasets[1].data = [0, 0, 0, 0, 0, 0, 0];
                        userActivityChart.update();
                    }
                });
        }

        function updateChartWithChallengeData(attemptsData) {
            if (userActivityChart && attemptsData) {
                userActivityChart.data.labels = attemptsData.labels || [];
                userActivityChart.data.datasets[0].data = attemptsData.solved_challenges || [];
                userActivityChart.data.datasets[1].data = attemptsData.total_attempts || [];
                userActivityChart.update();
            }
            updateSystemResources();
        }

        function updateCharts() {
            loadChartData();
        }

        function updateSystemResources() {
            if (systemResourcesChart) {
                const cpuUsage = 65;
                const memoryUsage = 45;
                const diskUsage = 30;
                const networkUsage = 25;

                systemResourcesChart.data.datasets[0].data = [cpuUsage, memoryUsage, diskUsage, networkUsage];
                systemResourcesChart.update();
            }
        }

        function loadDashboardStats() {
            fetch('/backend/api/users.php?action=stats')
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        document.getElementById('totalUsersCount').textContent = data.stats.total_users.toLocaleString();
                        document.getElementById('activeSessionsCount').textContent = data.stats.active_users.toLocaleString();
                    }
                })
                .catch(error => {
                    console.error('Error loading user stats:', error);
                });

            fetch('/backend/api/challenges.php?action=stats')
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        document.getElementById('totalChallengesCount').textContent = data.stats.total_challenges.toLocaleString();
                    }
                })
                .catch(error => {
                    console.error('Error loading challenge stats:', error);
                });

            const uptime = calculateUptime();
            document.getElementById('systemUptime').textContent = uptime;
        }

        function loadRecentUsers() {
            fetch('/backend/api/users.php?action=getAll&limit=5')
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        displayRecentUsers(data.users);
                    }
                })
                .catch(error => {
                    console.error('Error loading recent users:', error);
                });
        }

        function displayRecentUsers(users) {
            const tbody = document.querySelector('.user-table tbody');
            if (!tbody) return;

            tbody.innerHTML = users.map(user => {
                const statusClass = user.status === 'online' ? 'status-online' : 'status-offline';
                const statusText = user.status === 'online' ? 'Online' : 'Offline';
                const lastActivity = user.last_login ? formatTimeAgo(user.last_login) : 'Never';
                
                return `
                    <tr>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="bg-success rounded-circle me-2" style="width: 30px; height: 30px; display: flex; align-items: center; justify-content: center;">
                                    <i class="fas fa-user fa-sm"></i>
                                </div>
                                ${user.display_name}
                            </div>
                        </td>
                        <td>${user.email}</td>
                        <td><span class="status-badge ${statusClass}">${statusText}</span></td>
                        <td>${lastActivity}</td>
                        <td>
                            <button class="action-btn me-1" onclick="viewUser(${user.id})">View</button>
                            <button class="action-btn" onclick="editUser(${user.id})">Edit</button>
                        </td>
                    </tr>
                `;
            }).join('');
        }

        function calculateUptime() {
            const uptimePercent = 99.9;
            return uptimePercent.toFixed(1) + '%';
        }

        function formatTimeAgo(dateString) {
            if (!dateString) return 'Never';
            
            const date = new Date(dateString);
            const now = new Date();
            const diffMs = now - date;
            const diffMins = Math.floor(diffMs / 60000);
            const diffHours = Math.floor(diffMs / 3600000);
            const diffDays = Math.floor(diffMs / 86400000);

            if (diffMins < 1) return 'Just now';
            if (diffMins < 60) return `${diffMins} mins ago`;
            if (diffHours < 24) return `${diffHours} hours ago`;
            if (diffDays < 7) return `${diffDays} days ago`;
            return date.toLocaleDateString();
        }

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
                                    <p><strong>Rank:</strong> ${user.rank}</p>
                                    <p><strong>Points:</strong> ${user.points || 0}</p>
                                    <p><strong>Challenges Completed:</strong> ${user.challenges_completed || 0}</p>
                                    <p><strong>Status:</strong> ${user.status}</p>
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
                })
                .catch(error => {
                    console.error('Error viewing user:', error);
                });
        };

        window.editUser = function(userId) {
            fetch(`/backend/api/users.php?action=getById&id=${userId}`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const user = data.user;
                        Swal.fire({
                            title: 'Edit User',
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
                                            text: 'User updated successfully',
                                            icon: 'success',
                                            confirmButtonColor: '#00ff00',
                                            background: '#1a1a1a',
                                            color: '#00ff00'
                                        });
                                        loadRecentUsers();
                                    } else {
                                        Swal.fire({
                                            title: 'Error',
                                            text: 'Failed to update user: ' + data.message,
                                            icon: 'error',
                                            confirmButtonColor: '#00ff00',
                                            background: '#1a1a1a',
                                            color: '#00ff00'
                                        });
                                    }
                                })
                                .catch(error => {
                                    console.error('Error updating user:', error);
                                });
                            }
                        });
                    }
                })
                .catch(error => {
                    console.error('Error fetching user:', error);
                });
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