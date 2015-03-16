<?php
    date_default_timezone_set('America/Los_Angeles');
    $fileContent = file_get_contents("../data/todo.json"); //get the contents of our todo.json file with file_get_contents
    $output = []; //make an output array
    if(strlen($fileContent) > 0)  //if the strlen of our file contents is > 0, there is something to do!
    {
        $fileContent = json_decode($fileContent, true); //json_decode the contents of the todo.json, make sure to convert it to an associative array with true as the second arguement for json_decode
        
        $htmlOutput = [];//make a variable to hold our html output, set it to a blank string
        foreach($fileContent as $key => $value)//loop through the elements of our todo array, fetching the key and record for each one
        {
             $modDate = dateString($value['date']);
            
            
            $htmlOutput[] = "<div data-id=$key><div class='title'><span class='header'>Title: </span>".$value['title']."</div><div class='date'><span class='header'>Complete by: </span>".$modDate."</div><div class='details'><span class='header'>Details: </span>".nl2br($value['details'])."</div><button class='delTask'>Delete Task</button></div>";//make an html element set to contain our todo record, much like our student record from Student Grade Table;  It should include a data-id attribute with the key (for later deleting / editing), the title, the date converted to a human-readable format, and the todo details.  Make sure to use the nl2br() function on the details so it looks right in html
            //add the html element set to our html output variable
        }
        $output['html'] = $htmlOutput;
        $output['success'] = true;//add a success=true and html elements to our output array.  html element should hold the generated HTML from above
    }
    else  //if the strlen was 0, there were no todo items
    {
        $output['success'] = false;//add a success=false condition and appropriate error message indicating there were no records
        $output['error msg'] = "There are no tasks to load";
    }
    echo json_encode($output);//json encode the output array and echo it

    function dateString($date){
        if(date('H:i', $date) === "00:00"){
            $timeOfDay = " at Anytime";
        }else{
            $timeOfDay = " by ".date('g:i a', $date);
        }
        if($date >= strtotime('today') && $date < strtotime('tomorrow')){
            $modDate = "<span class='today'>Today$timeOfDay</span>";
        }else{
            $modDate = date('m-d-Y', $date).$timeOfDay;
        }
        return $modDate;
    }
?>