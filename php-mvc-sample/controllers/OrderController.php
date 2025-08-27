    <?php
require_once 'models/OrderModel.php';

class OrderController {
    private $orderModel;
    
    public function __construct() {
        $this->orderModel = new OrderModel();
    }
    
    public function index() {
        // Staff dashboard - redirect to new Riday dashboard
        include 'views/riday_dashboard.php';
    }
    
    public function getCurrentOrders() {
        // API endpoint để lấy đơn hàng hiện tại (pending, preparing)
        header('Content-Type: application/json');
        
        try {
            $orders = $this->orderModel->getCurrentOrders();
            
            echo json_encode([
                'success' => true,
                'orders' => $orders
            ]);
            
        } catch (Exception $e) {
            error_log('getCurrentOrders error: ' . $e->getMessage());
            http_response_code(500);
            echo json_encode([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }
    
    public function getCompletedOrders() {
        // API endpoint để lấy đơn hàng đã hoàn thành
        header('Content-Type: application/json');
        
        try {
            $orders = $this->orderModel->getCompletedOrders();
            
            echo json_encode([
                'success' => true,
                'orders' => $orders
            ]);
            
        } catch (Exception $e) {
            error_log('getCompletedOrders error: ' . $e->getMessage());
            http_response_code(500);
            echo json_encode([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }
    
    public function getAllOrders() {
        // API endpoint để lấy tất cả đơn hàng (JSON)
        header('Content-Type: application/json');
        
        try {
            $orders = $this->orderModel->getAllOrders();
            
            echo json_encode([
                'success' => true,
                'orders' => $orders
            ]);
            
        } catch (Exception $e) {
            error_log('getAllOrders error: ' . $e->getMessage());
            http_response_code(500);
            echo json_encode([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }
    
    public function dashboard() {
        // Redirect to new Riday dashboard
        include 'views/riday_dashboard.php';
    }
    
    public function create() {
        // API endpoint để tạo đơn hàng mới từ frontend
        header('Content-Type: application/json');
        
        try {
            // Debug: Log input
            error_log('OrderController::create() called');
            $input = json_decode(file_get_contents('php://input'), true);
            error_log('Input data: ' . print_r($input, true));
            
            if (!$input || !isset($input['items']) || !isset($input['tableNumber'])) {
                throw new Exception('Dữ liệu không hợp lệ: ' . print_r($input, true));
            }
            
            $orderData = [
                'table_number' => $input['tableNumber'],
                'items' => $input['items'],
                'total_amount' => $input['totalAmount'] ?? 0,
                'service_fee' => $input['serviceFee'] ?? 10000,
                'final_total' => $input['finalTotal'] ?? ($input['totalAmount'] + 10000),
                'customer_note' => $input['note'] ?? '',
                'status' => 'pending'
            ];
            
            error_log('Order data prepared: ' . print_r($orderData, true));
            
            $orderId = $this->orderModel->createOrder($orderData);
            error_log('Order ID created: ' . $orderId);
            
            if ($orderId) {
                echo json_encode([
                    'success' => true,
                    'orderId' => $orderId,
                    'message' => 'Đặt hàng thành công!'
                ]);
            } else {
                throw new Exception('Không thể tạo đơn hàng - orderModel returned false');
            }
            
        } catch (Exception $e) {
            error_log('OrderController::create() error: ' . $e->getMessage());
            http_response_code(400);
            echo json_encode([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }
    
    public function updateStatus() {
        // API để cập nhật trạng thái đơn hàng
        header('Content-Type: application/json');
        
        try {
            // Debug: Log để kiểm tra
            error_log('updateStatus called');
            
            $input = json_decode(file_get_contents('php://input'), true);
            error_log('Input data: ' . print_r($input, true));
            
            if (!$input || !isset($input['orderId']) || !isset($input['status'])) {
                $errorMsg = 'Dữ liệu không hợp lệ: ' . print_r($input, true);
                error_log($errorMsg);
                throw new Exception($errorMsg);
            }
            
            $result = $this->orderModel->updateOrderStatus($input['orderId'], $input['status']);
            error_log('Update result: ' . ($result ? 'true' : 'false'));
            
            if ($result) {
                echo json_encode([
                    'success' => true,
                    'message' => 'Cập nhật trạng thái thành công!'
                ]);
            } else {
                throw new Exception('Không thể cập nhật trạng thái - database operation failed');
            }
            
        } catch (Exception $e) {
            error_log('updateStatus error: ' . $e->getMessage());
            http_response_code(400);
            echo json_encode([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }
    
    public function getNewOrders() {
        // API để lấy đơn hàng mới (polling cho real-time updates)
        header('Content-Type: application/json');
        
        $since = $_GET['since'] ?? '0';
        $newOrders = $this->orderModel->getOrdersSince($since);
        
        echo json_encode([
            'success' => true,
            'orders' => $newOrders,
            'timestamp' => time()
        ]);
    }
    
    public function getOrderDetail() {
        // API để lấy chi tiết đơn hàng
        header('Content-Type: application/json');
        
        try {
            $orderId = $_GET['orderId'] ?? $_GET['id'] ?? null;
            
            if (!$orderId) {
                throw new Exception('ID đơn hàng không hợp lệ');
            }
            
            $order = $this->orderModel->getOrderById($orderId);
            
            if (!$order) {
                throw new Exception('Không tìm thấy đơn hàng');
            }
            
            echo json_encode([
                'success' => true,
                'order' => $order
            ]);
            
        } catch (Exception $e) {
            http_response_code(404);
            echo json_encode([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }
    
    public function getRecentActivity() {
        // API để lấy hoạt động gần đây
        header('Content-Type: application/json');
        
        try {
            $activities = $this->orderModel->getRecentActivity();
            
            echo json_encode([
                'success' => true,
                'activities' => $activities
            ]);
        } catch (Exception $e) {
            echo json_encode([
                'success' => false,
                'message' => 'Lỗi khi tải hoạt động: ' . $e->getMessage()
            ]);
        }
    }
    
    public function getStats() {
        // API để lấy thống kê đơn hàng
        header('Content-Type: application/json');
        
        $stats = $this->orderModel->getOrderStats();
        
        echo json_encode([
            'success' => true,
            'stats' => $stats
        ]);
    }
    
    public function deleteOrder() {
        // API để xóa đơn hàng (chỉ admin)
        header('Content-Type: application/json');
        
        try {
            $input = json_decode(file_get_contents('php://input'), true);
            
            if (!$input || !isset($input['orderId'])) {
                throw new Exception('ID đơn hàng không hợp lệ');
            }
            
            $result = $this->orderModel->deleteOrder($input['orderId']);
            
            if ($result) {
                echo json_encode([
                    'success' => true,
                    'message' => 'Xóa đơn hàng thành công!'
                ]);
            } else {
                throw new Exception('Không thể xóa đơn hàng');
            }
            
        } catch (Exception $e) {
            http_response_code(400);
            echo json_encode([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }
    
    public function bulkUpdate() {
        // API để cập nhật trạng thái nhiều đơn hàng cùng lúc
        header('Content-Type: application/json');
        
        try {
            $input = json_decode(file_get_contents('php://input'), true);
            
            if (!$input || !isset($input['orderIds']) || !isset($input['action'])) {
                throw new Exception('Dữ liệu không hợp lệ');
            }
            
            $successCount = 0;
            $action = $input['action'];
            
            foreach ($input['orderIds'] as $orderId) {
                if ($action === 'delete') {
                    if ($this->orderModel->deleteOrder($orderId)) {
                        $successCount++;
                    }
                } else {
                    // Treating as status update
                    if ($this->orderModel->updateOrderStatus($orderId, $action)) {
                        $successCount++;
                    }
                }
            }
            
            echo json_encode([
                'success' => true,
                'message' => "Cập nhật thành công {$successCount} đơn hàng!",
                'updated' => $successCount,
                'total' => count($input['orderIds'])
            ]);
            
        } catch (Exception $e) {
            http_response_code(400);
            echo json_encode([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }
    
    public function resetStats() {
        // API để reset tất cả thống kê (xóa tất cả orders)
        header('Content-Type: application/json');
        
        try {
            $result = $this->orderModel->resetAllStats();
            
            if ($result) {
                echo json_encode([
                    'success' => true,
                    'message' => 'Reset thống kê thành công! Tất cả dữ liệu đã được xóa.'
                ]);
            } else {
                throw new Exception('Không thể reset dữ liệu');
            }
            
        } catch (Exception $e) {
            http_response_code(400);
            echo json_encode([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }
    
    public function getOrderUpdates() {
        // API endpoint for real-time updates
        header('Content-Type: application/json');
        
        try {
            $orderCount = $this->orderModel->getTotalOrderCount();
            $lastUpdate = $this->orderModel->getLastOrderUpdateTime();
            $stats = $this->orderModel->getDashboardStats();
            
            echo json_encode([
                'success' => true,
                'orderCount' => $orderCount,
                'lastUpdate' => $lastUpdate,
                'stats' => $stats
            ]);
            
        } catch (Exception $e) {
            echo json_encode([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }
    
    public function getOrders() {
        // API endpoint to get all orders for refresh
        header('Content-Type: application/json');
        
        try {
            $orders = $this->orderModel->getAllOrders();
            
            echo json_encode([
                'success' => true,
                'orders' => $orders
            ]);
            
        } catch (Exception $e) {
            echo json_encode([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }
}
