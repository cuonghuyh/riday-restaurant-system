<?php
require_once __DIR__ . '/../config.php';

class DB
{
    /** @var PDO */
    private static $instance = null;

    public static function getInstance()
    {
        if (self::$instance === null) {
            try {
                // Kiểm tra loại database
                if (defined('DB_TYPE') && DB_TYPE === 'sqlite') {
                    // Sử dụng SQLite cho production/Render
                    $dsn = 'sqlite:' . DB_PATH;
                    $pdo = new PDO($dsn, null, null, [
                        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                        PDO::ATTR_EMULATE_PREPARES => false,
                    ]);
                    
                    // Tạo bảng nếu chưa tồn tại
                    self::createTablesIfNotExists($pdo);
                } else {
                    // Sử dụng MySQL cho development
                    $dsn = sprintf('mysql:host=%s;dbname=%s;charset=%s', DB_HOST, DB_NAME, DB_CHARSET);
                    $pdo = new PDO($dsn, DB_USER, DB_PASS, [
                        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                        PDO::ATTR_EMULATE_PREPARES => false,
                    ]);
                }
                
                self::$instance = $pdo;
            } catch (PDOException $e) {
                // In production you might log and show a friendly message
                throw new RuntimeException('Database connection failed: ' . $e->getMessage());
            }
        }

        return self::$instance;
    }

    private static function createTablesIfNotExists($pdo)
    {
        // Tạo các bảng cần thiết cho SQLite
        $tables = [
            'menu_items' => "
                CREATE TABLE IF NOT EXISTS menu_items (
                    id INTEGER PRIMARY KEY AUTOINCREMENT,
                    name TEXT NOT NULL,
                    description TEXT,
                    price DECIMAL(10,2) NOT NULL,
                    category TEXT,
                    image_url TEXT,
                    is_available INTEGER DEFAULT 1,
                    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
                    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP
                )",
            'orders' => "
                CREATE TABLE IF NOT EXISTS orders (
                    id INTEGER PRIMARY KEY AUTOINCREMENT,
                    table_number INTEGER NOT NULL,
                    customer_name TEXT,
                    status TEXT DEFAULT 'pending',
                    total_amount DECIMAL(10,2) NOT NULL,
                    order_items TEXT,
                    special_requests TEXT,
                    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
                    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP
                )",
            'tables' => "
                CREATE TABLE IF NOT EXISTS tables (
                    id INTEGER PRIMARY KEY AUTOINCREMENT,
                    table_number INTEGER UNIQUE NOT NULL,
                    capacity INTEGER DEFAULT 4,
                    status TEXT DEFAULT 'available',
                    qr_code_path TEXT,
                    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
                )"
        ];

        foreach ($tables as $tableName => $sql) {
            $pdo->exec($sql);
        }
    }
}
