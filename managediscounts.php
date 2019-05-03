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
                <h2> List of Current Discounts </h2><br>
                <?php
                    $currentdate = date("Y-m-d");
                    $selectquery = "select * from discount where startdate <= '".$currentdate."' AND enddate >= '".$currentdate."' ";
                    $selectquery_run = mysqli_query($conn,$selectquery);
                
                    if(mysqli_num_rows($selectquery_run) > 0)
				    {
					while($row = mysqli_fetch_array($selectquery_run))
					{
                    ?>
                    <h3> Discount ID : <?php echo $row['discountID'] ?> - <?php echo $row['discountpercentage']*100 ?> % </h3><br>
                    <?php } } ?>
            

            <form action='managediscounts.php' method='POST'>
                    Discount ID : <input type='number' name='discountid'> <p>
                    <input type='submit' name='drop' value='Delete'> <p> 
            </form>
                    <?php 
                        if(isset($_POST['drop']))
                        {
                            $dropquery = "delete from discount where discountID = '" . $_POST['discountid'] ."' ";
                            $dropquery_run = mysqli_query($conn,$dropquery);
                            echo "<script> location.href='managediscounts.php'; </script>";
                        }
                        ?>
           
            <form action='managediscounts.php' method='POST'>
                DiscountID : <input type='text' name='discountid'><br>
                Discount Precentage : <input type='number' step='0.01' name='discountpercentage'><p>
                startdate : <input type='date' name='startdate'><br>
                enddate : <input type='date' name='enddate'><br>
                <input type='submit' name='modify' value='Modify Discount'> 
                <input type='submit' name='add' value='Add Discount'> 
            </form>

            <?php

            
                if(isset($_POST['add']))
                {
                    $startdate = date('Y-m-d', strtotime(str_replace('-', '/', $_POST['startdate'])));
                    $enddate = date('Y-m-d', strtotime(str_replace('-', '/', $_POST['enddate'])));

                    $addquery = "INSERT INTO `discount`(`discountID`, `discountpercentage`, `startdate`, `enddate`)
                                 VALUES ('".$_POST['discountid']."','".$_POST['discountpercentage']."','".$startdate."','".$enddate."')";
                    $addquery_run = mysqli_query($conn,$addquery);
                    echo "<script> location.href='managediscounts.php'; </script>";

                }
                if(isset($_POST['modify']))
                {
                    
                    if($_POST['discountpercentage'] != "")
                    {
                        $query = "update discount set discountpercentage = '".$_POST['discountpercentage']."' 
                                  where discountID = '".$_POST['discountid']."' ";
                        $query_run = mysqli_query($conn,$query);
                    }   
                    
                    if($_POST['startdate'] != "")
                    {
                        $startdate = date('Y-m-d', strtotime(str_replace('-', '/', $_POST['startdate'])));

                        $query = "update discount set startdate = '".$startdate."' 
                                  where discountID = '".$_POST['discountid']."' ";
                        $query_run = mysqli_query($conn,$query);
                    }   
                    
                    if($_POST['enddate'] != "")
                    {
                        $enddate = date('Y-m-d', strtotime(str_replace('-', '/', $_POST['enddate'])));

                        $query = "update discount set enddate = '".$enddate."' 
                                  where discountID = '".$_POST['discountid']."' ";
                        $query_run = mysqli_query($conn,$query);
                    }   
                    
                    echo "<script> location.href='managediscounts.php'; </script>";
                }
            
            ?>
            </div>
        </body>


</html>