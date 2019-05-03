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
                <h2> List of Administration Accounts </h2><br>
                <?php

                    $selectquery = "select * from restaurant";
                    $selectquery_run = mysqli_query($conn,$selectquery);
                
                    if(mysqli_num_rows($selectquery_run) > 0)
				    {
					while($row = mysqli_fetch_array($selectquery_run))
					{
                    ?>
                    <h3> <?php echo $row['restaurantname'] ?> </h3><br>
                    <?php $finalrestaurantid = $row['restaurantID'];} } ?>
            
             <!-- DELETING RESTAURANTS  -->

            <form action='managerestaurants.php' method='POST'>
                    Restaurant Name : <input type='text' name='droprestaurant'> <p>
                    <input type='submit' name='drop' value='drop'> <p> 
            </form>
                    <?php 
                        if(isset($_POST['drop']))
                        {
                            $dropquery1 = "delete from branchphoneno where restaurantID = 
                                           (select restaurantID from restaurant where restaurantname = '" . $_POST["droprestaurant"] ."')";
                            $dropquery2 = "delete from branchdeliveryarea where restaurantID = 
                                            (select restaurantID from restaurant where restaurantname = '" . $_POST["droprestaurant"] ."')";
                            $dropquery3 = "delete from branch where restaurantID = 
                                            (select restaurantID from restaurant where restaurantname = '" . $_POST["droprestaurant"] ."')";
                            $dropquery4 = "delete from restaurantcuisine where restaurantID = 
                                            (select restaurantID from restaurant where restaurantname = '" . $_POST["droprestaurant"] ."')";
                            $dropquery = "delete from restaurant where restaurantname = '" . $_POST["droprestaurant"] ."' ";
                            
                            $dropquery_run = mysqli_query($conn,$dropquery1);
                            $dropquery_run = mysqli_query($conn,$dropquery2);
                            $dropquery_run = mysqli_query($conn,$dropquery3);
                            $dropquery_run = mysqli_query($conn,$dropquery4);
                            $dropquery_run = mysqli_query($conn,$dropquery);
                            echo "<script> location.href='managerestaurants.php'; </script>";
                        }
                        ?>
            <!-- END OF DELETING RESTAURANTS  -->

            
            <form action='managerestaurants.php' method='POST'>
                Restaurant ID : <input type='text' name='restaurantid'><br>
                Restaurant Name : <input type='text' name='restaurantname'><br>
                <input type='submit' name='modify' value='Modify'> 
                <input type='submit' name='add' value='Add'> 
            </form>

            <?php
                if(isset($_POST['modify']))
                {     
                    $query = "update restaurant set restaurantname = '" . $_POST["restaurantname"] ."' where restaurantID = '" . $_POST["restaurantid"] ."' ";
                    $query_run = mysqli_query($conn,$query);
                    echo "<script> location.href='managerestaurants.php'; </script>";
                }
                if(isset($_POST['add']))
                {
                    $finalrestaurantid = $finalrestaurantid + 1;
                    $addquery = "INSERT INTO restaurant (`restaurantID`, `restaurantname`) VALUES ( '" . $finalrestaurantid ."' , '" . $_POST["restaurantname"] ."')";
                    $addquery_run = mysqli_query($conn,$addquery);
                    echo "<script> location.href='managerestaurants.php'; </script>";
                }
            
            ?>
            </div>
        </body>


</html>