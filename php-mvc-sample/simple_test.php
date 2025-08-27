<?php
// Simple test for Cloudinary config
echo "=== CLOUDINARY CONFIG TEST ===\n";

try {
    $config = require_once 'config/cloudinary.php';
    echo "Config loaded successfully\n";
    echo "Cloud Name: " . $config['cloud_name'] . "\n";
    echo "API Key: " . $config['api_key'] . "\n";
    echo "API Secret length: " . strlen($config['api_secret']) . "\n";
    
    if (empty($config['cloud_name']) || empty($config['api_key']) || empty($config['api_secret'])) {
        echo "ERROR: Missing Cloudinary credentials!\n";
    } else {
        echo "✅ All credentials present\n";
    }
    
} catch (Exception $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
}
?>
