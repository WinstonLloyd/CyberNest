<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CyberNest Admin - Settings</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../../css/admin/dashboard.css">
    <link rel="stylesheet" href="../../css/admin/settings.css">
</head>
<body>
    <!-- Sidebar -->
    <nav class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <h3><i class="fas fa-shield-alt me-2"></i>CYBERNEST</h3>
            <small class="text-muted">Admin Panel</small>
        </div>
        <div class="sidebar-menu">
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link" href="dashboard.php">
                        <i class="fas fa-tachometer-alt"></i>
                        Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="challenges.php">
                        <i class="fas fa-trophy"></i>
                        Challenges
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="leaderboard.php">
                        <i class="fas fa-chart-line"></i>
                        Leaderboard
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="users.php">
                        <i class="fas fa-users"></i>
                        Users
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="settings.php">
                        <i class="fas fa-cog"></i>
                        Settings
                    </a>
                </li>
                <li class="nav-item mt-3">
                    <a class="nav-link" href="#" onclick="logout()">
                        <i class="fas fa-sign-out-alt"></i>
                        Logout
                    </a>
                </li>
            </ul>
        </div>
    </nav>

    <main class="main-content">
        <header class="top-header">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="h3 mb-0">Settings</h1>
                    <small class="text-muted">System configuration & preferences</small>
                </div>
                <div class="d-flex align-items-center">
                    <div class="me-3">
                        <span class="badge bg-success pulse">System Online</span>
                    </div>
                    <div class="dropdown">
                        <button class="btn btn-outline-success btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown">
                            <i class="fas fa-user-circle me-2"></i>Admin
                        </button>
                        <ul class="dropdown-menu dropdown-menu-dark dropdown-menu-end">
                            <li><a class="dropdown-item" href="#profile">Profile</a></li>
                            <li><a class="dropdown-item" href="#settings">Settings</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="#" onclick="logout()">Logout</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </header>

        <div class="container-fluid">
            <div class="settings-header">
                <i class="fas fa-cog settings-icon"></i>
                <h2 class="settings-title">CYBERNEST SETTINGS</h2>
                <p class="settings-subtitle">Configure system preferences and administrative options</p>
            </div>

            <ul class="nav nav-tabs" id="settingsTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="general-tab" data-bs-toggle="tab" data-bs-target="#general" type="button" role="tab">
                        <i class="fas fa-cog me-2"></i>General
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="security-tab" data-bs-toggle="tab" data-bs-target="#security" type="button" role="tab">
                        <i class="fas fa-shield-alt me-2"></i>Security
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="notifications-tab" data-bs-toggle="tab" data-bs-target="#notifications" type="button" role="tab">
                        <i class="fas fa-bell me-2"></i>Notifications
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="appearance-tab" data-bs-toggle="tab" data-bs-target="#appearance" type="button" role="tab">
                        <i class="fas fa-palette me-2"></i>Appearance
                    </button>
                </li>
            </ul>

            <div class="tab-content" id="settingsTabContent">
                <div class="tab-pane fade show active" id="general" role="tabpanel">
                    <div class="settings-section">
                        <h4 class="section-title">System Configuration</h4>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Site Name</label>
                                <input type="text" class="form-control" value="CyberNest" id="siteName">
                                <div class="form-text">The name displayed in the header and title</div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Admin Email</label>
                                <input type="email" class="form-control" value="admin@cybernest.com" id="adminEmail">
                                <div class="form-text">Contact email for administrative matters</div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Default Language</label>
                                <select class="form-select" id="defaultLanguage">
                                    <option value="en" selected>English</option>
                                    <option value="es">Spanish</option>
                                    <option value="fr">French</option>
                                    <option value="de">German</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Timezone</label>
                                <select class="form-select" id="timezone">
                                    <option value="UTC" selected>UTC</option>
                                    <option value="EST">Eastern Time</option>
                                    <option value="PST">Pacific Time</option>
                                    <option value="CET">Central European Time</option>
                                </select>
                            </div>
                        </div>

                        <div class="setting-item">
                            <div class="setting-info">
                                <h5>Maintenance Mode</h5>
                                <p>Temporarily disable user access to the platform</p>
                            </div>
                            <div class="toggle-switch" id="maintenanceMode" onclick="toggleSwitch(this)"></div>
                        </div>

                        <div class="setting-item">
                            <div class="setting-info">
                                <h5>User Registration</h5>
                                <p>Allow new users to register accounts</p>
                            </div>
                            <div class="toggle-switch active" id="userRegistration" onclick="toggleSwitch(this)"></div>
                        </div>
                    </div>
                </div>

                <div class="tab-pane fade" id="security" role="tabpanel">
                    <div class="settings-section">
                        <h4 class="section-title">Security Configuration</h4>
                        
                        <div class="alert-settings">
                            <i class="fas fa-info-circle me-2"></i>
                            Configure security settings to protect your CyberNest platform and user data.
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Session Timeout (minutes)</label>
                                <input type="number" class="form-control" value="30" id="sessionTimeout">
                                <div class="form-text">Automatically log out users after inactivity</div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Password Minimum Length</label>
                                <input type="number" class="form-control" value="8" id="passwordMinLength">
                                <div class="form-text">Minimum characters required for passwords</div>
                            </div>
                        </div>

                        <div class="setting-item">
                            <div class="setting-info">
                                <h5>Two-Factor Authentication</h5>
                                <p>Require 2FA for admin accounts</p>
                            </div>
                            <div class="toggle-switch active" id="twoFactorAuth" onclick="toggleSwitch(this)"></div>
                        </div>

                        <div class="setting-item">
                            <div class="setting-info">
                                <h5>IP Whitelist</h5>
                                <p>Restrict admin access to specific IP addresses</p>
                            </div>
                            <div class="toggle-switch" id="ipWhitelist" onclick="toggleSwitch(this)"></div>
                        </div>

                        <div class="setting-item">
                            <div class="setting-info">
                                <h5>Failed Login Lockout</h5>
                                <p>Lock accounts after multiple failed attempts</p>
                            </div>
                            <div class="toggle-switch active" id="failedLoginLockout" onclick="toggleSwitch(this)"></div>
                        </div>
                    </div>
                </div>

                <div class="tab-pane fade" id="notifications" role="tabpanel">
                    <div class="settings-section">
                        <h4 class="section-title">Notification Preferences</h4>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Email Notifications</label>
                                <input type="email" class="form-control" value="admin@cybernest.com" id="notificationEmail">
                                <div class="form-text">Email address for system notifications</div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Notification Frequency</label>
                                <select class="form-select" id="notificationFrequency">
                                    <option value="immediate" selected>Immediate</option>
                                    <option value="hourly">Hourly Digest</option>
                                    <option value="daily">Daily Digest</option>
                                    <option value="weekly">Weekly Digest</option>
                                </select>
                            </div>
                        </div>

                        <div class="setting-item">
                            <div class="setting-info">
                                <h5>New User Registrations</h5>
                                <p>Receive notifications when new users register</p>
                            </div>
                            <div class="toggle-switch active" id="newUserNotifications" onclick="toggleSwitch(this)"></div>
                        </div>

                        <div class="setting-item">
                            <div class="setting-info">
                                <h5>Challenge Submissions</h5>
                                <p>Notify when users complete challenges</p>
                            </div>
                            <div class="toggle-switch" id="challengeNotifications" onclick="toggleSwitch(this)"></div>
                        </div>

                        <div class="setting-item">
                            <div class="setting-info">
                                <h5>Security Alerts</h5>
                                <p>Receive security-related notifications</p>
                            </div>
                            <div class="toggle-switch active" id="securityNotifications" onclick="toggleSwitch(this)"></div>
                        </div>

                        <div class="setting-item">
                            <div class="setting-info">
                                <h5>System Maintenance</h5>
                                <p>Notifications about system updates and maintenance</p>
                            </div>
                            <div class="toggle-switch active" id="maintenanceNotifications" onclick="toggleSwitch(this)"></div>
                        </div>
                    </div>
                </div>

                <div class="tab-pane fade" id="appearance" role="tabpanel">
                    <div class="settings-section">
                        <h4 class="section-title">Appearance Configuration</h4>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Primary Color</label>
                                <input type="color" class="form-control" value="#00ff00" id="primaryColor">
                                <div class="form-text">Main accent color for the interface</div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Secondary Color</label>
                                <input type="color" class="form-control" value="#00cc00" id="secondaryColor">
                                <div class="form-text">Secondary accent color</div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Theme</label>
                                <select class="form-select" id="theme">
                                    <option value="cyber" selected>Cyber Terminal</option>
                                    <option value="dark">Dark Mode</option>
                                    <option value="light">Light Mode</option>
                                    <option value="matrix">Matrix</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Font Size</label>
                                <select class="form-select" id="fontSize">
                                    <option value="small">Small</option>
                                    <option value="medium" selected>Medium</option>
                                    <option value="large">Large</option>
                                    <option value="extra-large">Extra Large</option>
                                </select>
                            </div>
                        </div>

                        <div class="setting-item">
                            <div class="setting-info">
                                <h5>Animations</h5>
                                <p>Enable interface animations and transitions</p>
                            </div>
                            <div class="toggle-switch active" id="animations" onclick="toggleSwitch(this)"></div>
                        </div>

                        <div class="setting-item">
                            <div class="setting-info">
                                <h5>Sound Effects</h5>
                                <p>Play sound effects for interactions</p>
                            </div>
                            <div class="toggle-switch" id="soundEffects" onclick="toggleSwitch(this)"></div>
                        </div>

                        <div class="setting-item">
                            <div class="setting-info">
                                <h5>Compact Mode</h5>
                                <p>Use a more compact interface layout</p>
                            </div>
                            <div class="toggle-switch" id="compactMode" onclick="toggleSwitch(this)"></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="d-flex justify-content-end gap-2">
                <button class="btn btn-secondary-settings" onclick="resetSettings()">
                    <i class="fas fa-undo me-2"></i>Reset to Defaults
                </button>
                <button class="btn btn-settings" onclick="saveSettings()">
                    <i class="fas fa-save me-2"></i>Save Settings
                </button>
            </div>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="/javascript/admin/settings.js"></script>
</body>
</html>
