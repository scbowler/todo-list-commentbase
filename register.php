<?php
session_start();
?>

<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Todo List Register</title>

    <link rel="stylesheet" href="assets/style.css">
    <script src="assets/main.js"></script>
</head>
<body>
    <section id="register-form">
        <form action="actions/createUser.php" method="post">
            Choose user name:
            <input type="text" name="username" placeholder="Enter Username">
            Create password:
            <input type="password" name="password" placeholder="Enter Password">
            Confirm password:
            <input type="password" name="passMatch" placeholder="Confirm Password">
            First Name:
            <input type="text" name="fname" placeholder="First Name">
            Last Name:
            <input type="text" name="lname" placeholder="Last Name">
            <button id="register-btn">Register</button>
        </form>
    </section>
    <section id='register-error'>
        <?php
            if(isset($_SESSION['register'])){
                $register = $_SESSION['register'];
                echo "<h2>The following errors occured</h2>";
                foreach($register as $error){
                    echo "<h3>-$error</h3>";
                }
            }
        ?>
    </section>
</body>
</html>