<?php
// Database connection
$host = "localhost";
$port = "3306";
$dbname = "wmsu_sssp_db_simple";
$username = "root"; // Replace with your MySQL username
$password = ""; // Replace with your MySQL password

try {
    $pdo = new PDO("mysql:host=$host;port:$port,dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


} catch (PDOException $e) {

    die("Connection failed: " . $e->getMessage());
    
}



// Add your PHP code for interacting with the database here
?>


