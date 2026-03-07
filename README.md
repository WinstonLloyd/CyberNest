# CyberNest

A comprehensive cybersecurity learning platform with hacking challenges, user management, and real-time progress tracking.

## 🚀 Features

### 🎯 Challenge Management
- **Multiple Categories**: Web Security, Binary Exploitation, Cryptography, Digital Forensics, OSINT
- **Difficulty Levels**: Beginner, Intermediate, Expert
- **File Upload Support**: Upload challenge files, images, and documents
- **Flag System**: Secure flag submission and validation
- **Progress Tracking**: Real-time attempt monitoring and completion statistics

### 👥 User Management
- **Role-Based Access**: Admin and User roles
- **Profile System**: User profiles with points, rankings, and achievements
- **Session Management**: Secure authentication with token-based sessions
- **Progress Analytics**: Detailed performance metrics and skill tracking

### 🏆 Leaderboard & Gamification
- **Real-time Rankings**: Live leaderboard updates
- **Skill Categories**: Track performance across different cybersecurity domains
- **Achievement System**: Unlock achievements based on completed challenges
- **Success Metrics**: Track completion rates and point accumulation

### 🛡 Security Features
- **Secure Authentication**: Password hashing and session management
- **Input Validation**: Comprehensive input sanitization and validation
- **SQL Injection Protection**: Prepared statements with parameterized queries
- **XSS Protection**: Content Security Policy headers and output escaping
- **CSRF Protection**: Token-based request validation

## 🛠️ Technology Stack

### Backend
- **PHP 8.2+**: Core backend logic with modern features
- **MySQL**: Database for data persistence
- **PDO**: Secure database interactions with prepared statements
- **RESTful API**: Clean API endpoints for frontend integration
- **File Upload**: Secure file handling with validation and storage

### Frontend
- **HTML5/CSS3**: Modern, responsive web interface
- **JavaScript ES6+**: Dynamic frontend with real-time updates
- **Bootstrap 5**: Professional UI framework
- **SweetAlert2**: Beautiful alert and notification system
- **AJAX/Fetch**: Asynchronous data handling

### Security
- **Input Validation**: Server-side and client-side validation
- **Output Encoding**: Proper HTML entity encoding
- **HTTPS Ready**: SSL/TLS support for secure connections
- **Rate Limiting**: Protection against brute force attacks
- **Audit Logging**: Comprehensive security event logging

## 📁 Project Structure

```
cybernest/
├── backend/
│   ├── api/                    # API endpoints
│   ├── config/                  # Database configuration
│   ├── controllers/              # Business logic controllers
│   ├── models/                   # Data models
│   └── migrations/               # Database migrations
├── uploads/                     # File upload directory
│   ├── profile_pictures/         # User profile pictures
│   └── challenges/              # Challenge files
├── views/
│   ├── admin/                   # Admin interface
│   ├── users/                   # User interface
│   └── terminal.html            # Terminal interface
├── css/                         # Stylesheets
├── javascript/                   # Frontend scripts
└── index.php                     # Entry point
```

## 🚀 Quick Start

### Prerequisites
- **PHP 8.2+** with PDO extension
- **MySQL 5.7+** or MariaDB 10.2+
- **Apache/Nginx** web server
- **Composer** (optional) for dependency management

### Installation

1. **Clone Repository**
   ```bash
   git clone https://github.com/WinstonLloyd/CyberNest.git
   cd CyberNest
   ```

2. **Database Setup**
   ```bash
   # Run migration script
   php backend/migrations/migrate.php
   ```

3. **Configure Web Server**
   - Point document root to `htdocs/` directory
   - Ensure PHP extensions are enabled
   - Configure virtual host if needed

4. **Access Application**
   - **Admin Panel**: `http://localhost/views/admin/`
   - **User Portal**: `http://localhost/views/users/`
   - **Default Admin**: `admin` / `admin123`

### Default Credentials
⚠️ **Important**: Change default credentials in production!

- **Username**: `admin`
- **Password**: `admin123`
- **Email**: `admin@cybernest.local`

### Database Configuration
Edit `backend/config/database.php` to configure your database:

```php
class Database {
    private $host = 'localhost';
    private $db_name = 'cybernest';
    private $username = 'root';
    private $password = '';
}
```

### File Upload Settings
- **Max File Size**: 10MB per upload
- **Allowed Formats**: ZIP, TAR, TXT, PDF, DOC, DOCX, JPG, PNG, GIF, BMP, WEBP, SVG
- **Storage Path**: `uploads/challenges/`
- **Unique Filenames**: Prevents file overwrites

## 🛡️ Security Considerations

### Production Deployment
1. **Change Default Credentials**: Immediately update admin credentials
2. **Enable HTTPS**: Configure SSL/TLS certificates
3. **Database Security**: Use strong database passwords
4. **File Upload Limits**: Configure appropriate upload limits
5. **Regular Updates**: Keep dependencies updated
6. **Backup Strategy**: Implement regular database backups
7. **Access Control**: Restrict admin access by IP if needed
8. **Audit Logging**: Monitor security events

### Development Guidelines
1. **Input Validation**: Always validate and sanitize user input
2. **Error Handling**: Never expose sensitive information in error messages
3. **SQL Security**: Use prepared statements exclusively
4. **File Security**: Validate file types and scan for malware
5. **Session Security**: Use secure, HttpOnly cookies
6. **CSRF Protection**: Implement token-based protection
7. **XSS Prevention**: Properly encode all output
8. **Rate Limiting**: Implement request rate limiting

## 📊 API Endpoints

### Authentication
- `POST /backend/login.php` - User login
- `POST /backend/logout.php` - User logout
- `POST /backend/register.php` - User registration

### Challenges
- `GET /backend/api/challenges.php?action=getAll` - List all challenges
- `GET /backend/api/challenges.php?action=getById&id={id}` - Get specific challenge
- `POST /backend/api/challenges.php?action=create` - Create new challenge (with file upload)
- `POST /backend/api/challenges.php?action=update` - Update challenge (with file upload)
- `DELETE /backend/api/challenges.php?action=delete&id={id}` - Delete challenge
- `POST /backend/api/challenges.php?action=submitFlag` - Submit challenge flag

### User Management
- `GET /backend/api/challenges.php?action=getProfile` - Get user profile
- `POST /backend/api/challenges.php?action=updateUserSettings` - Update user settings
- `GET /backend/api/challenges.php?action=getUserSkills` - Get user skill statistics

### Statistics
- `GET /backend/api/challenges.php?action=stats` - Challenge statistics
- `GET /backend/api/challenges.php?action=getPlatformStats` - Platform-wide statistics
- `GET /backend/api/challenges.php?action=getTopPerformers` - Leaderboard data

## 🤝 Contributing

We welcome contributions! Please follow these guidelines:

1. **Fork the repository** and create a feature branch
2. **Follow coding standards** and maintain code quality
3. **Test thoroughly** before submitting pull requests
4. **Document changes** with clear commit messages
5. **Security first**: Consider security implications of all changes

### Development Setup
```bash
git clone https://github.com/your-username/CyberNest.git
cd CyberNest

composer install

php -S localhost:8000
```

## 📝 License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

## 🆘 Support & Community

- **Documentation**: Check the `docs/` directory for detailed guides
- **Issues**: Report bugs and feature requests on GitHub Issues
- **Discussions**: Join our community discussions
- **Updates**: Follow for announcements and updates

---

**Built with ❤️ for the cybersecurity community**
