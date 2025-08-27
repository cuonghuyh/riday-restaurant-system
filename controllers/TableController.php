<?php

require_once 'models/TableModel.php';

class TableController {
    private $tableModel;
    
    public function __construct() {
        $this->tableModel = new TableModel();
    }
    
    /**
     * Hiển thị trang quản lý bàn
     */
    public function index() {
        include 'views/table_management.php';
    }
    
    /**
     * API: Lấy tất cả bàn
     */
    public function getAllTables() {
        header('Content-Type: application/json');
        
        try {
            $tables = $this->tableModel->getAllTables();
            
            echo json_encode([
                'success' => true,
                'tables' => $tables
            ]);
            
        } catch (Exception $e) {
            error_log('TableController::getAllTables error: ' . $e->getMessage());
            http_response_code(500);
            echo json_encode([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }
    
    /**
     * API: Thêm bàn mới
     */
    public function addTable() {
        header('Content-Type: application/json');
        
        try {
            $input = json_decode(file_get_contents('php://input'), true);
            
            if (!$input || !isset($input['table_number'])) {
                throw new Exception('Dữ liệu không hợp lệ');
            }
            
            $tableNumber = intval($input['table_number']);
            $capacity = intval($input['capacity'] ?? 4);
            $location = trim($input['location'] ?? '');
            $status = $input['status'] ?? 'available';
            
            if ($tableNumber <= 0) {
                throw new Exception('Số bàn phải lớn hơn 0');
            }
            
            if ($capacity <= 0 || $capacity > 20) {
                throw new Exception('Số chỗ ngồi phải từ 1-20');
            }
            
            $result = $this->tableModel->addTable($tableNumber, $capacity, $location, $status);
            
            echo json_encode($result);
            
        } catch (Exception $e) {
            error_log('TableController::addTable error: ' . $e->getMessage());
            http_response_code(400);
            echo json_encode([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }
    
    /**
     * API: Cập nhật thông tin bàn
     */
    public function updateTable() {
        header('Content-Type: application/json');
        
        try {
            $input = json_decode(file_get_contents('php://input'), true);
            
            if (!$input || !isset($input['id']) || !isset($input['table_number'])) {
                throw new Exception('Dữ liệu không hợp lệ');
            }
            
            $id = intval($input['id']);
            $tableNumber = intval($input['table_number']);
            $capacity = intval($input['capacity'] ?? 4);
            $location = trim($input['location'] ?? '');
            $status = $input['status'] ?? 'available';
            
            if ($id <= 0) {
                throw new Exception('ID bàn không hợp lệ');
            }
            
            if ($tableNumber <= 0) {
                throw new Exception('Số bàn phải lớn hơn 0');
            }
            
            if ($capacity <= 0 || $capacity > 20) {
                throw new Exception('Số chỗ ngồi phải từ 1-20');
            }
            
            $result = $this->tableModel->updateTable($id, $tableNumber, $capacity, $location, $status);
            
            echo json_encode($result);
            
        } catch (Exception $e) {
            error_log('TableController::updateTable error: ' . $e->getMessage());
            http_response_code(400);
            echo json_encode([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }
    
    /**
     * API: Xóa bàn
     */
    public function deleteTable() {
        header('Content-Type: application/json');
        
        try {
            $input = json_decode(file_get_contents('php://input'), true);
            
            if (!$input || !isset($input['id'])) {
                throw new Exception('ID bàn không hợp lệ');
            }
            
            $id = intval($input['id']);
            
            if ($id <= 0) {
                throw new Exception('ID bàn không hợp lệ');
            }
            
            $result = $this->tableModel->deleteTable($id);
            
            echo json_encode($result);
            
        } catch (Exception $e) {
            error_log('TableController::deleteTable error: ' . $e->getMessage());
            http_response_code(400);
            echo json_encode([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }
    
    /**
     * API: Lấy thống kê bàn
     */
    public function getTableStats() {
        header('Content-Type: application/json');
        
        try {
            $stats = $this->tableModel->getTableStats();
            
            echo json_encode([
                'success' => true,
                'stats' => $stats
            ]);
            
        } catch (Exception $e) {
            error_log('TableController::getTableStats error: ' . $e->getMessage());
            http_response_code(500);
            echo json_encode([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }
    
    /**
     * API: Tạo bàn mẫu
     */
    public function createSampleTables() {
        header('Content-Type: application/json');
        
        try {
            $result = $this->tableModel->createSampleTables();
            echo json_encode($result);
            
        } catch (Exception $e) {
            error_log('TableController::createSampleTables error: ' . $e->getMessage());
            http_response_code(400);
            echo json_encode([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }
    
    /**
     * API: Cập nhật trạng thái bàn nhanh
     */
    public function updateTableStatus() {
        header('Content-Type: application/json');
        
        try {
            $input = json_decode(file_get_contents('php://input'), true);
            
            if (!$input || !isset($input['table_number']) || !isset($input['status'])) {
                throw new Exception('Dữ liệu không hợp lệ');
            }
            
            $tableNumber = intval($input['table_number']);
            $status = $input['status'];
            
            $allowedStatuses = ['available', 'occupied', 'reserved', 'maintenance'];
            if (!in_array($status, $allowedStatuses)) {
                throw new Exception('Trạng thái không hợp lệ');
            }
            
            $result = $this->tableModel->updateTableStatus($tableNumber, $status);
            
            if ($result) {
                echo json_encode([
                    'success' => true,
                    'message' => "Cập nhật trạng thái bàn $tableNumber thành công!"
                ]);
            } else {
                echo json_encode([
                    'success' => false,
                    'message' => 'Không thể cập nhật trạng thái'
                ]);
            }
            
        } catch (Exception $e) {
            error_log('TableController::updateTableStatus error: ' . $e->getMessage());
            http_response_code(400);
            echo json_encode([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }
}

?>
