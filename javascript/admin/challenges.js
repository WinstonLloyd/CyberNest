document.addEventListener('DOMContentLoaded', function() {
    loadChallenges();
    loadChallengeStats();
    
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    const tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
    
    const addChallengeModal = document.getElementById('addChallengeModal');
    addChallengeModal.addEventListener('hidden.bs.modal', function () {
        const form = document.getElementById('addChallengeForm');
        delete form.dataset.editingId;
        form.reset();
        document.querySelector('#addChallengeModal .modal-title').textContent = 'Add New Challenge';
    });
});
let allChallenges = [];
function loadChallenges(filters = {}) {
    console.log('Loading challenges with filters:', filters);
    
    const params = new URLSearchParams();
    
    if (filters.category && filters.category !== 'all') {
        params.append('category', filters.category);
        console.log('Adding category filter:', filters.category);
    }
    
    if (filters.difficulty && filters.difficulty !== 'all') {
        params.append('difficulty', filters.difficulty);
        console.log('Adding difficulty filter:', filters.difficulty);
    }
    
    if (filters.status && filters.status !== 'all') {
        params.append('status', filters.status);
        console.log('Adding status filter:', filters.status);
    }
    
    if (filters.search) {
        params.append('search', filters.search);
        console.log('Adding search filter:', filters.search);
    }
    
    const url = '/backend/api/challenges.php?action=getAll' + (params.toString() ? '&' + params.toString() : '');
    console.log('API URL:', url);
    
    fetch(url)
        .then(response => response.json())
        .then(data => {
            console.log('API Response:', data);
            if (data.success) {
                allChallenges = data.challenges;
                displayChallenges(data.challenges);
            } else {
                console.error('Failed to load challenges:', data.message);
            }
        })
        .catch(error => {
            console.error('Error loading challenges:', error);
        });
}
function loadChallengeStats() {
    fetch('/backend/api/challenges.php?action=stats')
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                updateStatsDisplay(data.stats);
            }
        })
        .catch(error => {
            console.error('Error loading stats:', error);
        });
}
function displayChallenges(challenges) {
    const container = document.querySelector('.challenges-grid');
    
    if (challenges.length === 0) {
        container.innerHTML = `
            <div class="col-12 text-center py-5">
                <i class="fas fa-trophy fa-3x mb-3 text-muted"></i>
                <h4 class="text-muted">No challenges found</h4>
                <p class="text-muted">Try adjusting your filters or create a new challenge.</p>
            </div>
        `;
        return;
    }
    
    container.innerHTML = challenges.map(challenge => createChallengeCard(challenge)).join('');
}
function createChallengeCard(challenge) {
    const difficultyClass = `difficulty-${challenge.difficulty}`;
    const statusBadge = getStatusBadge(challenge.status);
    const tags = challenge.tags ? challenge.tags.split(',').map(tag => `<span class="tag">${tag.trim()}</span>`).join('') : '';
    
    return `
        <div class="challenge-card">
            <div class="d-flex justify-content-between align-items-start mb-3">
                <div>
                    <h5 class="text-success mb-2">${challenge.title}</h5>
                    <span class="difficulty-badge ${difficultyClass}">${challenge.difficulty}</span>
                </div>
                <div class="text-end">
                    ${statusBadge}
                </div>
            </div>
            
            <div class="challenge-stats">
                <div class="stat-item">
                    <i class="fas fa-users stat-icon"></i>
                    <span class="stat-value">${challenge.attempts || 0} attempts</span>
                </div>
                <div class="stat-item">
                    <i class="fas fa-check-circle stat-icon"></i>
                    <span class="stat-value">${challenge.solved_count || 0} solved</span>
                </div>
                <div class="stat-item">
                    <i class="fas fa-trophy stat-icon"></i>
                    <span class="stat-value">${challenge.points} points</span>
                </div>
            </div>
            
            <div class="challenge-description">
                ${challenge.description}
            </div>
            
            <div class="challenge-tags">
                ${tags}
            </div>
            
            <div class="action-buttons">
                <a href="#" class="btn-action" onclick="viewChallenge(${challenge.id})">
                    <i class="fas fa-eye me-2"></i>View
                </a>
                <a href="#" class="btn-action" onclick="editChallenge(${challenge.id})">
                    <i class="fas fa-edit me-2"></i>Edit
                </a>
                ${getAdditionalActions(challenge)}
                <a href="#" class="btn-action danger" onclick="deleteChallenge(${challenge.id})">
                    <i class="fas fa-trash me-2"></i>Delete
                </a>
            </div>
        </div>
    `;
}
function getStatusBadge(status) {
    const badges = {
        'active': '<div class="badge bg-success">Active</div>',
        'inactive': '<div class="badge bg-danger">Inactive</div>',
        'draft': '<div class="badge bg-warning">Draft</div>'
    };
    return badges[status] || '<div class="badge bg-secondary">Unknown</div>';
}
function getAdditionalActions(challenge) {
    if (challenge.status === 'draft') {
        return `<a href="#" class="btn-action" onclick="publishChallenge(${challenge.id})">
            <i class="fas fa-rocket me-2"></i>Publish
        </a>`;
    } else if (challenge.status === 'inactive') {
        return `<a href="#" class="btn-action" onclick="activateChallenge(${challenge.id})">
            <i class="fas fa-power-off me-2"></i>Activate
        </a>`;
    }
    return '';
}
function updateStatsDisplay(stats) {
    const totalChallenges = stats.total_challenges || 0;
    const byDifficulty = stats.by_difficulty || [];
    
    document.querySelector('.stats-grid').innerHTML = `
        <div class="stat-card">
            <div class="stat-number">${totalChallenges}</div>
            <div class="stat-label">Total Challenges</div>
        </div>
        <div class="stat-card">
            <div class="stat-number">${byDifficulty.find(d => d.difficulty === 'beginner')?.count || 0}</div>
            <div class="stat-label">Beginner</div>
        </div>
        <div class="stat-card">
            <div class="stat-number">${byDifficulty.find(d => d.difficulty === 'intermediate')?.count || 0}</div>
            <div class="stat-label">Intermediate</div>
        </div>
        <div class="stat-card">
            <div class="stat-number">${byDifficulty.find(d => d.difficulty === 'expert')?.count || 0}</div>
            <div class="stat-label">Expert</div>
        </div>
    `;
}
window.refreshChallenges = function() {
    const refreshBtn = event.target;
    refreshBtn.innerHTML = '<i class="fas fa-sync-alt fa-spin me-2"></i>Refreshing...';
    refreshBtn.disabled = true;
    
    loadChallenges();
    loadChallengeStats();
    
    setTimeout(() => {
        refreshBtn.innerHTML = '<i class="fas fa-sync-alt me-2"></i>Refresh';
        refreshBtn.disabled = false;
    }, 1000);
};
document.getElementById('searchInput').addEventListener('input', function() {
    const searchTerm = this.value;
    const filters = {
        search: searchTerm,
        category: document.getElementById('categoryFilter').value,
        difficulty: document.getElementById('difficultyFilter').value,
        status: document.getElementById('statusFilter').value
    };
    loadChallenges(filters);
});
document.getElementById('categoryFilter').addEventListener('change', function() {
    const filters = {
        search: document.getElementById('searchInput').value,
        category: this.value,
        difficulty: document.getElementById('difficultyFilter').value,
        status: document.getElementById('statusFilter').value
    };
    loadChallenges(filters);
});
document.getElementById('difficultyFilter').addEventListener('change', function() {
    const filters = {
        search: document.getElementById('searchInput').value,
        category: document.getElementById('categoryFilter').value,
        difficulty: this.value,
        status: document.getElementById('statusFilter').value
    };
    loadChallenges(filters);
});
document.getElementById('statusFilter').addEventListener('change', function() {
    const filters = {
        search: document.getElementById('searchInput').value,
        category: document.getElementById('categoryFilter').value,
        difficulty: document.getElementById('difficultyFilter').value,
        status: this.value
    };
    loadChallenges(filters);
});
window.viewChallenge = function(challengeId) {
    fetch(`/backend/api/challenges.php?action=getById&id=${challengeId}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const challenge = data.challenge;
                
                let fileDisplay = '';
                if (challenge.file_path && challenge.original_filename) {
                    const fileExtension = challenge.original_filename.split('.').pop().toLowerCase();
                    const imageExtensions = ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'webp', 'svg'];
                    
                    if (imageExtensions.includes(fileExtension)) {
                        fileDisplay = `
                            <div style="margin-bottom: 20px;">
                                <p><strong>Challenge File:</strong></p>
                                <img src="/${challenge.file_path}" alt="${challenge.original_filename}" 
                                     style="max-width: 100%; max-height: 300px; border: 1px solid #28a745; border-radius: 8px;" />
                                <p><small class="text-muted">Filename: ${challenge.original_filename}</small></p>
                            </div>
                        `;
                    } else {
                        fileDisplay = `
                            <div style="margin-bottom: 20px;">
                                <p><strong>Challenge File:</strong></p>
                                <div style="border: 1px solid #28a745; border-radius: 8px; padding: 15px; background: rgba(40, 167, 69, 0.1);">
                                    <div style="display: flex; align-items: center; gap: 10px;">
                                        <i class="fas fa-file fa-2x text-success"></i>
                                        <div>
                                            <p style="margin: 0;"><strong>${challenge.original_filename}</strong></p>
                                            <a href="/${challenge.file_path}" download="${challenge.original_filename}" 
                                               class="btn btn-success btn-sm" style="margin-top: 5px;">
                                                <i class="fas fa-download me-2"></i>Download File
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        `;
                    }
                }
                
                Swal.fire({
                    title: challenge.title,
                    html: `
                        <div style="text-align: left;">
                            ${fileDisplay}
                            <p><strong>Description:</strong><br>${challenge.description}</p>
                            <p><strong>Difficulty:</strong> ${challenge.difficulty}</p>
                            <p><strong>Points:</strong> ${challenge.points}</p>
                            <p><strong>Category:</strong> ${challenge.category}</p>
                            <p><strong>Status:</strong> ${challenge.status}</p>
                            <p><strong>Flag:</strong> <code>${challenge.flag || 'Not set'}</code></p>
                        </div>
                    `,
                    icon: 'info',
                    confirmButtonColor: '#28a745',
                    background: '#1a1a1a',
                    color: '#00ff00',
                    confirmButtonText: 'Close',
                    width: fileDisplay ? '800px' : '600px'
                });
            }
        })
        .catch(error => {
            console.error('Error fetching challenge:', error);
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Failed to fetch challenge details',
                background: '#1a1a1a',
                color: '#00ff00',
                confirmButtonColor: '#dc3545'
            });
        });
};
window.editChallenge = function(challengeId) {
    fetch(`/backend/api/challenges.php?action=getById&id=${challengeId}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const challenge = data.challenge;
                const form = document.getElementById('addChallengeForm');
                
                document.getElementById('challengeName').value = challenge.title;
                document.getElementById('challengeDifficulty').value = challenge.difficulty;
                document.getElementById('challengeDescription').value = challenge.description;
                document.getElementById('challengePoints').value = challenge.points;
                document.getElementById('challengeCategory').value = challenge.category;
                document.getElementById('challengeStatus').value = challenge.status;
                document.getElementById('challengeFlag').value = challenge.flag || '';
                document.getElementById('challengeTags').value = challenge.tags || '';
                
                form.dataset.editingId = challengeId;
                
                document.querySelector('#addChallengeModal .modal-title').textContent = 'Edit Challenge';
                
                const modal = new bootstrap.Modal(document.getElementById('addChallengeModal'));
                modal.show();
            }
        })
        .catch(error => {
            console.error('Error fetching challenge:', error);
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Failed to fetch challenge details for editing',
                background: '#1a1a1a',
                color: '#00ff00',
                confirmButtonColor: '#dc3545'
            });
        });
};
window.deleteChallenge = function(challengeId) {
    Swal.fire({
        title: 'Delete Challenge?',
        text: 'Are you sure you want to delete this challenge? This action cannot be undone.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc3545',
        background: '#1a1a1a',
        color: '#00ff00',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Delete',
        cancelButtonText: 'Cancel'
    }).then((result) => {
        if (result.isConfirmed) {
            fetch(`/backend/api/challenges.php?action=delete&id=${challengeId}`, {
                method: 'DELETE'
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Deleted!',
                        text: 'Challenge deleted successfully!',
                        confirmButtonColor: '#28a745',
                        background: '#1a1a1a',
                        color: '#00ff00'
                    });
                    loadChallenges();
                    loadChallengeStats();
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Delete Failed',
                        text: 'Failed to delete challenge: ' + data.message,
                        background: '#1a1a1a',
                        color: '#00ff00',
                        confirmButtonColor: '#dc3545'
                    });
                }
            })
            .catch(error => {
                console.error('Error deleting challenge:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Failed to delete challenge. Please try again.',
                    background: '#1a1a1a',
                    color: '#00ff00',
                    confirmButtonColor: '#dc3545'
                });
            });
        }
    });
};
window.publishChallenge = function(challengeId) {
    Swal.fire({
        title: 'Publish Challenge?',
        text: 'Are you sure you want to publish this challenge?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc3545',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Publish',
        background: '#1a1a1a',
        color: '#00ff00',
        cancelButtonText: 'Cancel'
    }).then((result) => {
        if (result.isConfirmed) {
            fetch(`/backend/api/challenges.php?action=getById&id=${challengeId}`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const challenge = data.challenge;
                        challenge.status = 'active';
                        
                        return fetch('/backend/api/challenges.php?action=update', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json'
                            },
                            body: JSON.stringify(challenge)
                        });
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Published!',
                            text: 'Challenge published successfully!',
                            background: '#1a1a1a',
                            color: '#00ff00',
                            confirmButtonColor: '#28a745'
                        });
                        loadChallenges();
                        loadChallengeStats();
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Publish Failed',
                            text: 'Failed to publish challenge: ' + data.message,
                            background: '#1a1a1a',
                    color: '#00ff00',
                            confirmButtonColor: '#dc3545'
                        });
                    }
                })
                .catch(error => {
                    console.error('Error publishing challenge:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Failed to publish challenge. Please try again.',
                        background: '#1a1a1a',
                        color: '#00ff00',
                        confirmButtonColor: '#dc3545'
                    });
                });
        }
    });
};
window.activateChallenge = function(challengeId) {
    Swal.fire({
        title: 'Activate Challenge?',
        text: 'Are you sure you want to activate this challenge?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc3545',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Activate',
        background: '#1a1a1a',
        color: '#00ff00',
        cancelButtonText: 'Cancel'
    }).then((result) => {
        if (result.isConfirmed) {
            fetch(`/backend/api/challenges.php?action=getById&id=${challengeId}`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const challenge = data.challenge;
                        challenge.status = 'active';
                        
                        return fetch('/backend/api/challenges.php?action=update', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json'
                            },
                            body: JSON.stringify(challenge)
                        });
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Activated!',
                            text: 'Challenge activated successfully!',
                            background: '#1a1a1a',
                            color: '#00ff00',
                            confirmButtonColor: '#28a745'
                        });
                        loadChallenges();
                        loadChallengeStats();
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Activate Failed',
                            text: 'Failed to activate challenge: ' + data.message,
                            background: '#1a1a1a',
                            color: '#00ff00',
                            confirmButtonColor: '#dc3545'
                        });
                    }
                })
                .catch(error => {
                    console.error('Error activating challenge:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Failed to activate challenge. Please try again.',
                        background: '#1a1a1a',
                        color: '#00ff00',
                        confirmButtonColor: '#dc3545'
                    });
                });
        }
    });
};
window.saveChallenge = function() {
    const form = document.getElementById('addChallengeForm');
    if (!form.checkValidity()) {
        form.reportValidity();
        return;
    }
    
    const fileInput = document.getElementById('challengeFile');
    const file = fileInput.files[0];
    
    const challengeData = {
        title: document.getElementById('challengeName').value,
        difficulty: document.getElementById('challengeDifficulty').value,
        description: document.getElementById('challengeDescription').value,
        points: parseInt(document.getElementById('challengePoints').value),
        category: document.getElementById('challengeCategory').value,
        status: document.getElementById('challengeStatus').value,
        flag: document.getElementById('challengeFlag').value,
        tags: document.getElementById('challengeTags').value
    };
    
    const isEditing = form.dataset.editingId;
    
    if (isEditing) {
        challengeData.id = parseInt(isEditing);
        
        if (file) {
            const formData = new FormData();
            formData.append('challengeData', JSON.stringify(challengeData));
            formData.append('file', file);
            
            fetch('/backend/api/challenges.php?action=update', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const modal = bootstrap.Modal.getInstance(document.getElementById('addChallengeModal'));
                    modal.hide();
                    form.reset();
                    delete form.dataset.editingId;
                    
                    document.querySelector('#addChallengeModal .modal-title').textContent = 'Add New Challenge';
                    
                    Swal.fire({
                        icon: 'success',
                        title: 'Updated!',
                        text: 'Challenge updated successfully!',
                        background: '#1a1a1a',
                        color: '#00ff00',
                        confirmButtonColor: '#28a745'
                    });
                    loadChallenges();
                    loadChallengeStats();
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Update Failed',
                        text: 'Failed to update challenge: ' + data.message,
                        background: '#1a1a1a',
                        color: '#00ff00',
                        confirmButtonColor: '#dc3545'
                    });
                }
            })
            .catch(error => {
                console.error('Error updating challenge:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Failed to update challenge. Please try again.',
                    background: '#1a1a1a',
                    color: '#00ff00',
                    confirmButtonColor: '#dc3545'
                });
            });
        } else {
            fetch('/backend/api/challenges.php?action=update', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(challengeData)
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const modal = bootstrap.Modal.getInstance(document.getElementById('addChallengeModal'));
                    modal.hide();
                    form.reset();
                    delete form.dataset.editingId;
                    
                    document.querySelector('#addChallengeModal .modal-title').textContent = 'Add New Challenge';
                    
                    Swal.fire({
                        icon: 'success',
                        title: 'Updated!',
                        text: 'Challenge updated successfully!',
                        background: '#1a1a1a',
                        color: '#00ff00',
                        confirmButtonColor: '#28a745'
                    });
                    loadChallenges();
                    loadChallengeStats();
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Update Failed',
                        text: 'Failed to update challenge: ' + data.message,
                        background: '#1a1a1a',
                        color: '#00ff00',
                        confirmButtonColor: '#dc3545'
                    });
                }
            })
            .catch(error => {
                console.error('Error updating challenge:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Failed to update challenge. Please try again.',
                    background: '#1a1a1a',
                    color: '#00ff00',
                    confirmButtonColor: '#dc3545'
                });
            });
        }
    } else {
        const formData = new FormData();
        formData.append('challengeData', JSON.stringify(challengeData));
        if (file) {
            formData.append('file', file);
        }
        
        fetch('/backend/api/challenges.php?action=create', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const modal = bootstrap.Modal.getInstance(document.getElementById('addChallengeModal'));
                modal.hide();
                form.reset();
                Swal.fire({
                    icon: 'success',
                    title: 'Saved!',
                    text: 'Challenge saved successfully!',
                    background: '#1a1a1a',
                    color: '#00ff00',
                    confirmButtonColor: '#28a745'
                });
                loadChallenges();
                loadChallengeStats();
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Save Failed',
                    text: 'Failed to save challenge: ' + data.message,
                    background: '#1a1a1a',
                    color: '#00ff00',
                    confirmButtonColor: '#dc3545'
                });
            }
        })
        .catch(error => {
            console.error('Error saving challenge:', error);
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Failed to save challenge. Please try again.',
                background: '#1a1a1a',
                color: '#00ff00',
                confirmButtonColor: '#dc3545'
            });
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