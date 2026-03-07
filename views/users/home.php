<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CyberNest - Home</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../../css/admin/dashboard.css">
    <link rel="stylesheet" href="../../css/users/home.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
                        <a class="nav-link nav-link-custom active" href="home.php">
                            <i class="fas fa-home me-2"></i>Home
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link nav-link-custom" href="challenges.php">
                            <i class="fas fa-trophy me-2"></i>Challenges
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link nav-link-custom" href="leaderboard.php">
                            <i class="fas fa-chart-line me-2"></i>Leaderboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link nav-link-custom" href="profile.php">
                            <i class="fas fa-user me-2"></i>Profile
                        </a>
                    </li>
                </ul>
                <div class="navbar-nav">
                    <div class="nav-item dropdown user-dropdown">
                        <div class="user-avatar-nav" data-bs-toggle="dropdown">
                            CN
                        </div>
                        <ul class="dropdown-menu dropdown-menu-dark dropdown-menu-end">
                            <li><a class="dropdown-item" href="profile.php"><i class="fas fa-user me-2"></i>Profile</a></li>
                            <li><a class="dropdown-item" href="settings.php"><i class="fas fa-cog me-2"></i>Settings</a></li>
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
                <a href="challenges.php" class="btn-hero btn-hero-primary">
                    <i class="fas fa-play me-2"></i>Start Hacking
                </a>
                <a href="leaderboard.php" class="btn-hero btn-hero-secondary">
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
                <div class="stat-number" id="totalChallenges">Loading...</div>
                <div class="stat-label">Challenges</div>
            </div>
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-users"></i>
                </div>
                <div class="stat-number" id="totalHackers">Loading...</div>
                <div class="stat-label">Hackers</div>
            </div>
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-flag-checkered"></i>
                </div>
                <div class="stat-number" id="userCompleted">Loading...</div>
                <div class="stat-label">Your Completed</div>
            </div>
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-clock"></i>
                </div>
                <div class="stat-number" id="activeToday">Loading...</div>
                <div class="stat-label">Active Today</div>
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
                <a href="challenges.php" class="feature-link">
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
                <a href="profile.php" class="feature-link">
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
                <a href="leaderboard.php" class="feature-link">
                    View Leaderboard <i class="fas fa-arrow-right"></i>
                </a>
            </div>
        </div>
    </section>

    <!-- Recent Activity -->
    <section class="recent-activity container">
        <h2 class="section-title">RECENT ACTIVITY</h2>
        <div class="activity-list" id="recentActivityList">
            <div class="text-center py-4">
                <i class="fas fa-spinner fa-spin fa-2x mb-3 text-success"></i>
                <p class="text-success">Loading recent activity...</p>
            </div>
        </div>
    </section>

    <!-- Leaderboard Preview -->
    <section class="leaderboard-preview container">
        <h2 class="section-title">TOP HACKERS</h2>
        <div class="leaderboard-card" id="topHackersList">
            <div class="text-center py-4">
                <i class="fas fa-spinner fa-spin fa-2x mb-3 text-success"></i>
                <p class="text-success">Loading top hackers...</p>
            </div>
        </div>
        <div class="text-center mt-4">
            <a href="leaderboard.html" class="btn-hero btn-hero-secondary">
                <i class="fas fa-chart-line me-2"></i>View Full Leaderboard
            </a>
        </div>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../../javascript/users/home.js"></script>
</body>
</html>