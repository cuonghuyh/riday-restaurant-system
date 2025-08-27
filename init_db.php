<?php
// Database initialization script
require_once 'config.php';

try {
    // Connect to database
    $pdo = new PDO(
        "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=" . DB_CHARSET,
        DB_USER,
        DB_PASS,
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );
    
    echo "✅ Database connection successful!\n";
    
    // Check if tables exist
    $stmt = $pdo->query("SHOW TABLES");
    $tables = $stmt->fetchAll(PDO::FETCH_COLUMN);
    
    if (empty($tables)) {
        echo "📋 No tables found. Creating database schema...\n";
        
        // Read and execute SQL file
        $sql = file_get_contents(__DIR__ . '/restaurant_ordering.sql');
        if ($sql) {
            // Remove database creation commands
            $sql = preg_replace('/CREATE DATABASE.*?;/i', '', $sql);
            $sql = preg_replace('/USE `.*?`;/i', '', $sql);
            
            // Execute SQL
            $pdo->exec($sql);
            echo "✅ Database schema created successfully!\n";
        } else {
            echo "❌ Could not read SQL file!\n";
        }
    } else {
        echo "✅ Database tables already exist: " . implode(', ', $tables) . "\n";
    }
    
} catch (PDOException $e) {
    echo "❌ Database error: " . $e->getMessage() . "\n";
    exit(1);
}
?>
