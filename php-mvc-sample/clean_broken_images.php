<?php
require_once 'config.php';
require_once 'models/DB.php';

$pdo = DB::getInstance();

// Get all items with images
$stmt = $pdo->prepare('SELECT id, name, image FROM menu_items WHERE image IS NOT NULL AND image != ""');
$stmt->execute();
$items = $stmt->fetchAll();

echo "Checking and cleaning broken image URLs...\n\n";

foreach($items as $item) {
    echo "Checking ID {$item['id']} - {$item['name']}...\n";
    
    // Test if image URL is accessible
    $headers = @get_headers($item['image']);
    $is_accessible = $headers && strpos($headers[0], '200') !== false;
    
    if (!$is_accessible) {
        echo "❌ Image not accessible, clearing URL from database...\n";
        
        // Clear the broken image URL
        $updateStmt = $pdo->prepare('UPDATE menu_items SET image = NULL WHERE id = ?');
        $updateStmt->execute([$item['id']]);
        
        echo "✅ Cleared broken image URL for item {$item['id']}\n";
    } else {
        echo "✅ Image accessible\n";
    }
    
    echo str_repeat('-', 50) . "\n";
}

echo "\nDone! Broken image URLs have been cleared.\n";
?>
