<?php
session_start();

if (isset($_COOKIE['cybernest_session']) && !empty($_COOKIE['cybernest_session'])) {
    try {
        require_once __DIR__ . '/backend/config/database.php';
        require_once __DIR__ . '/backend/models/User.php';
        
        $database = new Database();
        $db = $database->getConnection();
        
        $query = "SELECT u.id, u.username, u.email, u.display_name, u.role 
                  FROM users u 
                  JOIN user_sessions s ON u.id = s.user_id 
                  WHERE s.session_token = :session_token 
                  AND s.expires_at > NOW() 
                  AND u.is_active = TRUE 
                  LIMIT 1";
        
        $stmt = $db->prepare($query);
        $stmt->bindParam(':session_token', $_COOKIE['cybernest_session']);
        $stmt->execute();
        
        if ($stmt->rowCount() > 0) {
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if ($user['role'] === 'admin') {
                header('Location: views/admin/dashboard.php');
            } else {
                header('Location: views/users/home.php');
            }
            exit;
        }
    } catch (Exception $e) {
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CyberNest - Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body class="min-vh-100 d-flex align-items-center justify-content-center matrix-bg">
    <canvas id="matrix" class="matrix-rain"></canvas>
    
    <div class="container px-4 py-8" style="max-width: 400px;">
        <!-- Login Form -->
        <div id="loginForm" class="terminal-border rounded p-4 position-relative overflow-hidden">
            <!-- Corner decorations -->
            <div class="corner-decoration corner-top-left"></div>
            <div class="corner-decoration corner-top-right"></div>
            <div class="corner-decoration corner-bottom-left"></div>
            <div class="corner-decoration corner-bottom-right"></div>
            
            <!-- Data streams -->
            <div class="data-stream stream-top">01001101 11010010 00110101</div>
            <div class="data-stream stream-right">10101001 01101010 11001100</div>
            <div class="data-stream stream-bottom">00110011 10100101 01011010</div>
            
            <div class="scan-line"></div>
            
            <div class="login-header">
                <h1 class="hacker-font display-6 fw-bold glitch mb-2">CYBERNEST</h1>
                <p class="text-green-400 small">ACCESS GRANTED REQUIRED</p>
            </div>
            
            <div class="form-section">
                <form id="loginFormElement">
                    <div class="enhanced-input-group">
                        <label class="form-label text-green-400 small">USERNAME:</label>
                        <input type="text" id="username" class="form-control input-field" 
                               placeholder="root@cybernest:~$" required>
                    </div>
                    
                    <div class="enhanced-input-group">
                        <label class="form-label text-green-400 small">PASSWORD:</label>
                        <input type="password" id="password" class="form-control input-field" 
                               placeholder="••••••••••" required>
                    </div>
                    
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div class="form-check">
                            <input type="checkbox" id="remember" class="form-check-input">
                            <label class="form-check-label text-green-400 small ms-2" for="remember">
                                REMEMBER SESSION
                            </label>
                        </div>
                        <a href="#" onclick="showForgotPassword()" class="text-green-400 small text-decoration-none">
                            FORGOT?
                        </a>
                    </div>
                    
                    <button type="submit" class="btn btn-success w-full py-2 rounded btn-hacker btn-full-width">
                        INITIALIZE ACCESS
                    </button>
                    
                    <div class="text-center mt-3">
                        <p class="text-green-400 small">
                            NO ACCESS? <a href="#" onclick="showRegister()" class="text-green-300 text-decoration-none" id="registerLink">REGISTER NOW</a>
                        </p>
                    </div>
                </form>
            </div>
            
            <div id="statusMessage" class="mt-3 text-center small d-none"></div>
        </div>
        
        <!-- Registration Form -->
        <div id="registerForm" class="terminal-border rounded p-4 position-relative overflow-hidden d-none compact-form">
            <!-- Corner decorations -->
            <div class="corner-decoration corner-top-left"></div>
            <div class="corner-decoration corner-top-right"></div>
            <div class="corner-decoration corner-bottom-left"></div>
            <div class="corner-decoration corner-bottom-right"></div>
            
            <!-- Data streams -->
            <div class="data-stream stream-top">11010010 00110101 01001101</div>
            <div class="data-stream stream-right">01101010 10100101 11001100</div>
            <div class="data-stream stream-bottom">10100101 01011010 00110011</div>
            
            <div class="scan-line"></div>
            
            <div class="login-header">
                <h1 class="hacker-font display-6 fw-bold glitch mb-2">NEW HACKER</h1>
                <p class="text-green-400 small">CREATE NEW IDENTITY</p>
            </div>
            
            <div class="form-section">
                <form id="registerFormElement">
                    <div class="enhanced-input-group">
                        <label class="form-label text-green-400 small">CallSign:</label>
                        <input type="text" id="regUsername" class="form-control input-field" 
                               placeholder="Choose your callsign" required>
                    </div>
                    
                    <div class="enhanced-input-group">
                        <label class="form-label text-green-400 small">Email:</label>
                        <input type="email" id="regEmail" class="form-control input-field" 
                               placeholder="user@matrix.domain" required>
                    </div>
                    
                    <div class="enhanced-input-group">
                        <label class="form-label text-green-400 small">Password:</label>
                        <input type="password" id="regPassword" class="form-control input-field" 
                               placeholder="Create password" required>
                    </div>
                    
                    <div class="enhanced-input-group">
                        <label class="form-label text-green-400 small">Confirm Password:</label>
                        <input type="password" id="regConfirmPassword" class="form-control input-field" 
                               placeholder="Confirm password" required>
                    </div>
                    
                    <div class="mb-3">
                        <div class="form-check">
                            <input type="checkbox" id="agreeTerms" class="form-check-input" required>
                            <label class="form-check-label text-green-400 small ms-2" for="agreeTerms">
                                I ACCEPT THE PROTOCOLS
                            </label>
                        </div>
                    </div>
                    
                    <button type="submit" class="btn btn-success w-full py-2 rounded btn-hacker">
                        GENERATE IDENTITY
                    </button>
                    
                    <div class="text-center mt-3">
                        <p class="text-green-400 small">
                            EXISTING USER? <a href="#" onclick="showLogin()" class="text-green-300 text-decoration-none">LOGIN NOW</a>
                        </p>
                    </div>
                </form>
            </div>
        </div>
        
        <!-- Terminal Access -->
        <div id="terminalAccess" class="terminal-border rounded p-4 d-none">
            <div class="text-center mb-4">
                <h1 class="hacker-font h4 fw-bold text-green-400 mb-2">ACCESS GRANTED</h1>
                <p class="text-green-300">Welcome to CyberNest</p>
            </div>
            
            <div class="text-center">
                <button onclick="enterTerminal()" class="btn btn-success px-4 py-2 rounded btn-hacker">
                    LAUNCH TERMINAL
                </button>
            </div>
        </div>
    </div>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="javascript/login.js"></script>
</html>