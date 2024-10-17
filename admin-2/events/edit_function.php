<?php



if (isset($_POST['edit-event'])) {
    if($_SESSION['editId'] != ""){
        $eId = $_SESSION['editId'];
    list($name, $description, $location, $date, $instruction, $lat, $lng, $newImageName, $tmpName) = updatedDetails();

    if ($newImageName === ""){
        $query = "UPDATE `tb_event_details` SET `evt_name`='$name',
        `evt_description`='$description',`evt_location`='$location',`evt_date`='$date',
        `evt_instruction`='$instruction',`evt_latitude`='$lat',
        `evt_longitude`='$lng' WHERE evt_id = '$eId'";
            
        $res = mysqli_query($conn, $query);

        if($res){

            $activityMessage = "You edited an event named \"" . $name . "\"";
            $_SESSION['edit_success'] = true;
            activityLog($activityMessage, $eId, $conn);

        }       
    } else{
       
        move_uploaded_file($tmpName, '../../images/event_img/' . $newImageName);

        $result = mysqli_query($conn, "SELECT evt_image FROM tb_event_details WHERE evt_id = '$eId'");

        if ($result && $row = mysqli_fetch_assoc($result)){
            $imageFilename = $row["evt_image"];
            $imageFilePath = "../../images/event_img/" . $imageFilename;
    
            if (file_exists($imageFilePath)){
                unlink($imageFilePath); // Delete the image file
            }
        }

        $query = "UPDATE `tb_event_details` SET `evt_name`='$name',
        `evt_description`='$description',`evt_location`='$location',`evt_date`='$date', 
        `evt_image`='$newImageName', `evt_instruction`='$instruction',`evt_latitude`='$lat',
        `evt_longitude`='$lng' WHERE evt_id = '$eId'";
            
        $res = mysqli_query($conn, $query);

        if($res){

            $activityMessage = "You edited an event named \"" . $name . "\"";
            $_SESSION['edit_success'] = true;
            activityLog($activityMessage, $eId, $conn);

        }     
    }
    header("Location: ".$_SERVER['PHP_SELF']);
    exit; // Terminate script execution
}}

function updatedDetails(){
    $name = htmlspecialchars($_POST["evt_name"]);
    $description = htmlspecialchars($_POST['evt_description']);
    $location = htmlspecialchars($_POST['evt_location']);
    $date = $_POST['evt_date'];
    $instruction = htmlspecialchars($_POST['evt_instruction']);
    $lat = $_POST['latitude'];
    $lng = $_POST['longitude'];
    $newImageName = "";
    $tmpName = "";
            
    if($_FILES["image"]["error"] === 4){ // checks if there's no image
        return array($name, $description, $location, $date, $instruction, $lat, $lng, $newImageName, $tmpName);
    } else{
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

            return array($name, $description, $location, $date, $instruction, $lat, $lng, $newImageName, $tmpName);
        }
    }
}

?>