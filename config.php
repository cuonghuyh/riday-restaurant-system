<?php
// Cấu hình cơ bản cho project
// Hỗ trợ cả local development và production deployment

// Đặt timezone mặc định cho toàn bộ ứng dụng
date_default_timezone_set('Asia/Ho_Chi_Minh');

// Database connection constants
// Ưu tiên environment variables (cho production) trước, fallback về local
if (!defined('DB_HOST')) define('DB_HOST', $_ENV['DB_HOST'] ?? '127.0.0.1');
if (!defined('DB_NAME')) define('DB_NAME', $_ENV['DB_NAME'] ?? 'restaurant_ordering');
if (!defined('DB_USER')) define('DB_USER', $_ENV['DB_USER'] ?? 'root');
if (!defined('DB_PASS')) define('DB_PASS', $_ENV['DB_PASS'] ?? 'mysql');

// Charset
if (!defined('DB_CHARSET')) define('DB_CHARSET', 'utf8mb4');

// Port cho production deployment
if (!defined('PORT')) define('PORT', $_ENV['PORT'] ?? 8000);

// Cloudinary configuration (optional)
if (!defined('CLOUDINARY_CLOUD_NAME')) define('CLOUDINARY_CLOUD_NAME', $_ENV['CLOUDINARY_CLOUD_NAME'] ?? '');
if (!defined('CLOUDINARY_API_KEY')) define('CLOUDINARY_API_KEY', $_ENV['CLOUDINARY_API_KEY'] ?? '');
if (!defined('CLOUDINARY_API_SECRET')) define('CLOUDINARY_API_SECRET', $_ENV['CLOUDINARY_API_SECRET'] ?? '');

// Thông tin này được include ở các file cần kết nối DB.
// Ví dụ:
// require_once __DIR__ . '/config.php';
// $pdo = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME.";charset=".DB_CHARSET, DB_USER, DB_PASS);

?>
