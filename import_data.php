<?php
require_once 'config.php';

echo "Importing only INSERT statements...\n";

try {
    $pdo = new PDO("mysql:host=" . DB_HOST . ";port=" . DB_PORT . ";dbname=" . DB_NAME . ";charset=" . DB_CHARSET, DB_USER, DB_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Manual INSERT statements from the SQL file
    $insertStatements = [
        "INSERT INTO `categories` (`id`, `name`, `icon`, `display_order`, `status`, `created_at`) VALUES
(1, 'Khai vị', '🥟', 1, 'active', '2025-08-25 16:50:18'),
(2, 'Món chính', '🍜', 2, 'active', '2025-08-25 16:50:18'),
(3, 'Tráng miệng', '🍮', 3, 'active', '2025-08-25 16:50:18'),
(4, 'Đồ uống', '🥤', 4, 'active', '2025-08-25 16:50:18')",

        "INSERT INTO `menu_items` (`id`, `name`, `description`, `price`, `image`, `status`, `category_id`) VALUES
(1, 'Gỏi cuốn tôm thịt', 'Gỏi cuốn tươi ngon với tôm và thịt heo', 45000, 'https://res.cloudinary.com/dx9ngssmo/image/upload/v1756268644/menu_items/yiyjqb7qpbnnmhnxppei.jpg', 'active', 1),
(2, 'Chả cá Lá Vọng', 'Món chả cá truyền thống Hà Nội', 120000, 'https://res.cloudinary.com/dx9ngssmo/image/upload/v1756268618/menu_items/kqegtxeaeiobxhyqbrml.jpg', 'active', 2),
(3, 'Pancake', 'Bánh pancake mềm mịn với siro maple', 60000, 'https://res.cloudinary.com/dx9ngssmo/image/upload/v1756268594/menu_items/cghpajkxkczpbw4seuld.jpg', 'active', 3),
(4, 'Cà phê sữa đá', 'Cà phê truyền thống Việt Nam', 25000, 'https://res.cloudinary.com/dx9ngssmo/image/upload/v1756268569/menu_items/rveqeysoglyhrxcbvvns.jpg', 'active', 4),
(5, 'Trà đào cam sả', 'Trà hoa quả tươi mát', 35000, 'https://res.cloudinary.com/dx9ngssmo/image/upload/v1756268569/menu_items/rveqeysoglyhrxcbvvns.jpg', 'active', 4)",

        "INSERT INTO `tables` (`id`, `qr_code`, `name`, `status`) VALUES
(1, 'QR_TABLE_001', 'Bàn 1', 'active'),
(2, 'QR_TABLE_002', 'Bàn 2', 'active'),
(3, 'QR_TABLE_003', 'Bàn 3', 'active'),
(4, 'QR_TABLE_004', 'Bàn 4', 'active'),
(5, 'QR_TABLE_005', 'Bàn 5', 'active'),
(6, 'QR_TABLE_006', 'Bàn 6', 'active'),
(7, 'QR_TABLE_007', 'Bàn 7', 'active'),
(8, 'QR_TABLE_008', 'Bàn 8', 'active'),
(9, 'QR_TABLE_009', 'Bàn 9', 'active'),
(10, 'QR_TABLE_010', 'Bàn 10', 'active')",

        "INSERT INTO `users` (`id`, `username`, `password`, `role`, `name`, `phone`) VALUES
(1, 'admin', 'admin123', 'admin', 'Administrator', '0123456789'),
(2, 'staff', 'staff123', 'staff', 'Nhân viên', '0987654321')"
    ];
    
    foreach ($insertStatements as $statement) {
        $pdo->exec($statement);
        echo "✅ Executed INSERT statement\n";
    }
    
    // Test the import
    $stmt = $pdo->query("SELECT COUNT(*) as count FROM menu_items");
    $result = $stmt->fetch();
    echo "✅ Found " . $result['count'] . " menu items\n";
    
    $stmt = $pdo->query("SELECT COUNT(*) as count FROM categories");
    $result = $stmt->fetch();
    echo "✅ Found " . $result['count'] . " categories\n";
    
    $stmt = $pdo->query("SELECT COUNT(*) as count FROM tables");
    $result = $stmt->fetch();
    echo "✅ Found " . $result['count'] . " tables\n";
    
    echo "✅ Data import completed successfully!\n";
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}
?>
