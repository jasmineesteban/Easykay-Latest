<?php
    
    function activityLog($message, $act_id, $conn){

        $act_date = date("Y/m/d");
        $year = date('Y');

        $queryid = "SELECT log_id FROM tb_activity_log ORDER BY log_id DESC LIMIT 1"; // it select the id that has highest value
        $result = mysqli_query($conn, $queryid);
        //10 characters log-2023-000000
                    
        $initialid = "log-" . $year . "-";
                    
        if ($row = mysqli_fetch_assoc($result)) { // check if there's value
        // Extract the numeric part of the last ID       
        $lastID = $row['log_id'];
        $numericPart = (int)substr($lastID, -6);
                    
        // Increment the numeric part
        $numericPart++;
                    
        // Generate the new ID
        $log_id = $initialid . str_pad($numericPart, 6, '0', STR_PAD_LEFT);
        }
        else {
            // If no records, start with the initial ID
            $log_id = $initialid . '000001';
        }

        $query = "INSERT INTO tb_activity_log VALUES('$log_id', '$act_id', '$act_date', '$message')";
        $result = mysqli_query($conn, $query);

    }



?>