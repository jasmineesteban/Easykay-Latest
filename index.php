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
    


    <link rel="stylesheet" type="text/css" href="style_2.css">
    <title>Welcome to EasyKay</title>
    
</head>
<body>
    <nav class="navbar navbar-expand-sm">
    <script src="crossfade.js"></script>
        <div class="container">
            <span>
                <img src="images/logo.png" alt="EASYKAY" width="30">
                <a class="navbar-brand" href="#">EasyKay</a>
            </span>
            
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
    <section class="landing d-flex align-items-center" id = "bkgcityhall">
        <div class = "container d-flex justify-content-center">
            <div class="content d-flex flex-column align-items-center">
                <div class="quotes text-center">
                    <p class="sentence-1">Navigating Santa Maria with Comfort and Ease</p>
                </div>
                <form class="search input-group mb-3" action="guest_user/home/guest_home.php" method="GET" onsubmit="updateHiddenInput()">
                    <input type="text" class="form-control" id="search-destination" placeholder="Your destination" aria-label="Recipient's username" aria-describedby="basic-addon2">
                    <input type="hidden" class="form-control" id="destination" name="destination" value="" aria-label="Recipient's username" aria-describedby="basic-addon2">
                    <button type="submit" class="input-group-text" id="search"><i class="fa-solid fa-magnifying-glass"></i></button>
                </form>
                <div class="btn">
                    
                    <button type="button" class="btn btn-primary btn-log" data-bs-toggle="modal" data-bs-target="#loginModal">
            Log in here
        </button>

                </div>
                <div class="quotes text-center">
                    <p class="sentence-2">Learn how to commute in Santa Maria, Bulacan by using EasyKay!</p>
                </div>
                <br>
            </div>
        </div>
    </section>
    <script>
    function updateHiddenInput() {

        var searchDestinationValue = document.getElementById('search-destination').value;
        document.getElementById('destination').value = searchDestinationValue;
    }
</script>
    
    
<!-- 2nd Page Container -->
    <section class="container-fluid d-flex align-items-center p-3">
    <link rel="stylesheet" type="text/css" href="css/container.css">
    <div class="container-fluid">
        <div class="row">
            <div class="col text-center">
            <h2>Santa Maria Tourists Events</h2>
            <p class="text-center">Experience Adventure and Culture:<br>Explore upcoming tourist events - Where every moment becomes a journey!</br></p>
        </div>
    </div>
    </section>

<!-- Widget -->
    <section>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"/>
        <link rel="stylesheet" type="text/css" href="css/widget.css">
            <div class="widget p-5">
                <div class="widget-item">
                    <i class="fas fa-plate-wheat"></i>
                    <h3>Local Cuisine Discovery</h3>
                    <p>Delight in diverse local flavors, from street eats to fine dining.</p>
                </div>
                <div class="widget-item">
                    <i class="fas fa-building-columns"></i>
                    <h3>Heritage Exploration</h3>
                    <p>Dive into history at iconic landmarks and ancient sites.</p>
                </div>
                <div class="widget-item">
                    <i class="fas fa-masks-theater"></i>
                    <h3>Artistic Immersion</h3>
                    <p>Engage with local art, from crafts to galleries.</p>
                </div>
                <div class="widget-item">
                    <i class="fas fa-leaf"></i>
                    <h3>Nature Discovery</h3>
                    <p>Explore natural wonders and wildlife in untouched landscapes.</p>
                </div>
            </div>
    </section>

<!-- Carousel-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css">
     <div class="owl-carousel owl-theme">
    <div class="owl">
        <div class="image-container">
            <img src="landimage/Events/Exhibit.jpg" class="img-fluid" alt="">
        </div>
    </div>
    <div class="owl">
        <div class="image-container">
        <a href= "https://www.facebook.com/santamariatourism/posts/369890982457849" target="blank">
            <img src="landimage/Events/Float Parade.jpg" class="img-fluid" alt="">
        </a>
        </div>
    </div>
    <div class="owl">
        <div class="image-container">
        <a href= "https://www.facebook.com/santamariabulacan.lgu/posts/pfbid027RVbevcDqMpjgiMDrdpBvS2ZgSVYpZKxRuALhBfgWyUuG7Sh36XHrpgn6a8Xv6Wwl" target="blank">
            <img src="landimage/Events/rizal.jpg" class="img-fluid" alt="">
        </a>
        </div>
    </div>

    <div class="owl">
        <div class="image-container">
        <a href= "https://www.facebook.com/santamariatourism/posts/371536205626660" target="blank">
            <img src="landimage/Events/Street dance.jpg" class="img-fluid" alt="">
        </a>
        </div>
    </div>
    <div class="owl">
        <div class="image-container">
        <a href= "https://www.facebook.com/santamariabulacan.lgu/posts/pfbid0fRdVGgywqKTe5VJ4mKdN6uGx9vyRAY7VQjsPCtSGRw34KYXVJ7Rhcvwf6VjB5bzBl" target="blank">
            <img src="landimage/Events/church.jpg" class="img-fluid" alt="">
        </a>
        </div>
    </div>
    <div class="owl">
        <div class="image-container">
        <a href= "https://www.facebook.com/santamariabulacan.lgu/posts/pfbid0b3wCT8Nb59Gyjgrhfa8qAmsF7VHf8uifH5d6TBaPXusJnHmLK8nybs1juoji6bwgl" target="blank">
            <img src="landimage/Events/dance.jpg" class="img-fluid" alt="">
        </a>
        </div>
    </div>
    <div class="owl">
        <div class="image-container">
        <a href= "https://www.facebook.com/santamariabulacan.lgu/posts/pfbid02B7DdEnGGVPh8J6wWqtGVE4cGSyWnhHdTnPzgsYzf1GAYe2PLPJCpA3sKXNG5jQsZl" target="blank">
            <img src="landimage/Events/parada.jpg" class="img-fluid" alt="">
        </a>
        </div>
    </div>
</div>

        <style>
            .owl-carousel .owl-item{
                border: none;
                color: transparent;
                background: none !important;
            }

            .owl-carousel .owl-item-active {
                color: transparent;
            }

            .owl-dots {
                display: none;
            }

            .owl-carousel .owl-item .image-container {
                width: 500px; /* Set the width */
                height: 300px; /* Set the height */
                overflow: hidden; /* Ensure the image doesn't overflow the container */
                border: none;
                color: transparent;
                background: none !important;
            }

            .owl-carousel .owl-item .image-container img {
                width: 100%; /* Fill the container horizontally */
                height: 100%; /* Fill the container vertically */
                object-fit: cover; /* Ensure the image covers the container without distortion */
            }

            @media only screen and (max-width: 768px) {
  .owl-carousel .owl-item .image-container {
    width: 100%; /* Set the width to fill its container */
    height: auto; /* Set the height to auto for responsiveness */
  }
}

        </style>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
        <script src="carousel.js"></script>

        
    <div id="loginmodal" class="modal-style1">
<!-- Login  Modal here -->
        <div class="add-modal-content" style="text-align: center;">
                <div class="text-center">
                    <img src="images/LOGO-FINAL.png" alt="EASYKAY LOGO" class="logo shadow-sm">
                </div>
                <p class="brand text-center mt-2 mb-4">EasyKay</p>
            <div style = "width: 90%; text-align: center; left: 10%;">
                <form class = "d-flex flex-column" action="" method="POST">
                    <button type="submit" class='btn' id='btn-fb' name='fb'><span class='fa-brands fa-facebook-f icon'></span>Log in with Facebook</button>
                    <button type="submit" class='btn' id='btn-email'  name='google'><span class='fa-regular fa-envelope icon'></span>Log in with Gmail</button>
                </form>
                <div class="horizontal-line">
                    <span class="line"></span>
                    <span class="or-text">or</span>
                    <span class="line"></span>
                </div>
                <button class="btn" id="btn-guest" onclick="location.href='./guest_user/home/guest_home.php'">Continue as a Guest</button>
            </div>
        </div>
        
    </div>

    <div id = "faq-container-modal" class = "modal-style1"><div id="faq-proper"></div></div>
    <div id = "about-container-modal" class = "modal-style1"></div>
    <div id = "terms-container-modal" class = "modal-style1"></div>
    <div id = "privacy-container-modal" class = "modal-style1"></div>
    <div id = "contact-container-modal" class = "modal-style1"></div>

    <script src="info.js"></script>
    <link rel="stylesheet" type="text/css" href="css/contact.css">
    <script>
        var faqmodal = document.getElementById("faq-container-modal");
        function openLogin(){
            document.getElementById("loginmodal").style.display = 'block';
        }

        function closeLogin(){
            document.getElementById("loginmodal").style.display = 'none';
        }
        window.onclick = function(event) {
            var loginmodal1 = document.getElementById("loginmodal");
            
            if (event.target === loginmodal1) {
                loginmodal1.style.display = "none";
            }
        }     
    </script>

<!-- Footer -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css">
    <link rel="stylesheet" type="text/css" href="css/footer.css">
        <footer class="foot">
            <div class="footer__redes">
                <ul class="footer__redes-wrapper">
                    <li>
                        <a href="https://www.facebook.com/easykay.smb" class="footer__link" target="blank">
                            <i class="fab fa-facebook-f"></i>
                                facebook
                        </a>
                    </li>
                    <li>
                        <a href="mailto:easykaysmb@gmail.com" class="footer__link" target="blank">
                            <i class="fab fa-google"></i>
                                gmail
                        </a>
                    </li>
                </ul>
            </div>
                <div class="separador"></div>
                    <p class="footer__texto">EasyKay &copy 2024</p>
        </footer>


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
    document.addEventListener('DOMContentLoaded', function() {
    // Check if the URL contains the 'code' parameter
    if (window.location.search.includes('code')) {
        // Extract the 'code' parameter from the URL
        const urlParams = new URLSearchParams(window.location.search);
        const code = urlParams.get('code');
         window.location.href = 'reg_user/home/reg_home.php';
    }
}); </script>
</body>

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

</html>