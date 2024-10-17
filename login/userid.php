<?php
    $_SESSION['setId'] = $_SESSION['userId'];

    if($_SESSION['setId'] == ""){
        header("Location: http://localhost/easykay/index.php"); 
        exit();
    }
?>

