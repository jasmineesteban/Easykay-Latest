<?php

    include "../connection.php";

    if(isset($_POST['submit'])){
        $email = $_POST['email'];
        $plain_password = $_POST['pass'];

        $hash_pass = password_hash( $plain_password, PASSWORD_DEFAULT);

        $queryid = "SELECT admin_id FROM tb_admin_info ORDER BY admin_id DESC LIMIT 1"; // it select the id that has highest value
        $result = mysqli_query($conn, $queryid);
        //10 characters admin_0001

        $initialid = "admin-";

        if ($row = mysqli_fetch_assoc($result)) { // check if there's value
                    // Extract the numeric part of the last ID

            $lastID = $row['admin_id'];
            $numericPart = (int)substr($lastID, -4);

                    // Increment the numeric part
            $numericPart++;

                    // Generate the new ID
            $admin_id = $initialid . str_pad($numericPart, 4, '0', STR_PAD_LEFT);
        }
        else {
                    // If no records, start with the initial ID
            $admin_id = $initialid . '0001';
        }

        $query = "INSERT INTO `tb_admin_info`(`admin_id`, `admin_name`, `admin_username`, `admin_password`) VALUES ('$admin_id','Admin','$email','$hash_pass')";
        $result = mysqli_query($conn, $query);

        if($result){
            echo "Successfully added!";
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin password</title>
</head>
<body>
    <form action="" method="post">
        <input type="email" name="email" value="">
        <input type="password" name="pass" value="">
        <button type="submit" name="submit">Submit</button>
    </form>
</body>
</html>