<?php
// Fix single item status
if (!isset($_GET['id'])) {
    die('No item ID provided');
}

require_once 'models/DB.php';

$itemId = $_GET['id'];

try {
    $db = DB::getInstance();
    
    $stmt = $db->prepare("UPDATE menu_items SET status = 'available' WHERE id = :id");
    $result = $stmt->execute([':id' => $itemId]);
    
    if ($result && $stmt->rowCount() > 0) {
        echo "<p style='color: green;'>✅ Item ID {$itemId} fixed to 'available' status!</p>";
    } else {
        echo "<p style='color: red;'>❌ Failed to update item ID {$itemId}</p>";
    }
    
    echo "<br><a href='monitor_menu_status.php'>← Back to monitor</a>";
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>
