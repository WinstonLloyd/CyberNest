<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CyberNest Admin - Settings</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../../css/admin/dashboard.css">
    <style>
        .settings-container {
            background: linear-gradient(135deg, rgba(0, 255, 0, 0.05) 0%, rgba(0, 255, 0, 0.02) 100%);
            border: 1px solid var(--primary-color);
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 20px;
        }

        .settings-header {
            text-align: center;
            margin-bottom: 30px;
        }

        .settings-title {
            color: var(--primary-color);
            font-size: 1.8rem;
            font-weight: bold;
            text-shadow: 0 0 15px rgba(0, 255, 0, 0.5);
            margin-bottom: 8px;
        }

        .settings-subtitle {
            color: var(--muted-text);
            font-size: 0.9rem;
        }

        .settings-icon {
            font-size: 3rem;
            color: var(--primary-color);
            margin-bottom: 20px;
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0% { opacity: 1; transform: scale(1); }
            50% { opacity: 0.7; transform: scale(1.1); }
            100% { opacity: 1; transform: scale(1); }
        }

        .settings-tabs {
            margin-bottom: 30px;
        }

        .nav-tabs .nav-link {
            color: var(--light-text);
            border: 1px solid var(--primary-color);
            background: rgba(0, 0, 0, 0.8);
            margin-right: 5px;
            transition: all 0.3s ease;
        }

        .nav-tabs .nav-link:hover {
            background: rgba(0, 255, 0, 0.1);
            color: var(--primary-color);
            border-color: var(--primary-color);
        }

        .nav-tabs .nav-link.active {
            background: rgba(0, 255, 0, 0.2);
            color: var(--primary-color);
            border-color: var(--primary-color);
        }

        .settings-section {
            background: rgba(0, 0, 0, 0.8);
            border: 1px solid var(--primary-color);
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 20px;
        }

        .section-title {
            color: var(--primary-color);
            font-size: 1.2rem;
            font-weight: 600;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 1px solid rgba(0, 255, 0, 0.3);
        }

        .form-control, .form-select {
            background: rgba(0, 0, 0, 0.8);
            border: 1px solid var(--primary-color);
            color: var(--primary-color);
        }

        .form-control:focus, .form-select:focus {
            background: rgba(0, 0, 0, 0.8);
            border-color: var(--primary-color);
            box-shadow: 0 0 10px rgba(0, 255, 0, 0.3);
            color: var(--primary-color);
        }

        .form-label {
            color: var(--primary-color);
            font-weight: 500;
        }

        .form-text {
            color: var(--muted-text);
            font-size: 0.85rem;
        }

        .btn-settings {
            background: var(--primary-color);
            color: var(--darker-bg);
            border: none;
            padding: 10px 20px;
            border-radius: 6px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-settings:hover {
            background: var(--secondary-color);
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(0, 255, 0, 0.4);
        }

        .btn-secondary-settings {
            background: transparent;
            color: var(--primary-color);
            border: 1px solid var(--primary-color);
            padding: 10px 20px;
            border-radius: 6px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-secondary-settings:hover {
            background: rgba(0, 255, 0, 0.1);
            transform: translateY(-2px);
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

        .toggle-switch::after {
            content: '';
            position: absolute;
            width: 26px;
            height: 26px;
            background: white;
            border-radius: 50%;
            top: 2px;
            left: 2px;
            transition: all 0.3s ease;
        }

        .toggle-switch.active::after {
            left: 32px;
        }

        .setting-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 0;
            border-bottom: 1px solid rgba(0, 255, 0, 0.1);
        }

        .setting-item:last-child {
            border-bottom: none;
        }

        .setting-info h5 {
            color: var(--primary-color);
            font-size: 1rem;
            margin-bottom: 5px;
        }

        .setting-info p {
            color: var(--muted-text);
            font-size: 0.85rem;
            margin: 0;
        }

        .alert-settings {
            background: rgba(0, 255, 0, 0.1);
            border: 1px solid var(--primary-color);
            color: var(--primary-color);
            border-radius: 6px;
            padding: 15px;
            margin-bottom: 20px;
        }

        @media (max-width: 768px) {
            .settings-title {
                font-size: 2rem;
            }
            
            .nav-tabs {
                flex-direction: column;
            }
            
            .nav-tabs .nav-link {
                margin-right: 0;
                margin-bottom: 5px;
            }
            
            .setting-item {
                flex-direction: column;
                align-items: flex-start;
                gap: 10px;
            }
        }
    </style>
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
                    <a class="nav-link" href="#logout">
                        <i class="fas fa-sign-out-alt"></i>
                        Logout
                    </a>
                </li>
            </ul>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="main-content">
        <!-- Top Header -->
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
                            <li><a class="dropdown-item" href="#logout">Logout</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </header>

        <!-- Settings Content -->
        <div class="container-fluid">
            <!-- Header -->
            <div class="settings-header">
                <i class="fas fa-cog settings-icon"></i>
                <h2 class="settings-title">CYBERNEST SETTINGS</h2>
                <p class="settings-subtitle">Configure system preferences and administrative options</p>
            </div>

            <!-- Settings Tabs -->
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

            <!-- Tab Content -->
            <div class="tab-content" id="settingsTabContent">
                <!-- General Settings -->
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

                <!-- Security Settings -->
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

                <!-- Notifications Settings -->
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

                <!-- Appearance Settings -->
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

            <!-- Save Buttons -->
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
    <script src="../../javascript/admin-dashboard.js"></script>
    <script>
        // Settings functionality
        document.addEventListener('DOMContentLoaded', function() {
            // Load settings from backend
            loadSettings();
            
            // Initialize tooltips
            const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            const tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });
        });

        // Load settings from backend
        function loadSettings() {
            fetch('/backend/api/settings.php?action=getAll')
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const settings = data.settings;
                        
                        // Update site name
                        document.getElementById('siteName').value = settings.siteName;
                        document.getElementById('adminEmail').value = settings.adminEmail;
                        document.getElementById('defaultLanguage').value = settings.defaultLanguage;
                        document.getElementById('timezone').value = settings.timezone;
                        document.getElementById('sessionTimeout').value = settings.sessionTimeout;
                        document.getElementById('passwordMinLength').value = settings.passwordMinLength;
                        document.getElementById('primaryColor').value = settings.primaryColor;
                        document.getElementById('secondaryColor').value = settings.secondaryColor;
                        document.getElementById('theme').value = settings.theme;
                        document.getElementById('fontSize').value = settings.fontSize;
                        document.getElementById('notificationEmail').value = settings.notificationEmail;
                        document.getElementById('notificationFrequency').value = settings.notificationFrequency;
                        
                        // Update page title and header
                        document.title = settings.siteName + ' Admin - Settings';
                        
                        // Update sidebar header
                        const sidebarHeader = document.querySelector('.sidebar-header h3');
                        if (sidebarHeader) {
                            sidebarHeader.innerHTML = '<i class="fas fa-shield-alt me-2"></i>' + settings.siteName;
                        }
                        
                        // Update settings header
                        const settingsTitle = document.querySelector('.settings-title');
                        if (settingsTitle) {
                            settingsTitle.textContent = settings.siteName + ' SETTINGS';
                        }
                    }
                })
                .catch(error => {
                    console.error('Error loading settings:', error);
                });
        }

        // Toggle switch functionality
        window.toggleSwitch = function(element) {
            element.classList.toggle('active');
        };

        // Save settings
        window.saveSettings = function() {
            const settings = {
                siteName: document.getElementById('siteName').value,
                adminEmail: document.getElementById('adminEmail').value,
                defaultLanguage: document.getElementById('defaultLanguage').value,
                timezone: document.getElementById('timezone').value,
                sessionTimeout: document.getElementById('sessionTimeout').value,
                passwordMinLength: document.getElementById('passwordMinLength').value,
                primaryColor: document.getElementById('primaryColor').value,
                secondaryColor: document.getElementById('secondaryColor').value,
                theme: document.getElementById('theme').value,
                fontSize: document.getElementById('fontSize').value,
                notificationEmail: document.getElementById('notificationEmail').value,
                notificationFrequency: document.getElementById('notificationFrequency').value,
                maintenanceMode: document.getElementById('maintenanceMode').classList.contains('active'),
                userRegistration: document.getElementById('userRegistration').classList.contains('active'),
                twoFactorAuth: document.getElementById('twoFactorAuth').classList.contains('active'),
                ipWhitelist: document.getElementById('ipWhitelist').classList.contains('active'),
                failedLoginLockout: document.getElementById('failedLoginLockout').classList.contains('active'),
                newUserNotifications: document.getElementById('newUserNotifications').classList.contains('active'),
                challengeNotifications: document.getElementById('challengeNotifications').classList.contains('active'),
                securityNotifications: document.getElementById('securityNotifications').classList.contains('active'),
                maintenanceNotifications: document.getElementById('maintenanceNotifications').classList.contains('active'),
                animations: document.getElementById('animations').classList.contains('active'),
                soundEffects: document.getElementById('soundEffects').classList.contains('active'),
                compactMode: document.getElementById('compactMode').classList.contains('active')
            };

            fetch('/backend/api/settings.php?action=save', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(settings)
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Update page title and header with new site name
                    document.title = settings.siteName + ' Admin - Settings';
                    
                    // Update sidebar header
                    const sidebarHeader = document.querySelector('.sidebar-header h3');
                    if (sidebarHeader) {
                        sidebarHeader.innerHTML = '<i class="fas fa-shield-alt me-2"></i>' + settings.siteName;
                    }
                    
                    // Update settings header
                    const settingsTitle = document.querySelector('.settings-title');
                    if (settingsTitle) {
                        settingsTitle.textContent = settings.siteName + ' SETTINGS';
                    }
                    
                    // Show success message
                    const alertDiv = document.createElement('div');
                    alertDiv.className = 'alert alert-success alert-dismissible fade show';
                    alertDiv.innerHTML = `
                        <i class="fas fa-check-circle me-2"></i>
                        Settings saved successfully!
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    `;
                    
                    const container = document.querySelector('.container-fluid');
                    container.insertBefore(alertDiv, container.firstChild);
                    
                    // Auto-dismiss after 3 seconds
                    setTimeout(() => {
                        alertDiv.remove();
                    }, 3000);
                } else {
                    // Show error message
                    const alertDiv = document.createElement('div');
                    alertDiv.className = 'alert alert-danger alert-dismissible fade show';
                    alertDiv.innerHTML = `
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        Failed to save settings: ${data.message}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    `;
                    
                    const container = document.querySelector('.container-fluid');
                    container.insertBefore(alertDiv, container.firstChild);
                    
                    // Auto-dismiss after 3 seconds
                    setTimeout(() => {
                        alertDiv.remove();
                    }, 3000);
                }
            })
            .catch(error => {
                console.error('Error saving settings:', error);
                
                // Show error message
                const alertDiv = document.createElement('div');
                alertDiv.className = 'alert alert-danger alert-dismissible fade show';
                alertDiv.innerHTML = `
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    Failed to save settings. Please try again.
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                `;
                
                const container = document.querySelector('.container-fluid');
                container.insertBefore(alertDiv, container.firstChild);
                
                // Auto-dismiss after 3 seconds
                setTimeout(() => {
                    alertDiv.remove();
                }, 3000);
            });
        };

        // Reset settings
        window.resetSettings = function() {
            if (confirm('Are you sure you want to reset all settings to their database values?')) {
                // Reload settings from database
                loadSettings();
                
                // Reset toggle switches to default states
                document.querySelectorAll('.toggle-switch').forEach(toggle => {
                    toggle.classList.remove('active');
                });
                
                // Set default active states
                document.getElementById('userRegistration').classList.add('active');
                document.getElementById('twoFactorAuth').classList.add('active');
                document.getElementById('failedLoginLockout').classList.add('active');
                document.getElementById('newUserNotifications').classList.add('active');
                document.getElementById('securityNotifications').classList.add('active');
                document.getElementById('maintenanceNotifications').classList.add('active');
                document.getElementById('animations').classList.add('active');
                
                // Show success message
                const alertDiv = document.createElement('div');
                alertDiv.className = 'alert alert-info alert-dismissible fade show';
                alertDiv.innerHTML = `
                    <i class="fas fa-info-circle me-2"></i>
                    Settings reset to database values!
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                `;
                
                const container = document.querySelector('.container-fluid');
                container.insertBefore(alertDiv, container.firstChild);
                
                // Auto-dismiss after 3 seconds
                setTimeout(() => {
                    alertDiv.remove();
                }, 3000);
            }
        };
    </script>
</body>
</html>
