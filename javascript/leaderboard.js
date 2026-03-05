// Filter functionality
function filterLeaderboard(period) {
    // Remove active class from all buttons
    document.querySelectorAll('.filter-btn').forEach(btn => {
        btn.classList.remove('active');
    });
    
    // Add active class to clicked button
    event.target.classList.add('active');
    
    // Here you would typically make an API call to filter data
    console.log('Filtering by:', period);
    
    // Simulate data refresh
    updateLeaderboardData(period);
}

// Search functionality
function searchPlayers(query) {
    const rows = document.querySelectorAll('tbody tr');
    rows.forEach(row => {
        const playerName = row.querySelector('.text-sm.font-medium.text-white')?.textContent.toLowerCase();
        if (playerName && playerName.includes(query.toLowerCase())) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
}

// Pagination
function changePage(page) {
    console.log('Changing to page:', page);
    // Here you would typically make an API call to get page data
}

// Simulate real-time updates
function updateLeaderboardData(period) {
    // Simulate score updates
    const scores = document.querySelectorAll('.text-lg.font-bold');
    scores.forEach(score => {
        if (Math.random() > 0.8) {
            const currentValue = parseInt(score.textContent.replace(',', ''));
            const change = Math.floor(Math.random() * 100) - 50;
            const newValue = Math.max(0, currentValue + change);
            score.textContent = newValue.toLocaleString();
            
            // Add animation for score change
            score.classList.add('score-animation');
            setTimeout(() => {
                score.classList.remove('score-animation');
            }, 2000);
        }
    });
}

// Update scores periodically
setInterval(() => {
    updateLeaderboardData('all');
}, 10000);

// Add keyboard shortcuts
document.addEventListener('keydown', (e) => {
    if (e.ctrlKey && e.key === 'r') {
        location.reload();
    }
    if (e.key === '/' && e.ctrlKey) {
        e.preventDefault();
        document.querySelector('.search-box').focus();
    }
});
