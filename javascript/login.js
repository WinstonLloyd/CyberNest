// Matrix rain effect
const canvas = document.getElementById('matrix');
const ctx = canvas.getContext('2d');

canvas.width = window.innerWidth;
canvas.height = window.innerHeight;

const matrix = "ABCDEFGHIJKLMNOPQRSTUVWXYZ123456789@#$%^&*()*&^%+-/~{[|`]}";
const matrixArray = matrix.split("");

const fontSize = 10;
const columns = canvas.width / fontSize;

const drops = [];
for(let x = 0; x < columns; x++) {
    drops[x] = 1;
}

function drawMatrix() {
    ctx.fillStyle = 'rgba(0, 0, 0, 0.04)';
    ctx.fillRect(0, 0, canvas.width, canvas.height);
    
    ctx.fillStyle = '#0f0';
    ctx.font = fontSize + 'px monospace';
    
    for(let i = 0; i < drops.length; i++) {
        const text = matrixArray[Math.floor(Math.random() * matrixArray.length)];
        ctx.fillText(text, i * fontSize, drops[i] * fontSize);
        
        if(drops[i] * fontSize > canvas.height && Math.random() > 0.975) {
            drops[i] = 0;
        }
        drops[i]++;
    }
}

setInterval(drawMatrix, 35);

// Form handling
function showLogin() {
    document.getElementById('loginForm').classList.remove('hidden');
    document.getElementById('registerForm').classList.add('hidden');
    document.getElementById('terminalAccess').classList.add('hidden');
}

function showRegister() {
    document.getElementById('loginForm').classList.add('hidden');
    document.getElementById('registerForm').classList.remove('hidden');
    document.getElementById('terminalAccess').classList.add('hidden');
}

function showForgotPassword() {
    showMessage('Password recovery initiated. Check your email matrix.', 'info');
}

function showMessage(message, type = 'error') {
    const statusDiv = document.getElementById('statusMessage');
    const regStatusDiv = document.getElementById('regStatusMessage');
    
    if (document.getElementById('loginForm').classList.contains('hidden')) {
        regStatusDiv.textContent = message;
        regStatusDiv.classList.remove('hidden');
        regStatusDiv.className = `mt-4 text-center text-sm ${type === 'error' ? 'text-red-400' : 'text-green-400'}`;
    } else {
        statusDiv.textContent = message;
        statusDiv.classList.remove('hidden');
        statusDiv.className = `mt-4 text-center text-sm ${type === 'error' ? 'text-red-400' : 'text-green-400'}`;
    }
    
    setTimeout(() => {
        statusDiv.classList.add('hidden');
        regStatusDiv.classList.add('hidden');
    }, 3000);
}

// Login form submission
document.getElementById('loginFormElement').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const username = document.getElementById('username').value;
    const password = document.getElementById('password').value;
    const remember = document.getElementById('remember').checked;
    
    // Simulate authentication
    if (username && password) {
        if (username === 'admin' && password === 'cyber2025') {
            showMessage('Authentication successful. Access granted.', 'success');
            setTimeout(() => {
                document.getElementById('loginForm').classList.add('hidden');
                document.getElementById('terminalAccess').classList.remove('hidden');
            }, 1500);
        } else if (username === 'root' && password === 'toor') {
            showMessage('Root access detected. Elevated privileges granted.', 'success');
            setTimeout(() => {
                document.getElementById('loginForm').classList.add('hidden');
                document.getElementById('terminalAccess').classList.remove('hidden');
            }, 1500);
        } else {
            showMessage('Access denied. Invalid credentials.', 'error');
            // Add glitch effect
            document.body.style.animation = 'glitch 0.5s';
            setTimeout(() => {
                document.body.style.animation = '';
            }, 500);
        }
    } else {
        showMessage('Please enter username and password.', 'error');
    }
});

// Registration form submission
document.getElementById('registerFormElement').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const username = document.getElementById('regUsername').value;
    const password = document.getElementById('regPassword').value;
    const confirmPassword = document.getElementById('regConfirmPassword').value;
    const email = document.getElementById('regEmail').value;
    const agreeTerms = document.getElementById('agreeTerms').checked;
    
    if (!username || !password || !email || !agreeTerms) {
        showMessage('All fields are required. Please complete the form.', 'error');
        return;
    }
    
    if (password !== confirmPassword) {
        showMessage('Encryption keys do not match.', 'error');
        return;
    }
    
    if (password.length < 8) {
        showMessage('Encryption key must be at least 8 characters.', 'error');
        return;
    }
    
    // Simulate registration
    showMessage('Identity created successfully. Redirecting to login...', 'success');
    setTimeout(() => {
        showLogin();
    }, 2000);
});

// Window resize handler
window.addEventListener('resize', () => {
    canvas.width = window.innerWidth;
    canvas.height = window.innerHeight;
});

// Add keyboard shortcuts
document.addEventListener('keydown', (e) => {
    if (e.ctrlKey && e.key === 'r') {
        location.reload();
    }
});
