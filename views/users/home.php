<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CyberNest - Home</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../../css/admin/dashboard.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        body {
            background: linear-gradient(135deg, #0a0a0a 0%, #1a1a1a 100%);
            color: var(--light-text);
            font-family: 'Courier New', monospace;
            min-height: 100vh;
        }

        .hero-section {
            background: linear-gradient(135deg, rgba(0, 255, 0, 0.1) 0%, rgba(0, 255, 0, 0.05) 100%);
            border: 1px solid var(--primary-color);
            border-radius: 15px;
            padding: 60px 30px;
            margin: 30px 0;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .hero-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(45deg, transparent 30%, rgba(0, 255, 0, 0.05) 50%, transparent 70%);
            animation: hero-scan 4s linear infinite;
            pointer-events: none;
        }

        @keyframes hero-scan {
            0% { transform: translateX(-100%); }
            100% { transform: translateX(100%); }
        }

        .hero-title {
            font-size: 3.5rem;
            font-weight: bold;
            color: var(--primary-color);
            text-shadow: 0 0 20px rgba(0, 255, 0, 0.8);
            margin-bottom: 20px;
            animation: glow 2s ease-in-out infinite alternate;
        }

        @keyframes glow {
            from { text-shadow: 0 0 20px rgba(0, 255, 0, 0.8); }
            to { text-shadow: 0 0 30px rgba(0, 255, 0, 1), 0 0 40px rgba(0, 255, 0, 0.6); }
        }

        .hero-subtitle {
            font-size: 1.3rem;
            color: var(--muted-text);
            margin-bottom: 30px;
        }

        .hero-buttons {
            display: flex;
            gap: 20px;
            justify-content: center;
            flex-wrap: wrap;
        }

        .btn-hero {
            padding: 15px 40px;
            font-size: 1.1rem;
            font-weight: 600;
            border-radius: 8px;
            text-decoration: none;
            transition: all 0.3s ease;
            border: 2px solid var(--primary-color);
            position: relative;
            overflow: hidden;
        }

        .btn-hero-primary {
            background: var(--primary-color);
            color: var(--darker-bg);
        }

        .btn-hero-primary:hover {
            background: var(--secondary-color);
            transform: translateY(-3px);
            box-shadow: 0 10px 30px rgba(0, 255, 0, 0.5);
        }

        .btn-hero-secondary {
            background: transparent;
            color: var(--primary-color);
        }

        .btn-hero-secondary:hover {
            background: rgba(0, 255, 0, 0.2);
            transform: translateY(-3px);
            box-shadow: 0 10px 30px rgba(0, 255, 0, 0.3);
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 25px;
            margin: 30px 0;
            justify-content: center;
            text-align: center;
        }

        .stat-card {
            background: linear-gradient(135deg, rgba(0, 255, 0, 0.1) 0%, rgba(0, 255, 0, 0.05) 100%);
            border: 1px solid var(--primary-color);
            border-radius: 12px;
            padding: 30px 20px;
            text-align: center;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(45deg, transparent 30%, rgba(0, 255, 0, 0.05) 50%, transparent 70%);
            animation: card-scan 3s linear infinite;
            pointer-events: none;
        }

        @keyframes card-scan {
            0% { transform: translateX(-100%); }
            100% { transform: translateX(100%); }
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 40px rgba(0, 255, 0, 0.4);
            border-color: var(--secondary-color);
        }

        .stat-icon {
            font-size: 3rem;
            color: var(--primary-color);
            margin-bottom: 15px;
        }

        .stat-number {
            font-size: 2.5rem;
            font-weight: bold;
            color: var(--primary-color);
            text-shadow: 0 0 10px rgba(0, 255, 0, 0.5);
            margin-bottom: 10px;
        }

        .stat-label {
            color: var(--muted-text);
            font-size: 1rem;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .section-title {
            text-align: center;
            font-size: 2.5rem;
            color: var(--primary-color);
            text-shadow: 0 0 15px rgba(0, 255, 0, 0.5);
            margin-bottom: 50px;
        }

        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
            gap: 30px;
            margin: 50px 0;
            justify-content: center;
        }

        .feature-card {
            background: rgba(0, 0, 0, 0.8);
            border: 1px solid var(--primary-color);
            border-radius: 12px;
            padding: 30px;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            text-align: center;
        }

        .feature-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(45deg, transparent 30%, rgba(0, 255, 0, 0.05) 50%, transparent 70%);
            animation: feature-scan 3s linear infinite;
            pointer-events: none;
        }

        @keyframes feature-scan {
            0% { transform: translateX(-100%); }
            100% { transform: translateX(100%); }
        }

        .feature-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 40px rgba(0, 255, 0, 0.3);
            border-color: var(--secondary-color);
        }

        .feature-icon {
            font-size: 2.5rem;
            color: var(--primary-color);
            margin-bottom: 20px;
        }

        .feature-title {
            font-size: 1.5rem;
            color: var(--primary-color);
            margin-bottom: 15px;
        }

        .feature-description {
            color: var(--muted-text);
            line-height: 1.6;
            margin-bottom: 20px;
        }

        .feature-link {
            color: var(--primary-color);
            text-decoration: none;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s ease;
        }

        .feature-link:hover {
            color: var(--secondary-color);
            transform: translateX(5px);
        }

        .activity-list {
            background: rgba(0, 0, 0, 0.8);
            border: 1px solid var(--primary-color);
            border-radius: 12px;
            padding: 30px;
            margin: 30px 0;
        }

        .activity-item {
            display: flex;
            align-items: center;
            gap: 20px;
            padding: 20px 0;
            border-bottom: 1px solid rgba(0, 255, 0, 0.1);
            transition: all 0.3s ease;
        }

        .activity-item:last-child {
            border-bottom: none;
        }

        .activity-item:hover {
            background: rgba(0, 255, 0, 0.05);
            border-radius: 8px;
            padding-left: 15px;
        }

        .activity-icon {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background: rgba(0, 255, 0, 0.1);
            border: 1px solid var(--primary-color);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--primary-color);
            font-size: 1.2rem;
            flex-shrink: 0;
        }

        .activity-content {
            flex: 1;
        }

        .activity-title {
            color: var(--primary-color);
            font-weight: 600;
            margin-bottom: 5px;
        }

        .activity-description {
            color: var(--muted-text);
            font-size: 0.9rem;
        }

        .activity-time {
            color: var(--muted-text);
            font-size: 0.85rem;
            white-space: nowrap;
        }

        .leaderboard-card {
            background: rgba(0, 0, 0, 0.8);
            border: 1px solid var(--primary-color);
            border-radius: 12px;
            padding: 30px;
            margin: 30px 0;
        }

        .leaderboard-item {
            display: flex;
            align-items: center;
            gap: 15px;
            padding: 15px 0;
            border-bottom: 1px solid rgba(0, 255, 0, 0.1);
            transition: all 0.3s ease;
        }

        .leaderboard-item:last-child {
            border-bottom: none;
        }

        .leaderboard-item:hover {
            background: rgba(0, 255, 0, 0.05);
            border-radius: 8px;
            padding-left: 10px;
        }

        .rank-badge {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            font-size: 1.1rem;
            flex-shrink: 0;
        }

        .rank-1 {
            background: linear-gradient(135deg, #ffd700, #ffed4e);
            color: #000;
        }

        .rank-2 {
            background: linear-gradient(135deg, #c0c0c0, #e8e8e8);
            color: #000;
        }

        .rank-3 {
            background: linear-gradient(135deg, #cd7f32, #e6a157);
            color: #000;
        }

        .rank-other {
            background: rgba(0, 255, 0, 0.1);
            border: 1px solid var(--primary-color);
            color: var(--primary-color);
        }

        .leaderboard-info {
            flex: 1;
        }

        .leaderboard-name {
            color: var(--primary-color);
            font-weight: 600;
            margin-bottom: 3px;
        }

        .leaderboard-stats {
            color: var(--muted-text);
            font-size: 0.85rem;
        }

        .leaderboard-points {
            color: var(--primary-color);
            font-weight: bold;
            font-size: 1.1rem;
        }

        .navbar-custom {
            background: linear-gradient(135deg, #1a1a1a 0%, #2a2a2a 100%);
            border-bottom: 2px solid var(--primary-color);
            padding: 15px 0;
            box-shadow: 0 0 20px rgba(0, 255, 0, 0.2);
        }

        .navbar-brand {
            color: var(--primary-color) !important;
            font-size: 1.5rem;
            font-weight: bold;
            text-shadow: 0 0 10px rgba(0, 255, 0, 0.5);
        }

        .nav-link-custom {
            color: var(--light-text) !important;
            padding: 10px 20px;
            border-radius: 6px;
            transition: all 0.3s ease;
            border: 1px solid transparent;
        }

        .nav-link-custom:hover {
            background: rgba(0, 255, 0, 0.1);
            border-color: var(--primary-color);
            color: var(--primary-color) !important;
            transform: translateY(-2px);
        }

        .nav-link-custom.active {
            background: rgba(0, 255, 0, 0.2);
            border-color: var(--primary-color);
            color: var(--primary-color) !important;
        }

        .user-dropdown {
            position: relative;
        }

        .user-avatar-nav {
            width: 35px;
            height: 35px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--darker-bg);
            font-weight: bold;
            border: 2px solid var(--primary-color);
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .user-avatar-nav:hover {
            transform: scale(1.1);
            box-shadow: 0 0 15px rgba(0, 255, 0, 0.5);
        }

        @media (max-width: 768px) {
            .hero-title {
                font-size: 2.5rem;
            }
            
            .hero-subtitle {
                font-size: 1.1rem;
            }
            
            .hero-buttons {
                flex-direction: column;
                align-items: center;
            }
            
            .btn-hero {
                width: 100%;
                max-width: 300px;
            }
            
            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
            }
            
            .features-grid {
                grid-template-columns: 1fr;
            }
            
            .activity-item {
                flex-direction: column;
                text-align: center;
                gap: 15px;
            }
            
            .leaderboard-item {
                flex-direction: column;
                text-align: center;
                gap: 10px;
            }
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-custom">
        <div class="container">
            <a class="navbar-brand" href="home.html">
                <i class="fas fa-shield-alt me-2"></i>CYBERNEST
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon" style="filter: invert(1);"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link nav-link-custom active" href="home.html">
                            <i class="fas fa-home me-2"></i>Home
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link nav-link-custom" href="challenges.html">
                            <i class="fas fa-trophy me-2"></i>Challenges
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link nav-link-custom" href="leaderboard.html">
                            <i class="fas fa-chart-line me-2"></i>Leaderboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link nav-link-custom" href="profile.html">
                            <i class="fas fa-user me-2"></i>Profile
                        </a>
                    </li>
                </ul>
                <div class="navbar-nav">
                    <div class="nav-item dropdown user-dropdown">
                        <div class="user-avatar-nav" data-bs-toggle="dropdown">
                            JD
                        </div>
                        <ul class="dropdown-menu dropdown-menu-dark dropdown-menu-end">
                            <li><a class="dropdown-item" href="profile.html"><i class="fas fa-user me-2"></i>Profile</a></li>
                            <li><a class="dropdown-item" href="settings.html"><i class="fas fa-cog me-2"></i>Settings</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="#" onclick="logout()"><i class="fas fa-sign-out-alt me-2"></i>Logout</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="container">
        <div class="hero-section">
            <h1 class="hero-title">WELCOME TO CYBERNEST</h1>
            <p class="hero-subtitle">Master the art of cybersecurity through hands-on challenges</p>
            <div class="hero-buttons">
                <a href="challenges.html" class="btn-hero btn-hero-primary">
                    <i class="fas fa-play me-2"></i>Start Hacking
                </a>
                <a href="leaderboard.html" class="btn-hero btn-hero-secondary">
                    <i class="fas fa-chart-line me-2"></i>View Rankings
                </a>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="stats-section container">
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-trophy"></i>
                </div>
                <div class="stat-number">45</div>
                <div class="stat-label">Challenges</div>
            </div>
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-users"></i>
                </div>
                <div class="stat-number">1,247</div>
                <div class="stat-label">Hackers</div>
            </div>
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-flag-checkered"></i>
                </div>
                <div class="stat-number">892</div>
                <div class="stat-label">Completed</div>
            </div>
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-clock"></i>
                </div>
                <div class="stat-number">24/7</div>
                <div class="stat-label">Available</div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="features-section container">
        <h2 class="section-title">FEATURES</h2>
        <div class="features-grid">
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-shield-alt"></i>
                </div>
                <h3 class="feature-title">Real-World Scenarios</h3>
                <p class="feature-description">
                    Practice on realistic cybersecurity challenges that mirror actual threats and vulnerabilities found in the wild.
                </p>
                <a href="challenges.html" class="feature-link">
                    Explore Challenges <i class="fas fa-arrow-right"></i>
                </a>
            </div>
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-graduation-cap"></i>
                </div>
                <h3 class="feature-title">Learn & Progress</h3>
                <p class="feature-description">
                    Track your progress, earn points, and level up your skills as you complete increasingly difficult challenges.
                </p>
                <a href="profile.html" class="feature-link">
                    View Progress <i class="fas fa-arrow-right"></i>
                </a>
            </div>
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-users"></i>
                </div>
                <h3 class="feature-title">Compete & Rank</h3>
                <p class="feature-description">
                    Compete with other hackers worldwide, climb the leaderboard, and prove your cybersecurity expertise.
                </p>
                <a href="leaderboard.html" class="feature-link">
                    View Leaderboard <i class="fas fa-arrow-right"></i>
                </a>
            </div>
        </div>
    </section>

    <!-- Recent Activity -->
    <section class="recent-activity container">
        <h2 class="section-title">RECENT ACTIVITY</h2>
        <div class="activity-list">
            <div class="activity-item">
                <div class="activity-icon">
                    <i class="fas fa-trophy"></i>
                </div>
                <div class="activity-content">
                    <div class="activity-title">New Challenge Released</div>
                    <div class="activity-description">Advanced SQL Injection challenge is now available</div>
                </div>
                <div class="activity-time">2 hours ago</div>
            </div>
            <div class="activity-item">
                <div class="activity-icon">
                    <i class="fas fa-user"></i>
                </div>
                <div class="activity-content">
                    <div class="activity-title">New Top Hacker</div>
                    <div class="activity-description">Alice Smith reached #1 on the leaderboard</div>
                </div>
                <div class="activity-time">5 hours ago</div>
            </div>
            <div class="activity-item">
                <div class="activity-icon">
                    <i class="fas fa-flag-checkered"></i>
                </div>
                <div class="activity-content">
                    <div class="activity-title">Challenge Completed</div>
                    <div class="activity-description">John Doe completed Buffer Overflow Basics</div>
                </div>
                <div class="activity-time">8 hours ago</div>
            </div>
            <div class="activity-item">
                <div class="activity-icon">
                    <i class="fas fa-code"></i>
                </div>
                <div class="activity-content">
                    <div class="activity-title">System Update</div>
                    <div class="activity-description">New security patches applied to all challenges</div>
                </div>
                <div class="activity-time">1 day ago</div>
            </div>
        </div>
    </section>

    <!-- Leaderboard Preview -->
    <section class="leaderboard-preview container">
        <h2 class="section-title">TOP HACKERS</h2>
        <div class="leaderboard-card">
            <div class="leaderboard-item">
                <div class="rank-badge rank-1">1</div>
                <div class="leaderboard-info">
                    <div class="leaderboard-name">Alice Smith</div>
                    <div class="leaderboard-stats">45 challenges • 12 hours ago</div>
                </div>
                <div class="leaderboard-points">4,123 pts</div>
            </div>
            <div class="leaderboard-item">
                <div class="rank-badge rank-2">2</div>
                <div class="leaderboard-info">
                    <div class="leaderboard-name">Bob Johnson</div>
                    <div class="leaderboard-stats">42 challenges • 3 hours ago</div>
                </div>
                <div class="leaderboard-points">3,856 pts</div>
            </div>
            <div class="leaderboard-item">
                <div class="rank-badge rank-3">3</div>
                <div class="leaderboard-info">
                    <div class="leaderboard-name">Emma Martinez</div>
                    <div class="leaderboard-stats">40 challenges • 6 hours ago</div>
                </div>
                <div class="leaderboard-points">3,456 pts</div>
            </div>
            <div class="leaderboard-item">
                <div class="rank-badge rank-other">4</div>
                <div class="leaderboard-info">
                    <div class="leaderboard-name">Michael Wilson</div>
                    <div class="leaderboard-stats">38 challenges • 1 day ago</div>
                </div>
                <div class="leaderboard-points">2,987 pts</div>
            </div>
            <div class="leaderboard-item">
                <div class="rank-badge rank-other">5</div>
                <div class="leaderboard-info">
                    <div class="leaderboard-name">Sarah Anderson</div>
                    <div class="leaderboard-stats">35 challenges • 2 days ago</div>
                </div>
                <div class="leaderboard-points">2,567 pts</div>
            </div>
        </div>
        <div class="text-center mt-4">
            <a href="leaderboard.html" class="btn-hero btn-hero-secondary">
                <i class="fas fa-chart-line me-2"></i>View Full Leaderboard
            </a>
        </div>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Home page functionality
        document.addEventListener('DOMContentLoaded', function() {
            // Animate stats on scroll
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

            // Add smooth scroll behavior
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

            // Add parallax effect to hero section
            window.addEventListener('scroll', () => {
                const scrolled = window.pageYOffset;
                const heroSection = document.querySelector('.hero-section');
                if (heroSection) {
                    heroSection.style.transform = `translateY(${scrolled * 0.5}px)`;
                }
            });

            // Simulate real-time updates
            setInterval(() => {
                const activityTimes = document.querySelectorAll('.activity-time');
                activityTimes.forEach((time, index) => {
                    if (index === 0) {
                        time.textContent = 'Just now';
                    }
                });
            }, 60000); // Update every minute

            // Add hover effects to cards
            const cards = document.querySelectorAll('.stat-card, .feature-card, .leaderboard-item, .activity-item');
            cards.forEach(card => {
                card.addEventListener('mouseenter', function() {
                    this.style.transform = 'translateY(-5px) scale(1.02)';
                });
                
                card.addEventListener('mouseleave', function() {
                    this.style.transform = 'translateY(0) scale(1)';
                });
            });

            // Initialize tooltips
            const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            const tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });
        });

        // Logout function
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
                                border: '1px solid #00ff00'
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
                        // Still redirect on error
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
    </script>
</body>
</html>