<?php
require_once __DIR__ . '/../config.php';

class DB
{
    /** @var PDO */
    private static $instance = null;

    public static function getInstance()
    {
        if (self::$instance === null) {
            // Use SQLite for simplicity on Render (free tier)
            $dbPath = __DIR__ . '/../database/restaurant.db';
            $dbDir = dirname($dbPath);
            
            // Create database directory if not exists
            if (!is_dir($dbDir)) {
                mkdir($dbDir, 0777, true);
            }
            
            $dsn = 'sqlite:' . $dbPath;
            try {
                $pdo = new PDO($dsn, null, null, [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES => false,
                ]);
                
                // Create tables if they don't exist
                self::createTables($pdo);
                self::$instance = $pdo;
            } catch (PDOException $e) {
                // In production you might log and show a friendly message
                throw new RuntimeException('Database connection failed: ' . $e->getMessage());
            }
        }

        return self::$instance;
    }
    
    /**
     * Create necessary tables for the restaurant system
     */
    private static function createTables($pdo)
    {
        // Create menu table
        $pdo->exec("
            CREATE TABLE IF NOT EXISTS menu (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                name TEXT NOT NULL,
                price REAL NOT NULL,
                description TEXT,
                image_url TEXT,
                category TEXT DEFAULT 'Món chính',
                is_available INTEGER DEFAULT 1,
                created_at DATETIME DEFAULT CURRENT_TIMESTAMP
            )
        ");
        
        // Create orders table
        $pdo->exec("
            CREATE TABLE IF NOT EXISTS orders (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                table_number INTEGER NOT NULL,
                customer_name TEXT,
                items TEXT NOT NULL,
                total_amount REAL NOT NULL,
                status TEXT DEFAULT 'pending',
                created_at DATETIME DEFAULT CURRENT_TIMESTAMP
            )
        ");
        
        // Insert sample menu items if table is empty
        $stmt = $pdo->query("SELECT COUNT(*) FROM menu");
        $count = $stmt->fetchColumn();
        
        if ($count == 0) {
            $sampleMenu = [
                ['Phở Bò', 65000, 'Phở bò truyền thống Hà Nội', 'https://via.placeholder.com/300x200?text=Pho+Bo', 'Món chính'],
                ['Bún Chả', 55000, 'Bún chả nướng thơm ngon', 'https://via.placeholder.com/300x200?text=Bun+Cha', 'Món chính'],
                ['Chả Cá Lã Vọng', 85000, 'Đặc sản Hà Nội', 'https://via.placeholder.com/300x200?text=Cha+Ca', 'Món chính'],
                ['Gỏi Cuốn', 35000, 'Gỏi cuốn tôm thịt', 'https://via.placeholder.com/300x200?text=Goi+Cuon', 'Khai vị'],
                ['Nem Nướng', 45000, 'Nem nướng Nha Trang', 'https://via.placeholder.com/300x200?text=Nem+Nuong', 'Khai vị'],
                ['Bia Hơi', 15000, 'Bia tươi mát lạnh', 'https://via.placeholder.com/300x200?text=Bia+Hoi', 'Đồ uống'],
                ['Nước Chanh', 20000, 'Chanh tươi mát', 'https://via.placeholder.com/300x200?text=Nuoc+Chanh', 'Đồ uống'],
                ['Cà Phê Đá', 25000, 'Cà phê phin truyền thống', 'https://via.placeholder.com/300x200?text=Ca+Phe', 'Đồ uống']
            ];
            
            $stmt = $pdo->prepare("INSERT INTO menu (name, price, description, image_url, category) VALUES (?, ?, ?, ?, ?)");
            foreach ($sampleMenu as $item) {
                $stmt->execute($item);
            }
        }
    }
}
