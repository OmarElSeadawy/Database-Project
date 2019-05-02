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
    <link rel="stylesheet" type="text/css" media="screen" href="css/startorder.css">
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

            <div class='welcome'>
            
                <h1> Addresses of <?php echo $_SESSION['username']; ?> </h2>
                <?php
                    $selectallquery = " select * from useraddress where username = '".$_SESSION['username']."' ";

                    $selectresult = mysqli_query($conn, $selectallquery);

                    if(mysqli_num_rows($selectresult) > 0)
                    {
                        while($row = mysqli_fetch_array($selectresult))
                        {

                    ?>
                        <h2> <?php echo $row['addressid']; ?> </h2>
                        <h2> <?php echo $row['address']; ?> </h2>                
                        
                    <?php
                    } } ?>

                    <form action='manageaddresses.php' method='POST' name='modificationdata'>
                        Address ID : <input type='number' name='addressid'><br>
                        Address : <input type='text' name='address'><br>
                        <input type='submit' name='modifydata' value='Modify Address'> 
                        <input type='submit' name='adddata' value='Add Address'> 
                        <input type='submit' name='dropdata' value='Drop Address'>
                    </form>

                    <?php 

                        if(isset($_POST['dropdata']))
                        {
                            $query = "delete from useraddress where addressid = '".$_POST['addressid']."'" ;
                  
                            $query_run = mysqli_query($conn,$query);
                            echo "<script> location.href='manageaddresses.php'; </script>";

                        }
                        if(isset($_POST['modifydata']))
                        {
                            
                            $query = "update useraddress set address = '".$_POST['address']."' 
                                      where addressid =  '".$_POST['addressid']."' ";
                            
                            $query_run = mysqli_query($conn,$query);
                            echo "<script> location.href='manageaddresses.php'; </script>";
                        }
        
                        if(isset($_POST['adddata']))
                        {
        
                            $addquery = "INSERT INTO `useraddress`(`username`, `addressid`, `address`) 
                                         VALUES ('".$_SESSION['username']."','".$_POST['addressid']."','".$_POST['address']."')";
                            $addquery_run = mysqli_query($conn,$addquery);
                            echo "<script> location.href='manageaddresses.php'; </script>";
        
                        }
                    
                    ?>
                    </div>
            </header>
        </body>
</html>