<?php
require_once 'config.php';

echo "Database Configuration:\n";
echo "Host: " . DB_HOST . "\n";
echo "Database: " . DB_NAME . "\n";
echo "User: " . DB_USER . "\n";
echo "Port: " . DB_PORT . "\n";

try {
    $pdo = new PDO("mysql:host=" . DB_HOST . ";port=" . DB_PORT . ";charset=" . DB_CHARSET, DB_USER, DB_PASS);
    echo "✅ MySQL connection successful!\n";
    
    // Check if database exists
    $stmt = $pdo->query("SHOW DATABASES LIKE '" . DB_NAME . "'");
    if ($stmt->rowCount() > 0) {
        echo "✅ Database '" . DB_NAME . "' exists\n";
    } else {
        echo "❌ Database '" . DB_NAME . "' does not exist\n";
        echo "Creating database...\n";
        $pdo->exec("CREATE DATABASE `" . DB_NAME . "` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
        echo "✅ Database created successfully!\n";
    }
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}
?>
