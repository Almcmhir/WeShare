<?php
session_start();

// Include the database connection file
require_once 'db_connection.php';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if the username and password are provided
    if (isset($_POST['username']) && isset($_POST['password'])) {
        // Retrieve username and password from the form
        $username = $_POST['username'];
        $password = $_POST['password'];

        // Hardcoded admin credentials
        $admin_username = "alfadz";
        $admin_password = "vvkavs";

        // Check if the provided credentials match the admin credentials
        if ($username === $admin_username && $password === $admin_password) {
            // Admin login successful
            $_SESSION['admin_logged_in'] = true;
            header('Location: admin_dashboard.php'); // Redirect to the admin dashboard
            exit;
        } else {
            // Incorrect username or password
            $error = "Incorrect username or password.";
        }
    } else {
        // Username or password not provided
        $error = "Username and password are required.";
    }
}

// Redirect to the login page with error message
header('Location: login.php?error=' . urlencode($error));
exit;
?>
