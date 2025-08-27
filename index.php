<?php
$controller = $_GET['controller'] ?? 'restaurant'; // Default to restaurant home page
$action = $_GET['action'] ?? 'home';

// QR Generator route
if (isset($_GET['qr_generator']) || $controller === 'qr') {
    include 'qr_generator.php';
    exit;
}

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

    case 'riday':
        require_once 'controllers/RestaurantController.php';
        $ctrl = new RestaurantController();
        $ctrl->ridayDashboard();
        break;

    case 'admin':
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
        echo "404 - Controller not found!";
}
