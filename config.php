<?php
// config.php - Production Ready Configuration
// Cấu hình an toàn cho production deployment

// Set timezone
date_default_timezone_set('Asia/Ho_Chi_Minh');

// Environment detection
$isProduction = isset($_SERVER['HTTP_HOST']) && !in_array($_SERVER['HTTP_HOST'], ['localhost', '127.0.0.1', 'localhost:8000', 'localhost:8001']);

// Error reporting
if ($isProduction) {
    error_reporting(0);
    ini_set('display_errors', 0);
} else {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
}

// Database configuration with fallback
if ($isProduction) {
    // Special-case: if deployed on ByteHost, use fixed MySQL credentials provided
    $hostHeader = $_SERVER['HTTP_HOST'] ?? ($_ENV['HTTP_HOST'] ?? '');
    if (stripos($hostHeader, 'byethost') !== false) {
        // ByteHost (byethost7.com) MySQL credentials
        define('DB_TYPE', 'mysql');
        define('DB_HOST', 'sql110.byethost7.com');
        define('DB_NAME', 'b7_39805051_restaurant_ordering');
        define('DB_USER', 'b7_39805051');
        define('DB_PASS', 'Quoccuong2403@');
        define('DB_PORT', '3306');
    } else {
        // Production database settings (Render uses PostgreSQL)
        define('DB_TYPE', $_ENV['DB_TYPE'] ?? 'pgsql'); // pgsql for Render, mysql for others
        define('DB_HOST', $_ENV['DATABASE_URL'] ? parse_url($_ENV['DATABASE_URL'], PHP_URL_HOST) : ($_ENV['DB_HOST'] ?? 'localhost'));
        define('DB_NAME', $_ENV['DATABASE_URL'] ? ltrim(parse_url($_ENV['DATABASE_URL'], PHP_URL_PATH), '/') : ($_ENV['DB_NAME'] ?? 'restaurant_ordering'));
        define('DB_USER', $_ENV['DATABASE_URL'] ? parse_url($_ENV['DATABASE_URL'], PHP_URL_USER) : ($_ENV['DB_USER'] ?? 'root'));
        define('DB_PASS', $_ENV['DATABASE_URL'] ? parse_url($_ENV['DATABASE_URL'], PHP_URL_PASS) : ($_ENV['DB_PASS'] ?? ''));
        define('DB_PORT', $_ENV['DATABASE_URL'] ? parse_url($_ENV['DATABASE_URL'], PHP_URL_PORT) : ($_ENV['DB_PORT'] ?? '5432'));
    }
} else {
    // Development database settings
    define('DB_TYPE', 'mysql');
    define('DB_HOST', '127.0.0.1');
    define('DB_NAME', 'restaurant_ordering');
    define('DB_USER', 'root');
    define('DB_PASS', 'mysql');
    define('DB_PORT', '3306');
}

define('DB_CHARSET', 'utf8mb4');

// Cloudinary configuration
define('CLOUDINARY_CLOUD_NAME', $_ENV['CLOUDINARY_CLOUD_NAME'] ?? 'dx9ngssmo');
define('CLOUDINARY_API_KEY', $_ENV['CLOUDINARY_API_KEY'] ?? '795853862463853');
define('CLOUDINARY_API_SECRET', $_ENV['CLOUDINARY_API_SECRET'] ?? 'T99X7YKQTEO2dxUhYDhobdSEzxs');

// Application settings
define('APP_NAME', 'Restaurant Ordering System');
define('APP_VERSION', '1.0.0');
define('APP_DEBUG', !$isProduction);

// Security settings
define('SESSION_TIMEOUT', 3600); // 1 hour
define('CSRF_TOKEN_EXPIRE', 1800); // 30 minutes

// Upload settings
define('MAX_UPLOAD_SIZE', 5 * 1024 * 1024); // 5MB
define('ALLOWED_IMAGE_TYPES', ['image/jpeg', 'image/png', 'image/gif', 'image/webp']);

// Paths
define('ROOT_PATH', __DIR__);
define('VIEWS_PATH', ROOT_PATH . '/views');
define('MODELS_PATH', ROOT_PATH . '/models');
define('CONTROLLERS_PATH', ROOT_PATH . '/controllers');
define('ASSETS_PATH', ROOT_PATH . '/assets');

// URL configuration
$protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http';
$host = $_SERVER['HTTP_HOST'] ?? 'localhost';
define('BASE_URL', $protocol . '://' . $host . dirname($_SERVER['SCRIPT_NAME']));

// Logging
if ($isProduction) {
    ini_set('log_errors', 1);
    ini_set('error_log', ROOT_PATH . '/logs/error.log');
    
    // Create logs directory if not exists
    if (!is_dir(ROOT_PATH . '/logs')) {
        mkdir(ROOT_PATH . '/logs', 0755, true);
    }
}

// Session configuration
if (session_status() === PHP_SESSION_NONE) {
    session_start([
        'cookie_lifetime' => SESSION_TIMEOUT,
        'cookie_httponly' => true,
        'cookie_secure' => $isProduction,
        'use_strict_mode' => true
    ]);
}

// Helper function to check if we're in production
function isProduction() {
    global $isProduction;
    return $isProduction;
}

// Helper function for safe environment variable access
function env($key, $default = null) {
    return $_ENV[$key] ?? getenv($key) ?: $default;
}

// Database connection test function
function testDatabaseConnection() {
    try {
        $dsn = 'mysql:host=' . DB_HOST . ';port=' . DB_PORT . ';dbname=' . DB_NAME . ';charset=' . DB_CHARSET;
        $pdo = new PDO($dsn, DB_USER, DB_PASS, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ]);
        return ['success' => true, 'message' => 'Database connection successful'];
    } catch (PDOException $e) {
        error_log('Database connection failed: ' . $e->getMessage());
        return ['success' => false, 'message' => 'Database connection failed: ' . $e->getMessage()];
    }
}

// Auto-create logs directory
if (!is_dir(ROOT_PATH . '/logs')) {
    @mkdir(ROOT_PATH . '/logs', 0755, true);
}

?>
