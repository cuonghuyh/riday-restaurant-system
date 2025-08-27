<?php
require_once '../controllers/AuthController.php';

$authController = new AuthController();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';

    switch ($action) {
        case 'login':
            $username = $_POST['username'] ?? '';
            $password = $_POST['password'] ?? '';
            $authController->login($username, $password);
            break;

        case 'register':
            $username = $_POST['username'] ?? '';
            $password = $_POST['password'] ?? '';
            $email = $_POST['email'] ?? '';
            $authController->register($username, $password, $email);
            break;

        default:
            http_response_code(400);
            echo json_encode(['message' => 'Invalid action']);
            break;
    }
} else {
    http_response_code(405);
    echo json_encode(['message' => 'Method not allowed']);
}