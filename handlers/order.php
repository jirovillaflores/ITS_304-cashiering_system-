<?php
include('../Classes/Client.php');
$clients = new Users();
$response = null;

// HANDLE ORDER FORM SUBMISSION
if (isset($_POST['order_now'])) {
    $userId = $_POST['user_id'] ?? '';
    $amount = $_POST['amount'] ?? '';

    if ($userId == '' || $amount == '') {
        $response = ['error' => "User ID and Amount are required!"];
    } else {
        $book = $clients->orderNow($userId, $amount);
        $response = ($book === 1)
            ? ['success' => true, 'message' => 'Order successfully placed.']
            : ['success' => false, 'error' => 'Failed to place order.'];
    }
}

// FETCH ALL ORDERS TO DISPLAY
$orders = $clients->getAllOrders();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Orders</title>
    <style>
        table, th, td { border:1px solid black; border-collapse: collapse; padding: 5px; }
        th { background-color: #eee; }
        .success { color: green; }
        .error { color: red; }
    </style>
</head>
<body>

<h2>Place a New Order</h2>

<?php if ($response): ?>
    <?php if (isset($response['success']) && $response['success']): ?>
        <p class="success"><?= $response['message'] ?></p>
    <?php else: ?>
        <p class="error"><?= $response['error'] ?></p>
    <?php endif; ?>
<?php endif; ?>

<form method="POST">
    <label>User ID:</label><br>
    <input type="number" name="user_id" required><br><br>

    <label>Total Amount:</label><br>
    <input type="number" step="0.01" name="amount" required><br><br>

    <button type="submit" name="order_now">Place Order</button>
</form>

<h2>Orders Table</h2>
<table>
    <tr>
        <th>Order ID</th>
        <th>User ID</th>
        <th>Total Amount</th>
        <th>Status</th>
    </tr>
    <?php if ($orders): ?>
        <?php foreach ($orders as $order): ?>
            <tr>
                <td><?= $order['order_id'] ?></td>
                <td><?= $order['user_id'] ?></td>
                <td><?= number_format($order['total_amount'], 2) ?></td>
                <td><?= $order['status'] ?></td>
            </tr>
        <?php endforeach; ?>
    <?php else: ?>
        <tr><td colspan="4">No orders yet.</td></tr>
    <?php endif; ?>
</table>

</body>
</html>
