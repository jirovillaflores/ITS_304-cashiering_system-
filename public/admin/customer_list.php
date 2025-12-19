<?php
session_start();

include ('../../Classes/Admin.php');
include ('../../includes/header.php');
$admin = new Users();

// Handle status update
if (isset($_GET['update_id']) && isset($_GET['status'])) {
    $orderId = intval($_GET['update_id']);
    $status = $_GET['status'] === 'approved' ? 'approved' : 'pending';
    $admin->updateOrderStatus($orderId, $status);
    header("Location: customer_list.php");
    exit;
}

// Fetch all orders
$orders = $admin->getAllOrders();
?>


<div class="p-4 sm:ml-64 pt-16">
    <div class="p-4 border-1 border-default border-dashed rounded-base">

        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-heading">Orders List</h1>
        </div>

        <div class="overflow-x-auto bg-neutral-primary-soft rounded-base border border-default">
            <table class="table w-full text-sm text-left text-body">
                <thead class="text-xs text-heading uppercase bg-neutral-secondary-soft">
                    <tr>
                        <th scope="col" class="px-6 py-3">Order ID</th>
                        <th scope="col" class="px-6 py-3">User Email</th>
                        <th scope="col" class="px-6 py-3">Total Amount</th>
                        <th scope="col" class="px-6 py-3">Status</th>
                        <th scope="col" class="px-6 py-3">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($orders)): ?>
                        <?php foreach ($orders as $order): ?>
                            <tr class="bg-white border-b hover:bg-neutral-secondary-soft">
                                <th scope="row" class="px-6 py-4 font-medium text-heading whitespace-nowrap">
                                    <?= htmlspecialchars($order['order_id']); ?>
                                </th>
                                <td class="px-6 py-4">
                                    <?= htmlspecialchars($order['user_email']); ?>
                                </td>
                                <td class="px-6 py-4">
                                    ₱<?= number_format($order['total_amount'], 2); ?>
                                </td>
                                <td class="px-6 py-4">
                                    <?= htmlspecialchars(ucfirst($order['status'])); ?>
                                </td>
                                <td class="px-6 py-4">
                                    <form method="GET" class="inline-block">
                                        <input type="hidden" name="update_id" value="<?= $order['order_id']; ?>">
                                        <select name="status" onchange="this.form.submit()" class="border rounded px-2 py-1 text-sm">
                                            <option value="pending" <?= $order['status'] === 'pending' ? 'selected' : ''; ?>>Pending</option>
                                            <option value="approved" <?= $order['status'] === 'approved' ? 'selected' : ''; ?>>Approved</option>
                                        </select>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr class="bg-white border-b">
                            <td colspan="5" class="px-6 py-4 text-center text-body">No orders found.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

    </div>
</div>

<?php include ('../../public/admin/footer.php'); ?>
