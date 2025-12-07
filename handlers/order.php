<?php
include('../Classes/Client.php');
$clients = new Users();

if (isset($_POST['order_now'])) {
        $add = $_POST['address'];
        $contact = $_POST['contact'];
        $userId = $_POST['user_id'];
        $amount = $_POST['amount'];

    // VALIDATIONS

    if ($add == '' && $contact == '') {
        $response = array(
            'error' => "Email and Password are empty!",
        );
    } else {

        $book = $clients->orderNow($amount, $add, $contact , $userId);

        if ($book === 1) {
            $response = array(
                'success' => "Book Success!",
            );
        } else if ($book === 2) {
            $response = array(
                'error' => "Please try again",
            );
        } else {
            $response = array(
                //'session => $_SESSION['email'],
                'error' => "Database error",
            );
        }
    }

    echo json_encode($response);
    exit;
}
?>