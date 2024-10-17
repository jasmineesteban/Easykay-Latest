<?php
    $adminid = $_SESSION['adminId'];
    if($adminid == ""){
        header("Location: http://localhost/easykay/index.php"); 
        exit();
    }
?>