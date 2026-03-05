// Filter functionality
function filterChallenges(category) {
    // Remove active class from all category chips
    document.querySelectorAll('.filter-chips:first-child .chip').forEach(chip => {
        chip.classList.remove('active');
    });
    
    // Add active class to clicked chip
    event.target.classList.add('active');
    
    // Filter challenge cards
    const cards = document.querySelectorAll('.challenge-card');
    cards.forEach(card => {
        if (category === 'all' || card.dataset.category === category) {
            card.style.display = 'block';
        } else {
            card.style.display = 'none';
        }
    });
    
    console.log('Filtering by category:', category);
}

function filterDifficulty(difficulty) {
    // Remove active class from all difficulty chips
    document.querySelectorAll('.filter-chips:last-child .chip').forEach(chip => {
        chip.classList.remove('active');
    });
    
    // Add active class to clicked chip
    event.target.classList.add('active');
    
    // Filter challenge cards
    const cards = document.querySelectorAll('.challenge-card');
    cards.forEach(card => {
        if (difficulty === 'all' || card.dataset.difficulty === difficulty) {
            card.style.display = 'block';
        } else {
            card.style.display = 'none';
        }
    });
    
    console.log('Filtering by difficulty:', difficulty);
}

// Start challenge
function startChallenge(challengeId) {
    console.log('Starting challenge:', challengeId);
    
    // Store the original button content and state
    const startBtn = event.target;
    const originalContent = startBtn.innerHTML;
    const originalDisabled = startBtn.disabled;
    
    // Immediately change button to "In Progress"
    startBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>In Progress...';
    startBtn.disabled = true;
    
    // Use SweetAlert2 for confirmation
    Swal.fire({
        title: `Start ${challengeId.replace('-', ' ')} Challenge?`,
        text: 'Are you ready to begin this hacking challenge?',
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#10b981',
        cancelButtonColor: '#6b7280',
        confirmButtonText: 'Start Challenge',
        cancelButtonText: 'Cancel',
        background: '#1f2937',
        color: '#fff',
        backdrop: 'rgba(0, 0, 0, 0.8)',
        customClass: {
            popup: 'cyber-border',
            title: 'hacker-font text-green-400',
            content: 'text-gray-300'
        }
    }).then((result) => {
        if (result.isConfirmed) {
            // Show flag input section - use proper ID mapping
            const flagSectionId = {
                'sql-injection': 'flag-section-sql',
                'rsa-cracking': 'flag-section-rsa',
                'buffer-overflow': 'flag-section-buffer',
                'network-analysis': 'flag-section-network',
                'reverse-engineering': 'flag-section-reverse',
                'steganography': 'flag-section-stego'
            };
            
            const flagSection = document.getElementById(flagSectionId[challengeId]);
            if (flagSection) {
                flagSection.style.display = 'block';
                // Focus on the input field
                const flagInput = flagSection.querySelector('.flag-input');
                if (flagInput) {
                    flagInput.focus();
                }
            } else {
                console.error('Flag section not found for:', challengeId, 'ID:', flagSectionId[challengeId]);
            }
            
            // Show success message
            Swal.fire({
                title: 'Challenge Started!',
                text: `Good luck, hacker! Complete the ${challengeId.replace('-', ' ')} challenge.`,
                icon: 'success',
                confirmButtonColor: '#10b981',
                background: '#1f2937',
                color: '#fff',
                backdrop: 'rgba(0, 0, 0, 0.8)',
                customClass: {
                    popup: 'cyber-border',
                    title: 'hacker-font text-green-400',
                    content: 'text-gray-300'
                }
            });
            
            // Simulate completion after delay
            setTimeout(() => {
                startBtn.innerHTML = '<i class="fas fa-check mr-2"></i>Completed';
                startBtn.classList.remove('filter-btn');
                startBtn.classList.add('bg-green-600');
            }, 3000);
        } else {
            // User cancelled - restore original button state
            startBtn.innerHTML = originalContent;
            startBtn.disabled = originalDisabled;
        }
    });
}

// Submit flag
function submitFlag(challengeId) {
    const flagInput = document.getElementById(`flag-${challengeId}`);
    const resultDiv = document.getElementById(`flag-result-${challengeId}`);
    const submitBtn = event.target;
    
    if (!flagInput.value.trim()) {
        resultDiv.innerHTML = '<div class="flag-error">Please enter a flag!</div>';
        return;
    }
    
    // Disable submit button
    submitBtn.disabled = true;
    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Checking...';
    
    // Simulate flag validation
    setTimeout(() => {
        const flag = flagInput.value.trim().toLowerCase();
        const correctFlags = {
            'sql-injection': 'flag{sql_injection_mastered}',
            'rsa-cracking': 'flag{rsa_weak_keys_found}',
            'buffer-overflow': 'flag{shell_access_obtained}',
            'network-analysis': 'flag{hidden_communications}',
            'reverse-engineering': 'flag{binary_reversed}',
            'steganography': 'flag{secret_message_extracted}'
        };
        
        if (correctFlags[challengeId] && flag === correctFlags[challengeId]) {
            resultDiv.innerHTML = '<div class="flag-success"><i class="fas fa-check-circle mr-2"></i>Correct! Flag submitted successfully!</div>';
            submitBtn.innerHTML = '<i class="fas fa-check mr-2"></i>Submitted';
            submitBtn.classList.add('bg-green-600');
            
            // Update progress to 100%
            const progressFill = submitBtn.closest('.challenge-card').querySelector('.progress-fill');
            if (progressFill) {
                progressFill.style.width = '100%';
                const progressText = submitBtn.closest('.challenge-card').querySelector('.text-xs.text-gray-400');
                if (progressText) {
                    progressText.textContent = 'Progress: 100% Complete';
                }
            }
        } else {
            resultDiv.innerHTML = '<div class="flag-error"><i class="fas fa-times mr-2"></i>Incorrect flag. Try again!</div>';
            submitBtn.innerHTML = '<i class="fas fa-flag mr-2"></i>Submit';
            submitBtn.classList.remove('bg-green-600');
        }
        
        // Re-enable submit button
        setTimeout(() => {
            submitBtn.disabled = false;
            if (!resultDiv.classList.contains('flag-success')) {
                submitBtn.innerHTML = '<i class="fas fa-flag mr-2"></i>Submit';
            }
        }, 1000);
    }, 1500);
}

// Add keyboard shortcuts
document.addEventListener('keydown', (e) => {
    if (e.ctrlKey && e.key === 'r') {
        location.reload();
    }
    if (e.key === '/' && e.ctrlKey) {
        e.preventDefault();
        // Focus on first challenge
        document.querySelector('.challenge-card').focus();
    }
});

// Simulate real-time updates
setInterval(() => {
    // Update participant counts randomly
    const counts = document.querySelectorAll('.participants-count');
    counts.forEach(count => {
        const current = parseInt(count.textContent.trim());
        const change = Math.floor(Math.random() * 10) - 5;
        const newValue = Math.max(1, current + change);
        count.innerHTML = `<i class="fas fa-users mr-1"></i>${newValue}`;
    });
}, 15000);