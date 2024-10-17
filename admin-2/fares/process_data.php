<?php
    session_start();

    if (isset($_SESSION['selectedTodaId'])) {

    $selectedTodaId = $_SESSION['selectedTodaId'];

    $_SESSION['selectedTodaId'] = $selectedTodaId;

    if(isset($_POST['id'])) {

        $id = $_POST['id'];

        $phpVariable = $id;

        $res = mysqli_query($conn, "Select * FROM tb_toda_fare");


    }
    else {
        echo "No id receive.";
    }
    }

   
?>