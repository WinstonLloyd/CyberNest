document.addEventListener('DOMContentLoaded', function() {
    loadSettings();
    
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    const tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
});
function loadSettings() {
    fetch('/backend/api/settings.php?action=getAll')
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const settings = data.settings;
                
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
                
                document.title = settings.siteName + ' Admin - Settings';
                
                const sidebarHeader = document.querySelector('.sidebar-header h3');
                if (sidebarHeader) {
                    sidebarHeader.innerHTML = '<i class="fas fa-shield-alt me-2"></i>' + settings.siteName;
                }
                
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
window.toggleSwitch = function(element) {
    element.classList.toggle('active');
};
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
            document.title = settings.siteName + ' Admin - Settings';
            
            const sidebarHeader = document.querySelector('.sidebar-header h3');
            if (sidebarHeader) {
                sidebarHeader.innerHTML = '<i class="fas fa-shield-alt me-2"></i>' + settings.siteName;
            }
            
            const settingsTitle = document.querySelector('.settings-title');
            if (settingsTitle) {
                settingsTitle.textContent = settings.siteName + ' SETTINGS';
            }
            
            const alertDiv = document.createElement('div');
            alertDiv.className = 'alert alert-success alert-dismissible fade show';
            alertDiv.innerHTML = `
                <i class="fas fa-check-circle me-2"></i>
                Settings saved successfully!
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            `;
            
            const container = document.querySelector('.container-fluid');
            container.insertBefore(alertDiv, container.firstChild);
            
            setTimeout(() => {
                alertDiv.remove();
            }, 3000);
        } else {
            const alertDiv = document.createElement('div');
            alertDiv.className = 'alert alert-danger alert-dismissible fade show';
            alertDiv.innerHTML = `
                <i class="fas fa-exclamation-triangle me-2"></i>
                Failed to save settings: ${data.message}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            `;
            
            const container = document.querySelector('.container-fluid');
            container.insertBefore(alertDiv, container.firstChild);
            
            setTimeout(() => {
                alertDiv.remove();
            }, 3000);
        }
    })
    .catch(error => {
        console.error('Error saving settings:', error);
        
        const alertDiv = document.createElement('div');
        alertDiv.className = 'alert alert-danger alert-dismissible fade show';
        alertDiv.innerHTML = `
            <i class="fas fa-exclamation-triangle me-2"></i>
            Failed to save settings. Please try again.
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        `;
        
        const container = document.querySelector('.container-fluid');
        container.insertBefore(alertDiv, container.firstChild);
        
        setTimeout(() => {
            alertDiv.remove();
        }, 3000);
    });
};
window.resetSettings = function() {
    if (confirm('Are you sure you want to reset all settings to their database values?')) {
        loadSettings();
        
        document.querySelectorAll('.toggle-switch').forEach(toggle => {
            toggle.classList.remove('active');
        });
        
        document.getElementById('userRegistration').classList.add('active');
        document.getElementById('twoFactorAuth').classList.add('active');
        document.getElementById('failedLoginLockout').classList.add('active');
        document.getElementById('newUserNotifications').classList.add('active');
        document.getElementById('securityNotifications').classList.add('active');
        document.getElementById('maintenanceNotifications').classList.add('active');
        document.getElementById('animations').classList.add('active');
        
        const alertDiv = document.createElement('div');
        alertDiv.className = 'alert alert-info alert-dismissible fade show';
        alertDiv.innerHTML = `
            <i class="fas fa-info-circle me-2"></i>
            Settings reset to database values!
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        `;
        
        const container = document.querySelector('.container-fluid');
        container.insertBefore(alertDiv, container.firstChild);
        
        setTimeout(() => {
            alertDiv.remove();
        }, 3000);
    }
};
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
        color: '#00ff00'
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
                        timer: 3000,
                        showConfirmButton: false
                    }).then(() => {
                        window.location.href = '../../index.php';
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
                    color: '#00ff00'
                }).then(() => {
                    window.location.href = '../../index.php';
                });
            });
        }
    });
}