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

function showLogin() {
    const loginForm = document.getElementById('loginForm');
    const registerForm = document.getElementById('registerForm');
    const terminalAccess = document.getElementById('terminalAccess');
    
    if (loginForm) {
        loginForm.classList.remove('d-none');
        loginForm.classList.remove('hidden');
        loginForm.style.display = 'block';
        loginForm.style.visibility = 'visible';
        loginForm.style.opacity = '1';
    }
    if (registerForm) {
        registerForm.classList.add('d-none');
        registerForm.classList.add('hidden');
    }
    if (terminalAccess) terminalAccess.classList.add('hidden');
}

function showRegister() {
    const loginForm = document.getElementById('loginForm');
    const registerForm = document.getElementById('registerForm');
    const terminalAccess = document.getElementById('terminalAccess');
    
    if (loginForm) {
        loginForm.classList.add('d-none');
        loginForm.classList.add('hidden');
        loginForm.style.display = 'none';
        loginForm.style.visibility = 'hidden';
        loginForm.style.opacity = '0';
    }
    
    if (terminalAccess) {
        terminalAccess.classList.add('d-none');
        terminalAccess.classList.add('hidden');
        terminalAccess.style.display = 'none';
        terminalAccess.style.visibility = 'hidden';
        terminalAccess.style.opacity = '0';
    }
    
    if (registerForm) {
        registerForm.classList.remove('d-none');
        registerForm.classList.remove('hidden');
        registerForm.style.display = 'block';
        registerForm.style.visibility = 'visible';
        registerForm.style.opacity = '1';
        registerForm.style.zIndex = '1000';
    }
}

function showForgotPassword() {
    showMessage('Password recovery initiated. Check your email matrix.', 'info');
}

function showMessage(message, type = 'error') {
    let icon, title, confirmButtonColor, timer;
    
    switch(type) {
        case 'success':
            icon = 'success';
            title = 'Success';
            confirmButtonColor = '#00ff00';
            timer = 2000;
            break;
        case 'info':
            icon = 'info';
            title = 'Information';
            confirmButtonColor = '#00ff00';
            timer = 3000;
            break;
        case 'error':
        default:
            icon = 'error';
            title = 'Error';
            confirmButtonColor = '#00ff00';
            timer = 3000;
            break;
    }
    
    Swal.fire({
        title: title,
        text: message,
        icon: icon,
        confirmButtonColor: confirmButtonColor,
        background: '#1a1a1a',
        color: '#00ff00',
        border: '1px solid #00ff00',
        timer: timer,
        showConfirmButton: false,
        toast: type === 'info',
        position: type === 'info' ? 'top-end' : 'center'
    });
}

document.getElementById('loginFormElement').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const username = document.getElementById('username').value;
    const password = document.getElementById('password').value;
    const remember = document.getElementById('remember').checked;
    
    if (!username || !password) {
        showMessage('Please enter username and password.', 'error');
        return;
    }
    
    showMessage('Authenticating...', 'info');
    
    fetch('/backend/login.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            username: username,
            password: password,
            remember: remember
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showMessage('Authentication successful. Access granted.', 'success');
            
            setTimeout(() => {
                if (data.user && data.user.role === 'admin') {
                    window.location.href = 'views/admin/dashboard.php';
                } else {
                    window.location.href = 'views/users/home.php';
                }
            }, 1500);
        } else {
            showMessage('Access denied: ' + data.message, 'error');
            document.body.style.animation = 'glitch 0.5s';
            setTimeout(() => {
                document.body.style.animation = '';
            }, 500);
        }
    })
    .catch(error => {
        console.error('Login error:', error);
        showMessage('System error. Please try again.', 'error');
    });
});

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
    
    showMessage('Creating identity...', 'info');
    
    fetch('/backend/register.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            username: username,
            email: email,
            password: password,
            confirm_password: confirmPassword,
            display_name: username
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showMessage('Identity created successfully. Redirecting to login...', 'success');
            setTimeout(() => {
                showLogin();
            }, 2000);
        } else {
            showMessage('Registration failed: ' + data.message, 'error');
        }
    })
    .catch(error => {
        console.error('Registration error:', error);
        showMessage('System error. Please try again.', 'error');
    });
});

window.addEventListener('resize', () => {
    canvas.width = window.innerWidth;
    canvas.height = window.innerHeight;
});

document.addEventListener('keydown', (e) => {
    if (e.ctrlKey && e.key === 'r') {
        location.reload();
    }
});
