backend/api/auth.php:

<?php
require_once '../controllers/AuthController.php';

$authController = new AuthController();

switch ($_SERVER['REQUEST_METHOD']) {
    case 'POST':
        if (isset($_POST['action']) && $_POST['action'] === 'login') {
            $authController->login($_POST);
        } elseif (isset($_POST['action']) && $_POST['action'] === 'register') {
            $authController->register($_POST);
        }
        break;

    default:
        http_response_code(405);
        echo json_encode(['message' => 'Method Not Allowed']);
        break;
}