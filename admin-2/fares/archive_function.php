<?php

if(isset($_POST['archive-toda'])){

    $arcId = $_POST['archiveId'];
    $arcQuery = "SELECT * FROM `tb_tricycle_toda` WHERE `toda_id` = '$arcId'";
    $arcrows = mysqli_query($conn, $arcQuery);
    $row = mysqli_fetch_row($arcrows);

    $rowData = array();

    if ($row) {
        $rowData = $row;
    }

    $fId = $rowData[0];
    $name = $rowData[1];
    $terminal = $rowData[2];
    $latitude = $rowData[3];
    $longitude = $rowData[4];

    $query = "DELETE FROM `tb_tricycle_toda` WHERE `toda_id` = '$fId'";
    $res = mysqli_query($conn, $query);

    if($res) {
        $year = date('Y');

        $queryid = "SELECT `arc_id` FROM `tb_archive_tricycle` ORDER BY `arc_id` DESC LIMIT 1";
        $result = mysqli_query($conn, $queryid);
        $initialid = "arc-" . $year . "-";
                
        if ($row = mysqli_fetch_assoc($result)) {      
            $lastID = $row['arc_id'];
            $numericPart = (int)substr($lastID, -6);         
            $numericPart++;
            $arc_id = $initialid . str_pad($numericPart, 6, '0', STR_PAD_LEFT);
        }
        else {
            $arc_id = $initialid . '000001';
        }

        $arcquery = "INSERT INTO `tb_archive_tricycle`(`arc_id`, `arc_toda_id`, `arc_toda_name`, `arc_toda_terminal`, `arc_toda_lat`, `arc_toda_long`) 
        VALUES ('$arc_id','$fId','$name','$terminal','$latitude','$longitude')";

        $arcres = mysqli_query($conn, $arcquery);

        $arcFareQuery = "SELECT * FROM `tb_toda_fare` WHERE `toda_id` = '$arcId'";
        $arcFarerows = mysqli_query($conn, $arcFareQuery);
        $rowFare = mysqli_fetch_row($arcFarerows);

        $rowDataFare = array();

        while ($rowFare = mysqli_fetch_assoc($arcFarerows)) {
            $rowDataFare[] = $rowFare;
        }

        foreach ($rowDataFare as $row) {
            $fareId = $row['toda_fare_id'];
            $todaId = $row['toda_id'];
            $route = $row['toda_route'];
            $one = $row['toda_one_pass'];
            $two = $row['toda_two_pass'];
        
            $year = date('Y');

            $queryid = "SELECT `arc_id` FROM `tb_archive_tricycle` ORDER BY `arc_id` DESC LIMIT 1";
            $result = mysqli_query($conn, $queryid);
            $initialid = "arc-" . $year . "-";
                    
            if ($row = mysqli_fetch_assoc($result)) {      
                $lastID = $row['arc_id'];
                $numericPart = (int)substr($lastID, -6);         
                $numericPart++;
                $arc_id = $initialid . str_pad($numericPart, 6, '0', STR_PAD_LEFT);
            }
            else {
                $arc_id = $initialid . '000001';
            }
            
            $insertQuery = "INSERT INTO `tb_archive_toda_fare`(`arc_id`, `arc_toda_fare_id`, `arc_toda_id`, `arc_toda_route`, `arc_toda_one`, `arc_toda_pass`)
                            VALUES ('$arc_id', '$fareId', '$todaId', '$route', '$one', '$two')";
        
            // Execute the INSERT query
            mysqli_query($conn, $insertQuery);
        }
        
    }

    

    header("Location: ".$_SERVER['PHP_SELF']);
    exit; // Terminate script execution

}
?>