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