<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CyberNest - Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../../css/admin/dashboard.css">
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

        .profile-container {
            max-width: 1200px;
            margin: 0 auto;
        }

        .profile-header {
            background: rgba(0, 0, 0, 0.8);
            border: 1px solid var(--primary-color);
            border-radius: 15px;
            padding: 40px;
            margin-bottom: 30px;
            position: relative;
            overflow: hidden;
        }

        .profile-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(45deg, transparent 30%, rgba(0, 255, 0, 0.05) 50%, transparent 70%);
            animation: header-scan 4s linear infinite;
            pointer-events: none;
        }

        @keyframes header-scan {
            0% { transform: translateX(-100%); }
            100% { transform: translateX(100%); }
        }

        .profile-info {
            display: flex;
            align-items: center;
            gap: 30px;
            flex-wrap: wrap;
        }

        .profile-avatar {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--darker-bg);
            font-size: 3rem;
            font-weight: bold;
            border: 4px solid var(--primary-color);
            position: relative;
            overflow: hidden;
            flex-shrink: 0;
        }

        .profile-avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 50%;
        }

        .profile-details {
            flex: 1;
        }

        .profile-name {
            font-size: 2.5rem;
            font-weight: bold;
            color: var(--primary-color);
            margin-bottom: 10px;
            text-shadow: 0 0 10px rgba(0, 255, 0, 0.5);
        }

        .profile-username {
            font-size: 1.2rem;
            color: var(--muted-text);
            margin-bottom: 15px;
        }

        .profile-bio {
            color: var(--light-text);
            line-height: 1.6;
            margin-bottom: 20px;
        }

        .profile-meta {
            display: flex;
            gap: 20px;
            flex-wrap: wrap;
        }

        .meta-item {
            display: flex;
            align-items: center;
            gap: 8px;
            color: var(--muted-text);
        }

        .meta-item i {
            color: var(--primary-color);
        }

        .profile-actions {
            display: flex;
            gap: 15px;
            margin-top: 20px;
            flex-wrap: wrap;
        }

        .btn-cyber {
            background: var(--primary-color);
            color: var(--darker-bg);
            border: none;
            padding: 12px 30px;
            border-radius: 6px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .btn-cyber:hover {
            background: var(--secondary-color);
            transform: translateY(-2px);
            box-shadow: 0 10px 30px rgba(0, 255, 0, 0.5);
        }

        .btn-cyber-secondary {
            background: transparent;
            color: var(--primary-color);
            border: 1px solid var(--primary-color);
        }

        .btn-cyber-secondary:hover {
            background: rgba(0, 255, 0, 0.1);
            transform: translateY(-2px);
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 25px;
            margin: 30px 0;
        }

        .stat-card {
            background: rgba(0, 0, 0, 0.8);
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
            animation: stat-scan 3s linear infinite;
            pointer-events: none;
        }

        @keyframes stat-scan {
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
            color: var(--primary-color);
            font-size: 2rem;
            font-weight: bold;
            margin-bottom: 30px;
            text-transform: uppercase;
            letter-spacing: 1px;
            text-align: center;
            text-shadow: 0 0 15px rgba(0, 255, 0, 0.5);
        }

        .achievements-section {
            background: rgba(0, 0, 0, 0.8);
            border: 1px solid var(--primary-color);
            border-radius: 15px;
            padding: 40px;
            margin-bottom: 30px;
            position: relative;
            overflow: hidden;
        }

        .achievements-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(45deg, transparent 30%, rgba(0, 255, 0, 0.05) 50%, transparent 70%);
            animation: achievements-scan 4s linear infinite;
            pointer-events: none;
        }

        @keyframes achievements-scan {
            0% { transform: translateX(-100%); }
            100% { transform: translateX(100%); }
        }

        .achievements-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 20px;
            margin-top: 30px;
        }

        .achievement-badge {
            background: rgba(0, 255, 0, 0.1);
            border: 1px solid var(--primary-color);
            border-radius: 12px;
            padding: 20px;
            text-align: center;
            transition: all 0.3s ease;
            cursor: pointer;
            position: relative;
            overflow: hidden;
        }

        .achievement-badge::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(45deg, transparent 30%, rgba(0, 255, 0, 0.05) 50%, transparent 70%);
            animation: badge-scan 3s linear infinite;
            pointer-events: none;
        }

        @keyframes badge-scan {
            0% { transform: translateX(-100%); }
            100% { transform: translateX(100%); }
        }

        .achievement-badge:hover {
            transform: translateY(-5px) scale(1.05);
            box-shadow: 0 15px 40px rgba(0, 255, 0, 0.4);
            border-color: var(--secondary-color);
        }

        .achievement-icon {
            font-size: 2.5rem;
            color: var(--primary-color);
            margin-bottom: 15px;
        }

        .achievement-name {
            color: var(--primary-color);
            font-weight: bold;
            margin-bottom: 5px;
        }

        .achievement-description {
            color: var(--muted-text);
            font-size: 0.85rem;
        }

        .achievement-badge.gold {
            background: linear-gradient(135deg, rgba(255, 215, 0, 0.2), rgba(255, 215, 0, 0.1));
            border-color: #ffd700;
        }

        .achievement-badge.gold .achievement-icon {
            color: #ffd700;
        }

        .achievement-badge.gold .achievement-name {
            color: #ffd700;
        }

        .achievement-badge.silver {
            background: linear-gradient(135deg, rgba(192, 192, 192, 0.2), rgba(192, 192, 192, 0.1));
            border-color: #c0c0c0;
        }

        .achievement-badge.silver .achievement-icon {
            color: #c0c0c0;
        }

        .achievement-badge.silver .achievement-name {
            color: #c0c0c0;
        }

        .achievement-badge.bronze {
            background: linear-gradient(135deg, rgba(205, 127, 50, 0.2), rgba(205, 127, 50, 0.1));
            border-color: #cd7f32;
        }

        .achievement-badge.bronze .achievement-icon {
            color: #cd7f32;
        }

        .achievement-badge.bronze .achievement-name {
            color: #cd7f32;
        }

        .recent-activity {
            background: rgba(0, 0, 0, 0.8);
            border: 1px solid var(--primary-color);
            border-radius: 15px;
            padding: 40px;
            margin-bottom: 30px;
            position: relative;
            overflow: hidden;
        }

        .recent-activity::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(45deg, transparent 30%, rgba(0, 255, 0, 0.05) 50%, transparent 70%);
            animation: activity-scan 4s linear infinite;
            pointer-events: none;
        }

        @keyframes activity-scan {
            0% { transform: translateX(-100%); }
            100% { transform: translateX(100%); }
        }

        .activity-list {
            margin-top: 30px;
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

        .progress-section {
            background: rgba(0, 0, 0, 0.8);
            border: 1px solid var(--primary-color);
            border-radius: 15px;
            padding: 40px;
            margin-bottom: 30px;
            position: relative;
            overflow: hidden;
        }

        .progress-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(45deg, transparent 30%, rgba(0, 255, 0, 0.05) 50%, transparent 70%);
            animation: progress-scan 4s linear infinite;
            pointer-events: none;
        }

        @keyframes progress-scan {
            0% { transform: translateX(-100%); }
            100% { transform: translateX(100%); }
        }

        .progress-item {
            margin-bottom: 30px;
        }

        .progress-label {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
        }

        .progress-name {
            color: var(--primary-color);
            font-weight: 600;
        }

        .progress-percentage {
            color: var(--muted-text);
            font-size: 0.9rem;
        }

        .progress-bar-custom {
            background: rgba(0, 0, 0, 0.8);
            border: 1px solid var(--primary-color);
            border-radius: 10px;
            height: 20px;
            overflow: hidden;
            position: relative;
        }

        .progress-fill {
            height: 100%;
            background: linear-gradient(90deg, var(--primary-color), var(--secondary-color));
            border-radius: 8px;
            transition: width 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .progress-fill::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(45deg, transparent 30%, rgba(255, 255, 255, 0.3) 50%, transparent 70%);
            animation: progress-shine 2s linear infinite;
        }

        @keyframes progress-shine {
            0% { transform: translateX(-100%); }
            100% { transform: translateX(100%); }
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

        .user-avatar-nav img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 50%;
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
            
            .profile-info {
                flex-direction: column;
                text-align: center;
            }
            
            .profile-name {
                font-size: 2rem;
            }
            
            .profile-actions {
                justify-content: center;
            }
            
            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
            }
            
            .achievements-grid {
                grid-template-columns: repeat(2, 1fr);
            }
            
            .activity-item {
                flex-direction: column;
                text-align: center;
                gap: 15px;
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
                        <a class="nav-link nav-link-custom" href="home.php">
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
                        <a class="nav-link nav-link-custom active" href="profile.php">
                            <i class="fas fa-user me-2"></i>Profile
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link nav-link-custom" href="settings.php">
                            <i class="fas fa-cog me-2"></i>Settings
                        </a>
                    </li>
                </ul>
                <div class="navbar-nav">
                    <div class="nav-item dropdown user-dropdown">
                        <div class="user-avatar-nav" data-bs-toggle="dropdown">
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
            <h1 class="hero-title">PROFILE</h1>
            <p class="hero-subtitle">Your cybersecurity journey and achievements</p>
        </div>
    </section>

    <!-- Profile Container -->
    <div class="profile-container container">
        <!-- Profile Header -->
        <div class="profile-header">
            <div class="profile-info">
                <div class="profile-avatar">
                    <img src="/uploads/default/default.jpg" alt="Default Profile Picture">
                </div>
                <div class="profile-details">
                    <h2 class="profile-name">Username</h2>
                    <div class="profile-username">@username</div>
                    <p class="profile-bio">Cybersecurity enthusiast and ethical hacker. Always learning and exploring new security challenges. Passionate about making the digital world a safer place.</p>
                    <div class="profile-meta">
                        <div class="meta-item">
                            <i class="fas fa-map-marker-alt"></i>
                            <span>San Francisco, CA</span>
                        </div>
                        <div class="meta-item">
                            <i class="fas fa-calendar"></i>
                            <span>Joined March 2024</span>
                        </div>
                        <div class="meta-item">
                            <i class="fas fa-link"></i>
                            <span>https://cybernest.dev</span>
                        </div>
                    </div>
                    <div class="profile-actions">
                        <button class="btn btn-cyber" onclick="editProfile()">
                            <i class="fas fa-edit me-2"></i>Edit Profile
                        </button>
                        <button class="btn btn-cyber-secondary" onclick="shareProfile()">
                            <i class="fas fa-share-alt me-2"></i>Share
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Statistics Grid -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-trophy"></i>
                </div>
                <div class="stat-number" id="userChallengesCompleted">Loading...</div>
                <div class="stat-label">Challenges Completed</div>
            </div>
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-star"></i>
                </div>
                <div class="stat-number" id="userPointsEarned">Loading...</div>
                <div class="stat-label">Points Earned</div>
            </div>
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-percentage"></i>
                </div>
                <div class="stat-number" id="userSuccessRate">Loading...</div>
                <div class="stat-label">Success Rate</div>
            </div>
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-chart-line"></i>
                </div>
                <div class="stat-number" id="userRankPosition">Loading...</div>
                <div class="stat-label">Rank Position</div>
            </div>
        </div>

        <!-- Progress Section -->
        <div class="progress-section">
            <h2 class="section-title">Skill Progress</h2>
            
            <div id="skillsProgressContainer">
                <div class="text-center py-4">
                    <i class="fas fa-spinner fa-spin fa-2x mb-3 text-success"></i>
                    <p class="text-success">Loading skill progress...</p>
                </div>
            </div>
        </div>

        <!-- Achievements Section -->
        <div class="achievements-section">
            <h2 class="section-title">Achievements</h2>
            
            <div class="achievements-grid">
                <div class="achievement-badge gold" title="First Challenge Completed">
                    <div class="achievement-icon">
                        <i class="fas fa-flag-checkered"></i>
                    </div>
                    <div class="achievement-name">First Blood</div>
                    <div class="achievement-description">Complete your first challenge</div>
                </div>

                <div class="achievement-badge gold" title="10 Challenges Completed">
                    <div class="achievement-icon">
                        <i class="fas fa-fire"></i>
                    </div>
                    <div class="achievement-name">On Fire</div>
                    <div class="achievement-description">Complete 10 challenges</div>
                </div>

                <div class="achievement-badge silver" title="Perfect Score">
                    <div class="achievement-icon">
                        <i class="fas fa-bullseye"></i>
                    </div>
                    <div class="achievement-name">Sharpshooter</div>
                    <div class="achievement-description">Get 100% on a challenge</div>
                </div>

                <div class="achievement-badge silver" title="Speed Demon">
                    <div class="achievement-icon">
                        <i class="fas fa-bolt"></i>
                    </div>
                    <div class="achievement-name">Speed Demon</div>
                    <div class="achievement-description">Complete a challenge in under 10 minutes</div>
                </div>

                <div class="achievement-badge bronze" title="Weekend Warrior">
                    <div class="achievement-icon">
                        <i class="fas fa-calendar-week"></i>
                    </div>
                    <div class="achievement-name">Weekend Warrior</div>
                    <div class="achievement-description">Complete 5 challenges in one weekend</div>
                </div>

                <div class="achievement-badge" title="Rising Star">
                    <div class="achievement-icon">
                        <i class="fas fa-star"></i>
                    </div>
                    <div class="achievement-name">Rising Star</div>
                    <div class="achievement-description">Reach top 10 in leaderboard</div>
                </div>

                <div class="achievement-badge" title="Persistent">
                    <div class="achievement-icon">
                        <i class="fas fa-hourglass-half"></i>
                    </div>
                    <div class="achievement-name">Persistent</div>
                    <div class="achievement-description">Attempt a challenge 10+ times</div>
                </div>

                <div class="achievement-badge" title="Explorer">
                    <div class="achievement-icon">
                        <i class="fas fa-compass"></i>
                    </div>
                    <div class="achievement-name">Explorer</div>
                    <div class="achievement-description">Try all challenge categories</div>
                </div>
            </div>
        </div>

        <!-- Recent Activity -->
        <div class="recent-activity">
            <h2 class="section-title">Recent Activity</h2>
            
            <div class="activity-list">
                <div class="activity-item">
                    <div class="activity-icon">
                        <i class="fas fa-trophy"></i>
                    </div>
                    <div class="activity-content">
                        <div class="activity-title">Completed SQL Injection Challenge</div>
                        <div class="activity-description">Successfully exploited vulnerable SQL query in 15 minutes</div>
                    </div>
                    <div class="activity-time">2 hours ago</div>
                </div>

                <div class="activity-item">
                    <div class="activity-icon">
                        <i class="fas fa-medal"></i>
                    </div>
                    <div class="activity-content">
                        <div class="activity-title">Earned "On Fire" Achievement</div>
                        <div class="activity-description">Completed 10 challenges - keep up the great work!</div>
                    </div>
                    <div class="activity-time">5 hours ago</div>
                </div>

                <div class="activity-item">
                    <div class="activity-icon">
                        <i class="fas fa-chart-line"></i>
                    </div>
                    <div class="activity-content">
                        <div class="activity-title">Rank Up to #6</div>
                        <div class="activity-description">You've moved up 2 positions in the leaderboard</div>
                    </div>
                    <div class="activity-time">1 day ago</div>
                </div>

                <div class="activity-item">
                    <div class="activity-icon">
                        <i class="fas fa-code"></i>
                    </div>
                    <div class="activity-content">
                        <div class="activity-title">Started Binary Analysis Challenge</div>
                        <div class="activity-description">Expert difficulty reverse engineering challenge</div>
                    </div>
                    <div class="activity-time">2 days ago</div>
                </div>

                <div class="activity-item">
                    <div class="activity-icon">
                        <i class="fas fa-star"></i>
                    </div>
                    <div class="activity-content">
                        <div class="activity-title">Earned 500 Points</div>
                        <div class="activity-description">Points for completing Port Scanner challenge</div>
                    </div>
                    <div class="activity-time">3 days ago</div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            loadUserProfile();
            loadUserSkills();
            startRealTimeUpdates();
            
            const observerOptions = {
                threshold: 0.5,
                rootMargin: '0px'
            };

            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        animateProgressBars();
                        observer.unobserve(entry.target);
                    }
                });
            }, observerOptions);

            const progressSection = document.querySelector('.progress-section');
            if (progressSection) {
                observer.observe(progressSection);
            }

            const statsObserver = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        animateStats();
                        statsObserver.unobserve(entry.target);
                    }
                });
            }, observerOptions);

            const statsGrid = document.querySelector('.stats-grid');
            if (statsGrid) {
                statsObserver.observe(statsGrid);
            }

            const achievementBadges = document.querySelectorAll('.achievement-badge');
            achievementBadges.forEach(badge => {
                badge.addEventListener('mouseenter', function() {
                    this.style.transform = 'translateY(-8px) scale(1.1) rotate(5deg)';
                });
                
                badge.addEventListener('mouseleave', function() {
                    this.style.transform = 'translateY(-5px) scale(1.05)';
                });
            });

            const activityItems = document.querySelectorAll('.activity-item');
            activityItems.forEach(item => {
                item.addEventListener('click', function() {
                    const title = this.querySelector('.activity-title').textContent;
                });
            });
        });

        function animateProgressBars() {
            const progressBars = document.querySelectorAll('.progress-fill');
            progressBars.forEach((bar, index) => {
                const width = bar.style.width;
                bar.style.width = '0%';
                
                setTimeout(() => {
                    bar.style.width = width;
                }, index * 200);
            });
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
                } else if (target.includes('%')) {
                    const num = parseInt(target);
                    let current = 0;
                    const increment = num / 50;
                    const timer = setInterval(() => {
                        current += increment;
                        if (current >= num) {
                            current = num;
                            clearInterval(timer);
                        }
                        stat.textContent = Math.floor(current) + '%';
                    }, 30);
                }
            });
        }

        function editProfile() {
            Swal.fire({
                icon: 'info',
                title: 'Edit Profile',
                text: 'Edit profile functionality would open a modal or redirect to settings page',
                confirmButtonColor: '#00ff00',
                confirmButtonText: 'OK'
            });
        }

        function shareProfile() {
            const profileUrl = window.location.href;
            
            if (navigator.share) {
                navigator.share({
                    title: 'CN - CyberNest Profile',
                    text: 'Check out my cybersecurity achievements and progress!',
                    url: profileUrl
                });
            } else {
                const dummy = document.createElement('input');
                document.body.appendChild(dummy);
                dummy.value = profileUrl;
                dummy.select();
                document.execCommand('copy');
                document.body.removeChild(dummy);
                
                Swal.fire({
                    icon: 'success',
                    title: 'Copied!',
                    text: 'Profile URL copied to clipboard!',
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 2000,
                    timerProgressBar: true
                });
            }
        }

        setInterval(() => {
            const activities = document.querySelectorAll('.activity-time');
            activities.forEach(activity => {
                const text = activity.textContent;
                if (text.includes('hour')) {
                    const hours = parseInt(text);
                    if (hours < 24) {
                        activity.textContent = (hours + 1) + ' hours ago';
                    } else {
                        activity.textContent = '1 day ago';
                    }
                } else if (text.includes('day')) {
                    const days = parseInt(text);
                    activity.textContent = (days + 1) + ' days ago';
                }
            });
        }, 60000);

        function loadUserProfile() {
            fetch('/backend/api/challenges.php?action=getUserProfile')
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        displayUserProfile(data.profile);
                    } else {
                        console.error('Failed to load user profile:', data.message);
                        showError('Failed to load profile data. Please try again.');
                    }
                })
                .catch(error => {
                    console.error('Error loading user profile:', error);
                    showError('Network error loading profile data.');
                });
        }

        function loadUserSkills() {
            fetch('/backend/api/challenges.php?action=getUserSkills')
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        displayUserSkills(data.skills);
                    } else {
                        console.error('Failed to load user skills:', data.message);
                        const container = document.getElementById('skillsProgressContainer');
                        if (container) {
                            container.innerHTML = `
                                <div class="text-center py-4">
                                    <i class="fas fa-exclamation-triangle fa-2x mb-3 text-warning"></i>
                                    <p class="text-warning">Error loading skills: ${data.message}</p>
                                </div>
                            `;
                        }
                    }
                })
                .catch(error => {
                    console.error('Error loading user skills:', error);
                    const container = document.getElementById('skillsProgressContainer');
                    if (container) {
                        container.innerHTML = `
                            <div class="text-center py-4">
                                <i class="fas fa-exclamation-triangle fa-2x mb-3 text-danger"></i>
                                <p class="text-danger">Network error loading skills</p>
                            </div>
                        `;
                    }
                });
        }

        function displayUserSkills(skills) {
            const container = document.getElementById('skillsProgressContainer');
            if (!container) return;

            if (skills.length === 0) {
                container.innerHTML = `
                    <div class="text-center py-4">
                        <i class="fas fa-info-circle fa-2x mb-3 text-muted"></i>
                        <p class="text-muted">No skill progress found. Start completing challenges to see your progress!</p>
                    </div>
                `;
                return;
            }

            container.innerHTML = skills.map(skill => `
                <div class="progress-item">
                    <div class="progress-label">
                        <span class="progress-name">${skill.skill_name}</span>
                        <span class="progress-percentage">${skill.progress_percentage}%</span>
                    </div>
                    <div class="progress-bar-custom">
                        <div class="progress-fill" style="width: ${skill.progress_percentage}%;" data-width="${skill.progress_percentage}%"></div>
                    </div>
                    <div class="progress-details">
                        <span class="progress-stat">${skill.completed_challenges}/${skill.total_challenges} completed</span>
                        <span class="progress-stat">${skill.points_earned} points</span>
                        <span class="progress-stat">Level: ${skill.skill_level}</span>
                    </div>
                </div>
            `).join('');

            setTimeout(() => {
                animateProgressBars();
            }, 100);
        }

        function displayUserProfile(profile) {
            updateProfileHeader(profile);
            
            updateStatistics(profile);
            
            updateRecentActivity(profile.recent_activities);
        }

        function updateProfileHeader(profile) {
            const avatar = document.querySelector('.profile-avatar');
            if (avatar) {
                if (profile.profile_picture && profile.profile_picture !== '') {
                    avatar.innerHTML = `<img src="${profile.profile_picture}" alt="Profile Picture">`;
                } else {
                    avatar.innerHTML = `<img src="/uploads/default/default.jpg" alt="Default Profile Picture">`;
                }
            }

            const navAvatar = document.querySelector('.user-avatar-nav');
            if (navAvatar) {
                if (profile.profile_picture && profile.profile_picture !== '') {
                    navAvatar.innerHTML = `<img src="${profile.profile_picture}" alt="Profile Picture">`;
                } else {
                    navAvatar.innerHTML = `<img src="/uploads/default/default.jpg" alt="Default Profile Picture">`;
                }
            }

            const nameElement = document.querySelector('.profile-name');
            const usernameElement = document.querySelector('.profile-username');
            if (nameElement) nameElement.textContent = profile.username;
            if (usernameElement) usernameElement.textContent = '@' + profile.username.toLowerCase();

            const bioElement = document.querySelector('.profile-bio');
            if (bioElement) {
                bioElement.textContent = profile.bio || 'Cybersecurity enthusiast and ethical hacker.';
            }

            const locationElement = document.querySelector('.meta-item:nth-child(1) span');
            const websiteElement = document.querySelector('.meta-item:nth-child(3) span');
            
            if (locationElement) locationElement.textContent = profile.location || 'Location not specified';
            if (websiteElement) websiteElement.textContent = profile.website || 'No website';
        }

        function updateStatistics(profile) {
            updateStatCard('userChallengesCompleted', profile.challenges_completed);
            updateStatCard('userPointsEarned', profile.points_earned);
            updateStatCard('userSuccessRate', profile.success_rate, '%');
            updateStatCard('userRankPosition', profile.rank_position);
        }

        function updateStatCard(elementId, value, suffix = '') {
            const element = document.getElementById(elementId);
            if (element) {
                element.textContent = value.toLocaleString() + suffix;
                
                element.style.transition = 'all 0.5s ease';
                element.style.transform = 'scale(1.1)';
                element.style.color = '#00ff00';
                
                setTimeout(() => {
                    element.style.transform = 'scale(1)';
                    element.style.color = '';
                }, 500);
            }
        }

        function updateRecentActivity(activities) {
            const activityList = document.querySelector('.activity-list');
            if (!activityList) return;

            if (activities.length === 0) {
                activityList.innerHTML = `
                    <div class="text-center py-4">
                        <i class="fas fa-info-circle fa-2x mb-3 text-muted"></i>
                        <p class="text-muted">No recent activity found</p>
                    </div>
                `;
                return;
            }

            activityList.innerHTML = activities.map(activity => `
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

        function getInitials(username) {
            return username.split(' ')
                .map(word => word.charAt(0).toUpperCase())
                .join('')
                .substring(0, 2);
        }

        function showError(message) {
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: message,
                confirmButtonColor: '#dc3545',
                confirmButtonText: 'OK'
            });
        }

        function startRealTimeUpdates() {
            setInterval(() => {
                loadUserProfile();
                loadUserSkills();
            }, 30000);

            document.addEventListener('visibilitychange', function() {
                if (!document.hidden) {
                    loadUserProfile();
                    loadUserSkills();
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
    </script>
</body>
</html>