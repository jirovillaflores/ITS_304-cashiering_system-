<?php
header('Content-Type: application/json');
require_once __DIR__ . '/../Classes/Connection.php';
require_once __DIR__ . '/../Classes/Admin.php';

$response = [];

try {
    $action = $_POST['action'] ?? '';

    // Use Admin Users class for product CRUD
    $admin = new Users();

    if ($action === 'create') {
        $name = trim($_POST['pr_name'] ?? '');
        $price = $_POST['pr_price'] ?? '';
        if ($name === '' || $price === '') {
            $response = ['success' => false, 'error' => 'Name and price are required'];
        } else {
            $price = (float) $price;
            $ok = $admin->addItem($name, $price);
            $response = ['success' => (bool)$ok, 'error' => $ok ? null : 'Database insert failed'];
        }
    } elseif ($action === 'update') {
        $id = (int)($_POST['pr_id'] ?? 0);
        $name = trim($_POST['pr_name'] ?? '');
        $price = $_POST['pr_price'] ?? '';
        if ($id <= 0 || $name === '' || $price === '') {
            $response = ['success' => false, 'error' => 'ID, name, and price are required'];
        } else {
            $price = (float) $price;
            $ok = $admin->updateItem($id, $name, $price);
            $response = ['success' => (bool)$ok, 'error' => $ok ? null : 'Update failed'];
        }
    } elseif ($action === 'delete') {
        $id = (int)($_POST['pr_id'] ?? 0);
        if ($id <= 0) {
            $response = ['success' => false, 'error' => 'Valid product ID required'];
        } else {
            $ok = $admin->deleteItem($id);
            $response = ['success' => (bool)$ok, 'error' => $ok ? null : 'Delete failed'];
        }
    } else {
        $response = ['success' => false, 'error' => 'Unknown action'];
    }
} catch (Throwable $e) {
    error_log('additem.php error: ' . $e->getMessage());
    $response = ['success' => false, 'error' => 'Server error'];
}

echo json_encode($response);
