<?php

require_once 'models/MenuModel.php';
require_once 'models/CloudinaryAPI.php';

class AdminController {
    private $menuModel;
    private $cloudinary;
    
    public function __construct() {
        $this->menuModel = new MenuModel();
        $this->cloudinary = new CloudinaryAPI();
    }
    
    public function index() {
        // Trang admin chính
        $menuItems = $this->menuModel->getMenuItems();
        include 'views/admin_dashboard.php';
    }
    
    public function menu() {
        // Trang quản lý menu
        $menuItems = $this->menuModel->getMenuItems();
        include 'views/admin_menu.php';
    }
    
    public function getMenuItems() {
        // API endpoint để lấy danh sách menu items
        header('Content-Type: application/json');
        
        try {
            $items = $this->menuModel->getMenuItems();
            
            echo json_encode([
                'success' => true,
                'items' => $items
            ]);
            
        } catch (Exception $e) {
            error_log('getMenuItems error: ' . $e->getMessage());
            http_response_code(500);
            echo json_encode([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }
    
    public function addMenuItem() {
        // API để thêm món ăn mới
        header('Content-Type: application/json');
        
        try {
            $input = json_decode(file_get_contents('php://input'), true);
            
            if (!$input || !isset($input['name']) || !isset($input['price'])) {
                throw new Exception('Thiếu thông tin món ăn');
            }
            
            $result = $this->menuModel->addMenuItem(
                $input['name'],
                $input['description'] ?? '',
                (int)$input['price'],
                $input['image'] ?? null
            );
            
            if ($result) {
                // Get the newly created item ID
                $itemId = $this->menuModel->getLastInsertId();
                
                echo json_encode([
                    'success' => true,
                    'message' => 'Thêm món ăn thành công!',
                    'itemId' => $itemId
                ]);
            } else {
                throw new Exception('Không thể thêm món ăn');
            }
            
        } catch (Exception $e) {
            error_log('addMenuItem error: ' . $e->getMessage());
            http_response_code(400);
            echo json_encode([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }
    
    public function updateMenuItem() {
        // API để cập nhật món ăn
        header('Content-Type: application/json');
        
        try {
            error_log('updateMenuItem called');
            
            $input = json_decode(file_get_contents('php://input'), true);
            error_log('Input data: ' . print_r($input, true));
            
            if (!$input || !isset($input['id'])) {
                throw new Exception('Thiếu ID món ăn');
            }
            
            // Check if menuModel is initialized
            if (!$this->menuModel) {
                throw new Exception('MenuModel not initialized');
            }
            
            error_log('About to call menuModel->updateMenuItem with ID: ' . $input['id']);
            
            $result = $this->menuModel->updateMenuItem(
                $input['id'],
                $input['name'] ?? null,
                $input['description'] ?? null,
                $input['price'] ?? null,
                $input['image'] ?? null,
                $input['status'] ?? null
            );
            
            error_log('MenuModel->updateMenuItem result: ' . ($result ? 'true' : 'false'));
            
            if ($result) {
                echo json_encode([
                    'success' => true,
                    'message' => 'Cập nhật món ăn thành công!'
                ]);
            } else {
                throw new Exception('Không thể cập nhật món ăn');
            }
            
        } catch (Exception $e) {
            error_log('updateMenuItem error: ' . $e->getMessage());
            http_response_code(400);
            echo json_encode([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }
    
    public function deleteMenuItem() {
        // API để xóa món ăn
        header('Content-Type: application/json');
        
        try {
            $input = json_decode(file_get_contents('php://input'), true);
            
            if (!$input || !isset($input['id'])) {
                throw new Exception('Thiếu ID món ăn');
            }
            
            $result = $this->menuModel->deleteMenuItem($input['id']);
            
            if ($result) {
                echo json_encode([
                    'success' => true,
                    'message' => 'Xóa món ăn thành công!'
                ]);
            } else {
                throw new Exception('Không thể xóa món ăn');
            }
            
        } catch (Exception $e) {
            error_log('deleteMenuItem error: ' . $e->getMessage());
            http_response_code(400);
            echo json_encode([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }
    
    public function uploadImage() {
        // API để upload ảnh cho món ăn
        header('Content-Type: application/json');
        
        try {
            if (!isset($_FILES['imageFile']) || !isset($_POST['itemId'])) {
                throw new Exception('Thiếu dữ liệu upload');
            }
            
            $itemId = $_POST['itemId'];
            $uploadFile = $_FILES['imageFile'];
            
            // Kiểm tra lỗi upload
            if ($uploadFile['error'] !== UPLOAD_ERR_OK) {
                throw new Exception('Lỗi upload file: ' . $uploadFile['error']);
            }
            
            // Kiểm tra loại file
            $allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif', 'image/webp'];
            if (!in_array($uploadFile['type'], $allowedTypes)) {
                throw new Exception('Chỉ chấp nhận file ảnh (JPG, PNG, GIF, WebP)');
            }
            
            // Kiểm tra kích thước (max 5MB)
            if ($uploadFile['size'] > 5 * 1024 * 1024) {
                throw new Exception('File quá lớn (tối đa 5MB)');
            }
            
            // Tạo tên file an toàn
            $fileExtension = pathinfo($uploadFile['name'], PATHINFO_EXTENSION);
            $safeFileName = 'menu_item_' . $itemId . '_' . time() . '.' . $fileExtension;
            
            // Đường dẫn upload
            $uploadDir = 'assets/images/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }
            
            $uploadPath = $uploadDir . $safeFileName;
            
            // Di chuyển file
            if (!move_uploaded_file($uploadFile['tmp_name'], $uploadPath)) {
                throw new Exception('Không thể lưu file');
            }
            
            // Cập nhật database
            $imagePath = 'images/' . $safeFileName;
            
            if ($this->menuModel->updateMenuItemImage($itemId, $imagePath)) {
                echo json_encode([
                    'success' => true,
                    'message' => 'Upload ảnh thành công!',
                    'imagePath' => $imagePath,
                    'fileName' => $safeFileName
                ]);
            } else {
                // Xóa file nếu cập nhật DB thất bại
                unlink($uploadPath);
                throw new Exception('Không thể cập nhật database');
            }
            
        } catch (Exception $e) {
            error_log('uploadImage error: ' . $e->getMessage());
            http_response_code(400);
            echo json_encode([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }
    
    public function uploadImageCloudinary() {
        // API để upload ảnh lên Cloudinary
        header('Content-Type: application/json');
        
        try {
            error_log('uploadImageCloudinary called');
            error_log('FILES: ' . print_r($_FILES, true));
            error_log('POST: ' . print_r($_POST, true));
            
            if (!isset($_FILES['imageFile']) || !isset($_POST['itemId'])) {
                throw new Exception('Thiếu dữ liệu upload - Files: ' . (isset($_FILES['imageFile']) ? 'yes' : 'no') . ', ItemId: ' . (isset($_POST['itemId']) ? 'yes' : 'no'));
            }
            
            // Check if we should use Cloudinary or local storage
            $config = include __DIR__ . '/../config/cloudinary.php';
            $useCloudinary = $config['use_cloudinary'] ?? true;
            
            if (!$useCloudinary) {
                // Use local storage instead
                error_log('Using local storage instead of Cloudinary');
                $this->uploadImageLocal($_POST['itemId'], $_FILES['imageFile']);
                return;
            }
            
            // Continue with Cloudinary upload
            $itemId = $_POST['itemId'];
            $uploadFile = $_FILES['imageFile'];
            
            // Check CloudinaryAPI initialization
            if (!$this->cloudinary) {
                throw new Exception('CloudinaryAPI not initialized');
            }
            error_log('CloudinaryAPI initialized successfully');
            
            // Kiểm tra lỗi upload
            if ($uploadFile['error'] !== UPLOAD_ERR_OK) {
                throw new Exception('Lỗi upload file: ' . $uploadFile['error']);
            }
            
            // Kiểm tra loại file
            $allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif', 'image/webp'];
            if (!in_array($uploadFile['type'], $allowedTypes)) {
                throw new Exception('Chỉ chấp nhận file ảnh (JPG, PNG, GIF, WebP)');
            }
            
            // Kiểm tra kích thước (max 10MB cho cloud)
            if ($uploadFile['size'] > 10 * 1024 * 1024) {
                throw new Exception('File quá lớn (tối đa 10MB)');
            }
            
            // Upload lên Cloudinary
            $uploadOptions = [
                'folder' => 'restaurant/menu',
                'public_id' => 'menu_item_' . $itemId . '_' . time(),
                'tags' => ['restaurant', 'menu', 'item_' . $itemId]
            ];
            
            error_log('About to upload to Cloudinary with options: ' . print_r($uploadOptions, true));

            $result = $this->cloudinary->uploadImage($uploadFile['tmp_name'], $uploadOptions);
            
            error_log('Cloudinary upload result: ' . print_r($result, true));

            if (!$result || !isset($result['public_id'])) {
                throw new Exception('Upload lên Cloudinary thất bại');
            }

            // Lưu Cloudinary URL vào database
            $cloudinaryImageUrl = $result['secure_url'];
            
            if ($this->menuModel->updateMenuItemImage($itemId, $cloudinaryImageUrl)) {
                // Tạo URLs cho different sizes
                $thumbnailUrl = $this->cloudinary->getImageUrl($result['public_id'], 'menu_thumb');
                $largeUrl = $this->cloudinary->getImageUrl($result['public_id'], 'menu_large');
                
                echo json_encode([
                    'success' => true,
                    'message' => 'Upload ảnh lên Cloudinary thành công!',
                    'publicId' => $result['public_id'],
                    'imageUrl' => $cloudinaryImageUrl,
                    'thumbnailUrl' => $thumbnailUrl,
                    'largeUrl' => $largeUrl,
                    'cloudinaryData' => [
                        'url' => $result['secure_url'],
                        'format' => $result['format'],
                        'width' => $result['width'],
                        'height' => $result['height'],
                        'bytes' => $result['bytes']
                    ]
                ]);
            } else {
                // Xóa khỏi Cloudinary nếu cập nhật DB thất bại
                $this->cloudinary->deleteImage($result['public_id']);
                throw new Exception('Không thể cập nhật database');
            }
            
        } catch (Exception $e) {
            error_log('uploadImageCloudinary error: ' . $e->getMessage());
            http_response_code(400);
            echo json_encode([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }
    
    /**
     * Upload image to local storage (fallback for development)
     */
    private function uploadImageLocal($itemId, $uploadFile) {
        try {
            error_log('uploadImageLocal called for item: ' . $itemId);
            
            // Kiểm tra lỗi upload
            if ($uploadFile['error'] !== UPLOAD_ERR_OK) {
                throw new Exception('Lỗi upload file: ' . $uploadFile['error']);
            }
            
            // Kiểm tra loại file
            $allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif', 'image/webp'];
            $uploadedType = $uploadFile['type'];
            
            // Fallback: check by extension if MIME type is not available
            if (empty($uploadedType)) {
                $extension = strtolower(pathinfo($uploadFile['name'], PATHINFO_EXTENSION));
                $mimeTypes = [
                    'jpg' => 'image/jpeg',
                    'jpeg' => 'image/jpeg',
                    'png' => 'image/png',
                    'gif' => 'image/gif',
                    'webp' => 'image/webp'
                ];
                $uploadedType = $mimeTypes[$extension] ?? '';
            }
            
            if (!in_array($uploadedType, $allowedTypes)) {
                throw new Exception('Chỉ chấp nhận file ảnh (JPG, PNG, GIF, WebP). Type: ' . $uploadedType);
            }
            
            // Kiểm tra kích thước (max 5MB cho local)
            if ($uploadFile['size'] > 5 * 1024 * 1024) {
                throw new Exception('File quá lớn (tối đa 5MB)');
            }
            
            // Tạo tên file an toàn
            $fileExtension = pathinfo($uploadFile['name'], PATHINFO_EXTENSION);
            $safeFileName = 'menu_item_' . $itemId . '_' . time() . '.' . $fileExtension;
            
            // Đường dẫn upload
            $config = include __DIR__ . '/../config/cloudinary.php';
            $uploadDir = $config['local_upload_dir'] ?? 'assets/images/';
            
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
                error_log('Created upload directory: ' . $uploadDir);
            }
            
            $uploadPath = $uploadDir . $safeFileName;
            
            // Di chuyển file
            if (!move_uploaded_file($uploadFile['tmp_name'], $uploadPath)) {
                throw new Exception('Không thể lưu file vào: ' . $uploadPath);
            }
            
            error_log('File uploaded to: ' . $uploadPath);
            
            // Cập nhật database với relative path
            $relativePath = ($config['local_upload_url'] ?? 'images/') . $safeFileName;
            
            if ($this->menuModel->updateMenuItemImage($itemId, $relativePath)) {
                echo json_encode([
                    'success' => true,
                    'message' => 'Upload ảnh thành công! (Local Storage)',
                    'imagePath' => $relativePath,
                    'fileName' => $safeFileName,
                    'fullPath' => $uploadPath,
                    'fileSize' => $uploadFile['size'],
                    'storage' => 'local'
                ]);
            } else {
                // Xóa file nếu cập nhật DB thất bại
                unlink($uploadPath);
                throw new Exception('Không thể cập nhật database');
            }
            
        } catch (Exception $e) {
            error_log('uploadImageLocal error: ' . $e->getMessage());
            http_response_code(400);
            echo json_encode([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }
    
    public function deleteImageCloudinary() {
        // API để xóa ảnh từ Cloudinary
        header('Content-Type: application/json');
        
        try {
            $input = json_decode(file_get_contents('php://input'), true);
            
            if (!$input || !isset($input['publicId'])) {
                throw new Exception('Thiếu public ID');
            }
            
            $publicId = $input['publicId'];
            
            // Xóa từ Cloudinary
            $result = $this->cloudinary->deleteImage($publicId);
            
            if ($result && isset($result['result']) && $result['result'] === 'ok') {
                echo json_encode([
                    'success' => true,
                    'message' => 'Xóa ảnh khỏi cloud thành công!'
                ]);
            } else {
                throw new Exception('Không thể xóa ảnh khỏi Cloudinary');
            }
            
        } catch (Exception $e) {
            error_log('deleteImageCloudinary error: ' . $e->getMessage());
            http_response_code(400);
            echo json_encode([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }
    
    public function testCloudinary() {
        // API để test kết nối Cloudinary
        header('Content-Type: application/json');
        
        try {
            $result = $this->cloudinary->testConnection();
            
            echo json_encode([
                'success' => $result['success'],
                'message' => $result['success'] ? 'Kết nối Cloudinary thành công!' : 'Lỗi kết nối Cloudinary',
                'data' => $result
            ]);
            
        } catch (Exception $e) {
            echo json_encode([
                'success' => false,
                'message' => 'Lỗi test Cloudinary: ' . $e->getMessage()
            ]);
        }
    }
    
    public function clearBrokenImage() {
        // API để clear broken image URL from database
        header('Content-Type: application/json');
        
        try {
            $input = json_decode(file_get_contents('php://input'), true);
            $itemId = $input['id'];
            
            if (empty($itemId)) {
                throw new Exception('Item ID is required');
            }
            
            // Clear image URL in database
            $result = $this->menuModel->clearImageUrl($itemId);
            
            if ($result) {
                echo json_encode([
                    'success' => true,
                    'message' => 'Broken image URL cleared successfully'
                ]);
            } else {
                echo json_encode([
                    'success' => false,
                    'message' => 'Failed to clear image URL'
                ]);
            }
            
        } catch (Exception $e) {
            error_log('clearBrokenImage error: ' . $e->getMessage());
            http_response_code(400);
            echo json_encode([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    /**
     * Clean up invalid image URL from database when image fails to load
     */
    public function cleanupInvalidImage() {
        header('Content-Type: application/json');
        
        try {
            $input = json_decode(file_get_contents('php://input'), true);
            
            if (!isset($input['itemId']) || !isset($input['imageUrl'])) {
                throw new Exception('Missing required data');
            }
            
            $itemId = $input['itemId'];
            $imageUrl = $input['imageUrl'];
            
            error_log("Cleaning up invalid image URL for item $itemId: $imageUrl");
            
            // Only clean up if it's a Cloudinary URL (to be safe)
            if (strpos($imageUrl, 'cloudinary.com') !== false) {
                // Clear the image field in database
                if ($this->menuModel->updateMenuItemImage($itemId, null)) {
                    echo json_encode([
                        'success' => true,
                        'message' => 'Invalid image URL cleaned up successfully'
                    ]);
                } else {
                    throw new Exception('Failed to update database');
                }
            } else {
                echo json_encode([
                    'success' => false,
                    'message' => 'Not a Cloudinary URL, skipping cleanup'
                ]);
            }
            
        } catch (Exception $e) {
            error_log('cleanupInvalidImage error: ' . $e->getMessage());
            http_response_code(400);
            echo json_encode([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }
}
