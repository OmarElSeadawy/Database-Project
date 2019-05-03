<?php
    session_start();
    require 'dbconfig/dbconn.php';
    ?>


<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Homepage</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" media="screen" href="css/home.css">
    <script src="js/index.js"></script>
</head>

        <body>
            <header>
                <div class="nav-bar">
                    <img src="css/avatar.png" class = "logo">
                    <ul class="menu">
                            <li onclick="window.location.href='home.php'"> <a>Home</a></li>
                            <?php if($_SESSION['usertype'] == 0): ?>
                                <!-- Administration Homepage -->
                                <li onclick="window.location.href='adminpanel.php'"> <a>Admin Page</a></li>
                            <?php elseif ($_SESSION['usertype'] == 1): ?>
                                <!-- Ordering Staff Homepage -->
                                <li onclick="window.location.href='orders.php'"> <a>Orders</a></li>
                            <?php else: ?>
                                <!-- User Homepage -->
                            <?php endif; ?>
                            <li onclick="window.location.href='profile.php'"> <a>Profile</a></li>                            
                            <li onclick="window.location.href='cart.php'"> <a>Shopping Cart</a></li>                            

                            <li onclick="window.location.href='index.php'"> <a>Logout</a></li>
                    </ul>
                </div>
            </header>
            <div class="welcome">
            <form action='changepassword.php' method='POST'>
                Old Password: <input type='text' name='oldpassword'><p>
                New Password: <input type='password' name='newpassword'><br>
                Repeat New Password: <input type='password' name='repeatedpassword'><br>
                <input type='submit' name='submit' value='Change Password'> 
            </form>

            <?php
                if(isset($_POST['submit']))
                {
                    if($_POST['oldpassword'] == $_SESSION['currentpassword'])
                    {
                        if($_POST['newpassword'] == $_POST['repeatedpassword'])
                        {
                            $query = "update user set password = '" . $_POST["newpassword"] ."'  where username = '" . $_SESSION["username"] ."' ";
                            $query_run = mysqli_query($conn,$query);
                            $_SESSION['currentpassword'] = $_POST['newpassword'];
                            echo "<script> location.href='profile.php'; </script>";
                        }
                        else
                            echo "Passwords Don't match";
                   }
                    else
                        echo "Old Password doesn't match your password";
                }
            
            ?>
            </div>
        </body>


</html>