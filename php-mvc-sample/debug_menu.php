<?php
// Debug menu items
require_once 'models/MenuModel.php';

echo "<h2>Debug Menu Items</h2>";
echo "<style>table {border-collapse: collapse; width: 100%;} th, td {border: 1px solid #ddd; padding: 8px; text-align: left;} th {background-color: #f2f2f2;}</style>";

try {
    $menuModel = new MenuModel();
    
    // Test database connection
    echo "<h3>1. Database Connection Test:</h3>";
    $allItems = $menuModel->getMenuItems();
    echo "Available items found: " . count($allItems) . "<br>";
    
    // Show all items regardless of status
    echo "<h3>2. All Items (any status):</h3>";
    require_once 'models/DB.php';
    $db = DB::getInstance();
    $stmt = $db->prepare('SELECT * FROM menu_items ORDER BY id');
    $stmt->execute();
    $rawItems = $stmt->fetchAll();
    
    echo "Total items in database: " . count($rawItems) . "<br><br>";
    
    if (!empty($rawItems)) {
        echo "<table>";
        echo "<tr><th>ID</th><th>Name</th><th>Status</th><th>Category ID</th><th>Price</th><th>Image</th><th>Created At</th><th>Updated At</th></tr>";
        foreach ($rawItems as $item) {
            echo "<tr>";
            echo "<td>{$item['id']}</td>";
            echo "<td>{$item['name']}</td>";
            echo "<td style='color: " . ($item['status'] == 'available' ? 'green' : 'red') . ";'><strong>{$item['status']}</strong></td>";
            echo "<td>{$item['category_id']}</td>";
            echo "<td>" . number_format($item['price']) . "đ</td>";
            echo "<td style='max-width: 200px; word-break: break-all;'>" . (empty($item['image']) ? '<em>No image</em>' : $item['image']) . "</td>";
            echo "<td>{$item['created_at']}</td>";
            echo "<td>{$item['updated_at']}</td>";
            echo "</tr>";
        }
        echo "</table>";
    }
    
    echo "<h3>3. Available Items Only (what shows on menu):</h3>";
    if (!empty($allItems)) {
        echo "<table>";
        echo "<tr><th>ID</th><th>Name</th><th>Price</th><th>Category</th><th>Image</th></tr>";
        foreach ($allItems as $item) {
            echo "<tr>";
            echo "<td>{$item['id']}</td>";
            echo "<td>{$item['name']}</td>";
            echo "<td>" . number_format($item['price']) . "đ</td>";
            echo "<td>{$item['category_name']}</td>";
            echo "<td style='max-width: 200px; word-break: break-all;'>" . (empty($item['image']) ? '<em>No image</em>' : $item['image']) . "</td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "<p style='color: red;'><strong>No available items found! This is why menu is empty.</strong></p>";
        echo "<p>Check if items have status = 'available' in the table above.</p>";
    }
    
    // Check for common status values
    echo "<h3>4. Status Distribution:</h3>";
    $stmt = $db->prepare('SELECT status, COUNT(*) as count FROM menu_items GROUP BY status');
    $stmt->execute();
    $statusCounts = $stmt->fetchAll();
    
    foreach ($statusCounts as $status) {
        echo "Status '<strong>{$status['status']}</strong>': {$status['count']} items<br>";
    }
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
    echo "<br>Stack trace: " . $e->getTraceAsString();
}
?>
