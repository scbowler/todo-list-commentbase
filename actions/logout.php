<?php
session_start();

$_SESSION['login'] = 'logout';

header('location: ../todoLogin.php');
?>