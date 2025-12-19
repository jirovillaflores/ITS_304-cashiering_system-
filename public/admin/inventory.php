<?php
session_start();
include ('../../public/admin/header.php');
include ('../../Classes/Products.php');

$productsObj = new Products();
$products = $productsObj->getProducts();
?>

<div class="p-4 sm:ml-64 pt-16">
    <div class="p-4 border-1 border-default border-dashed rounded-base">
        <h1 class="text-2xl font-bold mb-6">Inventory Management 📦</h1>

        <!-- Notification -->
        <div id="notification" class="hidden p-4 mb-4 rounded text-white"></div>

        <div class="flex flex-col sm:flex-row justify-between items-center mb-6 gap-4">
            <input type="text" id="search-input" placeholder="Search products by name or SKU" class="input input-bordered w-full sm:w-80">
            <button onclick="setCreateMode(); my_modal_3.showModal();" class="btn btn-primary w-full sm:w-auto">Add New Product</button>
        </div>

        <div class="overflow-x-auto bg-neutral-primary-soft rounded-base border border-default">
            <table id="product-table" class="table w-full">
    <thead>
        <tr>
            <th>ID</th>
            <th>Product Name</th>
            <th>Price</th>
            <th class="text-right">Actions</th>
        </tr>
    </thead>
    <tbody>
<?php foreach($products as $row): ?>
<tr data-id="<?= $row['pr_id'] ?>" data-name="<?= htmlspecialchars($row['pr_name']) ?>" data-price="<?= $row['pr_price'] ?>">
    <td><?= $row['pr_id'] ?></td>
    <td><?= htmlspecialchars($row['pr_name']) ?></td>
    <td>₱<?= number_format($row['pr_price'],2) ?></td>
            <td class="text-right">
        <button type="button" class="btn btn-ghost btn-sm text-info edit-product">Edit</button>
        <button type="button" class="btn btn-ghost btn-sm text-error delete-product">Delete</button>
        </td>
</tr>
<?php endforeach; ?>
</tbody>

</table>

        </div>
    </div>
</div>

<dialog id="my_modal_3" class="modal">
    <div class="modal-box">
        <h3 id="modal-title">Create New Product</h3>
        <form id="product-form">
            <input type="hidden" name="action" id="product-action" value="create">
            <input type="hidden" name="pr_id" id="product-id">

            <label for="pr_name" class="block mb-2.5 text-sm font-medium text-heading">Product Name</label>
            <input type="text" name="pr_name" id="pr_name" required class="input input-bordered w-full">

            <label for="pr_price" class="block mb-2.5 text-sm font-medium text-heading">Price</label>
            <input type="number" name="pr_price" id="pr_price" step="0.01" required class="input input-bordered w-full">

            <div class="modal-action">
                <button type="submit" id="submit-button" class="btn btn-primary">Submit</button>
                <button type="button" onclick="my_modal_3.close()" class="btn">Cancel</button>
            </div>
        </form>
    </div>
</dialog>


<?php include ('../../public/admin/footer.php'); ?>


<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<script>
$(document).ready(function () {

    const modal = document.getElementById('my_modal_3');

  
    window.setCreateMode = function () {
        modal.showModal();
        $('#modal-title').text('Create Product');
        $('#product-action').val('create');
        $('#product-id').val('');
        $('#pr_name').val('');
        $('#pr_price').val('');
    };

    
    $('#product-table').on('click', '.edit-product', function () {
        const row = $(this).closest('tr');

        modal.showModal();
        $('#modal-title').text('Edit Product');
        $('#product-action').val('update');
        $('#product-id').val(row.data('id'));
        $('#pr_name').val(row.data('name'));
        $('#pr_price').val(row.data('price'));
    });

    $('#product-table').on('click', '.delete-product', function () {
        if (!confirm('Delete this product?')) return;

        const id = $(this).closest('tr').data('id');

        $.ajax({
            url: 'product_handler.php',
            method: 'POST',
            dataType: 'json',
            data: { action: 'delete', pr_id: id },
            success: function (res) {
                alert(res.message);
                if (res.status === 'success') location.reload();
            },
            error: function () {
                alert('AJAX error');
            }
        });
    });

    // SUBMIT FORM
    $('#product-form').on('submit', function (e) {
        e.preventDefault();

        $.ajax({
            url: 'product_handler.php',
            method: 'POST',
            dataType: 'json',
            data: $(this).serialize(),
            success: function (res) {
                alert(res.message);
                if (res.status === 'success') location.reload();
            }
        });
    });

});
</script>




</div>

</body>
</html>
