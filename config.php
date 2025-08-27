<?php
// Cấu hình cơ bản cho project
// Hỗ trợ cả local development và production deployment

// Đặt timezone mặc định cho toàn bộ ứng dụng
date_default_timezone_set('Asia/Ho_Chi_Minh');

// Database connection constants
// Ưu tiên environment variables (cho production), fallback về local config
if (!defined('DB_HOST')) {
    define('DB_HOST', $_ENV['DB_HOST'] ?? getenv('DB_HOST') ?: '127.0.0.1');
}
if (!defined('DB_NAME')) {
    define('DB_NAME', $_ENV['DB_NAME'] ?? getenv('DB_NAME') ?: 'restaurant_ordering');
}
if (!defined('DB_USER')) {
    define('DB_USER', $_ENV['DB_USER'] ?? getenv('DB_USER') ?: 'root');
}
if (!defined('DB_PASS')) {
    define('DB_PASS', $_ENV['DB_PASS'] ?? getenv('DB_PASS') ?: 'mysql');
}

// Charset
if (!defined('DB_CHARSET')) define('DB_CHARSET', 'utf8mb4');

// Port cho Render deployment
$port = $_ENV['PORT'] ?? getenv('PORT') ?: 8000;

?>
