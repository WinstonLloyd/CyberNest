let allLeaderboardData = [];
let filteredLeaderboardData = [];
document.addEventListener('DOMContentLoaded', function() {
    loadLeaderboardData();
    loadLeaderboardStats();
    
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
        const matchesSearch = !searchTerm || 
            user.display_name.toLowerCase().includes(searchTerm) ||
            user.email.toLowerCase().includes(searchTerm) ||
            user.username.toLowerCase().includes(searchTerm);
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