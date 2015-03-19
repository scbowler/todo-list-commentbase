    <header id="main_header">
        <img src="images/todo_logo.gif" class="logo logo_large">
        <h1>Welcome: <?php echo $_SESSION['userinfo']['displayName'] ?></h1>
        <nav id="main-nav">
            <ul>
                <li><a>Register</a></li>
                <li><a href='actions/logout.php'>Logout</a></li>
                <li><a>About-us</a></li>
                <li><a>Account</a></li>
            </ul>
        </nav>
    </header>