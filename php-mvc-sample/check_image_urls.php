<?php
require_once 'config.php';
require_once 'models/DB.php';

$pdo = DB::getInstance();

// First check table structure
echo "Menu items table structure:\n";
$stmt = $pdo->query('DESCRIBE menu_items');
$columns = $stmt->fetchAll();
foreach($columns as $col) {
    echo $col['Field'] . ' - ' . $col['Type'] . "\n";
}

echo "\n" . str_repeat('=', 50) . "\n\n";

// Then check items with images
$stmt = $pdo->prepare('SELECT * FROM menu_items WHERE image IS NOT NULL AND image != ""');
$stmt->execute();
$items = $stmt->fetchAll();

echo "Menu items with image URLs:\n\n";
foreach($items as $item) {
    echo "ID: {$item['id']} - {$item['name']}\n";
    echo "Image: {$item['image']}\n";
    
    // Test if image URL is accessible
    if (!empty($item['image'])) {
        $headers = @get_headers($item['image']);
        $status = $headers ? $headers[0] : 'No response';
        echo "Status: $status\n";
    } else {
        echo "Status: No image URL\n";
    }
    echo str_repeat('-', 50) . "\n\n";
}
?>
