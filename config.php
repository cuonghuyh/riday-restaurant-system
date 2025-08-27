<?php
// Cấu hình cơ bản cho project
// Hỗ trợ deployment trên Render và local development

// Đặt timezone mặc định cho toàn bộ ứng dụng
date_default_timezone_set('Asia/Ho_Chi_Minh');

// Load environment variables from .env file if exists
function loadEnv($file) {
    if (!file_exists($file)) return;
    
    $lines = file($file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        if (strpos(trim($line), '#') === 0) continue;
        list($name, $value) = explode('=', $line, 2);
        $_ENV[trim($name)] = trim($value);
        putenv(trim($name) . '=' . trim($value));
    }
}

// Load .env file if exists (for local development)
loadEnv(__DIR__ . '/.env');

// Database connection constants
// Priority: Environment variables > .env file > defaults
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

// Thông tin này được include ở các file cần kết nối DB.
// Ví dụ:
// require_once __DIR__ . '/config.php';
// $pdo = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME.";charset=".DB_CHARSET, DB_USER, DB_PASS);

// Nếu cần, bạn có thể override các hằng số trên bằng cách define() trước khi include file này.

?>
