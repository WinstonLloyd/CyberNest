// Initialize Charts
const commandCtx = document.getElementById('commandChart').getContext('2d');
const userActivityCtx = document.getElementById('userActivityChart').getContext('2d');

// Command Usage Chart
new Chart(commandCtx, {
    type: 'line',
    data: {
        labels: ['00:00', '04:00', '08:00', '12:00', '16:00', '20:00'],
        datasets: [{
            label: 'Commands Executed',
            data: [1200, 1900, 3000, 2500, 2800, 3200],
            borderColor: 'rgb(0, 255, 0)',
            backgroundColor: 'rgba(0, 255, 0, 0.1)',
            tension: 0.4
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: {
                labels: {
                    color: '#0f0'
                }
            }
        },
        scales: {
            x: {
                grid: {
                    color: 'rgba(0, 255, 0, 0.1)'
                },
                ticks: {
                    color: '#0f0'
                }
            },
            y: {
                grid: {
                    color: 'rgba(0, 255, 0, 0.1)'
                },
                ticks: {
                    color: '#0f0'
                }
            }
        }
    }
});

// User Activity Chart
new Chart(userActivityCtx, {
    type: 'bar',
    data: {
        labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
        datasets: [{
            label: 'Active Users',
            data: [145, 189, 234, 267, 298, 312, 289],
            backgroundColor: 'rgba(0, 255, 0, 0.6)',
            borderColor: 'rgb(0, 255, 0)',
            borderWidth: 1
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: {
                labels: {
                    color: '#0f0'
                }
            }
        },
        scales: {
            x: {
                grid: {
                    color: 'rgba(0, 255, 0, 0.1)'
                },
                ticks: {
                    color: '#0f0'
                }
            },
            y: {
                grid: {
                    color: 'rgba(0, 255, 0, 0.1)'
                },
                ticks: {
                    color: '#0f0'
                }
            }
        }
    }
});

// Simulate real-time updates
setInterval(() => {
    // Update random stats
    const totalUsers = document.getElementById('totalUsers');
    const currentUsers = 1200 + Math.floor(Math.random() * 50);
    totalUsers.textContent = currentUsers.toLocaleString();

    // Update security alerts randomly
    const alerts = document.getElementById('securityAlerts');
    if (Math.random() > 0.95) {
        alerts.textContent = parseInt(alerts.textContent) + 1;
        alerts.classList.add('text-red-600');
        setTimeout(() => {
            alerts.classList.remove('text-red-600');
        }, 2000);
    }
}, 5000);

// Add keyboard shortcuts
document.addEventListener('keydown', (e) => {
    if (e.ctrlKey && e.key === 'r') {
        location.reload();
    }
});
