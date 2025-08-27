<?php
// Cấu hình cơ bản cho project
// Hỗ trợ cả local development và production deployment

// Đặt timezone mặc định cho toàn bộ ứng dụng
date_default_timezone_set('Asia/Ho_Chi_Minh');

// Database connection constants
// Ưu tiên environment variables (cho production) trước, fallback về local
if (!defined('DB_HOST')) define('DB_HOST', $_ENV['DB_HOST'] ?? getenv('DB_HOST') ?: '127.0.0.1');
if (!defined('DB_NAME')) define('DB_NAME', $_ENV['DB_NAME'] ?? getenv('DB_NAME') ?: 'restaurant_ordering');
if (!defined('DB_USER')) define('DB_USER', $_ENV['DB_USER'] ?? getenv('DB_USER') ?: 'root');
if (!defined('DB_PASS')) define('DB_PASS', $_ENV['DB_PASS'] ?? getenv('DB_PASS') ?: 'mysql');
if (!defined('DB_PORT')) define('DB_PORT', $_ENV['DB_PORT'] ?? getenv('DB_PORT') ?: '3306');

// Detect database type (PostgreSQL for production, MySQL for local)
if (!defined('DB_TYPE')) {
    $host = DB_HOST;
    define('DB_TYPE', (strpos($host, 'dpg-') !== false || DB_PORT == '5432') ? 'pgsql' : 'mysql');
}

// Charset
if (!defined('DB_CHARSET')) define('DB_CHARSET', 'utf8mb4');

// Port cho production deployment
if (!defined('PORT')) define('PORT', $_ENV['PORT'] ?? getenv('PORT') ?: 8000);

// Cloudinary configuration (optional)
if (!defined('CLOUDINARY_CLOUD_NAME')) define('CLOUDINARY_CLOUD_NAME', $_ENV['CLOUDINARY_CLOUD_NAME'] ?? getenv('CLOUDINARY_CLOUD_NAME') ?: '');
if (!defined('CLOUDINARY_API_KEY')) define('CLOUDINARY_API_KEY', $_ENV['CLOUDINARY_API_KEY'] ?? getenv('CLOUDINARY_API_KEY') ?: '');
if (!defined('CLOUDINARY_API_SECRET')) define('CLOUDINARY_API_SECRET', $_ENV['CLOUDINARY_API_SECRET'] ?? getenv('CLOUDINARY_API_SECRET') ?: '');

// Database connection helper function
function getDatabaseConnection() {
    if (DB_TYPE === 'pgsql') {
        $dsn = "pgsql:host=" . DB_HOST . ";port=" . DB_PORT . ";dbname=" . DB_NAME;
    } else {
        $dsn = "mysql:host=" . DB_HOST . ";port=" . DB_PORT . ";dbname=" . DB_NAME . ";charset=" . DB_CHARSET;
    }
    
    try {
        $pdo = new PDO($dsn, DB_USER, DB_PASS);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    } catch (PDOException $e) {
        die("Database connection failed: " . $e->getMessage());
    }
}

?>
