document.addEventListener('DOMContentLoaded', function() {
    loadPlatformStats();
    loadLeaderboard();
    startRealTimeUpdates();
    
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
            
            if (rank !== 'all') {
                const rankNum = parseInt(row.querySelector('.rank-badge').textContent);
                if (rank === '1-10' && rankNum > 10) show = false;
                if (rank === '1-25' && rankNum > 25) show = false;
                if (rank === '1-50' && rankNum > 50) show = false;
                if (rank === '1-100' && rankNum > 100) show = false;
            }
            
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
    const tableRows = document.querySelectorAll('.leaderboard-table tbody tr');
    tableRows.forEach(row => {
        row.addEventListener('mouseenter', function() {
            this.style.transform = 'translateX(10px) scale(1.02)';
        });
        
        row.addEventListener('mouseleave', function() {
            this.style.transform = 'translateX(0) scale(1)';
        });
    });
    setInterval(() => {
        const pointsCells = document.querySelectorAll('.points-cell');
        pointsCells.forEach((cell, index) => {
            if (index < 3) {
                const currentPoints = parseInt(cell.textContent.replace(',', ''));
                const change = Math.floor(Math.random() * 10) - 5;
                const newPoints = Math.max(0, currentPoints + change);
                cell.textContent = newPoints.toLocaleString();
            }
        });
    }, 30000);
});
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
    setInterval(() => {
        loadPlatformStats();
        loadLeaderboard();
    }, 30000);
    document.addEventListener('visibilitychange', function() {
        if (!document.hidden) {
            loadPlatformStats();
            loadLeaderboard();
        }
    });
}
window.changePage = function(page) {
    const buttons = document.querySelectorAll('.page-btn');
    buttons.forEach(btn => btn.classList.remove('active'));
    
    if (page === 'prev' || page === 'next') {
        const activeBtn = document.querySelector('.page-btn.active');
        const currentPage = parseInt(activeBtn.textContent);
        const newPage = page === 'prev' ? Math.max(1, currentPage - 1) : Math.min(5, currentPage + 1);
        buttons[newPage].classList.add('active');
    } else {
        buttons[page].classList.add('active');
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
                        timer: 2000,
                        showConfirmButton: false
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
                    timer: 2000,
                    showConfirmButton: false
                }).then(() => {
                    window.location.href = '../../index.php';
                });
            });
        }
    });
}