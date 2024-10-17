<?php
session_start();
    include "../connection.php";

    if(isset($_POST['submit'])){
        $_SESSION['email'] = $_POST['email'];

       echo '<script>';
        echo 'document.addEventListener("DOMContentLoaded", function() {';
        echo 'var myModal = new bootstrap.Modal(document.getElementById("insertpassword"));';
        echo 'myModal.show();';
        echo '});';
        echo '</script>';

    }
    /* if($plain_password == $hash_password){
                echo "You entered correct password.";
            }
            else{
                echo "You entered wrong password.";
            } */
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    
    <script src="https://kit.fontawesome.com/99c24c4877.js" crossorigin="anonymous"></script>

    <link rel="icon" href="logo.png">
    <link rel="stylesheet" type="text/css" href="log.css">
    <title>Admin login</title>
</head>
<body>
    <form action="" method="post">
        <input type="email" name="email" value="">
        <button type="submit" name="submit">Submit</button>
    </form>

    <div class="modal fade" id="insertpassword" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="insertpasswordLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="insertpasswordLabel">Admin Password</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="code.php" method="POST">
                    <div class="modal-body">
                        <div class="form-group">
                            <input type="password" class="form-control" name="password" value="" placeholder="Enter password">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary" name="login">Login</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>