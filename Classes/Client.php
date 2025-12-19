<?php
require_once('Connection.php');

class Users extends Dbh {

    // SIGNUP
    public function signup($email, $hashed_password) {
        $conn = $this->connect();
        $stmt = $conn->prepare('SELECT email FROM user WHERE email = ?');
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) return 3; // Email already exists

        $stmt = $conn->prepare('INSERT INTO user (email, pass, created_at) VALUES (?, ?, NOW())');
        $stmt->bind_param('ss', $email, $hashed_password);
        return $stmt->execute() ? 1 : 2;
    }

    // LOGIN
    public function login($email, $pass) {
        session_start();
        $conn = $this->connect();
        $stmt = $conn->prepare('SELECT id, email, pass FROM user WHERE email = ?');
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            if (password_verify($pass, $row['pass'])) {
                $_SESSION['id'] = $row['id'];
                $_SESSION['email'] = $row['email'];
                return ($_SESSION['id'] == 1)
                    ? '../public/admin/home.php'
                    : '../public/customers/home.php';
            } else {
                return 9; // Incorrect password
            }
        } else {
            return 8; // User not found
        }
    }

    // ADD ORDER
    public function orderNow($userId, $totalAmount) {
        $conn = $this->connect();
        $userId = (int)$userId;
        $totalAmount = (float)$totalAmount;
        $status = 'Pending';

        $stmt = $conn->prepare('INSERT INTO orders (user_id, total_amount, status) VALUES (?, ?, ?)');
        if (!$stmt) return false;

        $stmt->bind_param('ids', $userId, $totalAmount, $status);
        return $stmt->execute() ? 1 : false;
    }

    // GET ORDERS FOR SPECIFIC USER
    public function UserOrders($userId) {
        $conn = $this->connect();
        $stmt = $conn->prepare('SELECT order_id, user_id, total_amount, status FROM orders WHERE user_id = ? ORDER BY order_id DESC');
        $stmt->bind_param('i', $userId);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->num_rows ? $result->fetch_all(MYSQLI_ASSOC) : [];
    }

    // GET ALL ORDERS (ADMIN VIEW)
    public function getAllOrders() {
        $conn = $this->connect();
        $result = $conn->query('SELECT order_id, user_id, total_amount, status FROM orders ORDER BY order_id DESC');
        return $result->num_rows ? $result->fetch_all(MYSQLI_ASSOC) : [];
    }
}
?>
