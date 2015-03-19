<?php
    date_default_timezone_set('America/Los_Angeles');

    function generateRandomString($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    function dateString($date){
        $date = intval($date);
        if(date('H:i', $date) === "00:00"){
            $timeOfDay = " at Anytime";
        }else{
            $timeOfDay = " by ".date('g:i a', $date);
        }
        if($date >= strtotime('now') && $date < strtotime('tomorrow')){
            $modDate = "<span class='today'>Today$timeOfDay</span>";
        }elseif($date < strtotime('now')){
            $modDate = "<span class='past-due'>Past Due ".date('m-d-Y', $date).$timeOfDay."</span>";
        }else{
            $modDate = date('m-d-Y', $date).$timeOfDay;
        }
        return $modDate;
    }

    function updateDate($date){
        if($date <= time()){
            $date = time() + 600; 
        }
        
        return $date;
    }
?>