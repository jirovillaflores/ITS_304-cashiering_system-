<?php
session_start();

$order = [];
$total = 0;
$error = false;

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['order_data'])) {
    
    $data = json_decode($_POST['order_data'], true);
    
    if ($data && isset($data['items']) && is_array($data['items'])) {
        $order = $data['items'];
        $total = $data['total'] ?? 0;
        
        
        $_SESSION['last_order'] = $data;
    } else {
        $error = true;
    }
} elseif (isset($_SESSION['last_order'])) {
    $order = $_SESSION['last_order']['items'];
    $total = $_SESSION['last_order']['total'];
} else {
    
    header("Location: home.php");
    exit;
}

?>

<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Receipt</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/daisyui@4.4.19/dist/full.min.css" rel="stylesheet" type="text/css" />
    <style>
        /* Print styling (Only show receipt) */
        @media print {
            .no-print {
                display: none !important;
            }
            body {
                margin: 0;
                padding: 0;
            }
            .receipt-container {
                box-shadow: none !important;
                border: none !important;
                width: 100%;
                max-width: none;
                margin: 0;
                padding: 20px;
            }
        }
    </style>
</head>
<body class="bg-gray-50 min-h-screen flex justify-center items-center">

    <?php if ($error): ?>
    <div class="alert alert-error max-w-lg mx-auto shadow-lg">
        <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
        <span>Error processing order data. Please try again.</span>
        <div>
            <a href="home.php" class="btn btn-sm">New Order</a>
        </div>
    </div>
    <?php else: ?>

    <div class="receipt-container max-w-md mx-auto p-6 border-2 border-dashed border-gray-300 rounded-lg text-center bg-white shadow-2xl">
        <h1 class="text-4xl font-extrabold mb-2 text-success">R & R Hardware and Construction Supplies Cashiering System</h1>
        <h2 class="text-xl font-semibold mb-6">Order Confirmation (Receipt)</h2>
        <div class="divider"></div>
        <p class="text-sm text-gray-600 mb-4">Date: <?= date('M d, Y H:i:s') ?></p>
        
        <div class="text-left w-full">
            <ul class="space-y-2 border-b pb-4 mb-4">
            <?php foreach ($order as $item): ?>
                <li class="flex justify-between text-base">
                    <span class="text-gray-700"><?= htmlspecialchars($item['name']) ?> (<?= $item['quantity'] ?>x)</span>
                    <span class="font-medium">₱<?= number_format($item['price'] * $item['quantity'], 2) ?></span>
                </li>
            <?php endforeach; ?>
            </ul>
            
            <div class="flex justify-between font-bold text-2xl mt-4 border-t pt-4">
                <span>TOTAL PAID:</span>
                <span class="text-primary">₱<?= number_format($total, 2) ?></span>
            </div>
        </div>
        
        <div class="divider"></div>
        
        <button class="btn btn-neutral no-print w-full mt-6" onclick="window.print()">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6m-3-4v4m-6-10H5a2 2 0 00-2 2v4a2 2 0 002 2h2m6-4V3"/></svg>
            Print Receipt (Ctrl+P)
        </button>

        <a href="home.php" class="btn btn-outline btn-sm no-print w-full mt-2">
            Start New Order
        </a>
        
        <a href="logout.php" class="btn btn-link btn-sm no-print w-full mt-2 text-error">
            Logout
        </a>
    </div>

    <?php endif; ?>

    <script>
        // Automatically trigger print dialog on page load (optional, but requested in flow)
        // window.onload = function() {
        //     window.print();
        // };
    </script>

</body>
</html>