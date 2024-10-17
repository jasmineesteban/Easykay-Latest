<?php
    if (isset($_POST['add-event'])) {

    list($name, $description, $location, $date, $instruction, $lat, $lng, $newImageName, $tmpName) = details();

    if ($name && $description && $location && $date && $lat && $lng && $newImageName){

        move_uploaded_file($tmpName, '../../images/event_img/' . $newImageName);


        $queryid = "SELECT evt_id FROM tb_event_details ORDER BY evt_id DESC LIMIT 1"; // it select the expId that has highest value
        $result = mysqli_query($conn, $queryid);
                    
        $year = DATE('Y');

        $initialid = "evt-" . $year . "-";

        if ($row = mysqli_fetch_assoc($result)) { 

            $lastID = $row['evt_id'];
            $numericPart = (int)substr($lastID, -6);

            $numericPart++;

            $evtId = "evt-" . $year . "-" . str_pad($numericPart, 6, '0', STR_PAD_LEFT);
        }
        else {
            $evtId = $initialid . '000001';
        }

        $query = "INSERT INTO `tb_event_details`(`evt_id`, `evt_name`, `evt_description`, `evt_location`, `evt_date`, `evt_image`, `evt_instruction`, `evt_latitude`, `evt_longitude`) 
        VALUES ('$evtId','$name','$description','$location','$date','$newImageName','$instruction','$lat','$lng')";            
        
        $res = mysqli_query($conn, $query);

        if($res){
            $activityMessage = "You have added an event named \"" . $name . "\"";
            activityLog($activityMessage, $evtId, $conn);
            $_SESSION['add_success'] = true;
        }
    }
    header("Location: ".$_SERVER['PHP_SELF']);
    exit; // Terminate script execution
}
function details(){
    $name = htmlspecialchars($_POST["evt_name"]);
    $description = htmlspecialchars($_POST['evt_description']);
    $location = htmlspecialchars($_POST['evt_location']);
    $date = $_POST['evt_date'];
    $instruction = htmlspecialchars($_POST['evt_instruction']);
    $lat = $_POST['latitude'];
    $lng = $_POST['longitude'];
            
    if($_FILES["image"]["error"] !== 4){ // checks if there was no error during upload // means image was successfully uploaded
        $filename = $_FILES["image"]["name"];
        $filesize = $_FILES["image"]["size"];
        $tmpName = $_FILES["image"]["tmp_name"];
    
        $validImageExtension = ['jpg', 'jpeg', 'png'];
        $imageExtension = explode('.', $filename);  
        $imageExtension = strtolower(end($imageExtension)); // retrieves "jpg", "jpeg", or "png" - value
    
        if(!in_array($imageExtension, $validImageExtension)){
            echo '<div class="alert alert-danger" role="alert">Invalid Image Extension</div>'; 
        }
        elseif($filesize > 5000000){ // 5mb
            echo '<div class="alert alert-danger" role="alert">Image size is too large</div>'; 
        }
        else{
            $newImageName = uniqid() . "." . $imageExtension;
        }
    }
    
    return array($name, $description, $location, $date, $instruction, $lat, $lng, $newImageName, $tmpName);
        
}

?>