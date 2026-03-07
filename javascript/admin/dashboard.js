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