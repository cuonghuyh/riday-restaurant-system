<?php

require_once __DIR__ . '/DB.php';

class OrderModel {
    /** @var PDO */
    private $db;

    public function __construct()
    {
        // Set timezone Việt Nam cho toàn bộ session
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $this->db = DB::getInstance();
        
        // Đảm bảo MySQL cũng sử dụng timezone Việt Nam
        $this->db->exec("SET time_zone = '+07:00'");
    }
    
    public function createOrder($orderData) {
        $orderCode = $this->generateOrderCode();

        try {
            $this->db->beginTransaction();

            // Tạo thời gian Việt Nam chính xác
            $vietnamTime = new DateTime('now', new DateTimeZone('Asia/Ho_Chi_Minh'));
            $created_at = $vietnamTime->format('Y-m-d H:i:s');

            $stmt = $this->db->prepare(
                'INSERT INTO orders (order_code, table_id, total_amount, service_fee, final_total, customer_note, status, created_at) VALUES (:order_code, :table_id, :total_amount, :service_fee, :final_total, :customer_note, :status, :created_at)'
            );

            $stmt->execute([
                ':order_code' => $orderCode,
                ':table_id' => $orderData['table_number'], // Using table_number from frontend as table_id
                ':total_amount' => $orderData['total_amount'],
                ':service_fee' => $orderData['service_fee'],
                ':final_total' => $orderData['final_total'],
                ':customer_note' => $orderData['customer_note'],
                ':status' => $orderData['status'] ?? 'pending',
                ':created_at' => $created_at // Thời gian Việt Nam
            ]);

            $orderId = (int)$this->db->lastInsertId();

            $itemStmt = $this->db->prepare('INSERT INTO order_items (order_id, menu_item_id, item_name, quantity, unit_price, total_price) VALUES (:order_id, :menu_item_id, :item_name, :quantity, :unit_price, :total_price)');
            foreach ($orderData['items'] as $itemName => $item) {
                // Try to find menu_item_id from menu_items table, set to NULL if not found
                $menuItemStmt = $this->db->prepare('SELECT id FROM menu_items WHERE name = :name LIMIT 1');
                $menuItemStmt->execute([':name' => $itemName]);
                $menuItem = $menuItemStmt->fetch();
                $menuItemId = $menuItem ? $menuItem['id'] : null; // NULL thay vì 0
                
                $itemStmt->execute([
                    ':order_id' => $orderId,
                    ':menu_item_id' => $menuItemId,
                    ':item_name' => $itemName,
                    ':quantity' => $item['quantity'],
                    ':unit_price' => $item['price'],
                    ':total_price' => $item['quantity'] * $item['price'],
                ]);
            }

            $this->db->commit();
            return $orderId;
        } catch (Exception $e) {
            if ($this->db->inTransaction()) {
                $this->db->rollBack();
            }
            error_log('createOrder error: ' . $e->getMessage());
            return false;
        }
    }
    
    public function getAllOrders($limit = 50) {
        $sql = 'SELECT *, table_id as table_number FROM orders ORDER BY created_at DESC LIMIT :limit';
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
        $stmt->execute();

        $orders = $stmt->fetchAll();
        foreach ($orders as &$row) {
            if (!empty($row['created_at'])) {
                $dt = new DateTime($row['created_at'], new DateTimeZone('UTC'));
                $dt->setTimezone(new DateTimeZone('Asia/Ho_Chi_Minh'));
                $row['created_at'] = $dt->format('Y-m-d\TH:i:sP');
            }
            if (!empty($row['updated_at'])) {
                $dt = new DateTime($row['updated_at'], new DateTimeZone('UTC'));
                $dt->setTimezone(new DateTimeZone('Asia/Ho_Chi_Minh'));
                $row['updated_at'] = $dt->format('Y-m-d\TH:i:sP');
            }
            $row['items'] = $this->getOrderItems($row['id']);
        }

        return $orders;
    }
    
    public function getCurrentOrders($limit = 50) {
        // Lấy đơn hàng đang xử lý (pending, preparing)
        $sql = 'SELECT *, table_id as table_number FROM orders WHERE status IN ("pending","preparing") ORDER BY created_at DESC LIMIT :limit';
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
        $stmt->execute();

        $orders = $stmt->fetchAll();
        foreach ($orders as &$row) {
            if (!empty($row['created_at'])) {
                $dt = new DateTime($row['created_at'], new DateTimeZone('UTC'));
                $dt->setTimezone(new DateTimeZone('Asia/Ho_Chi_Minh'));
                $row['created_at'] = $dt->format('Y-m-d\TH:i:sP');
            }
            if (!empty($row['updated_at'])) {
                $dt = new DateTime($row['updated_at'], new DateTimeZone('UTC'));
                $dt->setTimezone(new DateTimeZone('Asia/Ho_Chi_Minh'));
                $row['updated_at'] = $dt->format('Y-m-d\TH:i:sP');
            }
            $row['items'] = $this->getOrderItems($row['id']);
        }

        return $orders;
    }
    
    public function getCompletedOrders($limit = 50) {
        // Lấy đơn hàng đã hoàn thành
        $sql = 'SELECT * FROM orders WHERE status = :status ORDER BY updated_at DESC LIMIT :limit';
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':status', 'completed');
        $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
        $stmt->execute();

        $orders = $stmt->fetchAll();
        foreach ($orders as &$row) {
            if (!empty($row['created_at'])) {
                $dt = new DateTime($row['created_at'], new DateTimeZone('UTC'));
                $dt->setTimezone(new DateTimeZone('Asia/Ho_Chi_Minh'));
                $row['created_at'] = $dt->format('Y-m-d\TH:i:sP');
            }
            if (!empty($row['updated_at'])) {
                $dt = new DateTime($row['updated_at'], new DateTimeZone('UTC'));
                $dt->setTimezone(new DateTimeZone('Asia/Ho_Chi_Minh'));
                $row['updated_at'] = $dt->format('Y-m-d\TH:i:sP');
            }
            $row['items'] = $this->getOrderItems($row['id']);
        }

        return $orders;
    }
    
    public function getOrderItems($orderId) {
        $stmt = $this->db->prepare('SELECT item_name as name, quantity, unit_price as price FROM order_items WHERE order_id = :order_id');
        $stmt->execute([':order_id' => $orderId]);
        return $stmt->fetchAll();
    }
    
    public function updateOrderStatus($orderId, $status) {
        try {
            error_log("OrderModel::updateOrderStatus called with orderId: $orderId, status: $status");
            
            // Tạo thời gian Việt Nam cho updated_at
            $vietnamTime = new DateTime('now', new DateTimeZone('Asia/Ho_Chi_Minh'));
            $updated_at = $vietnamTime->format('Y-m-d H:i:s');
            
            $stmt = $this->db->prepare('UPDATE orders SET status = :status, updated_at = :updated_at WHERE id = :id');
            $stmt->execute([
                ':status' => $status, 
                ':id' => $orderId,
                ':updated_at' => $updated_at
            ]);
            $affectedRows = $stmt->rowCount();

            error_log("Update executed. Affected rows: $affectedRows");

            return $affectedRows > 0;
            
        } catch (Exception $e) {
            error_log("OrderModel::updateOrderStatus error: " . $e->getMessage());
            return false;
        }
    }
    
    public function getOrdersSince($timestamp) {
        // $timestamp expected as unix timestamp
        $stmt = $this->db->prepare('SELECT * FROM orders WHERE UNIX_TIMESTAMP(created_at) > :ts ORDER BY created_at DESC');
        $stmt->execute([':ts' => (int)$timestamp]);
        $orders = $stmt->fetchAll();
        foreach ($orders as &$row) {
            $row['items'] = $this->getOrderItems($row['id']);
        }
        return $orders;
    }
    
    private function generateOrderCode() {
        // Tạo mã đơn hàng dạng KM001, KM002... với thời gian Việt Nam
        $today = date('ymd'); // Sử dụng timezone đã set
        $stmt = $this->db->prepare('SELECT COUNT(*) as count FROM orders WHERE DATE(created_at) = CURDATE()');
        $stmt->execute();
        $row = $stmt->fetch();
        $orderNumber = str_pad(($row['count'] ?? 0) + 1, 3, '0', STR_PAD_LEFT);

        return 'KM' . $today . $orderNumber;
    }
    
    public function getRecentActivity($limit = 10) {
        // Lấy hoạt động gần đây từ orders
        $sql = "SELECT 
                    id,
                    order_code,
                    status,
                    table_id,
                    final_total,
                    created_at,
                    updated_at
                FROM orders 
                ORDER BY updated_at DESC 
                LIMIT :limit";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([':limit' => $limit]);
        $orders = $stmt->fetchAll();
        
        $activities = [];
        
        foreach ($orders as $order) {
            $createdTime = new DateTime($order['created_at']);
            $updatedTime = new DateTime($order['updated_at']);
            $now = new DateTime();
            
            // Nếu đơn hàng mới tạo (trong vòng 1 giờ)
            $createdDiff = $now->getTimestamp() - $createdTime->getTimestamp();
            if ($createdDiff < 3600) { // 1 hour
                $activities[] = [
                    'type' => 'new_order',
                    'description' => "Đơn hàng mới #{$order['order_code']} từ bàn {$order['table_id']}",
                    'time_ago' => $this->timeAgo($createdTime),
                    'order_id' => $order['id'],
                    'timestamp' => $createdTime->getTimestamp()
                ];
            }
            
            // Nếu có cập nhật status gần đây
            $updateDiff = $now->getTimestamp() - $updatedTime->getTimestamp();
            if ($updateDiff < 3600 && $createdTime != $updatedTime) { // Updated within 1 hour and not same as created
                $statusText = '';
                switch ($order['status']) {
                    case 'completed':
                        $statusText = 'hoàn thành';
                        $type = 'order_completed';
                        break;
                    case 'cancelled':
                        $statusText = 'hủy';
                        $type = 'order_cancelled';
                        break;
                    case 'preparing':
                        $statusText = 'đang chuẩn bị';
                        $type = 'status_updated';
                        break;
                    default:
                        $statusText = $order['status'];
                        $type = 'status_updated';
                }
                
                $activities[] = [
                    'type' => $type,
                    'description' => "Đơn #{$order['order_code']} đã {$statusText}",
                    'time_ago' => $this->timeAgo($updatedTime),
                    'order_id' => $order['id'],
                    'timestamp' => $updatedTime->getTimestamp()
                ];
            }
        }
        
        // Sắp xếp theo thời gian giảm dần
        usort($activities, function($a, $b) {
            return $b['timestamp'] - $a['timestamp'];
        });
        
        // Giới hạn số lượng
        return array_slice($activities, 0, $limit);
    }
    
    private function timeAgo($datetime) {
        $now = new DateTime();
        $diff = $now->getTimestamp() - $datetime->getTimestamp();
        
        if ($diff < 60) {
            return 'Vài giây trước';
        } elseif ($diff < 3600) {
            $minutes = floor($diff / 60);
            return $minutes . ' phút trước';
        } elseif ($diff < 86400) {
            $hours = floor($diff / 3600);
            return $hours . ' giờ trước';
        } else {
            $days = floor($diff / 86400);
            return $days . ' ngày trước';
        }
    }
    
    public function getOrderStats() {
        // Thống kê đơn hàng hôm nay
        $sql = "SELECT 
                COUNT(*) as total_orders,
                SUM(CASE WHEN status = 'pending' THEN 1 ELSE 0 END) as pending_orders,
                SUM(CASE WHEN status = 'preparing' THEN 1 ELSE 0 END) as preparing_orders,
                SUM(CASE WHEN status = 'completed' THEN 1 ELSE 0 END) as completed_orders,
                SUM(final_total) as total_revenue
            FROM orders WHERE DATE(created_at) = CURDATE()";

        $stmt = $this->db->query($sql);
        return $stmt->fetch();
    }
    
    public function getOrderById($orderId) {
        $stmt = $this->db->prepare('SELECT *, table_id as table_number, total_amount as subtotal, (total_amount * 0.1) as tax_amount FROM orders WHERE id = :id');
        $stmt->execute([':id' => $orderId]);
        $order = $stmt->fetch();
        if ($order) {
            if (!empty($order['created_at'])) {
                $dt = new DateTime($order['created_at'], new DateTimeZone('UTC'));
                $dt->setTimezone(new DateTimeZone('Asia/Ho_Chi_Minh'));
                $order['created_at'] = $dt->format('Y-m-d\TH:i:sP');
            }
            if (!empty($order['updated_at'])) {
                $dt = new DateTime($order['updated_at'], new DateTimeZone('UTC'));
                $dt->setTimezone(new DateTimeZone('Asia/Ho_Chi_Minh'));
                $order['updated_at'] = $dt->format('Y-m-d\TH:i:sP');
            }
            $order['items'] = $this->getOrderItems($order['id']);
        }

        return $order;
    }
    
    public function deleteOrder($orderId) {
        try {
            $this->db->beginTransaction();
            $stmt = $this->db->prepare('DELETE FROM order_items WHERE order_id = :order_id');
            $stmt->execute([':order_id' => $orderId]);

            $stmt = $this->db->prepare('DELETE FROM orders WHERE id = :id');
            $stmt->execute([':id' => $orderId]);

            $this->db->commit();
            return true;
        } catch (Exception $e) {
            if ($this->db->inTransaction()) $this->db->rollBack();
            return false;
        }
    }
    
    public function getOrdersByStatus($status, $limit = 50) {
        $stmt = $this->db->prepare('SELECT * FROM orders WHERE status = :status ORDER BY created_at DESC LIMIT :limit');
        $stmt->bindValue(':status', $status);
        $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
        $stmt->execute();
        $orders = $stmt->fetchAll();
        foreach ($orders as &$row) {
            $row['items'] = $this->getOrderItems($row['id']);
        }
        return $orders;
    }
    
    public function updateOrderNote($orderId, $note) {
        // Tạo thời gian Việt Nam cho updated_at
        $vietnamTime = new DateTime('now', new DateTimeZone('Asia/Ho_Chi_Minh'));
        $updated_at = $vietnamTime->format('Y-m-d H:i:s');
        
        $stmt = $this->db->prepare('UPDATE orders SET customer_note = :note, updated_at = :updated_at WHERE id = :id');
        return $stmt->execute([
            ':note' => $note, 
            ':id' => $orderId,
            ':updated_at' => $updated_at
        ]);
    }
    
    public function getOrderHistory($days = 7) {
        $stmt = $this->db->prepare('SELECT * FROM orders WHERE DATE(created_at) >= DATE_SUB(CURDATE(), INTERVAL :days DAY) ORDER BY created_at DESC');
        $stmt->execute([':days' => (int)$days]);
        $orders = $stmt->fetchAll();
        foreach ($orders as &$row) {
            $row['items'] = $this->getOrderItems($row['id']);
        }
        return $orders;
    }
    
    public function resetAllStats() {
        try {
            // Xóa tất cả order items trước (foreign key constraint)
            $stmt1 = $this->db->prepare('DELETE FROM order_items');
            $stmt1->execute();
            
            // Xóa tất cả orders
            $stmt2 = $this->db->prepare('DELETE FROM orders');
            $stmt2->execute();
            
            // Reset AUTO_INCREMENT cho cả 2 bảng
            $this->db->exec('ALTER TABLE order_items AUTO_INCREMENT = 1');
            $this->db->exec('ALTER TABLE orders AUTO_INCREMENT = 1');
            
            error_log("Reset stats completed successfully");
            return true;
            
        } catch (Exception $e) {
            error_log("Reset stats error: " . $e->getMessage());
            throw $e;
        }
    }
    
    public function getTotalOrderCount() {
        try {
            $stmt = $this->db->prepare('SELECT COUNT(*) as count FROM orders');
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result['count'] ?? 0;
        } catch (Exception $e) {
            error_log("getTotalOrderCount error: " . $e->getMessage());
            return 0;
        }
    }
    
    public function getLastOrderUpdateTime() {
        try {
            $stmt = $this->db->prepare('SELECT UNIX_TIMESTAMP(MAX(updated_at)) as last_update FROM orders');
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result['last_update'] ?? time();
        } catch (Exception $e) {
            error_log("getLastOrderUpdateTime error: " . $e->getMessage());
            return time();
        }
    }
    
    public function getDashboardStats() {
        try {
            // Get total orders
            $stmt = $this->db->prepare('SELECT COUNT(*) as total FROM orders');
            $stmt->execute();
            $totalOrders = $stmt->fetch(PDO::FETCH_ASSOC)['total'] ?? 0;
            
            // Get pending orders
            $stmt = $this->db->prepare('SELECT COUNT(*) as pending FROM orders WHERE status = "pending"');
            $stmt->execute();
            $pendingOrders = $stmt->fetch(PDO::FETCH_ASSOC)['pending'] ?? 0;
            
            // Get total revenue
            $stmt = $this->db->prepare('SELECT SUM(total_amount) as revenue FROM orders WHERE status = "completed"');
            $stmt->execute();
            $totalRevenue = $stmt->fetch(PDO::FETCH_ASSOC)['revenue'] ?? 0;
            
            return [
                'totalOrders' => $totalOrders,
                'pendingOrders' => $pendingOrders,
                'totalRevenue' => $totalRevenue
            ];
            
        } catch (Exception $e) {
            error_log("getDashboardStats error: " . $e->getMessage());
            return [
                'totalOrders' => 0,
                'pendingOrders' => 0,
                'totalRevenue' => 0
            ];
        }
    }
}
