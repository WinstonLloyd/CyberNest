document.addEventListener('DOMContentLoaded', function() {
    const toggleSidebar = document.getElementById('toggleSidebar');
    const sidebar = document.getElementById('sidebar');
    
    if (toggleSidebar) {
        toggleSidebar.addEventListener('click', function() {
            sidebar.classList.toggle('active');
        });
    }

    document.addEventListener('click', function(event) {
        if (window.innerWidth <= 768 && 
            !sidebar.contains(event.target) && 
            !toggleSidebar.contains(event.target) && 
            sidebar.classList.contains('active')) {
            sidebar.classList.remove('active');
        }
    });

    const navLinks = document.querySelectorAll('.nav-link');
    navLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            if (this.getAttribute('href').startsWith('#')) {
                e.preventDefault();
            }
            
            navLinks.forEach(l => l.classList.remove('active'));
            this.classList.add('active');
        });
    });

    const statCards = document.querySelectorAll('.stat-card');
    statCards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-5px) scale(1.02)';
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0) scale(1)';
        });
    });

    function handleResize() {
        if (window.innerWidth > 768 && sidebar.classList.contains('active')) {
            sidebar.classList.remove('active');
        }
    }
    
    window.addEventListener('resize', handleResize);

    if (typeof bootstrap !== 'undefined') {
        const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        const tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    }

    const actionButtons = document.querySelectorAll('.action-btn');
    actionButtons.forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            const action = this.textContent.toLowerCase();
            const userRow = this.closest('tr');
            const userName = userRow.querySelector('td div').textContent.trim();
            
            if (action === 'view') {
                alert(`Viewing user: ${userName}`);
            } else if (action === 'edit') {
                alert(`Editing user: ${userName}`);
            }
        });
    });

    const statusBadges = document.querySelectorAll('.status-badge');
    statusBadges.forEach(badge => {
        badge.addEventListener('click', function() {
            const currentStatus = this.classList.contains('status-online');
            const userName = this.closest('tr').querySelector('td div').textContent.trim();
            
            if (currentStatus) {
                this.classList.remove('status-online');
                this.classList.add('status-offline');
                this.textContent = 'Offline';
            } else {
                this.classList.remove('status-offline');
                this.classList.add('status-online');
                this.textContent = 'Online';
            }
        });
    });

    const clearHistoryBtn = document.getElementById('clearHistory');
    if (clearHistoryBtn) {
        clearHistoryBtn.addEventListener('click', function() {
            if (confirm('Are you sure you want to clear activity history?')) {
                const historyContainer = document.getElementById('history');
                if (historyContainer) {
                    historyContainer.innerHTML = '<div class="text-muted">No activity yet...</div>';
                }
                this.textContent = 'Cleared!';
                this.classList.add('btn-success');
                this.classList.remove('btn-outline-danger');
                
                setTimeout(() => {
                    this.textContent = 'Clear History';
                    this.classList.remove('btn-success');
                    this.classList.add('btn-outline-danger');
                }, 1500);
            }
        });
    }

    const dropdownToggles = document.querySelectorAll('[data-bs-toggle="dropdown"]');
    dropdownToggles.forEach(toggle => {
        toggle.addEventListener('click', function(e) {
            e.preventDefault();
            const dropdownMenu = this.nextElementSibling;
            const isOpen = dropdownMenu.style.display === 'block';
            
            document.querySelectorAll('.dropdown-menu').forEach(menu => {
                menu.style.display = 'none';
            });
            
            dropdownMenu.style.display = isOpen ? 'none' : 'block';
        });
    });

    document.addEventListener('click', function(e) {
        if (!e.target.matches('[data-bs-toggle="dropdown"]') && !e.target.closest('.dropdown-menu')) {
            document.querySelectorAll('.dropdown-menu').forEach(menu => {
                menu.style.display = 'none';
            });
        }
    });

    document.addEventListener('keydown', function(e) {
        if (e.ctrlKey && e.key === 'b') {
            e.preventDefault();
            if (toggleSidebar) {
                toggleSidebar.click();
            }
        }
        
        if (e.ctrlKey && e.key === 'r') {
            e.preventDefault();
        }
    });
});
