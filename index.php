<?php
// Error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Get table number from URL parameter
$tableNumber = $_GET['table'] ?? 1;

// Handle URL routing
$url = $_GET['url'] ?? '';
$urlParts = explode('/', trim($url, '/'));

$controller = $_GET['controller'] ?? ($urlParts[0] ?? 'restaurant');
$action = $_GET['action'] ?? ($urlParts[1] ?? 'home');

// Store table number in session for later use
session_start();
$_SESSION['table_number'] = $tableNumber;

try {
    switch ($controller) {
        case 'restaurant':
            if (!file_exists('controllers/RestaurantController.php')) {
                throw new Exception('RestaurantController not found');
            }
            require_once 'controllers/RestaurantController.php';
            $ctrl = new RestaurantController();
            if ($action === 'menu') {
                $ctrl->menu();
            } elseif ($action === 'getMenuItems') {
                $ctrl->getMenuItems();
            } elseif ($action === 'home') {
                $ctrl->home();
            } else {
                $ctrl->home(); // Default to home page
            }
            break;

        case 'riday':
            if (!file_exists('controllers/RestaurantController.php')) {
                throw new Exception('RestaurantController not found');
            }
            require_once 'controllers/RestaurantController.php';
            $ctrl = new RestaurantController();
            $ctrl->ridayDashboard();
            break;

        case 'admin':
            if (!file_exists('controllers/AdminController.php')) {
                throw new Exception('AdminController not found');
            }
            require_once 'controllers/AdminController.php';
            $ctrl = new AdminController();
            switch ($action) {
                case 'menu':
                    $ctrl->menu();
                    break;
                case 'getMenuItems':
                    $ctrl->getMenuItems();
                    break;
                case 'addMenuItem':
                    $ctrl->addMenuItem();
                    break;
                case 'updateMenuItem':
                    $ctrl->updateMenuItem();
                    break;
                case 'deleteMenuItem':
                    $ctrl->deleteMenuItem();
                    break;
                case 'uploadImage':
                    $ctrl->uploadImage();
                    break;
                case 'uploadImageCloudinary':
                    $ctrl->uploadImageCloudinary();
                    break;
                case 'deleteImageCloudinary':
                    $ctrl->deleteImageCloudinary();
                    break;
                case 'testCloudinary':
                    $ctrl->testCloudinary();
                    break;
                default:
                    $ctrl->index();
            }
            break;

        case 'order':
            if (!file_exists('controllers/OrderController.php')) {
                throw new Exception('OrderController not found');
            }
            require_once 'controllers/OrderController.php';
            $ctrl = new OrderController();
            switch ($action) {
                case 'create':
                    $ctrl->create();
                    break;
                case 'updateStatus':
                    $ctrl->updateStatus();
                    break;
                case 'update-status':
                    $ctrl->updateStatus();
                    break;
                case 'getNewOrders':
                    $ctrl->getNewOrders();
                    break;
                case 'get-new':
                    $ctrl->getNewOrders();
                    break;
                case 'getOrderDetail':
                    $ctrl->getOrderDetail();
                    break;
                case 'getStats':
                    $ctrl->getStats();
                    break;
                case 'deleteOrder':
                    $ctrl->deleteOrder();
                    break;
                case 'resetStats':
                    $ctrl->resetStats();
                    break;
                case 'bulkUpdateStatus':
                    $ctrl->bulkUpdateStatus();
                    break;
                case 'dashboard':
                case 'index':
                    $ctrl->dashboard();
                    break;
                case 'getAllOrders':
                    $ctrl->getAllOrders();
                    break;
                case 'getCurrentOrders':
                    $ctrl->getCurrentOrders();
                    break;
                case 'getCompletedOrders':
                    $ctrl->getCompletedOrders();
                    break;
                default:
                    $ctrl->index();
            }
            break;

        default:
            // Default route - show restaurant home
            if (!file_exists('controllers/RestaurantController.php')) {
                echo "<h1>🍜 Riday Restaurant</h1>";
                echo "<p>Welcome to Riday Restaurant! Table #" . htmlspecialchars($tableNumber) . "</p>";
                echo "<p><a href='?controller=restaurant&action=menu'>View Menu</a></p>";
                echo "<p><a href='views/riday_dashboard.php'>Staff Dashboard</a></p>";
            } else {
                require_once 'controllers/RestaurantController.php';
                $ctrl = new RestaurantController();
                $ctrl->home();
            }
    }
} catch (Exception $e) {
    echo "<h1>🚨 Error</h1>";
    echo "<p>Something went wrong: " . htmlspecialchars($e->getMessage()) . "</p>";
    echo "<p><a href='/'>← Back to Home</a></p>";
    echo "<hr><small>Debug info: " . htmlspecialchars($e->getFile() . ':' . $e->getLine()) . "</small>";
}
