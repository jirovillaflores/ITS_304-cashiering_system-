<?php
require_once('Connection.php');

class Users extends Dbh {

public function addItem($prod_name, $price) {
    $conn = $this->connect();
    if (!$conn) {
        error_log("Database connection failed during addItem.");
        return false;
    }
    
  
    $sql = "INSERT INTO products (pr_name, pr_price) VALUES (?, ?)";
    $types = 'sd'; // string, double
    $params = [$prod_name, $price];
    
    $stmt = $conn->prepare($sql);
    
    if (!$stmt) {
        error_log("Query preparation failed: " . $conn->error);
        $conn->close();
        return false;
    }
    
    $stmt->bind_param($types, ...$params);

    $result = $stmt->execute();
    $stmt->close();

    return $result;
}

public function getProducts($userId = null) {
    $conn = $this->connect();
    if (!$conn) {
        error_log("Database connection failed: " . $conn->connect_error);
        return [];
    }
    
    $sql = "SELECT pr_id, pr_name, pr_price FROM products ORDER BY pr_id DESC"; 
    $stmt = $conn->prepare($sql);
    
    if (!$stmt) {
        error_log("Query preparation failed: " . $conn->error);
        return [];
    }
    
    $stmt->execute();
    $result = $stmt->get_result();

    $products = [];
    while ($row = $result->fetch_assoc()) {
        $products[] = $row;
    }
    $stmt->close();
    return $products;
}

public function updateItem($pr_id, $prod_name, $price) {
    $conn = $this->connect();
    if (!$conn) {
        error_log("Database connection failed during updateItem.");
        return false;
    }

    $sql = "UPDATE products SET pr_name = ?, pr_price = ? WHERE pr_id = ?";
    
    $stmt = $conn->prepare($sql);
    
    if (!$stmt) {
        error_log("Query preparation failed: " . $conn->error);
        $conn->close();
        return false;
    }
    
    // Bind parameters: string (name), double (price), int (pr_id)
    $stmt->bind_param('sdi', $prod_name, $price, $pr_id);

    $result = $stmt->execute();
    $stmt->close();

    return $result && $conn->affected_rows > 0;
}

public function deleteItem($pr_id) {
    $conn = $this->connect();
    if (!$conn) {
        error_log("Database connection failed during deleteItem.");
        return false;
    }

    $sql = "DELETE FROM products WHERE pr_id = ?";
    
    $stmt = $conn->prepare($sql);
    
    if (!$stmt) {
        error_log("Query preparation failed: " . $conn->error);
        $conn->close();
        return false;
    }
    
    $stmt->bind_param('i', $pr_id);

    $result = $stmt->execute();
    $stmt->close();
    
    return $result && $conn->affected_rows > 0;
}


public function getAllCustomers() {
    $conn = $this->connect();
    if (!$conn) return [];

    $sql = "SELECT id, mobile, lname, fname, mname, addr FROM cuslist ORDER BY id ASC";
    $result = $conn->query($sql);
    
    $customers = [];
    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $customers[] = $row;
        }
    }
    return $customers;
}


public function getAllOrders() {
    $conn = $this->connect();
    if (!$conn) return [];
    
    $sql = "SELECT o.*, u.email as user_email FROM orders o 
            LEFT JOIN user u ON o.user_id = u.id 
            ORDER BY order_id DESC"; 
            
    $result = $conn->query($sql);

    $orders = [];
    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $orders[] = $row;
        }
    }
    return $orders;
}

public function getSalesSummary() {
    $conn = $this->connect();
    if (!$conn) return ['total_sales' => 0, 'total_orders' => 0, 'average_order_value' => 0];

    $sql = "SELECT SUM(total_amount) as total_sales, COUNT(id) as total_orders 
            FROM orders WHERE status = 'Completed'";
    $result = $conn->query($sql)->fetch_assoc();

    $total_sales = (float)($result['total_sales'] ?? 0);
    $total_orders = (int)($result['total_orders'] ?? 0);
    $average_order_value = $total_orders > 0 ? $total_sales / $total_orders : 0;
    
    return [
        'total_sales' => $total_sales,
        'total_orders' => $total_orders,
        'average_order_value' => $average_order_value,
    ];
}

public function deleteCustomer($cust_id) {
    $conn = $this->connect();
    if (!$conn) return false;

    $sql = "DELETE FROM cuslist WHERE id = ?";
    $stmt = $conn->prepare($sql);
    if (!$stmt) return false;

    $stmt->bind_param("i", $cust_id);
    $result = $stmt->execute();
    $stmt->close();

    return $result && $conn->affected_rows > 0;
}

public function updateCustomer($id, $mobile, $lname, $fname, $mname) {
    $conn = $this->connect();
    if (!$conn) return false;

    $sql = "UPDATE cuslist 
            SET mobile = ?, lname = ?, fname = ?, mname = ?
            WHERE id = ?";

    $stmt = $conn->prepare($sql);
    if (!$stmt) return false;

    $stmt->bind_param("ssssi", $mobile, $lname, $fname, $mname, $id);
    $result = $stmt->execute();
    $stmt->close();

    return $result && $conn->affected_rows > 0;
}
public function updateOrderStatus($orderId, $status) {
    $conn = $this->connect();
    if (!$conn) return false;

    $sql = "UPDATE orders SET status = ? WHERE order_id = ?";
    $stmt = $conn->prepare($sql);
    if (!$stmt) return false;

    $stmt->bind_param("ss", $status, $orderId);
    $result = $stmt->execute();
    $stmt->close();

    return $result && $conn->affected_rows > 0;
}



}