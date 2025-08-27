<?php

class RestaurantController
{
    public function home()
    {
        // Display the restaurant home page
        include 'views/restaurant_home.php';
    }
    
    public function index()
    {
        // Redirect to home page
        $this->home();
    }
    
    public function ridayDashboard()
    {
        // Load the new Riday-style dashboard
        include 'views/riday_dashboard.php';
    }
    
    public function menu()
    {
        $tableNumber = (int)($_GET['table'] ?? 1);
        $categoryId = $_GET['category'] ?? null;
        
        // Load menu từ database
        require_once 'models/MenuModel.php';
        $menuModel = new MenuModel();
        
        // Lấy danh sách categories
        $categories = $menuModel->getCategories();
        
        // Lấy menu items theo category (nếu có)
        if ($categoryId && $categoryId !== 'all') {
            $menuItems = $menuModel->getMenuItemsByCategory($categoryId);
        } else {
            $menuItems = $menuModel->getMenuItems();
        }
        
        // Include file menu động từ database
        include 'views/menu_dynamic.php';
    }
    
    public function getMenuItems()
    {
        // API endpoint để lấy danh sách menu items
        header('Content-Type: application/json');
        
        try {
            require_once 'models/MenuModel.php';
            $menuModel = new MenuModel();
            $menuItems = $menuModel->getMenuItems();
            
            echo json_encode([
                'success' => true,
                'menuItems' => $menuItems
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
    
    public function updateMenuItemImage()
    {
        // API endpoint để cập nhật ảnh món ăn
        header('Content-Type: application/json');
        
        try {
            $input = json_decode(file_get_contents('php://input'), true);
            
            if (!$input || !isset($input['itemName']) || !isset($input['imagePath'])) {
                throw new Exception('Dữ liệu không hợp lệ');
            }
            
            require_once 'models/MenuModel.php';
            $menuModel = new MenuModel();
            $result = $menuModel->updateMenuItemImage($input['itemName'], $input['imagePath']);
            
            if ($result) {
                echo json_encode([
                    'success' => true,
                    'message' => 'Cập nhật ảnh thành công!'
                ]);
            } else {
                throw new Exception('Không thể cập nhật ảnh');
            }
            
        } catch (Exception $e) {
            error_log('updateMenuItemImage error: ' . $e->getMessage());
            http_response_code(400);
            echo json_encode([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }
}
