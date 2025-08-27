<?php
// Monitor status changes
require_once 'models/MenuModel.php';

$action = $_GET['action'] ?? 'view';

if ($action === 'fix_all') {
    // Fix all unavailable items to available
    require_once 'models/DB.php';
    $db = DB::getInstance();
    
    $stmt = $db->prepare("UPDATE menu_items SET status = 'available' WHERE status = 'unavailable'");
    $result = $stmt->execute();
    
    if ($result) {
        echo "<p style='color: green;'>✅ All items fixed to 'available' status!</p>";
    }
}

?>
<!DOCTYPE html>
<html>
<head>
    <title>Menu Status Monitor</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        table { border-collapse: collapse; width: 100%; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        .available { color: green; font-weight: bold; }
        .unavailable { color: red; font-weight: bold; }
        .btn { padding: 8px 16px; margin: 5px; text-decoration: none; border-radius: 4px; }
        .btn-success { background: #28a745; color: white; }
        .btn-danger { background: #dc3545; color: white; }
    </style>
</head>
<body>

<h2>Menu Status Monitor</h2>

<div>
    <a href="?action=fix_all" class="btn btn-success">Fix All to Available</a>
    <a href="?" class="btn btn-danger">Refresh</a>
    <a href="debug_menu.php" class="btn">Debug Menu</a>
</div>

<?php
try {
    require_once 'models/DB.php';
    $db = DB::getInstance();
    
    // Get all items with timestamps
    $stmt = $db->prepare('SELECT *, 
        CASE 
            WHEN updated_at IS NOT NULL THEN updated_at 
            ELSE created_at 
        END as last_modified
        FROM menu_items ORDER BY last_modified DESC');
    $stmt->execute();
    $items = $stmt->fetchAll();
    
    echo "<h3>All Menu Items (sorted by last modified)</h3>";
    echo "<table>";
    echo "<tr><th>ID</th><th>Name</th><th>Status</th><th>Price</th><th>Image</th><th>Created</th><th>Updated</th><th>Action</th></tr>";
    
    foreach ($items as $item) {
        $statusClass = $item['status'] === 'available' ? 'available' : 'unavailable';
        echo "<tr>";
        echo "<td>{$item['id']}</td>";
        echo "<td>{$item['name']}</td>";
        echo "<td class='$statusClass'>{$item['status']}</td>";
        echo "<td>" . number_format($item['price']) . "đ</td>";
        echo "<td>" . (empty($item['image']) ? 'No image' : 'Has image') . "</td>";
        echo "<td>{$item['created_at']}</td>";
        echo "<td>" . ($item['updated_at'] ?? 'Never') . "</td>";
        echo "<td>";
        if ($item['status'] !== 'available') {
            echo "<a href='fix_single_item.php?id={$item['id']}' class='btn btn-success'>Fix</a>";
        } else {
            echo "✅ OK";
        }
        echo "</td>";
        echo "</tr>";
    }
    echo "</table>";
    
    // Status summary
    $stmt = $db->prepare('SELECT status, COUNT(*) as count FROM menu_items GROUP BY status');
    $stmt->execute();
    $statusSummary = $stmt->fetchAll();
    
    echo "<h3>Status Summary</h3>";
    foreach ($statusSummary as $status) {
        echo "<p>Status '<strong>{$status['status']}</strong>': {$status['count']} items</p>";
    }
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>

</body>
</html>
