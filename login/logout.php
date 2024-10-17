<?php
    session_start();
    include "../connection.php";

    mysqli_close($conn);
    session_unset();

    session_destroy();

    header("location: ../index.php");
    exit;
    

    
?>