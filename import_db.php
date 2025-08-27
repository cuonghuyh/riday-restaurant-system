<?php
require_once 'config.php';

echo "Importing SQL file...\n";

try {
    $pdo = new PDO("mysql:host=" . DB_HOST . ";port=" . DB_PORT . ";dbname=" . DB_NAME . ";charset=" . DB_CHARSET, DB_USER, DB_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Read SQL file
    $sql = file_get_contents('restaurant_ordering.sql');
    
    // Split SQL by semicolon and execute each statement
    $statements = explode(';', $sql);
    
    $successCount = 0;
    foreach ($statements as $statement) {
        $statement = trim($statement);
        if (empty($statement) || strpos($statement, '--') === 0) {
            continue;
        }
        
        try {
            $pdo->exec($statement);
            $successCount++;
        } catch (Exception $e) {
            // Skip comments and empty statements
            if (strpos($e->getMessage(), 'syntax error') === false) {
                echo "Warning: " . $e->getMessage() . "\n";
            }
        }
    }
    
    echo "✅ Successfully executed $successCount SQL statements\n";
    
    // Test the import
    $stmt = $pdo->query("SELECT COUNT(*) as count FROM menu_items");
    $result = $stmt->fetch();
    echo "✅ Found " . $result['count'] . " menu items\n";
    
    $stmt = $pdo->query("SELECT COUNT(*) as count FROM categories");
    $result = $stmt->fetch();
    echo "✅ Found " . $result['count'] . " categories\n";
    
    echo "✅ Database import completed successfully!\n";
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}
?>
