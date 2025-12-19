<?php
session_start();
header('Content-Type: application/json');
include_once('../../Classes/Products.php');

$products = new Products();
$action = $_POST['action'] ?? '';

try {
    switch($action){
        case 'create':
            $name = htmlspecialchars(strip_tags(trim($_POST['pr_name'] ?? '')));
            $price = floatval($_POST['pr_price'] ?? 0);
            if($name=='' || $price <= 0) throw new Exception('Invalid input.');
            $id = $products->addProduct(['pr_name'=>$name,'pr_price'=>$price]);
            echo json_encode(['success'=>true,'pr_id'=>$id]);
            break;

        case 'update':
            $id = intval($_POST['pr_id'] ?? 0);
            $name = htmlspecialchars(strip_tags(trim($_POST['pr_name'] ?? '')));
            $price = floatval($_POST['pr_price'] ?? 0);
            if($id <= 0 || $name=='' || $price <= 0) throw new Exception('Invalid input.');
            $products->updateProduct($id, ['pr_name'=>$name,'pr_price'=>$price]);
            echo json_encode(['success'=>true]);
            break;

        case 'delete':
            $id = intval($_POST['pr_id'] ?? 0);
            if($id <= 0) throw new Exception('No ID specified.');
            $products->deleteProduct($id);
            echo json_encode(['success'=>true]);
            break;

        default:
            throw new Exception('Invalid action.');
    }
} catch(Exception $e){
    echo json_encode(['success'=>false,'error'=>$e->getMessage()]);
}
