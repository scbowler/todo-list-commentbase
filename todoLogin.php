<?php
session_start();
include_once("includes/functions.php");
?>
<!doctype html>

<html>
<head>
    <meta charset="UTF-8">
    <title>Todo List Login</title>

    <link rel="stylesheet" href="assets/style.css">
    <script src="assets/main.js"></script>
</head>
<body>
    <section id="login-form">
        <form action="actions/login.php" method="post">
            <input type="text" name="username" placeholder="Enter Username">
            <input type="password" name="password" placeholder="Enter Password">
            <button id="login-btn">Login</button>
        </form>
        <?php 
            if(isset($_SESSION['login'])){
                if($_SESSION['login'] === 'failed'){
                    echo "<h3>Invalid username or password. $_SESSION[query]</h3>";
                    session_unset();
                }elseif($_SESSION['login'] === 'logout'){
                    session_unset();
                    session_destroy();
                    echo "<h3>Logged out successfuly.</h3>";
                }
            }elseif(isset($_SESSION['register'])){
                if($_SESSION['register'] === 'success'){
                    echo "<h3>User created successfuly. Please Login.</h3>";
                    session_unset();
                }elseif($_SESSION['register'] === 'fail'){
                    echo "<h3>User not created.</h3>";
                    echo "<h3>$_SESSION[query]</h3>";
                    session_unset();
                }
            }
        ?>
        <h3><a href="register.php">Register</a></h3>
    </section>

</body>
</html>