<?php

class AuthController {
    
    public function __construct() {
        // Start session if not already started
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }
    
    /**
     * Show login page
     */
    public function login() {
        // If already logged in, redirect to dashboard
        if ($this->isLoggedIn()) {
            header('Location: ?controller=riday');
            exit;
        }
        
        include __DIR__ . '/../views/login.php';
    }
    
    /**
     * Handle login form submission
     */
    public function authenticate() {
        header('Content-Type: application/json');
        
        try {
            $input = json_decode(file_get_contents('php://input'), true);
            
            if (!$input || !isset($input['username']) || !isset($input['password'])) {
                throw new Exception('Thiếu thông tin đăng nhập');
            }
            
            $username = trim($input['username']);
            $password = $input['password'];
            
            if (empty($username) || empty($password)) {
                throw new Exception('Vui lòng nhập đầy đủ thông tin');
            }
            
            // Check user credentials
            require_once __DIR__ . '/../models/DB.php';
            $db = DB::getInstance();
            
            $stmt = $db->prepare('SELECT id, username, password, role, name FROM users WHERE username = ?');
            $stmt->execute([$username]);
            $user = $stmt->fetch();
            
            if (!$user) {
                throw new Exception('Tài khoản không tồn tại');
            }
            
            // Verify password
            if (!password_verify($password, $user['password'])) {
                // Also check if password is plain text (for legacy support)
                if ($password !== $user['password']) {
                    throw new Exception('Mật khẩu không đúng');
                }
            }
            
            // Store user info in session
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];
            $_SESSION['name'] = $user['name'];
            $_SESSION['logged_in'] = true;
            $_SESSION['login_time'] = time();
            
            echo json_encode([
                'success' => true,
                'message' => 'Đăng nhập thành công!',
                'user' => [
                    'id' => $user['id'],
                    'username' => $user['username'],
                    'role' => $user['role'],
                    'name' => $user['name']
                ]
            ]);
            
        } catch (Exception $e) {
            http_response_code(400);
            echo json_encode([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }
    
    /**
     * Logout user
     */
    public function logout() {
        session_destroy();
        header('Location: ?controller=auth&action=login');
        exit;
    }
    
    /**
     * Check if user is logged in
     */
    public function isLoggedIn() {
        return isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true;
    }
    
    /**
     * Get current user info
     */
    public function getCurrentUser() {
        if (!$this->isLoggedIn()) {
            return null;
        }
        
        return [
            'id' => $_SESSION['user_id'],
            'username' => $_SESSION['username'],
            'role' => $_SESSION['role'],
            'name' => $_SESSION['name'],
            'login_time' => $_SESSION['login_time']
        ];
    }
    
    /**
     * Check if user has required role
     */
    public function hasRole($requiredRole) {
        if (!$this->isLoggedIn()) {
            return false;
        }
        
        $userRole = $_SESSION['role'];
        
        // Admin can access everything
        if ($userRole === 'admin') {
            return true;
        }
        
        // Check specific role
        return $userRole === $requiredRole;
    }
    
    /**
     * Require authentication (middleware)
     */
    public function requireAuth($redirectUrl = null) {
        if (!$this->isLoggedIn()) {
            if ($redirectUrl) {
                header("Location: $redirectUrl");
            } else {
                header('Location: ?controller=auth&action=login');
            }
            exit;
        }
    }
    
    /**
     * Require specific role (middleware)  
     */
    public function requireRole($requiredRole, $redirectUrl = null) {
        $this->requireAuth($redirectUrl);
        
        if (!$this->hasRole($requiredRole)) {
            http_response_code(403);
            echo json_encode([
                'success' => false,
                'message' => 'Bạn không có quyền truy cập chức năng này'
            ]);
            exit;
        }
    }
}
