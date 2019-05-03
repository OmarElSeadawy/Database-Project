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
            <form action='modifyaccount.php' method='POST'>
                First Name : <input type='text' name='firstname'><p>
                Last Name : <input type='text' name='lastname'><br>
                Email : <input type='text' name='email'><br>
                Birthdate : <input type='date' name='birthdate'><br>
                Username : <input type='text' name='username'><br>
                <input type='submit' name='submit' value='Submit Changes'> 
            </form>

            <?php
                if(isset($_POST['submit']))
                {
                    $query = "update user set password = '" . $_SESSION["currentpassword"] ."' ";
                    if($_POST['firstname'] != "")
                        $query .= " , fname = '" . $_POST["firstname"] ."' ";
                    if($_POST['lastname'] != "")
                        $query .= " , lname = '" . $_POST["lastname"] ."' ";
                    if($_POST['email'] != "")
                        $query .= " , email = '" . $_POST["email"] ."' ";
                    if($_POST['birthdate'] != "")
                        $query .= " , bdate = '" . date('Y-m-d', strtotime(str_replace('-', '/', $_POST['birthdate']))) ."' ";
                    if($_POST['username'] != "")
                        $query .= " , username = '" . $_POST["username"] ."' ";
                    
                    $query .= " where username = '" . $_SESSION["username"] ."'";
                    if($_POST['username'] != "")
                        $_SESSION['username'] = $_POST["username"];
                
                    $query_run = mysqli_query($conn,$query);
                    echo "<script> location.href='profile.php'; </script>";
                }
            
            ?>
            </div>
        </body>


</html>