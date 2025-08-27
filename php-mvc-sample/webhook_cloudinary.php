<?php
// webhook_cloudinary.php - Nhận thông báo từ Cloudinary khi ảnh bị xóa
require_once 'config.php';
require_once 'models/DB.php';

// Kiểm tra signature từ Cloudinary để bảo mật
function verifyCloudinarySignature($body, $signature, $secret) {
    $expectedSignature = hash_hmac('sha1', $body, $secret);
    return hash_equals($signature, $expectedSignature);
}

// Lấy raw input
$input = file_get_contents('php://input');
$headers = getallheaders();

// Kiểm tra signature (nếu có setup webhook secret)
$signature = $headers['X-Cld-Signature'] ?? '';
// $isValid = verifyCloudinarySignature($input, $signature, 'YOUR_WEBHOOK_SECRET');

try {
    $data = json_decode($input, true);
    
    if ($data && isset($data['notification_type'])) {
        
        switch ($data['notification_type']) {
            case 'delete':
                // Khi ảnh bị xóa trên Cloudinary
                $publicId = $data['public_id'];
                
                // Extract menu item ID từ public_id (format: restaurant/menu/menu_item_1039_xxx)
                if (preg_match('/menu_item_(\d+)_/', $publicId, $matches)) {
                    $menuId = $matches[1];
                    
                    // Xóa URL ảnh trong database
                    $pdo = DB::getInstance();
                    $stmt = $pdo->prepare('UPDATE menu_items SET image = NULL WHERE id = ?');
                    $stmt->execute([$menuId]);
                    
                    error_log("Cloudinary webhook: Cleared image URL for menu item {$menuId}");
                }
                break;
                
            case 'upload':
                // Khi có ảnh mới được upload (optional - để log)
                error_log("Cloudinary webhook: New image uploaded - " . $data['public_id']);
                break;
        }
    }
    
    http_response_code(200);
    echo json_encode(['status' => 'success']);
    
} catch (Exception $e) {
    error_log("Cloudinary webhook error: " . $e->getMessage());
    http_response_code(500);
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}
?>
