<?php
header('Content-Type: application/json');
require '../../Classes/Products.php';

$p = new Products();
$action = $_POST['action'] ?? '';

switch ($action) {

    case 'create':
        echo json_encode([
            'status' => $p->addProduct($_POST['pr_name'], $_POST['pr_price']) ? 'success' : 'error',
            'message'=> 'Product added'
        ]);
        break;

    case 'update':
        echo json_encode([
            'status' => $p->updateProduct($_POST['pr_id'], $_POST['pr_name'], $_POST['pr_price']) ? 'success' : 'error',
            'message'=> 'Product updated'
        ]);
        break;

    case 'delete':
        echo json_encode([
            'status' => $p->deleteProduct($_POST['pr_id']) ? 'success' : 'error',
            'message'=> 'Product deleted'
        ]);
        break;

    default:
        echo json_encode(['status'=>'error','message'=>'Invalid action']);
}
