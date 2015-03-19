<?php
session_start();

$conn = mysqli_connect('localhost', 'root', '', 'todolist_db');

$user = htmlentities(addslashes($_POST['username']));
$pass = sha1($_POST['password']);

$query = "SELECT * FROM users WHERE username='$user' AND password='$pass'";

$result = mysqli_query($conn, $query);

if(mysqli_num_rows($result) === 1){
    $_SESSION['userinfo'] = mysqli_fetch_assoc($result);
    $_SESSION['userinfo']['password'] = '*****';
    $_SESSION['login'] = 'success';
    
    header('location: ../index.php');
    exit();
}else{
    $_SESSION['login'] = 'failed';
    $_SESSION['query'] = $query;
    header('location: ../todoLogin.php');
}

?>