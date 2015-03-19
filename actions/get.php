<?php
    session_start();
    date_default_timezone_set('America/Los_Angeles');
    require_once("../includes/functions.php");
    
    $userID = $_SESSION['userinfo']['id'];

    $conn = mysqli_connect('localhost', 'root', '', 'todolist_db');
    $result = mysqli_query($conn, "SELECT * FROM todo WHERE userID='$userID'");

    while($row = mysqli_fetch_assoc($result)){
        $fileContent[$row['id']] = ['title'=>$row['title'], 'timestamp'=>$row['timestamp'], 'details'=>$row['details']];
    }

    $output = [];
    if(isset($fileContent)) 
    {

        $htmlOutput = [];
        foreach($fileContent as $key => $value)
        {
            //print_r($value['timestamp']); 
            $modDate = dateString($value['timestamp']);
            $title = stripslashes($value['title']);
            $details = stripslashes($value['details']);
            
            
            $htmlOutput[] = "<div data-id=".$key."><div class='title'><span class='header'>Title: </span>".$title."</div><div class='date'><span class='header'>Complete by: </span>".$modDate."</div><div class='details'><span class='header'>Details: </span>".nl2br($details)."</div><button class='editTask'>Edit Task</button><button class='delTask'>Delete Task</button></div>";
        }
        $output['html'] = $htmlOutput;
        $output['success'] = true;
    }
    else
    {
        $output['success'] = false;
        $output['error msg'] = "There are no tasks to load";
    }
    //print_r($output);
    echo json_encode($output);
?>