document.addEventListener('DOMContentLoaded', function() {
    loadChallenges();
    loadUserTotalPoints();
    startRealTimeUpdates();
    
    const searchInput = document.getElementById('searchInput');
    if (searchInput) {
        searchInput.addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            const cards = document.querySelectorAll('.challenge-card');
            
            cards.forEach(card => {
                const title = card.querySelector('.challenge-title').textContent.toLowerCase();
                const description = card.querySelector('.challenge-description').textContent.toLowerCase();
                const tags = Array.from(card.querySelectorAll('.tag')).map(tag => tag.textContent.toLowerCase()).join(' ');
                
                if (title.includes(searchTerm) || description.includes(searchTerm) || tags.includes(searchTerm)) {
                    card.style.display = '';
                } else {
                    card.style.display = 'none';
                }
            });
        });
    }
    const difficultyFilter = document.getElementById('difficultyFilter');
    const categoryFilter = document.getElementById('categoryFilter');
    const statusFilter = document.getElementById('statusFilter');
    
    function applyFilters() {
        const difficulty = difficultyFilter.value;
        const category = categoryFilter.value;
        const status = statusFilter.value;
        const cards = document.querySelectorAll('.challenge-card');
        
        cards.forEach(card => {
            let show = true;
            
            if (difficulty !== 'all' && card.dataset.difficulty !== difficulty) {
                show = false;
            }
            
            if (category !== 'all' && card.dataset.category !== category) {
                show = false;
            }
            
            if (status !== 'all' && card.dataset.status !== status) {
                show = false;
            }
            
            card.style.display = show ? '' : 'none';
        });
    }
    
    if (difficultyFilter) difficultyFilter.addEventListener('change', applyFilters);
    if (categoryFilter) categoryFilter.addEventListener('change', applyFilters);
    if (statusFilter) statusFilter.addEventListener('change', applyFilters);
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
});
function loadChallenges() {
    fetch('/backend/api/challenges.php?action=getUserChallenges')
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                displayChallenges(data.challenges);
                updateStats(data.challenges);
            } else {
                console.error('Failed to load challenges:', data.message);
                showError('Failed to load challenges');
            }
        })
        .catch(error => {
            console.error('Error loading challenges:', error);
            showError('Error loading challenges');
        });
}
function loadUserTotalPoints() {
    fetch('/backend/api/challenges.php?action=getUserTotalPoints')
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const pointsDisplay = document.getElementById('totalPointsDisplay');
                if (pointsDisplay) {
                    pointsDisplay.textContent = data.total_points.toLocaleString();
                }
            } else {
                console.error('Failed to load user points:', data.message);
            }
        })
        .catch(error => {
            console.error('Error loading user points:', error);
        });
}
function displayChallenges(challenges) {
    const container = document.getElementById('challengesGrid');
    
    if (challenges.length === 0) {
        container.innerHTML = `
            <div class="text-center py-5">
                <i class="fas fa-trophy fa-3x mb-3 text-muted"></i>
                <h4 class="text-muted">No challenges found</h4>
                <p class="text-muted">Check back later for new challenges!</p>
            </div>
        `;
        return;
    }
    
    container.innerHTML = challenges.map(challenge => createChallengeCard(challenge)).join('');
    
    addChallengeCardHandlers();
}
function createChallengeCard(challenge) {
    const difficultyClass = `difficulty-${challenge.difficulty}`;
    const statusBadge = getStatusBadge(challenge.status);
    const tags = challenge.tags ? challenge.tags.split(',').map(tag => `<span class="tag">${tag.trim()}</span>`).join('') : '';
    
    let fileDownloadHtml = '';
    if (challenge.file_path && challenge.original_filename) {
        fileDownloadHtml = `
            <div class="challenge-file">
                <a href="/${challenge.file_path}" download="${challenge.original_filename}" 
                   class="btn btn-sm btn-success file-download-btn">
                    <i class="fas fa-download me-1"></i>Download
                </a>
            </div>
        `;
    }
    let userStatusClass = '';
    let userStatusText = '';
    let userStatusIcon = '';
    
    if (challenge.status === 'inactive') {
        userStatusClass = 'status-inactive';
        userStatusText = 'Unavailable';
        userStatusIcon = '<i class="fas fa-times-circle"></i>';
    } else if (challenge.status === 'draft') {
        userStatusClass = 'status-draft';
        userStatusText = 'Draft';
        userStatusIcon = '<i class="fas fa-edit"></i>';
    } else if (challenge.user_completed == 1) {
        userStatusClass = 'status-completed';
        userStatusText = 'Completed';
        userStatusIcon = '<i class="fas fa-check-circle"></i>';
    } else if (challenge.user_attempts > 0) {
        userStatusClass = 'status-attempted';
        userStatusText = 'Attempted';
        userStatusIcon = '<i class="fas fa-clock"></i>';
    } else {
        userStatusClass = 'status-active';
        userStatusText = 'Available';
        userStatusIcon = '<i class="fas fa-play-circle"></i>';
    }
    
    return `
        <div class="challenge-card" data-difficulty="${challenge.difficulty}" data-category="${challenge.category}" data-status="${challenge.status}" data-id="${challenge.id}" data-user-completed="${challenge.user_completed}">
            <div class="challenge-header">
                <div>
                    <h3 class="challenge-title">${challenge.title}</h3>
                </div>
                <span class="difficulty-badge ${difficultyClass}">${challenge.difficulty}</span>
            </div>
            <p class="challenge-description">${challenge.description}</p>
            
            ${fileDownloadHtml}
            
            <div class="challenge-stats">
                <div class="stat-item">
                    <div class="stat-value">${challenge.attempts || 0}</div>
                    <div class="stat-label">Total Attempts</div>
                </div>
                <div class="stat-item">
                    <div class="stat-value">${challenge.solved_count || 0}</div>
                    <div class="stat-label">Solved</div>
                </div>
                <div class="stat-item">
                    <div class="stat-value">${challenge.user_attempts || 0}</div>
                    <div class="stat-label">Your Attempts</div>
                </div>
            </div>
            <div class="challenge-tags">
                ${tags}
            </div>
            <div class="challenge-footer">
                <div class="challenge-points">${challenge.points} pts</div>
                <span class="challenge-status ${userStatusClass}">${userStatusIcon} ${userStatusText}</span>
            </div>
        </div>
    `;
}
function getStatusBadge(status) {
    const badges = {
        'active': 'Available',
        'inactive': 'Unavailable',
        'draft': 'Draft'
    };
    return badges[status] || 'Unknown';
}
function updateStats(challenges) {
    const totalChallenges = challenges.length;
    const activeChallenges = challenges.filter(c => c.status === 'active').length;
    const completedChallenges = challenges.filter(c => c.user_completed == 1).length;
    const attemptedChallenges = challenges.filter(c => c.user_attempts > 0 && c.user_completed == 0).length;
    const earnedPoints = challenges.filter(c => c.user_completed == 1).reduce((sum, c) => sum + c.points, 0);
    
    const statCards = document.querySelectorAll('.stat-card');
    if (statCards.length >= 4) {
        statCards[0].querySelector('.stat-number').textContent = totalChallenges;
        statCards[1].querySelector('.stat-number').textContent = completedChallenges;
        statCards[2].querySelector('.stat-number').textContent = attemptedChallenges;
        statCards[3].querySelector('.stat-number').textContent = earnedPoints.toLocaleString();
    }
}
function addChallengeCardHandlers() {
    const challengeCards = document.querySelectorAll('.challenge-card');
    challengeCards.forEach(card => {
        card.addEventListener('click', function() {
            const title = this.querySelector('.challenge-title').textContent;
            const difficulty = this.querySelector('.difficulty-badge').textContent;
            const status = this.dataset.status;
            const userCompleted = this.dataset.userCompleted;
            const challengeId = this.dataset.id;
            
            if (status === 'inactive') {
                Swal.fire({
                    icon: 'warning',
                    title: 'Challenge Inactive',
                    text: 'This challenge is currently inactive and cannot be attempted.',
                    confirmButtonColor: '#00ff00',
                    background: '#1a1a1a',
                    color: '#00ff00',
                    border: '1px solid #00ff00'
                });
                return;
            }
            
            if (status === 'draft') {
                Swal.fire({
                    icon: 'info',
                    title: 'Challenge in Draft',
                    text: 'This challenge is still in draft mode and not available.',
                    confirmButtonColor: '#00ff00',
                    background: '#1a1a1a',
                    color: '#00ff00',
                    border: '1px solid #00ff00'
                });
                return;
            }
            
            if (userCompleted === '1') {
                Swal.fire({
                    icon: 'success',
                    title: 'Already Completed',
                    text: 'You have already completed this challenge!',
                    confirmButtonColor: '#00ff00',
                    background: '#1a1a1a',
                    color: '#00ff00',
                    border: '1px solid #00ff00'
                });
                return;
            }
            
            showFlagModal(title, difficulty, challengeId);
        });
    });
}
function showFlagModal(challengeTitle, difficulty, challengeId) {
    const modalHtml = `
        <div class="modal fade" id="flagModal" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content" style="background: #1a1a1a; border: 1px solid #00ff00;">
                    <div class="modal-header" style="border-bottom: 1px solid #00ff00;">
                        <h5 class="modal-title" style="color: #00ff00;">
                            <i class="fas fa-flag me-2"></i>Submit Flag
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <h6 style="color: #00ff00; margin-bottom: 15px;">Challenge: ${challengeTitle}</h6>
                            <h6 style="color: #00ff00; margin-bottom: 20px;">Difficulty: ${difficulty}</h6>
                        </div>
                        <div class="mb-3">
                            <label for="flagInput" style="color: #00ff00; display: block; margin-bottom: 8px;">Enter Flag:</label>
                            <input type="text" class="form-control" id="flagInput" 
                                   placeholder="e.g., CYBERNEST{flag_here}" 
                                   style="background: rgba(0,0,0,0.8); border: 1px solid #00ff00; color: #00ff00;">
                            <small style="color: #888;">Enter the correct flag to complete this challenge</small>
                        </div>
                    </div>
                    <div class="modal-footer" style="border-top: 1px solid #00ff00;">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" 
                                style="background: transparent; border: 1px solid #6c757d; color: #6c757d;">Cancel</button>
                        <button type="button" class="btn btn-success" onclick="submitFlag(${challengeId})" 
                                style="background: #00ff00; border: 1px solid #00ff00; color: #000;">Submit Flag</button>
                    </div>
                </div>
            </div>
        </div>
    `;
    
    const existingModal = document.getElementById('flagModal');
    if (existingModal) {
        existingModal.remove();
    }
    
    document.body.insertAdjacentHTML('beforeend', modalHtml);
    
    const modal = new bootstrap.Modal(document.getElementById('flagModal'));
    modal.show();
    
    setTimeout(() => {
        document.getElementById('flagInput').focus();
    }, 500);
}
window.submitFlag = function(challengeId) {
    const flagInput = document.getElementById('flagInput');
    const flag = flagInput.value.trim();
    
    if (!flag) {
        Swal.fire({
            icon: 'warning',
            title: 'Flag Required',
            text: 'Please enter a flag to submit.',
            confirmButtonColor: '#00ff00',
            background: '#1a1a1a',
            color: '#00ff00',
            border: '1px solid #00ff00'
        });
        return;
    }
    
    fetch('/backend/api/challenges.php?action=submitFlag', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            challenge_id: challengeId,
            flag: flag
        })
    })
    .then(response => response.json())
    .then(data => {
        const modal = bootstrap.Modal.getInstance(document.getElementById('flagModal'));
        modal.hide();
        
        if (data.success) {
            if (data.already_completed) {
                Swal.fire({
                    icon: 'success',
                    title: 'Already Completed',
                    text: data.message,
                    confirmButtonColor: '#00ff00',
                    background: '#1a1a1a',
                    color: '#00ff00',
                    border: '1px solid #00ff00'
                });
            } else if (data.correct) {
                let message = '🎉 ' + data.message;
                if (data.points_earned) {
                    message += '\n\n🏆 Points earned: ' + data.points_earned;
                }
                Swal.fire({
                    icon: 'success',
                    title: 'Challenge Completed!',
                    html: message,
                    confirmButtonColor: '#00ff00',
                    background: '#1a1a1a',
                    color: '#00ff00',
                    border: '1px solid #00ff00'
                }).then(() => {
                    loadChallenges();
                    loadUserTotalPoints();
                    updateRealTimeAttempts();
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Incorrect Flag',
                    text: data.message,
                    confirmButtonColor: '#00ff00',
                    background: '#1a1a1a',
                    color: '#00ff00',
                    border: '1px solid #00ff00'
                }).then(() => {
                    updateRealTimeAttempts();
                });
            }
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Submission Error',
                text: data.message,
                confirmButtonColor: '#00ff00',
                background: '#1a1a1a',
                color: '#00ff00',
                border: '1px solid #00ff00'
            });
        }
    })
    .catch(error => {
        console.error('Error submitting flag:', error);
        Swal.fire({
            icon: 'error',
            title: 'Error Submitting Flag',
            text: 'An error occurred while submitting the flag. Please try again.',
            confirmButtonColor: '#00ff00',
            background: '#1a1a1a',
            color: '#00ff00',
            border: '1px solid #00ff00'
        });
    });
};
function showError(message) {
    const container = document.getElementById('challengesGrid');
    container.innerHTML = `
        <div class="text-center py-5">
            <i class="fas fa-exclamation-triangle fa-3x mb-3 text-danger"></i>
            <h4 class="text-danger">Error</h4>
            <p class="text-muted">${message}</p>
        </div>
    `;
}
let realTimeInterval;
let lastAttemptCounts = {};

function startRealTimeUpdates() {
    realTimeInterval = setInterval(updateRealTimeAttempts, 5000);
    
    document.addEventListener('visibilitychange', function() {
        if (!document.hidden) {
            updateRealTimeAttempts();
        }
    });
}

function updateRealTimeAttempts() {
    fetch('/backend/api/challenges.php?action=getRealTimeAttempts')
        .then(response => response.json())
        .then(data => {
            if (data.success && data.attempts) {
                data.attempts.forEach(attempt => {
                    const challengeId = attempt.challenge_id;
                    const newCount = attempt.attempt_count;
                    
                    if (lastAttemptCounts[challengeId] !== undefined && 
                        lastAttemptCounts[challengeId] < newCount) {
                        showAttemptUpdate(challengeId, newCount, attempt.completed);
                    }
                    
                    lastAttemptCounts[challengeId] = newCount;
                    
                    updateChallengeAttemptCount(challengeId, newCount, attempt.completed);
                });
            }
        })
        .catch(error => {
            console.error('Error updating real-time attempts:', error);
        });
}

function updateChallengeAttemptCount(challengeId, attemptCount, completed) {
    const challengeCard = document.querySelector(`[data-id="${challengeId}"]`);
    if (challengeCard) {
        const yourAttemptsElement = challengeCard.querySelector('.challenge-stats .stat-item:nth-child(3) .stat-value');
        if (yourAttemptsElement) {
            const oldCount = parseInt(yourAttemptsElement.textContent);
            yourAttemptsElement.textContent = attemptCount;
            
            yourAttemptsElement.style.transition = 'all 0.3s ease';
            yourAttemptsElement.style.transform = 'scale(1.2)';
            yourAttemptsElement.style.color = '#00ff00';
            
            setTimeout(() => {
                yourAttemptsElement.style.transform = 'scale(1)';
                yourAttemptsElement.style.color = '';
            }, 300);
        }
        
        if (completed) {
            const statusElement = challengeCard.querySelector('.challenge-status');
            if (statusElement) {
                statusElement.className = 'challenge-status status-completed';
                statusElement.innerHTML = '<i class="fas fa-check-circle"></i> Completed';
            }
            
            challengeCard.dataset.userCompleted = '1';
        }
    }
}

function showAttemptUpdate(challengeId, newCount, completed) {
    const challengeCard = document.querySelector(`[data-id="${challengeId}"]`);
    if (challengeCard) {
        const notification = document.createElement('div');
        notification.style.cssText = `
            position: absolute;
            top: 10px;
            right: 10px;
            background: rgba(0, 255, 0, 0.9);
            color: #000;
            padding: 8px 12px;
            border-radius: 6px;
            font-size: 0.8rem;
            font-weight: bold;
            z-index: 1000;
            animation: slideInRight 0.3s ease;
            box-shadow: 0 4px 12px rgba(0, 255, 0, 0.4);
        `;
        
        if (completed) {
            notification.innerHTML = `<i class="fas fa-check-circle"></i> Challenge Completed!`;
            notification.style.background = 'rgba(40, 167, 69, 0.9)';
        } else {
            notification.innerHTML = `<i class="fas fa-clock"></i> Attempt ${newCount}`;
        }
        
        challengeCard.style.position = 'relative';
        challengeCard.appendChild(notification);
        
        setTimeout(() => {
            notification.style.animation = 'slideOutRight 0.3s ease';
            setTimeout(() => {
                if (notification.parentNode) {
                    notification.parentNode.removeChild(notification);
                }
            }, 300);
        }, 3000);
    }
}

const style = document.createElement('style');
style.textContent = `
    @keyframes slideInRight {
        from {
            transform: translateX(100%);
            opacity: 0;
        }
        to {
            transform: translateX(0);
            opacity: 1;
        }
    }
    
    @keyframes slideOutRight {
        from {
            transform: translateX(0);
            opacity: 1;
        }
        to {
            transform: translateX(100%);
            opacity: 0;
        }
    }
`;
document.head.appendChild(style);

window.addEventListener('beforeunload', function() {
    if (realTimeInterval) {
        clearInterval(realTimeInterval);
    }
});
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

function openTerminalModal() {
    const terminalModal = document.getElementById('terminalModal');
    const modal = new bootstrap.Modal(terminalModal);
    modal.show();
}