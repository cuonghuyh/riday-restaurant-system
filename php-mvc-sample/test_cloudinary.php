<?php
// Test Cloudinary upload directly
require_once 'models/CloudinaryAPI.php';

try {
    echo "=== CLOUDINARY TEST ===\n";
    
    // Test config
    $config = require_once 'config/cloudinary.php';
    echo "Cloud Name: " . $config['cloud_name'] . "\n";
    echo "API Key: " . $config['api_key'] . "\n";
    echo "API Secret: " . substr($config['api_secret'], 0, 10) . "...\n\n";
    
    // Test CloudinaryAPI instance
    $cloudinary = new CloudinaryAPI();
    echo "CloudinaryAPI instance created successfully\n";
    
    // Test with a small test image
    $testImageContent = base64_decode('iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAADUlEQVR42mNkYPhfDwAChwGA60e6kgAAAABJRU5ErkJggg==');
    $testImagePath = 'test_image.png';
    file_put_contents($testImagePath, $testImageContent);
    
    echo "Test image created: " . $testImagePath . "\n";
    
    // Test upload
    $result = $cloudinary->uploadImage($testImagePath, [
        'folder' => 'restaurant/menu',
        'public_id' => 'test_image_' . time()
    ]);
    
    echo "Upload result:\n";
    print_r($result);
    
    // Clean up
    unlink($testImagePath);
    echo "Test image cleaned up\n";
    
} catch (Exception $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
    echo "Stack trace:\n" . $e->getTraceAsString() . "\n";
}
?>
