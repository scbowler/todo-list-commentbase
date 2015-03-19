<?php
session_start();

$conn = mysqli_connect('localhost', 'root', '', 'todolist_db');

$errors = [];

$goto = '../register.php';

if(isset($_POST)){
    $user = htmlentities(addslashes($_POST['username']));
    $pass1 = htmlentities(addslashes($_POST['password']));
    $pass2 = htmlentities(addslashes($_POST['passMatch']));
    $fname = htmlentities(addslashes($_POST['fname']));
    $lname = htmlentities(addslashes($_POST['lname']));
    
    if($user === ''){
        $errors[] = "No username";
    }else{
        $query = "SELECT username FROM users WHERE username='$user'";
        
        $result = mysqli_query($conn, $query);
        if(mysqli_num_rows($result) > 0){
            $errors[] = "User already exists";
        }
    }
    if($pass1 === '' || $pass2 === ''){
        $errors[] = "Password blank";
    }else{
        if($pass1 !== $pass2){
            $errors[] = "Passwords do not match";
        }else{
            $password = sha1($pass1);
        }
    }
    if($fname === '' || $lname === ''){
        $errors[] = "Missing first or last name";
    }else{
        $displayName = "$fname $lname";
    }
    
    if($errors === []){
        $query = "INSERT INTO users (username, password, displayName) VALUES ('$user', '$password', '$displayName')";
        
        mysqli_query($conn, $query);
        
        if(mysqli_affected_rows($conn) === 1){
            $_SESSION['register'] = 'success';
        }else{
            $_SESSION['register'] = 'fail';
            $_SESSION['query'] = $query;
        }
    $goto = '../todoLogin.php'; 
    }else{
        $_SESSION['register'] = $errors;
    }
}else{
    $errors[] = "Error with data";
    $_SESSION['register'] = $errors;
}

header("location: $goto");
?>