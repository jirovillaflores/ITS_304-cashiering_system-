<?php
session_start();

// Database connection
$host = 'localhost';
$user = 'root';
$pass = '';
$db_name = 'r&r_dbs';

$conn = new mysqli($host, $user, $pass, $db_name);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch products
$sql = "SELECT pr_id, pr_name, pr_price FROM products ORDER BY pr_id ASC";
$result = $conn->query($sql);

$products = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $products[] = $row;
    }
}

unset($_SESSION['current_order']);
?>

<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Homepage</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/daisyui@4.4.19/dist/full.min.css" rel="stylesheet" type="text/css" />
    <style>
        /* Ensures currency columns look neat */
        .col-price { text-align: right; font-family: monospace; }
        .col-center { text-align: center; }
    </style>
</head>
<body class="bg-gray-50">

<div class="drawer drawer-end">
    <input id="order-drawer" type="checkbox" class="drawer-toggle" />

    <div class="drawer-content min-h-screen flex flex-col">
        <header class="navbar bg-base-100 shadow-md px-6 py-4">
            <div class="flex-1">
                <div>
                    <h1 class="text-2xl font-bold text-primary">R & R Hardware</h1>
                    <?php if(isset($_SESSION['email'])): ?>
                        <p class="text-xs text-gray-500">User: <?= htmlspecialchars($_SESSION['email']) ?></p>
                    <?php endif; ?>
                </div>
            </div>
            <div class="flex-none gap-2">
                <button class="btn btn-ghost btn-circle relative mr-2" onclick="document.getElementById('order-drawer').checked = true;">
                    <div class="indicator">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4z"/>
                        </svg>
                        <span id="cart-count-badge" class="badge badge-sm badge-primary indicator-item">0</span>
                    </div>
                </button>
                <a href="logout.php" class="btn btn-outline btn-error btn-sm">Logout</a>
            </div>
        </header>

        <main class="p-6 max-w-6xl mx-auto w-full">
            <h2 class="text-3xl font-bold mb-6 text-gray-800">Available Products</h2>

            <div class="overflow-x-auto bg-base-100 shadow-xl rounded-xl">
                <table class="table table-zebra w-full">
                    <thead class="bg-primary text-primary-content">
                        <tr>
                            <th class="w-16">#</th>
                            <th>Product Name</th>
                            <th class="text-right">Price</th>
                            <th class="text-center">Quantity</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($products as $index => $product): ?>
                        <tr data-id="<?= $product['pr_id'] ?>" 
                            data-name="<?= $product['pr_name'] ?>" 
                            data-price="<?= $product['pr_price'] ?>"
                            class="hover">
                            <th><?= $index + 1 ?></th>
                            <td class="font-medium"><?= $product['pr_name'] ?></td>
                            <td class="col-price">₱<?= number_format($product['pr_price'], 2) ?></td>
                            <td class="text-center">
                                <input type="number" min="1" value="1" class="input input-bordered input-sm w-20 text-center quantity-input"/>
                            </td>
                            <td class="text-center">
                                <button class="btn btn-primary btn-sm add-to-cart">Add to Order</button>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </main>
    </div>

    <div class="drawer-side z-50">
        <label for="order-drawer" class="drawer-overlay"></label>
        <div class="p-6 w-80 md:w-96 min-h-full bg-base-100 text-base-content shadow-2xl flex flex-col">
            <h2 class="text-2xl font-bold mb-6 flex justify-between items-center">
                Current Order
                <label for="order-drawer" class="btn btn-sm btn-circle">✕</label>
            </h2>

            <div class="flex-grow overflow-y-auto">
                <table id="order-list" class="table table-compact w-full">
                    <thead>
                        <tr>
                            <th>Item</th>
                            <th class="text-right">Total</th>
                            <th class="text-center">Qty</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        </tbody>
                </table>
            </div>

            <div class="divider"></div>

            <div class="bg-gray-50 p-4 rounded-lg space-y-2 mb-4">
                <div class="flex justify-between text-sm">
                    <span>Subtotal</span>
                    <span id="subtotal" class="font-mono">₱0.00</span>
                </div>
                <div class="flex justify-between text-lg font-bold text-primary border-t pt-2">
                    <span>TOTAL</span>
                    <span id="total" class="font-mono">₱0.00</span>
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
    const orderListBody = document.querySelector('#order-list tbody');
    const subtotalDisplay = document.getElementById('subtotal');
    const totalDisplay = document.getElementById('total');
    const cartCountBadge = document.getElementById('cart-count-badge');
    const checkoutBtn = document.getElementById('checkout-btn');
    const orderDataInput = document.getElementById('order-data-input');

    function updateOrderDisplay() {
        orderListBody.innerHTML = '';
        let subtotal = 0;
        let totalItems = 0;

        if (order.length === 0) {
            orderListBody.innerHTML = '<tr><td colspan="4" class="text-center py-10 text-gray-400 italic">Your cart is empty</td></tr>';
            checkoutBtn.disabled = true;
        } else {
            checkoutBtn.disabled = false;
            order.forEach((item, index) => {
                const itemTotal = item.price * item.quantity;
                subtotal += itemTotal;
                totalItems += item.quantity;

                const row = document.createElement('tr');
                row.innerHTML = `
                    <td class="max-w-[120px] truncate font-semibold text-xs">${item.name}</td>
                    <td class="text-right font-mono text-xs">₱${itemTotal.toFixed(2)}</td>
                    <td class="text-center text-xs">${item.quantity}</td>
                    <td class="text-right">
                        <button class="btn btn-ghost btn-xs text-error remove-item" data-index="${index}">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                        </button>
                    </td>
                `;
                orderListBody.appendChild(row);
            });
        }

        subtotalDisplay.textContent = `₱${subtotal.toLocaleString(undefined, {minimumFractionDigits: 2})}`;
        totalDisplay.textContent = `₱${subtotal.toLocaleString(undefined, {minimumFractionDigits: 2})}`;
        cartCountBadge.textContent = totalItems;

        orderDataInput.value = JSON.stringify({
            items: order,
            total: subtotal.toFixed(2)
        });
    }

    // Event Listeners
    document.querySelectorAll('.add-to-cart').forEach(button => {
        button.addEventListener('click', (e) => {
            const row = e.target.closest('tr');
            const qtyInput = row.querySelector('.quantity-input');
            const qty = parseInt(qtyInput.value) || 1;
            
            const productData = {
                id: parseInt(row.dataset.id),
                name: row.dataset.name,
                price: parseFloat(row.dataset.price),
                quantity: qty
            };

            const existing = order.find(item => item.id === productData.id);
            if (existing) {
                existing.quantity += qty;
            } else {
                order.push(productData);
            }
            
            updateOrderDisplay();
            qtyInput.value = 1; // Reset input
            document.getElementById('order-drawer').checked = true;
        });
    });

    orderListBody.addEventListener('click', (e) => {
        const btn = e.target.closest('.remove-item');
        if (btn) {
            order.splice(parseInt(btn.dataset.index), 1);
            updateOrderDisplay();
        }
    });

    updateOrderDisplay();
</script>
</body>
</html>