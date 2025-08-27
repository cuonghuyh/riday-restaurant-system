<?php
$controller = $_GET['controller'] ?? 'restaurant'; // Default to restaurant home page
$action = $_GET['action'] ?? 'home';

switch ($controller) {
    case 'restaurant':
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

    case 'auth':
        require_once 'controllers/AuthController.php';
        $ctrl = new AuthController();
        switch ($action) {
            case 'login':
                $ctrl->login();
                break;
            case 'authenticate':
                $ctrl->authenticate();
                break;
            case 'logout':
                $ctrl->logout();
                break;
            default:
                $ctrl->login();
        }
        break;

    case 'riday':
        // Require authentication for dashboard
        require_once 'controllers/AuthController.php';
        $authCtrl = new AuthController();
        $authCtrl->requireAuth('?controller=auth&action=login');
        
        require_once 'controllers/RestaurantController.php';
        $ctrl = new RestaurantController();
        $ctrl->ridayDashboard();
        break;

    case 'admin':
        // Require authentication for admin actions
        require_once 'controllers/AuthController.php';
        $authCtrl = new AuthController();
        $authCtrl->requireAuth('?controller=auth&action=login');
        
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
            case 'cleanupInvalidImage':
                $ctrl->cleanupInvalidImage();
                break;
            case 'clearBrokenImage':
                $ctrl->clearBrokenImage();
                break;
            default:
                $ctrl->index();
        }
        break;

    case 'order':
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

    case 'table':
        // Require authentication for table management
        require_once 'controllers/AuthController.php';
        $authCtrl = new AuthController();
        $authCtrl->requireAuth('?controller=auth&action=login');
        
        require_once 'controllers/TableController.php';
        $ctrl = new TableController();
        switch ($action) {
            case 'index':
                $ctrl->index();
                break;
            case 'getAllTables':
                $ctrl->getAllTables();
                break;
            case 'addTable':
                $ctrl->addTable();
                break;
            case 'updateTable':
                $ctrl->updateTable();
                break;
            case 'deleteTable':
                $ctrl->deleteTable();
                break;
            case 'getTableStats':
                $ctrl->getTableStats();
                break;
            case 'createSampleTables':
                $ctrl->createSampleTables();
                break;
            case 'updateTableStatus':
                $ctrl->updateTableStatus();
                break;
            default:
                $ctrl->index();
        }
        break;

    default:
        echo "404 - Controller not found!";
}
