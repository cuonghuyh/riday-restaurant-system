<?php
// Cấu hình cơ bản cho project
// Cập nhật DB_* theo môi trường của bạn (phpMyAdmin / hosting)

// Đặt timezone mặc định cho toàn bộ ứng dụng
date_default_timezone_set('Asia/Ho_Chi_Minh');

// Database connection constants (MySQL / MariaDB)
if (!defined('DB_HOST')) define('DB_HOST', '127.0.0.1');
if (!defined('DB_NAME')) define('DB_NAME', 'restaurant_ordering');
if (!defined('DB_USER')) define('DB_USER', 'root');
if (!defined('DB_PASS')) define('DB_PASS', 'mysql');

// Charset
if (!defined('DB_CHARSET')) define('DB_CHARSET', 'utf8mb4');

// Thông tin này được include ở các file cần kết nối DB.
// Ví dụ:
// require_once __DIR__ . '/config.php';
// $pdo = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME.";charset=".DB_CHARSET, DB_USER, DB_PASS);

// Nếu cần, bạn có thể override các hằng số trên bằng cách define() trước khi include file này.

?>
