<?php
    session_start();
    include "connection.php";

    if(isset($_POST['fb'])){
        include "login/fb_config.php"; 
        header('location: ' . $fb_login_url);
        exit;
    }
    elseif(isset($_POST['google'])){
        include "login/config.php"; 
        header('location: ' . $client->createAuthUrl());
        exit;
    }

    if(isset($_POST['admin'])){

        $username = $_POST['username'];
        $entered_password = $_POST['password'];

        $stmt = $conn->prepare("SELECT admin_password FROM tb_admin_info WHERE admin_username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->bind_result($hash_pass);
        $stmt->fetch();
        $stmt->close();

        if ($hash_pass !== null) {
            if (password_verify($entered_password, $hash_pass)) {
                header('Location: admin-2/ad_home.php');

                $_SESSION['adminId'] = true;
                exit;
            } else {

                $_SESSION['show_modal'] = true;
            }
        } else {
            $_SESSION['show_modal'] = true;
        }
    }

    
    function userAccount($e, $n, $c){
        $email = $e;
        $name = $n;
        $conn = $c;

        $act_date = date("Y/m/d");
        $year = date('Y');

        $queryid = "SELECT user_id FROM tb_user_profile ORDER BY user_id DESC LIMIT 1"; // it select the id that has highest value
        $result = mysqli_query($conn, $queryid);
        //16 characters user-2023-000000
                    
        $initialid = "user-" . $year . "-";
                    
        if ($row = mysqli_fetch_assoc($result)) { // check if there's value     
        $lastID = $row['user_id'];
        $numericPart = (int)substr($lastID, -6);
        $numericPart++;
        $id = $initialid . str_pad($numericPart, 6, '0', STR_PAD_LEFT);
        }
        else {
            $id = $initialid . '000001';
        }

        $query = "INSERT INTO `tb_user_profile` VALUES ('$id', '$name', '$email')";
        $result = mysqli_query($conn, $query);

        $_SESSION['userId'] = $id;

        header('Location: reg_user/home/reg_home.php');
        exit;
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous"></script>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/99c24c4877.js" crossorigin="anonymous"></script>
    <link rel="icon" href="images/logo.png">

    <link rel=”stylesheet” href=”https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css” />
    <link rel=”stylesheet” href=”https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css” integrity=”sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T” crossorigin=”anonymous”>

    <link rel="stylesheet" type="text/css" href="index_style.css">
    <title>Welcome to EasyKay</title>
 
</head>
<body>
    <nav class="navbar navbar-expand-lg bg-light shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="index.php">EasyKay</a>
            
            <button class="navbar-icon fa-solid fa-bars" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <li class="nav-item mx-2">
                        <a class="nav-link" href="guest_user/home/guest_home.php">Home</a>
                    </li>
                    <li class="nav-item mx-2">
                        <a class="nav-link" href="guest_user/event/guest_event.php">Events</a>
                    </li>
                </ul>
            </div>
            <div class= "dropdown dropdown-info mx-2">
                <a class="dropdown-icon fas fa-info-circle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"></a>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li><a type="button" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#faqsModal">FAQs</a></li>
                    <li><a type="button" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#aboutModal">About Us</a></li>
                    <li><a type="button" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#termsModal">Terms and conditions</a></li>
                    <li><a type="button" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#dataModal">Data Privacy</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <?php 
        include "info/faqs.php";
        include "info/about.php";
        include "info/terms.php";
        include "info/data.php";
    ?>

    <div class="container my-5">

        
        <button type="button" class="btn btn-primary m-5" data-bs-toggle="modal" data-bs-target="#loginModal">
            Log in
        </button>

    </div>

    <!-- log in Modal -->
<div class="modal fade" id="loginModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body px-4">
                <div class="text-center my-3">
                    <img src="images/logo.png" alt="EASYKAY LOGO" class="logo shadow-sm mt-4">
                    <h4 class="my-3 mb-5"><b>EasyKay</b></h4>
                </div>
                <form class = "d-flex flex-column" action="" method="POST">
                    <button type="submit" class='btn btn-login' id='btn-fb' name='fb'><span class='fa-brands fa-facebook-f icon'></span>Log in with Facebook</button>
                    <button type="submit" class='btn btn-login' id='btn-email'  name='google'><span class='fa-regular fa-envelope icon'></span>Log in with Gmail</button>
                </form>
                <div class="horizontal-line my-4">
                    <span class="line"></span>
                    <span class="or-text">or</span>
                    <span class="line"></span>
                </div>
                <button class="btn btn-login mb-5" id="btn-guest" onclick="location.href='./guest_user/home/guest_home.php'">Continue as a Guest</button>
                <div class="text-center">
                    <a class="btn admin-btn" data-bs-target="#adminLogin" data-bs-toggle="modal">Log in as Admin</a>
                </div>
                

            </div>
        </div>
    </div>
</div>

<!-- log in Modal -->
<div class="modal fade" id="adminLogin" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body px-4">
                <div class="text-center my-2">
                    <img src="images/logo.png" alt="EASYKAY LOGO" class="logo shadow-sm mt-4">
                    <h4 class="my-3 mb-4"><b>Admin</b></h4>
                </div>
                <form action="" method="POST" class=" needs-validation" novalidate>
                    <div class="col-12 mb-4">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" class="form-control" id="username" name="username" required>
                        <div class="invalid-feedback">
                            Please enter a username.
                        </div>
                    </div>
                    <div class="col-12 my-2">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="myInput" name="password" required>
                        <div class="invalid-feedback">
                            Incorrect password.
                        </div>
                    </div>
                    <div class="my-1 mb-5">
                        <input type="checkbox" onclick="myFunction()">Show Password
                    </div>
                    <div class="col-12 mb-5">
                        <button class="btn btn-primary admin w-100" name="admin" type="submit">Log In</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

    <?php if(isset($_SESSION['show_modal']) && $_SESSION['show_modal']): ?>
        <script src="show.js"></script>
        <?php unset($_SESSION['show_modal']); ?>
    <?php endif; ?>
    <div class="modal fade" id="showmodal" tabindex="-1" aria-labelledby="showmodalLabel" aria-hidden="true">
        <div class="modal-dialog ">
            <div class="modal-content success-message">
                <div class="modal-body d-flex justify-content-between">
                    <span>Incorrect username or password!</span>
                    <button type="button" class="btn-close " data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

            </div>
        </div>
    </div>





<script>
function myFunction() {
  var x = document.getElementById("myInput");
  if (x.type === "password") {
    x.type = "text";
  } else {
    x.type = "password";
  }
}

(() => {
    'use strict'

    // Fetch all the forms we want to apply custom Bootstrap validation styles to
    const forms = document.querySelectorAll('.needs-validation')

    // Loop over them and prevent submission
    Array.from(forms).forEach(form => {
        form.addEventListener('submit', event => {
        if (!form.checkValidity()) {
            event.preventDefault()
            event.stopPropagation()
        }

        form.classList.add('was-validated')
        }, false)
    })
    })()
</script>
    
</body>
</html>