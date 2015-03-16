<?php
    $errorMsgs = [];
    $output = [];
    $fileFound = false;
    
    if(isset($_POST)){
        if($_POST['toDelete'] === ""){
            $errorMsgs[] = "No entry selected for deletion";
        }else{
            $fileContents = file_get_contents("../data/todo.json");
            if(strlen($fileContents) === 0){
                $errorMsgs[] = "Nothing to delete";
            }else{
                $fileContents = json_decode($fileContents, true);
                foreach($fileContents as $key=>$value){
                    if($key === $_POST['toDelete']){
                        unset($fileContents[$key]);
                        $fileFound = true;
                    }
                }
                if(!$fileFound){
                    $errorMsgs[] = "Entry not found";
                }
                $fileContents = json_encode($fileContents);
                
                $putOK = file_put_contents("../data/todo.json", $fileContents);
                if($putOK < 1){
                    $errorMsgs[] = "Error returning data to file";
                }
            }
        }
        if($errorMsgs === []){
            $output['success'] = true;
            $output['error msg'] = "Task <span class='bold'>".$_POST['title']."</span> deleted successfuly";
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