<?php
   $username = $_POST['username'];
   $password = $_POST['password'];
   $email = $_POST['email'];

   


   if(!empty($username) || !empty($password) || !empty($email)){
        $host = "localhost";
        $dbusername = "root";
        $dbpassword = "";
        $dbname = "wmsu_sssp_db_simple";

        $conn = new mysqli($host,$dbusername,$dbpassword,$dbname);
        
        if(mysqli_connect_error()){
            die('Connect Error('.mysqli_connect_errno().')'.mysqli_connect_error());
        } 
        
        else 

        {
            $SELECT = "SELECT email FROM user WHERE email = ? LIMIT 1";
            $INSERT = "INSERT INTO user (Username, Password, Email) VALUES (?,?,?)";

            //PREPARE STATEMENT
            $stmt = $conn -> prepare($SELECT);
            $stmt -> bind_param("s" , $email);
            $stmt -> execute();
            $stmt -> bind_result($email);
            $stmt -> store_result();
            $rnum = $stmt -> num_rows;
            
            if($rnum == 0){
                $stmt -> close();

                $stmt = $conn -> prepare($INSERT);
                $stmt -> bind_param("sss",$username, $password, $email);
                $stmt -> execute();
                echo "New record inserted successfully";
            } 
            
            else 

            {
                echo "Someone is registered using this email.";
            }

                $stmt -> close();
                $conn -> close();


        }
   } 
   
   else {
    echo "All fields are required";
    die();
   }
