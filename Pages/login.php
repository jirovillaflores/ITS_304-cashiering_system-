<?php
session_start();

// ========================
// SESSION & ROLE CHECK
// ========================
if (!isset($_SESSION['user_id']) || !isset($_SESSION['role'])) {
    // Not logged in
    header("Location: ../login.php");
    exit();
}

// Only allow customers
if ($_SESSION['role'] !== 'customer') {
    // If logged in as admin, redirect to admin dashboard
    header("Location: ../admin/dashboard.php");
    exit();
}

// ========================
// DATABASE CONNECTION
// ========================
$host = 'localhost';
$user = 'root';
$pass = '';
$db_name = 'r&r_dbs';

$conn = new mysqli($host, $user, $pass, $db_name);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// ========================
// FETCH PRODUCTS
// ========================
$sql = "SELECT pr_id, pr_name, pr_price FROM products ORDER BY pr_id ASC";
$result = $conn->query($sql);

$products = [];
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $products[] = $row;
    }
}

// Clear old order data for this session
unset($_SESSION['current_order']);
?>

<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Customer Homepage - Product Selection</title>
<script src="https://cdn.tailwindcss.com"></script>
<link href="https://cdn.jsdelivr.net/npm/daisyui@4.4.19/dist/full.min.css" rel="stylesheet" type="text/css" />
</head>
<body>

<div class="drawer drawer-end">
    <input id="order-drawer" type="checkbox" class="drawer-toggle" />

    <!-- MAIN CONTENT -->
    <div class="drawer-content min-h-screen p-4 bg-gray-50">
        <header class="navbar bg-base-100 shadow-md rounded-box mb-6">
            <div class="flex-1">
                <a class="text-2xl font-bold text-primary">R & R Hardware and Construction Supplies</a>
                <span class="ml-4 text-sm text-gray-600">Logged in as: <?= htmlspecialchars($_SESSION['email']) ?></span>
            </div>
            <div class="flex-none">
                <button class="btn btn-ghost btn-circle relative" onclick="document.getElementById('order-drawer').checked = true;">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                        d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4z"/>
                    </svg>
                    <div id="cart-count-badge" class="badge badge-sm badge-primary absolute top-0 right-0">0</div>
                </button>
                
                <a href="../logout.php" class="btn btn-ghost ml-2">Logout</a>
            </div>
        </header>

        <h2 class="text-3xl font-semibold mb-6">Select Products</h2>

        <table class="table-auto w-full bg-base-100 shadow-md rounded-box">
            <thead class="bg-primary/20">
                <tr>
                    <th class="px-4 py-2 text-left">#</th>
                    <th class="px-4 py-2 text-left">Product</th>
                    <th class="px-4 py-2 text-left">Price</th>
                    <th class="px-4 py-2 text-left">Quantity</th>
                    <th class="px-4 py-2 text-left">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($products as $index => $product): ?>
                <tr data-id="<?= $product['pr_id'] ?>" 
                    data-name="<?= $product['pr_name'] ?>" 
                    data-price="<?= $product['pr_price'] ?>">
                    <td class="border px-4 py-2"><?= $index + 1 ?></td>
                    <td class="border px-4 py-2"><?= htmlspecialchars($product['pr_name']) ?></td>
                    <td class="border px-4 py-2">₱<?= number_format($product['pr_price'], 2) ?></td>
                    <td class="border px-4 py-2">
                        <input type="number" min="1" value="1" class="input input-sm w-20 quantity-input"/>
                    </td>
                    <td class="border px-4 py-2">
                        <button class="btn btn-primary btn-sm add-to-cart">Add to Order</button>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- CART DRAWER -->
    <div class="drawer-side z-50">
        <label for="order-drawer" class="drawer-overlay"></label>
        <div class="menu w-96 min-h-full bg-base-200 p-4">
            <h2 class="text-2xl font-bold mb-4">Current Order</h2>

            <table id="order-list" class="table-auto w-full bg-base-100 shadow-sm rounded-box mb-4">
                <thead>
                    <tr class="bg-primary/20">
                        <th class="px-2 py-1 text-left">Product</th>
                        <th class="px-2 py-1 text-left">Price</th>
                        <th class="px-2 py-1 text-left">Quantity</th>
                        <th class="px-2 py-1 text-left">Total</th>
                        <th class="px-2 py-1 text-left">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr id="empty-cart-message">
                        <td colspan="5" class="text-gray-500 italic text-center">Your order is empty.</td>
                    </tr>
                </tbody>
            </table>

            <div class="divider"></div>

            <div class="space-y-2 mb-4">
                <div class="flex justify-between font-semibold">
                    <span>Subtotal:</span>
                    <span id="subtotal">₱0.00</span>
                </div>
                <div class="flex justify-between font-semibold text-lg text-primary">
                    <span>TOTAL:</span>
                    <span id="total">₱0.00</span>
                </div>
            </div>

            <form id="checkout-form" method="POST" action="checkout.php">
                <input type="hidden" name="order_data" id="order-data-input">
                <button type="submit" id="checkout-btn" class="btn btn-primary w-full" disabled>
                    Complete Order
                </button>
            </form>
        </div>
    </div>
</div>

<script>
const order = [];
const orderList = document.getElementById('order-list');
const subtotalDisplay = document.getElementById('subtotal');
const totalDisplay = document.getElementById('total');
const cartCountBadge = document.getElementById('cart-count-badge');
const checkoutBtn = document.getElementById('checkout-btn');
const orderDataInput = document.getElementById('order-data-input');

function updateOrderDisplay() {
    const tbody = orderList.querySelector('tbody');
    tbody.innerHTML = '';
    let subtotal = 0;
    let totalItems = 0;

    if (order.length === 0) {
        tbody.innerHTML = `<tr><td colspan="5" class="text-gray-500 italic text-center">Your order is empty.</td></tr>`;
        checkoutBtn.disabled = true;
    } else {
        checkoutBtn.disabled = false;

        order.forEach((item, index) => {
            const itemTotal = item.price * item.quantity;
            subtotal += itemTotal;
            totalItems += item.quantity;

            const row = document.createElement('tr');
            row.innerHTML = `
                <td class="border px-2 py-1">${item.name}</td>
                <td class="border px-2 py-1">₱${item.price.toFixed(2)}</td>
                <td class="border px-2 py-1">${item.quantity}</td>
                <td class="border px-2 py-1">₱${itemTotal.toFixed(2)}</td>
                <td class="border px-2 py-1">
                    <button type="button" class="btn btn-xs btn-error btn-outline remove-item" data-index="${index}">Delete</button>
                </td>
            `;
            tbody.appendChild(row);
        });
    }

    subtotalDisplay.textContent = `₱${subtotal.toFixed(2)}`;
    totalDisplay.textContent = `₱${subtotal.toFixed(2)}`;
    cartCountBadge.textContent = totalItems;

    // Send only total and items to checkout
    orderDataInput.value = JSON.stringify({
        items: order,
        total: subtotal.toFixed(2)
    });
}

function addItem(productData) {
    const existingItem = order.find(item => item.id === productData.id);
    if (existingItem) {
        existingItem.quantity += productData.quantity;
    } else {
        order.push(productData);
    }
    updateOrderDisplay();
}

// Add to cart button
document.querySelectorAll('.add-to-cart').forEach(button => {
    button.addEventListener('click', (e) => {
        const row = e.target.closest('tr');
        const productData = {
            id: parseInt(row.dataset.id),
            name: row.dataset.name,
            price: parseFloat(row.dataset.price),
            quantity: parseInt(row.querySelector('.quantity-input').value) || 1
        };
        addItem(productData);
        document.getElementById('order-drawer').checked = true;
    });
});

// Remove item
orderList.addEventListener('click', (e) => {
    if (e.target.closest('.remove-item')) {
        const index = parseInt(e.target.closest('.remove-item').dataset.index);
        order.splice(index, 1);
        updateOrderDisplay();
    }
});

// Initial load
updateOrderDisplay();
</script>

</body>
</html>
