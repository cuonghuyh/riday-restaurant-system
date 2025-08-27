<?php
// Fix menu item status
require_once 'models/DB.php';

echo "<h2>Fix Menu Item Status</h2>";

try {
    $db = DB::getInstance();
    
    // Update status of item ID 1039 to available
    $stmt = $db->prepare('UPDATE menu_items SET status = :status WHERE id = :id');
    $result = $stmt->execute([
        ':status' => 'available',
        ':id' => 1039
    ]);
    
    if ($result && $stmt->rowCount() > 0) {
        echo "<p style='color: green;'><strong>✅ Fixed! Item ID 1039 ('Bún đậu') status changed to 'available'</strong></p>";
        
        // Verify the change
        $stmt = $db->prepare('SELECT * FROM menu_items WHERE id = :id');
        $stmt->execute([':id' => 1039]);
        $item = $stmt->fetch();
        
        echo "<p>Current status: <strong style='color: green;'>{$item['status']}</strong></p>";
        echo "<p>Now the item should appear on the menu!</p>";
        
    } else {
        echo "<p style='color: red;'>❌ Failed to update status</p>";
    }
    
    echo "<br><a href='debug_menu.php'>← Back to debug</a>";
    echo "<br><a href='index.php?controller=restaurant&action=menu&table=1'>→ Check menu</a>";
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>
