<?php

require_once __DIR__ . '/DB.php';

class TableModel {
    /** @var PDO */
    private $db;

    public function __construct()
    {
        $this->db = DB::getInstance();
    }
    
    /**
     * Lấy tất cả bàn
     */
    public function getAllTables() {
        try {
            $stmt = $this->db->prepare('SELECT * FROM tables ORDER BY table_number ASC');
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            error_log('getAllTables error: ' . $e->getMessage());
            return [];
        }
    }
    
    /**
     * Thêm bàn mới
     */
    public function addTable($tableNumber, $capacity = 4, $location = '', $status = 'available') {
        try {
            // Kiểm tra bàn đã tồn tại chưa
            if ($this->isTableExists($tableNumber)) {
                return ['success' => false, 'message' => "Bàn số $tableNumber đã tồn tại!"];
            }
            
            $stmt = $this->db->prepare('INSERT INTO tables (table_number, capacity, location, status, created_at) VALUES (:table_number, :capacity, :location, :status, NOW())');
            $result = $stmt->execute([
                ':table_number' => $tableNumber,
                ':capacity' => $capacity,
                ':location' => $location,
                ':status' => $status
            ]);
            
            if ($result) {
                return [
                    'success' => true, 
                    'message' => "Thêm bàn số $tableNumber thành công!",
                    'tableId' => $this->db->lastInsertId()
                ];
            } else {
                return ['success' => false, 'message' => 'Không thể thêm bàn vào database'];
            }
        } catch (Exception $e) {
            error_log('addTable error: ' . $e->getMessage());
            return ['success' => false, 'message' => 'Lỗi database: ' . $e->getMessage()];
        }
    }
    
    /**
     * Cập nhật thông tin bàn
     */
    public function updateTable($id, $tableNumber, $capacity = 4, $location = '', $status = 'available') {
        try {
            // Kiểm tra nếu thay đổi số bàn, xem có trung không
            $currentTable = $this->getTableById($id);
            if (!$currentTable) {
                return ['success' => false, 'message' => 'Không tìm thấy bàn này!'];
            }
            
            if ($currentTable['table_number'] != $tableNumber && $this->isTableExists($tableNumber)) {
                return ['success' => false, 'message' => "Bàn số $tableNumber đã tồn tại!"];
            }
            
            $stmt = $this->db->prepare('UPDATE tables SET table_number = :table_number, capacity = :capacity, location = :location, status = :status, updated_at = NOW() WHERE id = :id');
            $result = $stmt->execute([
                ':id' => $id,
                ':table_number' => $tableNumber,
                ':capacity' => $capacity,
                ':location' => $location,
                ':status' => $status
            ]);
            
            if ($result) {
                return [
                    'success' => true, 
                    'message' => "Cập nhật bàn số $tableNumber thành công!"
                ];
            } else {
                return ['success' => false, 'message' => 'Không thể cập nhật bàn'];
            }
        } catch (Exception $e) {
            error_log('updateTable error: ' . $e->getMessage());
            return ['success' => false, 'message' => 'Lỗi database: ' . $e->getMessage()];
        }
    }
    
    /**
     * Xóa bàn
     */
    public function deleteTable($id) {
        try {
            $table = $this->getTableById($id);
            if (!$table) {
                return ['success' => false, 'message' => 'Không tìm thấy bàn này!'];
            }
            
            // Kiểm tra xem bàn có đang có đơn hàng không
            $stmt = $this->db->prepare('SELECT COUNT(*) as order_count FROM orders WHERE table_id = :table_id AND status IN ("pending", "preparing")');
            $stmt->execute([':table_id' => $table['table_number']]);
            $result = $stmt->fetch();
            
            if ($result['order_count'] > 0) {
                return ['success' => false, 'message' => 'Không thể xóa bàn đang có đơn hàng chưa hoàn thành!'];
            }
            
            $stmt = $this->db->prepare('DELETE FROM tables WHERE id = :id');
            $result = $stmt->execute([':id' => $id]);
            
            if ($result) {
                return [
                    'success' => true, 
                    'message' => "Xóa bàn số {$table['table_number']} thành công!"
                ];
            } else {
                return ['success' => false, 'message' => 'Không thể xóa bàn'];
            }
        } catch (Exception $e) {
            error_log('deleteTable error: ' . $e->getMessage());
            return ['success' => false, 'message' => 'Lỗi database: ' . $e->getMessage()];
        }
    }
    
    /**
     * Lấy thông tin bàn theo ID
     */
    public function getTableById($id) {
        try {
            $stmt = $this->db->prepare('SELECT * FROM tables WHERE id = :id');
            $stmt->execute([':id' => $id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            error_log('getTableById error: ' . $e->getMessage());
            return null;
        }
    }
    
    /**
     * Kiểm tra bàn có tồn tại không
     */
    public function isTableExists($tableNumber) {
        try {
            $stmt = $this->db->prepare('SELECT COUNT(*) as count FROM tables WHERE table_number = :table_number');
            $stmt->execute([':table_number' => $tableNumber]);
            $result = $stmt->fetch();
            return $result['count'] > 0;
        } catch (Exception $e) {
            error_log('isTableExists error: ' . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Cập nhật trạng thái bàn
     */
    public function updateTableStatus($tableNumber, $status) {
        try {
            $stmt = $this->db->prepare('UPDATE tables SET status = :status, updated_at = NOW() WHERE table_number = :table_number');
            $result = $stmt->execute([
                ':status' => $status,
                ':table_number' => $tableNumber
            ]);
            
            return $result;
        } catch (Exception $e) {
            error_log('updateTableStatus error: ' . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Lấy thống kê bàn
     */
    public function getTableStats() {
        try {
            $stats = [];
            
            // Total tables
            $stmt = $this->db->prepare('SELECT COUNT(*) as total FROM tables');
            $stmt->execute();
            $stats['total'] = $stmt->fetch()['total'];
            
            // Available tables
            $stmt = $this->db->prepare('SELECT COUNT(*) as available FROM tables WHERE status = "available"');
            $stmt->execute();
            $stats['available'] = $stmt->fetch()['available'];
            
            // Occupied tables
            $stmt = $this->db->prepare('SELECT COUNT(*) as occupied FROM tables WHERE status = "occupied"');
            $stmt->execute();
            $stats['occupied'] = $stmt->fetch()['occupied'];
            
            // Reserved tables
            $stmt = $this->db->prepare('SELECT COUNT(*) as reserved FROM tables WHERE status = "reserved"');
            $stmt->execute();
            $stats['reserved'] = $stmt->fetch()['reserved'];
            
            // Maintenance tables
            $stmt = $this->db->prepare('SELECT COUNT(*) as maintenance FROM tables WHERE status = "maintenance"');
            $stmt->execute();
            $stats['maintenance'] = $stmt->fetch()['maintenance'];
            
            return $stats;
        } catch (Exception $e) {
            error_log('getTableStats error: ' . $e->getMessage());
            return [
                'total' => 0,
                'available' => 0,
                'occupied' => 0,
                'reserved' => 0,
                'maintenance' => 0
            ];
        }
    }
    
    /**
     * Tự động tạo bàn mẫu nếu chưa có
     */
    public function createSampleTables() {
        try {
            $existingTables = $this->getAllTables();
            if (count($existingTables) > 0) {
                return ['success' => false, 'message' => 'Đã có bàn trong hệ thống!'];
            }
            
            $sampleTables = [
                ['number' => 1, 'capacity' => 2, 'location' => 'Tầng 1 - Cửa sổ'],
                ['number' => 2, 'capacity' => 4, 'location' => 'Tầng 1 - Giữa'],
                ['number' => 3, 'capacity' => 4, 'location' => 'Tầng 1 - Giữa'],
                ['number' => 4, 'capacity' => 6, 'location' => 'Tầng 1 - VIP'],
                ['number' => 5, 'capacity' => 2, 'location' => 'Tầng 2 - Cửa sổ'],
                ['number' => 6, 'capacity' => 4, 'location' => 'Tầng 2 - Giữa'],
                ['number' => 7, 'capacity' => 8, 'location' => 'Tầng 2 - VIP'],
                ['number' => 8, 'capacity' => 4, 'location' => 'Tầng 2 - Giữa'],
            ];
            
            $created = 0;
            foreach ($sampleTables as $table) {
                $result = $this->addTable($table['number'], $table['capacity'], $table['location']);
                if ($result['success']) {
                    $created++;
                }
            }
            
            return [
                'success' => true, 
                'message' => "Đã tạo $created bàn mẫu thành công!"
            ];
        } catch (Exception $e) {
            error_log('createSampleTables error: ' . $e->getMessage());
            return ['success' => false, 'message' => 'Lỗi tạo bàn mẫu: ' . $e->getMessage()];
        }
    }
}

?>
