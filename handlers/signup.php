<?php
include('../Classes/Client.php');
$clients = new Users();

if (isset($_POST['signup'])) {
    $email = $_POST['email'];
    $pass = $_POST['pass'];

    // VALIDATIONS

    if ($email == '' && $pass == '') {
        $response = array(
            'error' => "Email and Password are empty!",
        );
    } 
    else if ($email == '') {
        $response = array(
            'error' => "Email is empty!",
        );
    }
    else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $response = array(
            'error' => "Email is not valid!",
        );
            
    } 
    else if ($pass == '') {
        $response = array(
            'error' => "Password is empty!",
        );
    } 
    else if (
        strlen($pass) < 8 || 
        !preg_match('/[A-Z]/', $pass) || 
        !preg_match('/[0-9]/', $pass)
    ) {
        $response = array(
            'error' => "Password must be at least 8 characters long, include at least one uppercase letter and one number.",
        );
    } 
    else {

        $hashed_password = password_hash($pass, PASSWORD_DEFAULT);

        $insert = $clients->signup($email, $hashed_password);

        if ($insert === 1) {
            $response = array(
                'success' => "Data has been inserted successfully!",
            );
        } else if ($insert === 3) {
            $response = array(
                'error' => "Email already exists!",
            );
        } else {
            $response = array(
                'error' => "Database error",
            );
        }
    }

    echo json_encode($response);
    exit;
}
?>