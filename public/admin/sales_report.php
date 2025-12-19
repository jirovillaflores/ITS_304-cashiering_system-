<?php
session_start();
// Include the header (which contains the shared navbar and sidebar structure)
include ('../../public/admin/header.php');

// --- MOCK SALES DATA (Replace with your actual database fetch) ---
$total_sales = 45320.50;
$total_orders = 87;
$average_order_value = 520.93;
$monthly_sales_data = [
    ['month' => 'Jan', 'revenue' => 12000],
    ['month' => 'Feb', 'revenue' => 15500],
    ['month' => 'Mar', 'revenue' => 17820.50],
];
// --- Mock Detailed Transactions ---
$transactions = [
    ['id' => 'TXN-001', 'date' => '2025-12-12', 'customer' => 'Alice J.', 'amount' => 1250.00, 'status' => 'Completed'],
    ['id' => 'TXN-002', 'date' => '2025-12-12', 'customer' => 'Bob S.', 'amount' => 89.99, 'status' => 'Completed'],
    ['id' => 'TXN-003', 'date' => '2025-12-11', 'customer' => 'Charlie B.', 'amount' => 450.50, 'status' => 'Pending'],
    ['id' => 'TXN-004', 'date' => '2025-12-11', 'customer' => 'Diana P.', 'amount' => 2000.00, 'status' => 'Completed'],
    ['id' => 'TXN-005', 'date' => '2025-12-10', 'customer' => 'Eve L.', 'amount' => 320.10, 'status' => 'Cancelled'],
];
?>

<div class="p-4 sm:ml-64 pt-16">
    <div class="p-4 border-1 border-default border-dashed rounded-base">
        
        <h1 class="text-2xl font-bold text-heading mb-6">Sales Report Overview 📈</h1>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
            
            <div class="card bg-neutral-primary-soft shadow-md border border-default p-4">
                <div class="card-body p-0">
                    <h2 class="card-title text-heading text-lg">Total Revenue (Q4)</h2>
                    <p class="text-3xl font-extrabold text-fg-brand">₱ <?php echo number_format($total_sales, 2); ?></p>
                    <p class="text-sm text-success-strong">↑ 12.5% vs last period</p>
                </div>
            </div>

            <div class="card bg-neutral-primary-soft shadow-md border border-default p-4">
                <div class="card-body p-0">
                    <h2 class="card-title text-heading text-lg">Total Orders</h2>
                    <p class="text-3xl font-extrabold text-fg-brand"><?php echo $total_orders; ?></p>
                    <p class="text-sm text-danger-strong">↓ 3.1% vs last period</p>
                </div>
            </div>

            <div class="card bg-neutral-primary-soft shadow-md border border-default p-4">
                <div class="card-body p-0">
                    <h2 class="card-title text-heading text-lg">Avg. Order Value</h2>
                    <p class="text-3xl font-extrabold text-fg-brand">₱ <?php echo number_format($average_order_value, 2); ?></p>
                    <p class="text-sm text-success-strong">↑ 7.2% vs last period</p>
                </div>
            </div>
        </div>

        <div class="bg-neutral-secondary-soft rounded-base border border-default mb-8 p-6">
            <h2 class="text-xl font-bold text-heading mb-4">Monthly Revenue Trend</h2>
            <div class="h-64 flex items-center justify-center text-fg-disabled">
                [Placeholder for Interactive Sales Chart]
            </div>
            <div class="stats shadow w-full mt-4 border border-default">
              <?php foreach ($monthly_sales_data as $data): ?>
                <div class="stat">
                  <div class="stat-title"><?php echo $data['month']; ?> Revenue</div>
                  <div class="stat-value text-base text-fg-brand">₱<?php echo number_format($data['revenue'], 0); ?></div>
                </div>
              <?php endforeach; ?>
            </div>
        </div>
        
        <h2 class="text-xl font-bold text-heading mb-4">Recent Transactions</h2>

        <div class="overflow-x-auto bg-neutral-primary-soft rounded-base border border-default">
            <table class="table w-full text-sm text-left text-body">
                <thead class="text-xs text-heading uppercase bg-neutral-secondary-soft">
                    <tr>
                        <th scope="col" class="px-6 py-3">Transaction ID</th>
                        <th scope="col" class="px-6 py-3">Date</th>
                        <th scope="col" class="px-6 py-3">Customer</th>
                        <th scope="col" class="px-6 py-3">Amount</th>
                        <th scope="col" class="px-6 py-3">Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($transactions)): ?>
                        <?php foreach ($transactions as $txn): ?>
                            <tr class="bg-white border-b hover:bg-neutral-secondary-soft">
                                <th scope="row" class="px-6 py-4 font-medium text-heading whitespace-nowrap">
                                    <?php echo htmlspecialchars($txn['id']); ?>
                                </th>
                                <td class="px-6 py-4">
                                    <?php echo htmlspecialchars($txn['date']); ?>
                                </td>
                                <td class="px-6 py-4">
                                    <?php echo htmlspecialchars($txn['customer']); ?>
                                </td>
                                <td class="px-6 py-4 font-bold text-fg-brand">
                                    ₱<?php echo number_format($txn['amount'], 2); ?>
                                </td>
                                <td class="px-6 py-4">
                                    <?php 
                                        $badge_class = 'badge-neutral';
                                        if ($txn['status'] == 'Completed') $badge_class = 'badge-success';
                                        if ($txn['status'] == 'Pending') $badge_class = 'badge-warning';
                                        if ($txn['status'] == 'Cancelled') $badge_class = 'badge-error';
                                    ?>
                                    <div class="badge <?php echo $badge_class; ?> text-xs font-semibold">
                                        <?php echo htmlspecialchars($txn['status']); ?>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr class="bg-white border-b">
                            <td colspan="5" class="px-6 py-4 text-center text-body">No recent transactions found.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

    </div>
</div>

<?php 
// Include the footer (assumed to contain closing tags and scripts)
include ('../../public/admin/footer.php'); 
?>