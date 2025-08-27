<?php
// Cấu hình cơ bản cho project
// Cập nhật DB_* theo môi trường của bạn (phpMyAdmin / hosting)

// Đặt timezone mặc định cho toàn bộ ứng dụng
date_default_timezone_set('Asia/Ho_Chi_Minh');

// Kiểm tra môi trường deployment
$isProduction = isset($_ENV['ENVIRONMENT']) && $_ENV['ENVIRONMENT'] === 'production';
$isRender = isset($_ENV['RENDER']) || isset($_ENV['RENDER_SERVICE_NAME']);

// Database connection constants
if ($isProduction || $isRender) {
    // Production/Render: Sử dụng SQLite
    if (!defined('DB_TYPE')) define('DB_TYPE', 'sqlite');
    if (!defined('DB_PATH')) define('DB_PATH', __DIR__ . '/database/restaurant.db');
} else {
    // Development: Sử dụng MySQL
    if (!defined('DB_HOST')) define('DB_HOST', '127.0.0.1');
    if (!defined('DB_NAME')) define('DB_NAME', 'restaurant_ordering');
    if (!defined('DB_USER')) define('DB_USER', 'root');
    if (!defined('DB_PASS')) define('DB_PASS', 'mysql');
    if (!defined('DB_TYPE')) define('DB_TYPE', 'mysql');
}

// Charset
if (!defined('DB_CHARSET')) define('DB_CHARSET', 'utf8mb4');

// Debug mode
if (!defined('DEBUG_MODE')) define('DEBUG_MODE', !$isProduction);

// Base URL
if (!defined('BASE_URL')) {
    if ($isRender) {
        define('BASE_URL', 'https://' . $_ENV['RENDER_EXTERNAL_HOSTNAME']);
    } else {
        define('BASE_URL', 'http://localhost');
    }
}

?>
