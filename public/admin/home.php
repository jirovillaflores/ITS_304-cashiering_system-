<?php
session_start();

require_once '../../Classes/Connection.php';

// Database connection
$db = new Dbh();
$conn = $db->connect();

// --- Fetch Dashboard Data ---

// 1. Total Sales (YTD)
$totalSales = 0;
$resultSales = $conn->query("SELECT SUM(total_amount) AS total_sales FROM orders");
if ($resultSales && $row = $resultSales->fetch_assoc()) {
    $totalSales = $row['total_sales'] ?? 0;
}

// 2. Items in Stock
$totalItems = 0;
$resultItems = $conn->query("SELECT COUNT(*) AS total_items FROM products");
if ($resultItems && $row = $resultItems->fetch_assoc()) {
    $totalItems = $row['total_items'] ?? 0;
}

// 3. New Customers (Last 30 IDs)
$newCustomers = 0;
$resultUsers = $conn->query("SELECT COUNT(*) AS new_customers FROM (SELECT order_id FROM orders ORDER BY order_id DESC LIMIT 30) AS recent_users");
if ($resultUsers && $row = $resultUsers->fetch_assoc()) {
    $newCustomers = $row['new_customers'] ?? 0;
}

// --- Dashboard Stats Array ---
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
        'title' => 'New Customers (Last 30 IDs)',
        'value' => $newCustomers,
        'icon'  => 'user-plus',
        'color' => 'info'
    ],
];

// --- Handle Product Add Form ---
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['pr_name'], $_POST['pr_price'])) {
    $name = trim($_POST['pr_name']);
    $price = floatval($_POST['pr_price']);

    if (!empty($name) && $price > 0) {
        $stmt = $conn->prepare("INSERT INTO products (pr_name, pr_price) VALUES (?, ?)");
        $stmt->bind_param("sd", $name, $price);
        $stmt->execute();
        $stmt->close();
        header("Location: ".$_SERVER['PHP_SELF']); // Refresh page after adding
        exit;
    }
}
?>

<?php include ('../../public/admin/header.php'); ?>

<div class="p-6 pt-16 bg-gray-50 min-h-screen">

    <h1 class="text-3xl font-bold text-heading mb-6">Overview</h1>

    <!-- Dashboard Cards -->
    <div class="flex flex-col lg:flex-row gap-6 mb-8">
        <?php foreach ($dashboard_stats as $stat): ?>
        <div class="card flex-1 bg-base-100 shadow-xl border-t-4 border-<?= $stat['color'] ?>/70">
            <div class="card-body p-5 flex-row items-center justify-between">
                <div>
                    <h2 class="text-sm font-medium text-body uppercase"><?= $stat['title'] ?></h2>
                    <p class="text-3xl font-extrabold text-heading mt-1"><?= $stat['value'] ?></p>
                </div>
                <div class="p-3 rounded-full bg-<?= $stat['color'] ?>-200 text-<?= $stat['color'] ?>-700">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <?php 
                            switch ($stat['icon']) {
                                case 'currency-dollar': echo '<path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8h.01M12 18V6m-2 4h4a2 2 0 002-2V6a2 2 0 00-2-2h-4a2 2 0 00-2 2v2M8 10h8m-8 4h8"/>'; break;
                                case 'cube': echo '<path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10m0-10l-4-2m4 2l4-2"/>'; break;
                                case 'user-plus': echo '<path stroke-linecap="round" stroke-linejoin="round" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zm-8 7h8a4 4 0 014 4v2a1 1 0 01-1 1H3a1 1 0 01-1-1v-2a4 4 0 014-4z"/>'; break;
                            }
                        ?>
                    </svg>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>

    <!-- Quick Actions -->
    <div class="flex flex-col lg:flex-row gap-6">
        <div class="flex-1 card bg-base-100 shadow-xl p-6 flex flex-col">
            <h3 class="text-xl font-semibold mb-4 text-heading">Quick Actions</h3>
            <div class="space-y-4">
                <button onclick="my_modal_3.showModal()" type="button" class="btn btn-primary w-full shadow-lg">
                    <svg class="w-5 h-5 inline-block mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14m-7 7V5"/></svg>
                    Create New Product
                </button>
                <a href="inventory.php" class="btn btn-outline btn-info w-full flex items-center">View Inventory</a>
                <a href="customer_list.php" class="btn btn-outline w-full flex items-center">Manage Customers</a>
                <a href="logout.php" class="logout btn btn-outline btn-error w-full flex items-center">Logout</a>
            </div>
        </div>
    </div>

</div>

<!-- Create Product Modal -->
<dialog id="my_modal_3" class="modal">
    <div class="modal-box p-0">
        <div class="p-4 md:p-6"> 
            <div class="flex justify-between items-center pb-4 md:pb-6 border-b border-default">
                <h3 class="text-lg font-medium text-heading">Create new product</h3>
                <form method="dialog">
                    <button class="text-body bg-transparent rounded-base text-sm w-9 h-9 flex justify-center items-center hover:bg-neutral-tertiary hover:text-heading">
                        &times;
                    </button>
                </form>
            </div>
            
            <form method="POST" class="mt-4 md:mt-6">
                <div class="grid gap-4 grid-cols-2 py-4 md:py-6">
                    <div class="col-span-2">
                        <label class="block mb-2.5 text-sm font-medium text-heading">Product Name</label>
                        <input type="text" name="pr_name" class="input input-bordered w-full" placeholder="Type product name" required>
                    </div>
                    <div class="col-span-2">
                        <label class="block mb-2.5 text-sm font-medium text-heading">Price</label>
                        <input type="number" name="pr_price" step="0.01" class="input input-bordered w-full" placeholder="Enter price" required>
                    </div>
                </div>
                <div class="flex items-center space-x-4 border-t border-default pt-4 md:pt-6">
                    <button type="submit" class="btn btn-primary">Add Product</button>
                    <button type="button" class="btn btn-outline" onclick="my_modal_3.close()">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</dialog>

<?php include ('../../public/admin/footer.php'); ?>
