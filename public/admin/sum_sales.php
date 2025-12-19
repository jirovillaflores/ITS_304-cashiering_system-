<?php
session_start();

require_once '../../Classes/Connection.php';
$db = new Users();
$conn = $db->connect();

// Calculate dynamic Total Sales (YTD)
$totalSales = 0;
$result = $conn->query("SELECT SUM(total_amount) AS total_sales FROM orders");
if ($result) {
    $row = $result->fetch_assoc();
    $totalSales = $row['total_sales'] ?? 0;
}

// Total items in stock
$totalItems = 0;
$res_items = $conn->query("SELECT COUNT(*) AS total_items FROM products");
if ($res_items) {
    $row_items = $res_items->fetch_assoc();
    $totalItems = $row_items['total_items'] ?? 0;
}

// New customers in last 30 days
$newCustomers = 0;
$res_customers = $conn->query("SELECT COUNT(*) AS new_customers FROM users WHERE created_at >= DATE_SUB(NOW(), INTERVAL 30 DAY)");
if ($res_customers) {
    $row_cust = $res_customers->fetch_assoc();
    $newCustomers = $row_cust['new_customers'] ?? 0;
}

// Dashboard stats array
$dashboard_stats = [
    [
        'title' => 'Total Sales (YTD)',
        'value' => '₱' . number_format($totalSales, 2),
        'icon'  => 'currency-dollar',
        'color' => 'success'
    ],
    [
        'title' => 'Items in Stock',
        'value' => $totalItems,
        'icon'  => 'cube',
        'color' => 'warning'
    ],
    [
        'title' => 'New Customers (Last 30 Days)',
        'value' => $newCustomers,
        'icon'  => 'user-plus',
        'color' => 'info'
    ],
];
?>
