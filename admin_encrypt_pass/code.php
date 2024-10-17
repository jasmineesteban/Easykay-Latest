<?php
session_start();

include "../connection.php";

    if (isset($_POST['login'])) {
        $email = $_SESSION['email'];
        $plain_password = $_POST['password'];

        $query = "SELECT admin_password FROM tb_admin_info WHERE admin_email ='$email'"; // selects email
        $result = mysqli_query($conn, $query);

        if (mysqli_num_rows($result) > 0) { 
            $row = mysqli_fetch_assoc($result);
            $hash_password = $row["admin_password"] ;
        }
        else{
            echo "You entered an incorrect password.";
        }

        $verify = password_verify($plain_password, $hash_password); 

        if($verify){
            header('location: admin_sucess.php');
            exit;
        }
        else{
            header('location: admin_pass.php');
            exit;
        }  
    }


?>