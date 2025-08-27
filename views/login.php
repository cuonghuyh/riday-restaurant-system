<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập - Riday Restaurant System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        :root {
            --primary-color: #6366f1;
            --primary-dark: #4338ca;
            --secondary-color: #f1f5f9;
            --text-dark: #1e293b;
            --text-light: #64748b;
            --border-color: #e2e8f0;
            --success-color: #10b981;
            --danger-color: #ef4444;
            --warning-color: #f59e0b;
        }

        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .login-container {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            padding: 3rem;
            width: 100%;
            max-width: 450px;
            margin: 0 auto;
        }

        .logo-section {
            text-align: center;
            margin-bottom: 2rem;
        }

        .logo-icon {
            width: 80px;
            height: 80px;
            background: var(--primary-color);
            border-radius: 20px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1rem;
            font-size: 2rem;
            color: white;
        }

        .login-title {
            font-size: 1.8rem;
            font-weight: 700;
            color: var(--text-dark);
            margin-bottom: 0.5rem;
        }

        .login-subtitle {
            color: var(--text-light);
            font-size: 0.95rem;
        }

        .form-floating {
            margin-bottom: 1.5rem;
        }

        .form-floating input {
            border: 2px solid var(--border-color);
            border-radius: 12px;
            padding: 1rem;
            font-size: 1rem;
            transition: all 0.3s ease;
        }

        .form-floating input:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.2rem rgba(99, 102, 241, 0.1);
        }

        .form-floating label {
            color: var(--text-light);
            font-weight: 500;
        }

        .btn-login {
            background: var(--primary-color);
            border: none;
            border-radius: 12px;
            padding: 1rem;
            font-size: 1rem;
            font-weight: 600;
            color: white;
            width: 100%;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .btn-login:hover {
            background: var(--primary-dark);
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(99, 102, 241, 0.3);
        }

        .btn-login:active {
            transform: translateY(0);
        }

        .btn-login:disabled {
            opacity: 0.7;
            transform: none;
            cursor: not-allowed;
        }

        .loading-spinner {
            display: none;
        }

        .alert {
            border-radius: 12px;
            border: none;
            padding: 1rem;
            margin-bottom: 1.5rem;
            font-weight: 500;
        }

        .alert-danger {
            background: rgba(239, 68, 68, 0.1);
            color: var(--danger-color);
        }

        .alert-success {
            background: rgba(16, 185, 129, 0.1);
            color: var(--success-color);
        }

        .demo-accounts {
            background: rgba(99, 102, 241, 0.05);
            border-radius: 12px;
            padding: 1.5rem;
            margin-top: 2rem;
            border: 1px solid rgba(99, 102, 241, 0.1);
        }

        .demo-accounts h6 {
            color: var(--primary-color);
            font-weight: 600;
            margin-bottom: 1rem;
            font-size: 0.9rem;
        }

        .demo-account {
            background: white;
            border-radius: 8px;
            padding: 0.75rem;
            margin-bottom: 0.5rem;
            border: 1px solid var(--border-color);
            cursor: pointer;
            transition: all 0.2s ease;
            font-size: 0.85rem;
        }

        .demo-account:hover {
            border-color: var(--primary-color);
            background: rgba(99, 102, 241, 0.02);
        }

        .demo-account:last-child {
            margin-bottom: 0;
        }

        .footer-text {
            text-align: center;
            margin-top: 2rem;
            color: var(--text-light);
            font-size: 0.85rem;
        }

        @media (max-width: 576px) {
            .login-container {
                margin: 1rem;
                padding: 2rem;
            }

            .logo-icon {
                width: 60px;
                height: 60px;
                font-size: 1.5rem;
            }

            .login-title {
                font-size: 1.5rem;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="login-container">
            <div class="logo-section">
                <div class="logo-icon">
                    <i class="bi bi-shop"></i>
                </div>
                <h1 class="login-title">Đăng nhập hệ thống</h1>
                <p class="login-subtitle">Riday Restaurant Management</p>
            </div>

            <div id="alertContainer"></div>

            <form id="loginForm">
                <div class="form-floating">
                    <input type="text" class="form-control" id="username" name="username" placeholder="Tên đăng nhập" required>
                    <label for="username"><i class="bi bi-person me-2"></i>Tên đăng nhập</label>
                </div>

                <div class="form-floating">
                    <input type="password" class="form-control" id="password" name="password" placeholder="Mật khẩu" required>
                    <label for="password"><i class="bi bi-lock me-2"></i>Mật khẩu</label>
                </div>

                <button type="submit" class="btn btn-login" id="loginBtn">
                    <span class="login-text">
                        <i class="bi bi-box-arrow-in-right me-2"></i>Đăng nhập
                    </span>
                    <span class="loading-spinner">
                        <i class="bi bi-arrow-clockwise me-2" style="animation: spin 1s linear infinite;"></i>Đang xử lý...
                    </span>
                </button>
            </form>

            <div class="demo-accounts">
                <h6><i class="bi bi-info-circle me-2"></i>Tài khoản demo:</h6>
                <div class="demo-account" onclick="fillLogin('admin', 'admin')">
                    <strong>Admin:</strong> admin / admin
                    <small class="text-muted d-block">Quản trị viên - Toàn quyền</small>
                </div>
                <div class="demo-account" onclick="fillLogin('staff', 'staff')">
                    <strong>Staff:</strong> staff / staff  
                    <small class="text-muted d-block">Nhân viên - Quyền hạn chế</small>
                </div>
            </div>

            <div class="footer-text">
                <i class="bi bi-shield-check me-2"></i>Hệ thống bảo mật cao
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Auto-fill demo login
        function fillLogin(username, password) {
            document.getElementById('username').value = username;
            document.getElementById('password').value = password;
            document.getElementById('username').focus();
        }

        // Show alert message
        function showAlert(type, message) {
            const container = document.getElementById('alertContainer');
            const alertClass = type === 'error' ? 'alert-danger' : 'alert-success';
            const icon = type === 'error' ? 'bi-x-circle' : 'bi-check-circle';
            
            container.innerHTML = `
                <div class="alert ${alertClass}">
                    <i class="bi ${icon} me-2"></i>${message}
                </div>
            `;
            
            // Auto-hide after 5 seconds
            setTimeout(() => {
                container.innerHTML = '';
            }, 5000);
        }

        // Handle login form submission
        document.getElementById('loginForm').addEventListener('submit', async function(e) {
            e.preventDefault();
            
            const username = document.getElementById('username').value.trim();
            const password = document.getElementById('password').value;
            
            if (!username || !password) {
                showAlert('error', 'Vui lòng nhập đầy đủ thông tin đăng nhập');
                return;
            }

            const loginBtn = document.getElementById('loginBtn');
            const loginText = loginBtn.querySelector('.login-text');
            const loadingSpinner = loginBtn.querySelector('.loading-spinner');
            
            // Show loading state
            loginBtn.disabled = true;
            loginText.style.display = 'none';
            loadingSpinner.style.display = 'inline';
            
            try {
                const response = await fetch('?controller=auth&action=authenticate', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        username: username,
                        password: password
                    })
                });
                
                const result = await response.json();
                
                if (result.success) {
                    showAlert('success', result.message + ' Đang chuyển hướng...');
                    
                    // Redirect after 1.5 seconds
                    setTimeout(() => {
                        window.location.href = '?controller=riday';
                    }, 1500);
                } else {
                    showAlert('error', result.message);
                    
                    // Reset button state
                    loginBtn.disabled = false;
                    loginText.style.display = 'inline';
                    loadingSpinner.style.display = 'none';
                }
                
            } catch (error) {
                console.error('Login error:', error);
                showAlert('error', 'Lỗi kết nối. Vui lòng thử lại.');
                
                // Reset button state
                loginBtn.disabled = false;
                loginText.style.display = 'inline';
                loadingSpinner.style.display = 'none';
            }
        });

        // Add spinning animation for loading icon
        const style = document.createElement('style');
        style.textContent = `
            @keyframes spin {
                from { transform: rotate(0deg); }
                to { transform: rotate(360deg); }
            }
        `;
        document.head.appendChild(style);

        // Focus username field on page load
        window.addEventListener('load', function() {
            document.getElementById('username').focus();
        });

        // Enter key support
        document.addEventListener('keypress', function(e) {
            if (e.key === 'Enter' && !document.getElementById('loginBtn').disabled) {
                document.getElementById('loginForm').dispatchEvent(new Event('submit'));
            }
        });
    </script>
</body>
</html>
