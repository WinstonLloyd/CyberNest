<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CyberNest - Settings</title>
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

        .settings-container {
            max-width: 1200px;
            margin: 0 auto;
        }

        .settings-tabs {
            display: flex;
            gap: 10px;
            margin-bottom: 30px;
            border-bottom: 2px solid var(--primary-color);
            padding-bottom: 10px;
            flex-wrap: wrap;
        }

        .tab-btn {
            background: transparent;
            border: 1px solid var(--primary-color);
            color: var(--primary-color);
            padding: 12px 24px;
            border-radius: 8px 8px 0 0;
            cursor: pointer;
            transition: all 0.3s ease;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            font-size: 0.9rem;
        }

        .tab-btn:hover {
            background: rgba(0, 255, 0, 0.1);
            transform: translateY(-2px);
        }

        .tab-btn.active {
            background: var(--primary-color);
            color: var(--darker-bg);
            border-color: var(--primary-color);
        }

        .tab-content {
            display: none;
            animation: fadeIn 0.3s ease-in-out;
        }

        .tab-content.active {
            display: block;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .settings-section {
            background: rgba(0, 0, 0, 0.8);
            border: 1px solid var(--primary-color);
            border-radius: 12px;
            padding: 30px;
            margin-bottom: 30px;
            position: relative;
            overflow: hidden;
        }

        .settings-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(45deg, transparent 30%, rgba(0, 255, 0, 0.05) 50%, transparent 70%);
            animation: section-scan 4s linear infinite;
            pointer-events: none;
        }

        @keyframes section-scan {
            0% { transform: translateX(-100%); }
            100% { transform: translateX(100%); }
        }

        .section-title {
            color: var(--primary-color);
            font-size: 1.5rem;
            font-weight: bold;
            margin-bottom: 25px;
            text-transform: uppercase;
            letter-spacing: 1px;
            border-bottom: 1px solid rgba(0, 255, 0, 0.3);
            padding-bottom: 10px;
        }

        .form-group {
            margin-bottom: 25px;
        }

        .form-label {
            color: var(--primary-color);
            font-weight: 600;
            margin-bottom: 8px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            font-size: 0.9rem;
        }

        .form-control, .form-select {
            background: rgba(0, 0, 0, 0.8);
            border: 1px solid var(--primary-color);
            color: var(--primary-color);
            padding: 12px 15px;
            border-radius: 6px;
            font-size: 0.9rem;
            transition: all 0.3s ease;
        }

        .form-control:focus, .form-select:focus {
            outline: none;
            box-shadow: 0 0 10px rgba(0, 255, 0, 0.3);
            border-color: var(--primary-color);
            background: rgba(0, 0, 0, 0.9);
        }

        .form-control::placeholder {
            color: var(--muted-text);
        }

        .toggle-switch {
            position: relative;
            width: 60px;
            height: 30px;
            background: rgba(0, 0, 0, 0.8);
            border: 1px solid var(--primary-color);
            border-radius: 15px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .toggle-switch.active {
            background: var(--primary-color);
        }

        .toggle-slider {
            position: absolute;
            top: 3px;
            left: 3px;
            width: 22px;
            height: 22px;
            background: var(--muted-text);
            border-radius: 50%;
            transition: all 0.3s ease;
        }

        .toggle-switch.active .toggle-slider {
            transform: translateX(30px);
            background: var(--darker-bg);
        }

        .toggle-group {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 20px;
        }

        .toggle-label {
            color: var(--light-text);
            font-weight: 500;
        }

        .toggle-description {
            color: var(--muted-text);
            font-size: 0.85rem;
            margin-top: 5px;
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
            margin-right: 10px;
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

        .avatar-upload {
            display: flex;
            align-items: center;
            gap: 20px;
            margin-bottom: 25px;
        }

        .avatar-preview {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--darker-bg);
            font-size: 2rem;
            font-weight: bold;
            border: 3px solid var(--primary-color);
            position: relative;
            overflow: hidden;
        }

        .avatar-preview img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 50%;
            position: absolute;
            top: 0;
            left: 0;
        }

        .avatar-info {
            flex: 1;
        }

        .progress-bar-custom {
            background: rgba(0, 0, 0, 0.8);
            border: 1px solid var(--primary-color);
            border-radius: 10px;
            height: 20px;
            overflow: hidden;
            margin-bottom: 10px;
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

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: rgba(0, 255, 0, 0.1);
            border: 1px solid var(--primary-color);
            border-radius: 8px;
            padding: 20px;
            text-align: center;
        }

        .stat-value {
            font-size: 2rem;
            font-weight: bold;
            color: var(--primary-color);
            margin-bottom: 5px;
        }

        .stat-label {
            color: var(--muted-text);
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
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

        .user-avatar-nav img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 50%;
        }

        .alert-cyber {
            background: rgba(0, 255, 0, 0.1);
            border: 1px solid var(--primary-color);
            color: var(--primary-color);
            padding: 15px;
            border-radius: 6px;
            margin-bottom: 20px;
            display: none;
        }

        .alert-cyber.show {
            display: block;
            animation: slideDown 0.3s ease-out;
        }

        @keyframes slideDown {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @media (max-width: 768px) {
            .hero-title {
                font-size: 2.5rem;
            }
            
            .hero-subtitle {
                font-size: 1.1rem;
            }
            
            .settings-tabs {
                flex-direction: column;
            }
            
            .tab-btn {
                width: 100%;
                text-align: center;
            }
            
            .avatar-upload {
                flex-direction: column;
                text-align: center;
            }
            
            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
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
                        <a class="nav-link nav-link-custom" href="profile.php">
                            <i class="fas fa-user me-2"></i>Profile
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link nav-link-custom active" href="settings.php">
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
            <h1 class="hero-title">SETTINGS</h1>
            <p class="hero-subtitle">Customize your CyberNest experience</p>
        </div>
    </section>

    <!-- Settings Container -->
    <div class="settings-container container">
        <!-- Alert Message -->
        <div class="alert-cyber" id="alertMessage">
            <i class="fas fa-check-circle me-2"></i>
            <span id="alertText">Settings saved successfully!</span>
        </div>

        <!-- Settings Tabs -->
        <div class="settings-tabs">
            <button class="tab-btn active" onclick="switchTab('profile')">
                <i class="fas fa-user me-2"></i>Profile
            </button>
            <button class="tab-btn" onclick="switchTab('security')">
                <i class="fas fa-shield-alt me-2"></i>Security
            </button>
            <button class="tab-btn" onclick="switchTab('notifications')">
                <i class="fas fa-bell me-2"></i>Notifications
            </button>
            <button class="tab-btn" onclick="switchTab('appearance')">
                <i class="fas fa-palette me-2"></i>Appearance
            </button>
            <button class="tab-btn" onclick="switchTab('privacy')">
                <i class="fas fa-lock me-2"></i>Privacy
            </button>
        </div>

        <!-- Profile Tab -->
        <div class="tab-content active" id="profile-tab">
            <div class="settings-section">
                <h2 class="section-title">Profile Information</h2>
                
                <div class="avatar-upload">
                    <div class="avatar-preview" id="avatarPreview">
                        <img src="/uploads/default/default.jpg" alt="Default Profile Picture">
                    </div>
                    <div class="avatar-info">
                        <div class="form-group">
                            <label class="form-label">Profile Picture</label>
                            <input type="file" class="form-control" id="avatarInput" accept="image/*">
                        </div>
                        <small class="text-muted">Upload a new avatar (JPG, PNG, max 2MB)</small>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label">Username</label>
                            <input type="text" class="form-control" id="username" value="Username" placeholder="Enter username">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label">Display Name</label>
                            <input type="text" class="form-control" id="displayName" value="Display Name" placeholder="Enter display name">
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Email Address</label>
                    <input type="email" class="form-control" id="email" value="CyberNest@gmail.com" placeholder="Enter email">
                </div>

                <div class="form-group">
                    <label class="form-label">Bio</label>
                    <textarea class="form-control" id="bio" rows="4" placeholder="Tell us about yourself...">Cybersecurity enthusiast and ethical hacker. Always learning and exploring new security challenges.</textarea>
                </div>

                <div class="form-group">
                    <label class="form-label">Location</label>
                    <input type="text" class="form-control" id="location" value="San Francisco, CA" placeholder="Enter location">
                </div>

                <div class="form-group">
                    <label class="form-label">Website</label>
                    <input type="url" class="form-control" id="website" value="https://cybernest.dev" placeholder="Enter website URL">
                </div>
            </div>

            <div class="settings-section">
                <h2 class="section-title">Account Statistics</h2>
                
                <div class="stats-grid">
                    <div class="stat-card">
                        <div class="stat-value" id="settingsChallengesCompleted">Loading...</div>
                        <div class="stat-label">Challenges Completed</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-value" id="settingsPointsEarned">Loading...</div>
                        <div class="stat-label">Points Earned</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-value" id="settingsSuccessRate">Loading...</div>
                        <div class="stat-label">Success Rate</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-value" id="settingsRankPosition">Loading...</div>
                        <div class="stat-label">Rank Position</div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Profile Completion</label>
                    <div class="progress-bar-custom">
                        <div class="progress-fill" style="width: 75%;"></div>
                    </div>
                    <small class="text-muted">75% complete - Add more details to improve your profile</small>
                </div>
            </div>
        </div>

        <!-- Security Tab -->
        <div class="tab-content" id="security-tab">
            <div class="settings-section">
                <h2 class="section-title">Password Settings</h2>
                
                <div class="form-group">
                    <label class="form-label">Current Password</label>
                    <input type="password" class="form-control" id="currentPassword" placeholder="Enter current password">
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label">New Password</label>
                            <input type="password" class="form-control" id="newPassword" placeholder="Enter new password">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label">Confirm New Password</label>
                            <input type="password" class="form-control" id="confirmPassword" placeholder="Confirm new password">
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Two-Factor Authentication</label>
                    <div class="toggle-group">
                        <div>
                            <div class="toggle-label">Enable 2FA</div>
                            <div class="toggle-description">Add an extra layer of security to your account</div>
                        </div>
                        <div class="toggle-switch" id="twoFactorToggle" onclick="toggleSwitch(this)"></div>
                    </div>
                </div>
            </div>

            <div class="settings-section">
                <h2 class="section-title">Login Activity</h2>
                
                <div class="form-group">
                    <label class="form-label">Active Sessions</label>
                    <div class="list-group">
                        <div class="list-group-item bg-dark text-light border-secondary">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="mb-1">Chrome on Windows</h6>
                                    <small class="text-muted">192.168.1.100 • San Francisco, CA</small>
                                </div>
                                <small class="text-muted">Current session</small>
                            </div>
                        </div>
                        <div class="list-group-item bg-dark text-light border-secondary">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="mb-1">Firefox on Android</h6>
                                    <small class="text-muted">192.168.1.101 • San Francisco, CA</small>
                                </div>
                                <button class="btn btn-sm btn-outline-danger">Revoke</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Notifications Tab -->
        <div class="tab-content" id="notifications-tab">
            <div class="settings-section">
                <h2 class="section-title">Email Notifications</h2>
                
                <div class="toggle-group">
                    <div>
                        <div class="toggle-label">Challenge Updates</div>
                        <div class="toggle-description">Get notified about new challenges and updates</div>
                    </div>
                    <div class="toggle-switch active" id="challengeUpdatesToggle" onclick="toggleSwitch(this)"></div>
                </div>

                <div class="toggle-group">
                    <div>
                        <div class="toggle-label">Leaderboard Changes</div>
                        <div class="toggle-description">Receive notifications when your rank changes</div>
                    </div>
                    <div class="toggle-switch active" id="leaderboardToggle" onclick="toggleSwitch(this)"></div>
                </div>

                <div class="toggle-group">
                    <div>
                        <div class="toggle-label">Achievement Unlocked</div>
                        <div class="toggle-description">Celebrate your accomplishments</div>
                    </div>
                    <div class="toggle-switch active" id="achievementsToggle" onclick="toggleSwitch(this)"></div>
                </div>

                <div class="toggle-group">
                    <div>
                        <div class="toggle-label">Security Alerts</div>
                        <div class="toggle-description">Important security notifications</div>
                    </div>
                    <div class="toggle-switch active" id="securityAlertsToggle" onclick="toggleSwitch(this)"></div>
                </div>
            </div>

            <div class="settings-section">
                <h2 class="section-title">In-App Notifications</h2>
                
                <div class="toggle-group">
                    <div>
                        <div class="toggle-label">Desktop Notifications</div>
                        <div class="toggle-description">Show notifications on your desktop</div>
                    </div>
                    <div class="toggle-switch" id="desktopToggle" onclick="toggleSwitch(this)"></div>
                </div>

                <div class="toggle-group">
                    <div>
                        <div class="toggle-label">Sound Effects</div>
                        <div class="toggle-description">Play sounds for notifications</div>
                    </div>
                    <div class="toggle-switch active" id="soundToggle" onclick="toggleSwitch(this)"></div>
                </div>
            </div>
        </div>

        <!-- Appearance Tab -->
        <div class="tab-content" id="appearance-tab">
            <div class="settings-section">
                <h2 class="section-title">Theme Settings</h2>
                
                <div class="form-group">
                    <label class="form-label">Color Theme</label>
                    <select class="form-select" id="colorTheme">
                        <option value="green" selected>Cyber Green (Default)</option>
                        <option value="blue">Neon Blue</option>
                        <option value="red">Matrix Red</option>
                        <option value="purple">Cyber Purple</option>
                        <option value="orange">Terminal Orange</option>
                    </select>
                </div>

                <div class="toggle-group">
                    <div>
                        <div class="toggle-label">Dark Mode</div>
                        <div class="toggle-description">Use dark theme throughout the application</div>
                    </div>
                    <div class="toggle-switch active" id="darkModeToggle" onclick="toggleSwitch(this)"></div>
                </div>

                <div class="toggle-group">
                    <div>
                        <div class="toggle-label">Animations</div>
                        <div class="toggle-description">Enable visual effects and transitions</div>
                    </div>
                    <div class="toggle-switch active" id="animationsToggle" onclick="toggleSwitch(this)"></div>
                </div>
            </div>

            <div class="settings-section">
                <h2 class="section-title">Display Settings</h2>
                
                <div class="form-group">
                    <label class="form-label">Font Size</label>
                    <select class="form-select" id="fontSize">
                        <option value="small">Small</option>
                        <option value="medium" selected>Medium</option>
                        <option value="large">Large</option>
                        <option value="extra-large">Extra Large</option>
                    </select>
                </div>

                <div class="form-group">
                    <label class="form-label">Language</label>
                    <select class="form-select" id="language">
                        <option value="en" selected>English</option>
                        <option value="es">Español</option>
                        <option value="fr">Français</option>
                        <option value="de">Deutsch</option>
                        <option value="ja">日本語</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Privacy Tab -->
        <div class="tab-content" id="privacy-tab">
            <div class="settings-section">
                <h2 class="section-title">Profile Privacy</h2>
                
                <div class="toggle-group">
                    <div>
                        <div class="toggle-label">Public Profile</div>
                        <div class="toggle-description">Make your profile visible to other users</div>
                    </div>
                    <div class="toggle-switch active" id="publicProfileToggle" onclick="toggleSwitch(this)"></div>
                </div>

                <div class="toggle-group">
                    <div>
                        <div class="toggle-label">Show Email</div>
                        <div class="toggle-description">Display email address on your profile</div>
                    </div>
                    <div class="toggle-switch" id="showEmailToggle" onclick="toggleSwitch(this)"></div>
                </div>

                <div class="toggle-group">
                    <div>
                        <div class="toggle-label">Show Location</div>
                        <div class="toggle-description">Display your location on your profile</div>
                    </div>
                    <div class="toggle-switch active" id="showLocationToggle" onclick="toggleSwitch(this)"></div>
                </div>

                <div class="toggle-group">
                    <div>
                        <div class="toggle-label">Show Statistics</div>
                        <div class="toggle-description">Display your challenge statistics</div>
                    </div>
                    <div class="toggle-switch active" id="showStatsToggle" onclick="toggleSwitch(this)"></div>
                </div>
            </div>

            <div class="settings-section">
                <h2 class="section-title">Data Management</h2>
                
                <div class="form-group">
                    <label class="form-label">Data Export</label>
                    <p class="text-muted">Download a copy of your personal data</p>
                    <button class="btn btn-cyber-secondary" onclick="exportData()">
                        <i class="fas fa-download me-2"></i>Export Data
                    </button>
                </div>

                <div class="form-group">
                    <label class="form-label">Account Deletion</label>
                    <p class="text-muted">Permanently delete your account and all associated data</p>
                    <button class="btn btn-outline-danger" onclick="confirmDeleteAccount()">
                        <i class="fas fa-trash me-2"></i>Delete Account
                    </button>
                </div>
            </div>
        </div>

        <!-- Save Buttons -->
        <div class="d-flex justify-content-end mb-5">
            <button class="btn btn-cyber-secondary" onclick="resetSettings()">
                <i class="fas fa-undo me-2"></i>Reset
            </button>
            <button class="btn btn-cyber" onclick="saveSettings()">
                <i class="fas fa-save me-2"></i>Save Changes
            </button>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function switchTab(tabName) {
            const tabs = document.querySelectorAll('.tab-content');
            tabs.forEach(tab => tab.classList.remove('active'));
            
            const buttons = document.querySelectorAll('.tab-btn');
            buttons.forEach(btn => btn.classList.remove('active'));
            
            document.getElementById(tabName + '-tab').classList.add('active');
            
            event.target.classList.add('active');
        }

        function toggleSwitch(element) {
            element.classList.toggle('active');
        }

        function saveSettings() {
            const settings = {
                profile: {
                    username: document.getElementById('username').value,
                    displayName: document.getElementById('displayName').value,
                    email: document.getElementById('email').value,
                    bio: document.getElementById('bio').value,
                    location: document.getElementById('location').value,
                    website: document.getElementById('website').value
                },
                security: {
                    twoFactor: document.getElementById('twoFactorToggle').classList.contains('active')
                },
                notifications: {
                    challengeUpdates: document.getElementById('challengeUpdatesToggle').classList.contains('active'),
                    leaderboard: document.getElementById('leaderboardToggle').classList.contains('active'),
                    achievements: document.getElementById('achievementsToggle').classList.contains('active'),
                    security: document.getElementById('securityAlertsToggle').classList.contains('active'),
                    desktop: document.getElementById('desktopToggle').classList.contains('active'),
                    sound: document.getElementById('soundToggle').classList.contains('active')
                },
                appearance: {
                    colorTheme: document.getElementById('colorTheme').value,
                    darkMode: document.getElementById('darkModeToggle').classList.contains('active'),
                    animations: document.getElementById('animationsToggle').classList.contains('active'),
                    fontSize: document.getElementById('fontSize').value,
                    language: document.getElementById('language').value
                },
                privacy: {
                    publicProfile: document.getElementById('publicProfileToggle').classList.contains('active'),
                    showEmail: document.getElementById('showEmailToggle').classList.contains('active'),
                    showLocation: document.getElementById('showLocationToggle').classList.contains('active'),
                    showStats: document.getElementById('showStatsToggle').classList.contains('active')
                }
            };

            localStorage.setItem('cybernest-settings', JSON.stringify(settings));
            
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: 'Settings saved successfully!',
                confirmButtonColor: '#00ff00',
                background: '#1a1a1a',
                color: '#00ff00',
                confirmButtonText: 'OK'
            });
        }

        function resetSettings() {
            Swal.fire({
                title: 'Reset Settings?',
                text: 'Are you sure you want to reset all settings to default values?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#00ff00',
                cancelButtonColor: '#dc3545',
                confirmButtonText: 'Yes, reset!',
                background: '#1a1a1a',
                color: '#00ff00',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('username').value = 'Username';
                    document.getElementById('displayName').value = 'Display Name';
                    document.getElementById('email').value = 'CyberNest@gmail.com';
                    document.getElementById('bio').value = 'Cybersecurity enthusiast and ethical hacker. Always learning and exploring new security challenges.';
                    document.getElementById('location').value = 'San Francisco, CA';
                    document.getElementById('website').value = 'https://cybernest.dev';
                    
                    const toggles = document.querySelectorAll('.toggle-switch');
                    toggles.forEach(toggle => {
                        if (toggle.id.includes('Toggle') && 
                            !['twoFactorToggle', 'desktopToggle', 'showEmailToggle'].includes(toggle.id)) {
                            toggle.classList.add('active');
                        } else {
                            toggle.classList.remove('active');
                        }
                    });
                    
                    document.getElementById('colorTheme').value = 'green';
                    document.getElementById('fontSize').value = 'medium';
                    document.getElementById('language').value = 'en';
                    
                    Swal.fire({
                        icon: 'success',
                        title: 'Success!',
                        text: 'Settings reset to default values!',
                        confirmButtonColor: '#00ff00',
                        background: '#1a1a1a',
                        color: '#00ff00',
                        confirmButtonText: 'OK'
                    });
                }
            });
        }

        function exportData() {
            const userData = {
                profile: {
                    username: document.getElementById('username').value,
                    displayName: document.getElementById('displayName').value,
                    email: document.getElementById('email').value,
                    bio: document.getElementById('bio').value,
                    location: document.getElementById('location').value,
                    website: document.getElementById('website').value
                },
                statistics: {
                    challengesCompleted: 12,
                    pointsEarned: 2450,
                    successRate: 89,
                    rankPosition: 6
                },
                exportDate: new Date().toISOString()
            };
            
            const dataStr = JSON.stringify(userData, null, 2);
            const dataUri = 'data:application/json;charset=utf-8,'+ encodeURIComponent(dataStr);
            
            const exportFileDefaultName = 'cybernest-data-export.json';
            
            const linkElement = document.createElement('a');
            linkElement.setAttribute('href', dataUri);
            linkElement.setAttribute('download', exportFileDefaultName);
            linkElement.click();
            
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: 'Data exported successfully!',
                confirmButtonColor: '#00ff00',
                background: '#1a1a1a',
                color: '#00ff00',
                confirmButtonText: 'OK'
            });
        }

        function confirmDeleteAccount() {
            Swal.fire({
                title: 'Delete Account?',
                text: 'This action cannot be undone. Are you sure?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Delete Forever',
                background: '#1a1a1a',
                color: '#00ff00',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: 'Absolutely Sure?',
                        text: 'This will permanently delete all your data. This action cannot be undone!',
                        icon: 'error',
                        showCancelButton: true,
                        confirmButtonColor: '#dc3545',
                        cancelButtonColor: '#6c757d',
                        confirmButtonText: 'Delete Forever',
                        cancelButtonText: 'Cancel',
                        background: '#1a1a1a',
                        color: '#00ff00'
                    }).then((finalResult) => {
                        if (finalResult.isConfirmed) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Success!',
                                text: 'Account deletion request submitted. You will receive an email confirmation.',
                                confirmButtonColor: '#00ff00',
                                background: '#1a1a1a',
                                color: '#00ff00',
                                confirmButtonText: 'OK'
                            });
                        }
                    });
                }
            });
        }

        document.getElementById('avatarInput').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file && file.type.startsWith('image/')) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const avatarPreview = document.getElementById('avatarPreview');
                    avatarPreview.innerHTML = `<img src="${e.target.result}" alt="Avatar">`;
                };
                reader.readAsDataURL(file);
            }
        });

        document.addEventListener('DOMContentLoaded', function() {
            loadUserProfile();
            loadUserStats();
            
            const savedSettings = localStorage.getItem('cybernest-settings');
            if (savedSettings) {
                const settings = JSON.parse(savedSettings);
                
                if (settings.security && settings.security.twoFactor) {
                    document.getElementById('twoFactorToggle').classList.add('active');
                }
                
                if (settings.notifications) {
                    Object.keys(settings.notifications).forEach(key => {
                        const toggleId = key + 'Toggle';
                        const toggle = document.getElementById(toggleId);
                        if (toggle && settings.notifications[key]) {
                            toggle.classList.add('active');
                        }
                    });
                }
                
                if (settings.appearance) {
                    if (settings.appearance.colorTheme) {
                        document.getElementById('colorTheme').value = settings.appearance.colorTheme;
                    }
                    if (settings.appearance.fontSize) {
                        document.getElementById('fontSize').value = settings.appearance.fontSize;
                    }
                    if (settings.appearance.language) {
                        document.getElementById('language').value = settings.appearance.language;
                    }
                }
            }
        });

        function loadUserProfile() {
            fetch('/backend/api/challenges.php?action=getUserProfile')
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        populateProfileForm(data.profile);
                    } else {
                        console.error('Failed to load user profile:', data.message);
                    }
                })
                .catch(error => {
                    console.error('Error loading user profile:', error);
                });
        }

        function loadUserStats() {
            fetch('/backend/api/challenges.php?action=getUserProfile')
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        updateSettingsStats(data.profile);
                    } else {
                        console.error('Failed to load user stats:', data.message);
                    }
                })
                .catch(error => {
                    console.error('Error loading user stats:', error);
                });
        }

        function populateProfileForm(profile) {
            
            document.getElementById('username').value = profile.username || '';
            document.getElementById('displayName').value = profile.display_name || profile.username;
            document.getElementById('email').value = profile.email || '';
            document.getElementById('bio').value = profile.bio || '';
            document.getElementById('location').value = profile.location || '';
            document.getElementById('website').value = profile.website || '';
            
            const avatarPreview = document.getElementById('avatarPreview');
            
            if (profile.profile_picture && profile.profile_picture !== '') {
                avatarPreview.innerHTML = `<img src="${profile.profile_picture}" alt="Profile Picture">`;
            } else {
                avatarPreview.innerHTML = `<img src="/uploads/default/default.jpg" alt="Default Profile Picture">`;
            }

            // Update navigation avatar
            const navAvatar = document.querySelector('.user-avatar-nav');
            if (navAvatar) {
                if (profile.profile_picture && profile.profile_picture !== '') {
                    navAvatar.innerHTML = `<img src="${profile.profile_picture}" alt="Profile Picture">`;
                } else {
                    navAvatar.innerHTML = `<img src="/uploads/default/default.jpg" alt="Default Profile Picture">`;
                }
            }
        }

        function updateSettingsStats(profile) {
            updateStatCard('settingsChallengesCompleted', profile.challenges_completed);
            updateStatCard('settingsPointsEarned', profile.points_earned);
            updateStatCard('settingsSuccessRate', profile.success_rate, '%');
            updateStatCard('settingsRankPosition', profile.rank_position);
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

        function getInitials(username) {
            return username.split(' ')
                .map(word => word.charAt(0).toUpperCase())
                .join('')
                .substring(0, 2);
        }

        function saveSettings() {
            const profileData = {
                username: document.getElementById('username').value,
                displayName: document.getElementById('displayName').value,
                email: document.getElementById('email').value,
                bio: document.getElementById('bio').value,
                location: document.getElementById('location').value,
                website: document.getElementById('website').value
            };

            const securityData = {
                currentPassword: document.getElementById('currentPassword').value,
                newPassword: document.getElementById('newPassword').value,
                confirmPassword: document.getElementById('confirmPassword').value
            };

            const avatarInput = document.getElementById('avatarInput');
            const hasNewAvatar = avatarInput.files.length > 0;

            if (hasNewAvatar) {
                const formData = new FormData();
                formData.append('profile_picture', avatarInput.files[0]);

                Swal.fire({
                    title: 'Uploading Profile Picture...',
                    text: 'Please wait while we upload your profile picture',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                fetch('/backend/api/users.php?action=uploadProfilePicture', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        saveProfileData(profileData, securityData);
                    } else {
                        Swal.close();
                        Swal.fire({
                            icon: 'error',
                            title: 'Upload Failed',
                            text: data.message || 'Failed to upload profile picture',
                            confirmButtonColor: '#dc3545',
                            background: '#1a1a1a',
                            color: '#dc3545',
                            confirmButtonText: 'OK'
                        });
                    }
                })
                .catch(error => {
                    Swal.close();
                    console.error('Profile picture upload error:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Upload Error',
                        text: 'Network error occurred while uploading profile picture',
                        confirmButtonColor: '#dc3545',
                        background: '#1a1a1a',
                        color: '#dc3545',
                        confirmButtonText: 'OK'
                    });
                });
            } else {
                saveProfileData(profileData, securityData);
            }
        }

        function saveProfileData(profileData, securityData) {
            Swal.fire({
                title: 'Saving...',
                text: 'Please wait while we save your settings',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            fetch('/backend/api/challenges.php?action=updateUserSettings', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    ...profileData,
                    ...securityData
                })
            })
            .then(response => response.json())
            .then(data => {
                Swal.close();
                
                if (data.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success!',
                        text: 'Settings saved successfully!',
                        confirmButtonColor: '#00ff00',
                        background: '#1a1a1a',
                        color: '#00ff00',
                        confirmButtonText: 'OK'
                    });
                    
                    document.getElementById('currentPassword').value = '';
                    document.getElementById('newPassword').value = '';
                    document.getElementById('confirmPassword').value = '';
                    
                    loadUserProfile();
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: 'Error: ' + data.message,
                        confirmButtonColor: '#dc3545',
                        background: '#1a1a1a',
                        color: '#00ff00',
                        confirmButtonText: 'OK'
                    });
                }
            })
            .catch(error => {
                console.error('Error saving settings:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: 'Network error. Please try again.',
                    confirmButtonColor: '#dc3545',
                    background: '#1a1a1a',
                    color: '#00ff00',
                    confirmButtonText: 'OK'
                });
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