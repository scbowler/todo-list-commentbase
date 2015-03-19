<?php
session_start();
date_default_timezone_set('America/Los_Angeles');
include_once("../includes/functions.php");
$errorMsgs = [];
$output = [];
if(isset($_POST))
{
    if(!isset($_POST['update'])){
        $_POST['update'] = false;
    }
    
    if($_POST['title'] === "") 
    {
        $errorMsgs['title'] = "Blank Title";
    }
    if($_POST['date'] === "") 
    {
        $errorMsgs['date'] = "Blank Date";
    }
    else 
    {
        
        if(!strtotime($_POST['date'])){ 
            $errorMsgs['date'] = "Invalid Date: ".$_POST['date'];
        }
        else if(strtotime($_POST['date']) < time())
        {
            $errorMsgs['date'] = "Date is before now";
        }
    }
    if($_POST['details'] === "")
    {
            $errorMsgs['details'] = "Details blank";
    }
    if($errorMsgs === []){
        
        $data = ['title'=>htmlentities(addslashes($_POST['title'])), 'date'=>strtotime($_POST['date']), 'details'=>htmlentities(addslashes($_POST['details']))];
        $entryID = generateRandomString().$data['date'];
            
        $conn = mysqli_connect('localhost', 'root', '', 'todolist_db');
        
        $userID = $_SESSION['userinfo']['id'];
        
        if($_POST['update']){
            $query = "UPDATE todo SET title='$data[title]', timestamp='$data[date]', details='$data[details]' WHERE id='$_POST[id]'";
            
        }else{
            $query = "INSERT INTO todo (id, userID, title, timestamp, details) VALUES ('$entryID', '$userID', '$data[title]', '$data[date]', '$data[details]')";
        }
        
        $result = mysqli_query($conn, $query);

        if(mysqli_affected_rows($conn) == 1) 
        {
            $output['success'] = true;
            $output['success msg'] = "File updated successfuly";
        }
        else 
        {
            $output['success'] = false; 
            $output['fail msg'] .= "The file failed to update: ID = ".$_POST['id']." update ".$_POST['update'];
        }
    }
    else
    {
        $output['success'] = false; 
        $output['fail msg'] = "There was an error with your input";
        $output['errors'] = $errorMsgs;
    }
}
else
{
    $output['success'] = false;
    $output['fail msg'] = "No input was recieved";
}
echo json_encode($output);
?>