<?php
    $errorMsgs = [];
    $output = [];
    $fileFound = false;
    
    if(isset($_POST)){
        if($_POST['toDelete'] === ""){
            $errorMsgs[] = "No entry selected for deletion";
        }else{
            
            $conn = mysqli_connect('localhost', 'root', '', 'lf_db');
            
            $result = mysqli_query($conn, "DELETE FROM todo WHERE id='".$_POST['toDelete']."'");
        }
        if($errorMsgs === []){
            $output['success'] = true;
            $output['success msg'] = "Task $_POST[title] deleted successfuly";
            $output['result'] = $result;
        }else{
            $output['success'] = false;
            $output['error msg'] = "There was errors removing your task";
            $output['errors'] = $errorMsgs;
        }
    }else{
        $output['success'] = false;
        $output['error msg'] = "No data recieved";
    }
    
    echo json_encode($output);
?>