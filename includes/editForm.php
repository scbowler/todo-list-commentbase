<?php
date_default_timezone_set('America/Los_Angeles');
require_once("functions.php");

$output = [];
$html = "";
$errors = [];

if(isset($_POST)){
    $conn = mysqli_connect("localhost", "root", "", "todolist_db");
    $result = mysqli_query($conn, "SELECT * FROM todo WHERE id='".$_POST['id']."'");
    if(mysqli_num_rows($result) > 0){
        while($rows = mysqli_fetch_assoc($result)){
            $modDate = updateDate($rows['timestamp']);
            $html = "<form><input type='text' name='titleUD' value='".$rows['title']."'><input type='tex' name='dateUD' value='".date('m/d/Y g:i a', $modDate)."'><textarea name='detailsUD'>".$rows['details']."</textarea><div class='btn-container'><button type='button' class='task-btn' id='update'>Update</button><button type='button' class='task-btn' id='cancelUD'>Cancel</button></div></form>";
            
            $output['id'] = $rows['id'];
            $output['title'] = $rows['title'];
            $output['date'] = $rows['timestamp'];
            $output['datails'] = $rows['details'];
        }
    }else{
        $errors[] = "Unable to find task";
    }
}else{
    $errors[] = "Data transfer error";
}

if($errors == []){
    $output['success'] = true;
    $output['html'] = $html;
}else{
    $output['success'] = false;
    $output['errors'] = $errors;
}

echo json_encode($output);
       
?>






