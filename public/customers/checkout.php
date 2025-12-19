<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['id']) || !isset($_SESSION['email'])) {
    header("Location: home.php");
    exit;
}

$userId = $_SESSION['id'];
$userEmail = $_SESSION['email'];
$order = [];
$total = 0;
$error = false;

// Database connection
$host = 'localhost';
$user = 'root';
$pass = '';
$db_name = 'r&r_dbs';

$conn = new mysqli($host, $user, $pass, $db_name);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Process POST order data
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['order_data'])) {

    $data = json_decode($_POST['order_data'], true);

    if ($data && isset($data['items']) && is_array($data['items'])) {
        $order = $data['items'];
        $total = $data['total'] ?? 0;

        // Insert order into orders table
        $status = 'Pending';
        $stmt = $conn->prepare("INSERT INTO orders (user_id, total_amount, status) VALUES (?, ?, ?)");
        $stmt->bind_param("ids", $userId, $total, $status);

        if ($stmt->execute()) {
            $order_id = $stmt->insert_id;

            // Optional: insert each item into order_items table if exists
            /*
            foreach ($order as $item) {
                $stmt_item = $conn->prepare("INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)");
                $stmt_item->bind_param("iiid", $order_id, $item['id'], $item['quantity'], $item['price']);
                $stmt_item->execute();
            }
            */

            // Save order to session for persistence/printing
            $_SESSION['last_order'] = [
                'order_id' => $order_id,
                'items' => $order,
                'total' => $total
            ];

        } else {
            $error = true;
        }
    } else {
        $error = true;
    }
} elseif (isset($_SESSION['last_order'])) {
    // Refreshing page, keep last order
    $order = $_SESSION['last_order']['items'];
    $total = $_SESSION['last_order']['total'];
} else {
    // No data, redirect
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
    <link href="https://cdn.jsdelivr.net/npm/daisyui@4.4.19/dist/full.min.css" rel="stylesheet" />
    <style>
        @media print {
            .no-print { display: none !important; }
            body { margin:0; padding:0; }
            .receipt-container { width:100%; max-width:none; margin:0; padding:20px; border:none; box-shadow:none; }
        }
    </style>
</head>
<body class="bg-gray-50 min-h-screen flex justify-center items-center">

<?php if ($error): ?>
<div class="alert alert-error max-w-lg mx-auto shadow-lg">
    <span>Error processing order. Please try again.</span>
    <div class="mt-2">
        <a href="home.php" class="btn btn-sm">New Order</a>
    </div>
</div>
<?php else: ?>
<div class="receipt-container max-w-md mx-auto p-6 border-2 border-dashed border-gray-300 rounded-lg text-center bg-white shadow-2xl">
    <h1 class="text-4xl font-extrabold mb-2 text-success">R & R Hardware and Construction Supplies</h1>
    <h2 class="text-xl font-semibold mb-2">Order Confirmation (Receipt)</h2>

    <div class="text-sm text-gray-600 mb-2">
        <p><strong>Date:</strong> <?= date('M d, Y H:i:s') ?></p>
        <p><strong>Customer Email:</strong> <?= htmlspecialchars($userEmail) ?></p>
    </div>

    <div class="divider"></div>

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

    <button class="btn btn-neutral no-print w-full mt-6" onclick="window.print()">Print Receipt</button>
    <a href="home.php" class="btn btn-outline btn-sm no-print w-full mt-2">Start New Order</a>
    <a href="logout.php" class="btn btn-link btn-sm no-print w-full mt-2 text-error">Logout</a>
</div>
<?php endif; ?>

</body>
</html>
