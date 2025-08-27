backend/api/auth.php:

<?php
header('Content-Type: application/json');

require_once '../controllers/AuthController.php';

$authController = new AuthController();

$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case 'POST':
        // Handle login and registration
        $action = $_POST['action'] ?? '';
        if ($action === 'login') {
            $authController->login();
        } elseif ($action === 'register') {
            $authController->register();
        } else {
            echo json_encode(['error' => 'Invalid action']);
        }
        break;

    default:
        echo json_encode(['error' => 'Method not allowed']);
        break;
}