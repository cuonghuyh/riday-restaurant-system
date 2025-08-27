<?php

require_once __DIR__ . '/DB.php';

class MenuModel
{
    /** @var PDO */
    private $db;

    public function __construct()
    {
        $this->db = DB::getInstance();
    }
    
    public function getCategories()
    {
        try {
            $stmt = $this->db->prepare('SELECT * FROM categories WHERE status = :status ORDER BY display_order, name');
            $stmt->execute([':status' => 'active']);
            $categories = $stmt->fetchAll();
            
            if (empty($categories)) {
                // Fallback categories nếu chưa có data
                return [
                    ['id' => 1, 'name' => 'Khai vị', 'icon' => '🥟'],
                    ['id' => 2, 'name' => 'Món chính', 'icon' => '🍜'],
                    ['id' => 3, 'name' => 'Tráng miệng', 'icon' => '🍮'],
                    ['id' => 4, 'name' => 'Đồ uống', 'icon' => '🥤']
                ];
            }
            
            return $categories;
        } catch (Exception $e) {
            error_log('MenuModel::getCategories error: ' . $e->getMessage());
            // Fallback categories nếu chưa có bảng categories
            return [
                ['id' => 1, 'name' => 'Khai vị', 'icon' => '🥟'],
                ['id' => 2, 'name' => 'Món chính', 'icon' => '🍜'],
                ['id' => 3, 'name' => 'Tráng miệng', 'icon' => '🍮'],
                ['id' => 4, 'name' => 'Đồ uống', 'icon' => '🥤']
            ];
        }
    }
    
    public function getMenuItems($categoryId = null)
    {
        try {
            if ($categoryId) {
                $stmt = $this->db->prepare('SELECT m.*, c.name as category_name, c.icon as category_icon 
                                          FROM menu_items m 
                                          LEFT JOIN categories c ON m.category_id = c.id 
                                          WHERE m.status = :status AND m.category_id = :category_id 
                                          ORDER BY m.name');
                $stmt->execute([':status' => 'available', ':category_id' => $categoryId]);
            } else {
                $stmt = $this->db->prepare('SELECT m.*, c.name as category_name, c.icon as category_icon 
                                          FROM menu_items m 
                                          LEFT JOIN categories c ON m.category_id = c.id 
                                          WHERE m.status = :status 
                                          ORDER BY c.display_order, m.name');
                $stmt->execute([':status' => 'available']);
            }
            return $stmt->fetchAll();
        } catch (Exception $e) {
            error_log('MenuModel::getMenuItems error: ' . $e->getMessage());
            // Fallback to hardcoded data if database fails
            return [
                [
                    'id' => 1,
                    'name' => 'Ramen Tonkotsu',
                    'price' => 85000,
                    'description' => 'Ramen nước dùng xương heo đậm đà',
                    'image' => '',
                    'status' => 'available',
                    'category_id' => 2,
                    'category_name' => 'Món chính',
                    'category_icon' => '🍜'
                ],
                [
                    'id' => 2,
                    'name' => 'Gyoza',
                    'price' => 45000,
                    'description' => 'Bánh bao chiên nhân thịt (6 cái)',
                    'image' => '',
                    'status' => 'available',
                    'category_id' => 1,
                    'category_name' => 'Khai vị',
                    'category_icon' => '🥟'
                ],
                [
                    'id' => 3,
                    'name' => 'Sushi Set',
                    'price' => 120000,
                    'description' => 'Set sushi tuyển chọn',
                    'image' => '',
                    'status' => 'available',
                    'category_id' => 2,
                    'category_name' => 'Món chính',
                    'category_icon' => '🍜'
                ]
            ];
        }
    }

    public function getMenuItemById($id)
    {
        try {
            $stmt = $this->db->prepare('SELECT * FROM menu_items WHERE id = :id');
            $stmt->execute([':id' => $id]);
            return $stmt->fetch();
        } catch (Exception $e) {
            error_log('MenuModel::getMenuItemById error: ' . $e->getMessage());
            return null;
        }
    }

    public function getMenuItemsByCategory($categoryId)
    {
        try {
            if ($categoryId === 'all' || !$categoryId) {
                return $this->getMenuItems();
            }
            
            return $this->getMenuItems($categoryId);
        } catch (Exception $e) {
            error_log('MenuModel::getMenuItemsByCategory error: ' . $e->getMessage());
            return [];
        }
    }
    
    public function updateMenuItemImage($itemId, $imagePath)
    {
        try {
            // Nếu itemId là string (tên món), tìm theo tên
            if (!is_numeric($itemId)) {
                $stmt = $this->db->prepare('UPDATE menu_items SET image = :image WHERE name = :name');
                $result = $stmt->execute([
                    ':image' => $imagePath,
                    ':name' => $itemId
                ]);
            } else {
                // Nếu itemId là số, tìm theo ID
                $stmt = $this->db->prepare('UPDATE menu_items SET image = :image WHERE id = :id');
                $result = $stmt->execute([
                    ':image' => $imagePath,
                    ':id' => $itemId
                ]);
            }
            
            return $result && $stmt->rowCount() > 0;
        } catch (Exception $e) {
            error_log('MenuModel::updateMenuItemImage error: ' . $e->getMessage());
            return false;
        }
    }
    
    public function updateMenuItem($id, $name = null, $description = null, $price = null, $image = null, $status = null)
    {
        try {
            $updates = [];
            $params = [':id' => $id];
            
            if ($name !== null) {
                $updates[] = 'name = :name';
                $params[':name'] = $name;
            }
            
            if ($description !== null) {
                $updates[] = 'description = :description';
                $params[':description'] = $description;
            }
            
            if ($price !== null) {
                $updates[] = 'price = :price';
                $params[':price'] = $price;
            }
            
            if ($image !== null) {
                $updates[] = 'image = :image';
                $params[':image'] = $image;
            }
            
            if ($status !== null) {
                $updates[] = 'status = :status';
                $params[':status'] = $status;
            }
            
            if (empty($updates)) {
                return false;
            }
            
            $sql = 'UPDATE menu_items SET ' . implode(', ', $updates) . ' WHERE id = :id';
            $stmt = $this->db->prepare($sql);
            return $stmt->execute($params) && $stmt->rowCount() > 0;
            
        } catch (Exception $e) {
            error_log('MenuModel::updateMenuItem error: ' . $e->getMessage());
            return false;
        }
    }
    
    public function deleteMenuItem($id)
    {
        try {
            // Kiểm tra xem có order_items nào đang reference đến menu item này không
            $stmt = $this->db->prepare('SELECT COUNT(*) as count FROM order_items WHERE menu_item_id = :id');
            $stmt->execute([':id' => $id]);
            $result = $stmt->fetch();
            
            if ($result['count'] > 0) {
                throw new Exception("Không thể xóa món ăn này vì đã có {$result['count']} đơn hàng sử dụng món này. Vui lòng đặt trạng thái 'Hết hàng' thay vì xóa.");
            }
            
            // Lấy thông tin ảnh trước khi xóa để xóa file
            $item = $this->getMenuItemById($id);
            
            $stmt = $this->db->prepare('DELETE FROM menu_items WHERE id = :id');
            $result = $stmt->execute([':id' => $id]);
            
            // Xóa file ảnh nếu có
            if ($result && $item && !empty($item['image'])) {
                $imagePath = 'assets/' . $item['image'];
                if (file_exists($imagePath)) {
                    unlink($imagePath);
                }
            }
            
            return $result && $stmt->rowCount() > 0;
        } catch (Exception $e) {
            error_log('MenuModel::deleteMenuItem error: ' . $e->getMessage());
            
            // Re-throw the exception để AdminController có thể hiển thị message
            throw $e;
        }
    }
    
    public function canDeleteMenuItem($id)
    {
        try {
            $stmt = $this->db->prepare('SELECT COUNT(*) as count FROM order_items WHERE menu_item_id = :id');
            $stmt->execute([':id' => $id]);
            $result = $stmt->fetch();
            
            return $result['count'] == 0;
        } catch (Exception $e) {
            error_log('MenuModel::canDeleteMenuItem error: ' . $e->getMessage());
            return false;
        }
    }
    
    public function addMenuItem($name, $description, $price, $imagePath = null)
    {
        try {
            $stmt = $this->db->prepare('INSERT INTO menu_items (name, description, price, image, status) VALUES (:name, :description, :price, :image, :status)');
            return $stmt->execute([
                ':name' => $name,
                ':description' => $description,
                ':price' => $price,
                ':image' => $imagePath,
                ':status' => 'available'
            ]);
        } catch (Exception $e) {
            error_log('MenuModel::addMenuItem error: ' . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Lấy URL ảnh từ Cloudinary hoặc local
     * 
     * @param string $imagePath Path hoặc public_id của ảnh
     * @param string $size Size ảnh (thumb, large)
     * @return string|null URL ảnh
     */
    public function getImageUrl($imagePath, $size = 'thumb') {
        if (empty($imagePath)) {
            return null;
        }
        
        // Nếu là Cloudinary public_id (không có extension)
        if (!preg_match('/\.(jpg|jpeg|png|gif|webp)$/i', $imagePath)) {
            try {
                require_once __DIR__ . '/CloudinaryAPI.php';
                $cloudinary = new CloudinaryAPI();
                return $cloudinary->getImageUrl($imagePath, 'menu_' . $size);
            } catch (Exception $e) {
                error_log('Error generating Cloudinary URL: ' . $e->getMessage());
                return null;
            }
        }
        
        // Nếu là local path
        if (strpos($imagePath, 'assets/') === 0) {
            return $imagePath;
        }
        
        return 'assets/' . $imagePath;
    }
    
    /**
     * Kiểm tra xem ảnh có phải từ Cloudinary không
     * 
     * @param string $imagePath
     * @return bool
     */
    public function isCloudinaryImage($imagePath) {
        if (empty($imagePath)) {
            return false;
        }
        
        // Cloudinary public_id thường không có extension
        return !preg_match('/\.(jpg|jpeg|png|gif|webp)$/i', $imagePath);
    }
}
