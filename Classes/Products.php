<?php
class Products {
    private $host = 'localhost';
    private $user = 'root';
    private $pass = '';
    private $db   = 'r&r_dbs'; // change if your DB name is different
    private $conn;

    public function __construct() {
        $this->connect();
    }

    // Connect to database
    public function connect() {
        if ($this->conn === null) {
            $this->conn = new mysqli($this->host, $this->user, $this->pass, $this->db);
            if ($this->conn->connect_error) {
                die("Connection failed: " . $this->conn->connect_error);
            }
        }
        return $this->conn;
    }

    // Get all products
    public function getProducts() {
        $products = [];
        $sql = "SELECT * FROM products ORDER BY pr_id DESC";
        $result = $this->conn->query($sql);
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $products[] = $row;
            }
        }
        return $products;
    }

    // Add a new product
    public function addProduct($name, $price) {
        $stmt = $this->conn->prepare("INSERT INTO products (pr_name, pr_price) VALUES (?, ?)");
        if (!$stmt) return false;
        $stmt->bind_param("sd", $name, $price);
        $res = $stmt->execute();
        $stmt->close();
        return $res;
    }

    // Update a product
    public function updateProduct($id, $name, $price) {
        $stmt = $this->conn->prepare("UPDATE products SET pr_name = ?, pr_price = ? WHERE pr_id = ?");
        if (!$stmt) return false;
        $stmt->bind_param("sdi", $name, $price, $id);
        $res = $stmt->execute();
        $stmt->close();
        return $res;
    }

    // Delete a product
    public function deleteProduct($id) {
        $stmt = $this->conn->prepare("DELETE FROM products WHERE pr_id = ?");
        if (!$stmt) return false;
        $stmt->bind_param("i", $id);
        $res = $stmt->execute();
        $stmt->close();
        return $res;
    }
}
?>
