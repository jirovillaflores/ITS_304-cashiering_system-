</body>

<script>

function setCreateMode() {
    // Check if the required elements exist
    if (document.getElementById('modal-title')) {
        document.getElementById('modal-title').textContent = 'Create New Product';
        document.getElementById('product-action').value = 'create';
        document.getElementById('product-id').value = ''; // This holds the pr_id
        document.getElementById('pr_name').value = '';
        document.getElementById('pr_price').value = '';
        document.getElementById('submit-button').innerHTML = '<svg class="w-4 h-4 me-1.5 -ms-0.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14m-7 7V5"/></svg> Add Product';
    }
}

/**
 * Sets the modal state to UPDATE mode, pre-filling fields with product data.
 * NOTE: Using pr_id, pr_name, pr_price for consistency with PHP attributes.
 * @param {number} pr_id - The ID of the product being edited.
 * @param {string} pr_name - The name of the product.
 * @param {number} pr_price - The price of the product.
 */
function editProduct(pr_id, pr_name, pr_price) {
    const modal = document.getElementById('my_modal_3');
    if (modal) {
        document.getElementById('modal-title').textContent = `Update Product ID: ${pr_id}`;
        document.getElementById('product-action').value = 'update';
        document.getElementById('product-id').value = pr_id; // Set the hidden ID field
        document.getElementById('pr_name').value = pr_name;
        document.getElementById('pr_price').value = pr_price;
        document.getElementById('submit-button').innerHTML = '<svg class="w-4 h-4 me-1.5 -ms-0.5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4 4v5h.582m15.356-2A8.001 8.001 0 004.582 19.42M20 15v5h.582"/></svg> Update Product';

        modal.showModal();
    }
}

/**
 * Handles the confirmation and AJAX request for deleting a product.
 * @param {number} pr_id - The ID of the product to delete.
 */
function deleteProduct(pr_id) {
    if (confirm(`Are you sure you want to delete Product ID ${pr_id}? This action cannot be undone.`)) {
        $.ajax({
            url: '../handlers/additem.php', 
            method: 'POST',
            dataType: 'json',
            data: { 
                action: 'delete', 
                pr_id: pr_id // Sending the product ID
            },
            success: function(response) {
                if (response.success) {
                    alert('Product deleted successfully!');
                    location.reload(); 
                } else {
                    alert('Deletion failed: ' + (response.error || 'Unknown error.'));
                }
            },
            error: function() {
                alert('Request failed. Check server response.');
            }
        });
    }
}

/**
 * Handles the confirmation and AJAX request for deleting a customer.
 * NOTE: Assumes customer ID attribute is 'cust_id' for back-end consistency.
 * @param {number} cust_id - The ID of the customer to delete.
 */
function deleteCustomer(cust_id) {
    if (confirm(`Are you sure you want to delete Customer ID ${cust_id}? This action cannot be undone.`)) {
        $.ajax({
            url: '../handlers/additem.php', 
            method: 'POST',
            dataType: 'json',
            data: { 
                action: 'delete', 
                cust_id: cust_id // Sending the customer ID
            },
            success: function(response) {
                if (response.success) {
                    alert('Customer deleted successfully!');
                    location.reload(); 
                } else {
                    alert('Deletion failed: ' + (response.error || 'Unknown error.'));
                }
            },
            error: function() {
                alert('Request failed. Check server response.');
            }
        });
    }
}

// Placeholder for customer editing (will need a dedicated modal/form)
function editCustomer(id, name, email) {
    alert(`Simulating edit for Customer: ${name} (ID: ${id}) - Open Customer Edit Modal here.`);
}


// ==========================================================
// 2. JQUERY DOCUMENT READY (For AJAX Form Submission: Create/Update)
// ==========================================================

$(document).ready(function() {
    
    // Initial call to set the modal state
    setCreateMode(); 

    // Handle the product form submission (Create or Update)
    $('#product-form').on('submit', function(e) {
        e.preventDefault(); 

        const formData = new FormData(this);
        const action = $('#product-action').val();
        const actionVerb = (action === 'update' ? 'updated' : 'added');

        // Append the standardized product ID name to formData
        // Since the HTML input ID is 'product-id', we rename it for the back-end
        formData.append('pr_id', $('#product-id').val()); 
        
        // Append the standardized product input names
        formData.append('pr_name', $('#pr_name').val());
        formData.append('pr_price', $('#pr_price').val());


        $.ajax({
            url: '../handlers/additem.php',
            method: "POST",
            data: formData,
            processData: false, 
            contentType: false, 
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    // SUCCESS ALERT MESSAGE
                    alert(`Product successfully ${actionVerb}!`); 
                    
                    // Close the modal
                    if (typeof my_modal_3 !== 'undefined') {
                        my_modal_3.close(); 
                    }
                    
                    // Reload the page to display the change
                    location.reload(); 
                } else {
                    // ERROR ALERT MESSAGE
                    alert(`Failed to ${action}. Error: ${response.error || 'Unknown server error.'}`); 
                }
            },
            error: function(xhr, status, error) {
                console.error("AJAX Error:", status, error, xhr.responseText);
                alert("Request failed. Check the console for details.");
            }
        });
    });

});
</script>
</html>