<?php

    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        $username = $_POST["Username"];
        $password = $_POST["Password"];
        $email = $_POST["Email"];

        try {
            //code...
            require_once "db_connect.inc.php";

            $query = "INSERT INTO user (Username, Password, Email) VALUES (?,?,?);";

            $stmt = $pdo->prepare($query);

            $stmt->execute([$username,$password,$email]);

            $pdo = null;
            $stmt = null;

            header("Location: ../signUp_wmsu.html");

            die();
        } catch (PDOException $e) {
            //throw $th;
            die("Query failed:". $e ->getMessage());
        }


    } else {

        header("Location: ../signUp_wmsu.html");
    }

?>