<?php
include('../Classes/Client.php');
$clients = new Users();

if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $pass = $_POST['pass'];

    $response = [];

    if ($email === '' && $pass === '') {
        $response = [
            'error' => 'Email and Password are empty!'
        ];
    } 
    else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $response = array(
            'error' => 'Email is not valid!'
        );
    } 
    else if ($email === '') {
        $response = array(
            'error' => 'Email is empty!'
    );
    } 
    else if ($pass === '') {
        $response = array(
            'error' => 'Password is empty!'
        );
    } 
    else if (
        strlen($pass) < 8 ||
        !preg_match('/[A-Z]/', $pass) ||
        !preg_match('/[0-9]/', $pass)
    ) {
        $response = [
            'error' => 'Password must be at least 8 characters long and include at least one uppercase letter and one number.'
        ];
    } 
    else {
       
        $login = $clients->login($email, $pass);

        if ($login === 9) {
            $response = array(
                'error' => 'Database error!'
            );
        } 
        else if ($login === 8) {
            $response = array(
                'error' => 'User not found!'
            );
        } 
        else {
            // Success → return redirect path
            $response = array(
                'id' => $_SESSION['id'],
                'email' => $_SESSION['email'],
                'redirect' => $login    
            );
        }
    }

    echo json_encode($response);
    exit;
}

