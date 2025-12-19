<?php
// Start the session to access and destroy session variables
session_start();

// Unset all session variables
$_SESSION = array();

// If you want to kill the session, also delete the session cookie.
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Finally, destroy the session itself.
session_destroy();

// Redirect the user to the login page (or the main index page)
// Assuming your login page is at the root or 'index.php' in the customer folder
header("Location: ../../Pages/home.php"); 
exit;
?>