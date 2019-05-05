<?php 
    if(session_status() == PHP_SESSION_ACTIVE)
    {
        session_destroy();
    }
    session_start();
    require 'dbconfig/dbconn.php';
    ?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Login Page</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" media="screen" href="css/index.css">
    <script src="js/index.js"></script>
</head>
<body style="background-color:#bdc3c7">
	<div id="main-wrap">
        <center>
            <h2>Login Form</h2>
            <img src="css/avatar.png" alt="Avatar" class="avatar">   
        </center>
    
        
        <form class="form" action="index.php" method="post">
            <label><b> Username: </b></label><br>
            <input name="username" type="text" class="inputvalues" placeholder="Please Enter Username"/><br>
            <label><b> Password: </b></label><br>
            <input name="password" type="password" class="inputvalues" placeholder="Please Enter Password"/><br>
            <input name="login" type="submit" id="login_button" value="Login"/>
            <a href="register.php"><input type="button" id="reg_button" value="Register"/></a>

        </form>
     

        <?php
            if(isset($_POST['login']))
            {
                $username = $_POST['username'];
                $password = $_POST['password'];
                $query = "select * from user WHERE username='$username' AND password='$password'";
                $query_run = mysqli_query($conn,$query);

                if(mysqli_num_rows($query_run) > 0)
                {
                    //Valid User
                    $row = mysqli_fetch_assoc($query_run);
                    $usertype = $row['usertype']; 
                    $_SESSION['username'] = $username;
                    $_SESSION['usertype'] = $usertype;
                    header('location:home.php');
                }
                else
                {
                    echo '<script type="text/javascript"> alert("Invalid Username/Password") </script>';
                }
            }

        ?>
    <form class='form' method="POST" action="send_link.php">
            <h2>Forget Password</h2>
            <input type="text" name="email" value='Enter Email'>
            <input type="submit" name="submitmail">
        </form>

    </div>


</body>
</html>