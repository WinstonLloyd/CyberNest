document.addEventListener('DOMContentLoaded', function() {
    loadUserProfile();
    loadPlatformStats();
    loadRecentActivity();
    loadTopHackers();
    
    startRealTimeUpdates();
    
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
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });
    window.addEventListener('scroll', () => {
        const scrolled = window.pageYOffset;
        const heroSection = document.querySelector('.hero-section');
        if (heroSection) {
            heroSection.style.transform = `translateY(${scrolled * 0.5}px)`;
        }
    });
    setInterval(() => {
        const activityTimes = document.querySelectorAll('.activity-time');
        activityTimes.forEach((time, index) => {
            if (index === 0) {
                time.textContent = 'Just now';
            }
        });
    }, 60000);
    const cards = document.querySelectorAll('.stat-card, .feature-card, .leaderboard-item, .activity-item');
    cards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-5px) scale(1.02)';
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0) scale(1)';
        });
    });
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    const tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
});

function loadUserProfile() {
    fetch('/backend/api/challenges.php?action=getUserProfile')
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                updateNavigationAvatar(data.profile);
            } else {
                console.error('Failed to load user profile:', data.message);
            }
        })
        .catch(error => {
            console.error('Error loading user profile:', error);
        });
}

function updateNavigationAvatar(profile) {
    const navAvatar = document.querySelector('.user-avatar-nav');
    if (navAvatar) {
        if (profile.profile_picture && profile.profile_picture !== '') {
            navAvatar.innerHTML = `<img src="${profile.profile_picture}" alt="Profile Picture">`;
        } else {
            navAvatar.innerHTML = `<img src="/uploads/default/default.jpg" alt="Default Profile Picture">`;
        }
    }
}

function getInitials(username) {
    return username.split(' ')
        .map(word => word.charAt(0).toUpperCase())
        .join('')
        .substring(0, 2);
}

function loadPlatformStats() {
    fetch('/backend/api/challenges.php?action=getPlatformStats')
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const stats = data.stats;
                updateStatCard('totalChallenges', stats.total_challenges);
                updateStatCard('totalHackers', stats.total_hackers);
                updateStatCard('userCompleted', stats.user_completed);
                updateStatCard('activeToday', stats.active_today);
            } else {
                console.error('Failed to load platform stats:', data.message);
            }
        })
        .catch(error => {
            console.error('Error loading platform stats:', error);
        });
}
function loadRecentActivity() {
    fetch('/backend/api/challenges.php?action=getRecentActivity&limit=8')
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                displayRecentActivity(data.activities);
            } else {
                console.error('Failed to load recent activity:', data.message);
            }
        })
        .catch(error => {
            console.error('Error loading recent activity:', error);
        });
}
function loadTopHackers() {
    fetch('/backend/api/challenges.php?action=getTopHackers&limit=5')
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                displayTopHackers(data.hackers);
            } else {
                console.error('Failed to load top hackers:', data.message);
            }
        })
        .catch(error => {
            console.error('Error loading top hackers:', error);
        });
}
function updateStatCard(elementId, value) {
    const element = document.getElementById(elementId);
    if (element) {
        const oldValue = element.textContent;
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
function displayRecentActivity(activities) {
    const container = document.getElementById('recentActivityList');
    if (!container) return;
    if (activities.length === 0) {
        container.innerHTML = `
            <div class="text-center py-4">
                <i class="fas fa-info-circle fa-2x mb-3 text-muted"></i>
                <p class="text-muted">No recent activity found</p>
            </div>
        `;
        return;
    }
    container.innerHTML = activities.map(activity => `
        <div class="activity-item">
            <div class="activity-icon">
                <i class="${activity.icon}"></i>
            </div>
            <div class="activity-content">
                <div class="activity-title">${activity.title}</div>
                <div class="activity-description">${activity.description}</div>
            </div>
            <div class="activity-time">${activity.time}</div>
        </div>
    `).join('');
}
function displayTopHackers(hackers) {
    const container = document.getElementById('topHackersList');
    if (!container) return;
    if (hackers.length === 0) {
        container.innerHTML = `
            <div class="text-center py-4">
                <i class="fas fa-users fa-2x mb-3 text-muted"></i>
                <p class="text-muted">No hackers found</p>
            </div>
        `;
        return;
    }
    container.innerHTML = hackers.map(hacker => {
        const rankClass = hacker.rank <= 3 ? `rank-${hacker.rank}` : 'rank-other';
        return `
            <div class="leaderboard-item">
                <div class="rank-badge ${rankClass}">${hacker.rank}</div>
                <div class="leaderboard-info">
                    <div class="leaderboard-name">${hacker.username}</div>
                    <div class="leaderboard-stats">${hacker.challenges_completed} challenges • ${hacker.last_activity}</div>
                </div>
                <div class="leaderboard-points">${hacker.points.toLocaleString()} pts</div>
            </div>
        `;
    }).join('');
}
function startRealTimeUpdates() {
    setInterval(() => {
        loadUserProfile();
        loadPlatformStats();
        loadRecentActivity();
        loadTopHackers();
    }, 30000);
    document.addEventListener('visibilitychange', function() {
        if (!document.hidden) {
            loadUserProfile();
            loadPlatformStats();
            loadRecentActivity();
            loadTopHackers();
        }
    });
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
                        border: '1px solid #00ff00'
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