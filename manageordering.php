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
                            <li onclick="window.location.href='index.php'"> <a>Logout</a></li>
                    </ul>
                </div>
            </header>

            
            <div class="welcome">
                <h2> List of Ordering Staff Accounts </h2><br>
                <?php

                    $selectquery = "select username from user where usertype = '1'";
                    $selectquery_run = mysqli_query($conn,$selectquery);
                
                    if(mysqli_num_rows($selectquery_run) > 0)
				    {
					while($row = mysqli_fetch_array($selectquery_run))
					{
                    ?>
                    <h3> <?php echo $row['username'] ?> </h3><br>
                    <?php } } ?>
            
             <!-- DELETING OTHER ADMIN USERS -->

            <form action='manageadmins.php' method='POST'>
                    Username : <input type='text' name='dropusername'> <p>
                    <input type='submit' name='drop' value='Delete'> <p> 
            </form>
                    <?php 
                        if(isset($_POST['drop']))
                        {
                            $query3 = "INSERT INTO dropaccount (`DeletedUsername`, `AdminUsername`, `DropID`, `datetime`) VALUES ('" . $_POST["dropusername"] ."','" . $_SESSION["username"] ."',NULL,'".date("Y-m-d H:i:s")."')";
                            $query3_run = mysqli_query($conn,$query3);
                            $dropquery = "delete from user where username = '" . $_POST["dropusername"] ."' ";
                            $dropquery_run = mysqli_query($conn,$dropquery);
                            echo "<script> location.href='manageadmins.php'; </script>";
                        }
                        ?>
            <!-- END OF DELETING ADMIN USERS  -->

            
            <form action='manageadmins.php' method='POST'>
                Username : <input type='text' name='username'><br>
                First Name : <input type='text' name='firstname'><p>
                Last Name : <input type='text' name='lastname'><br>
                Email : <input type='email' name='email'><br>
                Birthdate : <input type='date' name='birthdate'><br>
                Gender : <input type='text' name='gender'><br>
                Password : <input type='password' name='password'><br>
                <input type='submit' name='modify' value='Modify'> 
                <input type='submit' name='add' value='Add'> 
            </form>

            <?php
                if(isset($_POST['modify']))
                {
                    
                    $query = "update user set isActive = 1 ";
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
                    if($_POST['gender'] != "")
                        $query .= " , gender = '" . $_POST['gender'] ."' ";
                    if($_POST['password'] != "")
                        {
                            $query .= " , password = '" . $_POST['password'] ."' ";
                            $query2 = "INSERT INTO changepassword (`changeID`, `AdminUsername`, `changedUsername`, `datetime`) VALUES (NULL,'" . $_SESSION["username"] ."','" . $_POST["username"] ."','".date("Y-m-d H:i:s")."')";
                        }

                    $query .= " where username = '" . $_POST["username"] ."'";
                    
                    $query_run = mysqli_query($conn,$query);
                    $query2_run = mysqli_query($conn,$query2);
                    echo "<script> location.href='manageadmins.php'; </script>";
                }

                if(isset($_POST['add']))
                {
                    $date = date('Y-m-d', strtotime(str_replace('-', '/', $_POST['birthdate'])));

                    $addquery = "INSERT INTO user (`UUID`, `username`, `password`, `bdate`, `gender`, `usertype`, `fname`,
                             `lname`, `email`, `isActive`) 
                             VALUES (NULL, '" . $_POST["username"] ."', '" . $_POST['password'] ."', 
                             '".$date."', '" . $_POST['gender'] ."' ,
                              '1', '" . $_POST["firstname"] ."', '" . $_POST["lastname"] ."'
                              , '" . $_POST["email"] ."', '1')";
                    $addquery_run = mysqli_query($conn,$addquery);
                    echo "<script> location.href='manageadmins.php'; </script>";

                }
            
            ?>
            </div>
        </body>


</html>