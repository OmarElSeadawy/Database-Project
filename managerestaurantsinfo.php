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
                            <li onclick="window.location.href='cart.php'"> <a>Shopping Cart</a></li>                            

                            <li onclick="window.location.href='index.php'"> <a>Logout</a></li>
                    </ul>  
                    </div>

            <div class='welcome'>
                <form action='managerestaurantsinfo.php' method='POST' name='filter' > 
                    <select name='selectrestaurantid' id='selectrestaurantid'> 
                    <?php
                         $selectquery = "select * from restaurant";
                         $runquery = mysqli_query($conn,$selectquery);

                         if(mysqli_num_rows($runquery) > 0)
                         {
                             while($row = mysqli_fetch_array($runquery))
                             {
                        ?>
                            <option value= <?php echo $row['restaurantID'] ?> > <?php echo $row['restaurantname'] ?> </option>";
                        <?php } }?> 
                        </select>

                    <br/> 
                    <input name="show" type='submit' value ='show'> 
                </form>

                <?php

                if(isset($_POST['show']))
                {
                    // Show Branch Informaion
                    $_SESSION['selectrestaurantid'] = $_POST["selectrestaurantid"];
                    $selectallquery = " select r.restaurantname, b.branchID, b.openinghrs, b.address, a.areaname, c.phoneno, rc.cuisineType, q.deliverycost 
                               from branch b, branchdeliveryarea q, area a, branchphoneno c, restaurant r, restaurantcuisine rc
                               where b.restaurantID = '" . $_POST["selectrestaurantid"] ."'     
                               and   q.restaurantID = '" . $_POST["selectrestaurantid"] ."'
                               and   c.restaurantID = '" . $_POST["selectrestaurantid"] ."'
                               and   r.restaurantID = '" . $_POST["selectrestaurantid"] ."'
                               and   rc.restaurantID = '" . $_POST["selectrestaurantid"] ."'
                               and   q.areaID = a.areaID ";

                    $selectresult = mysqli_query($conn, $selectallquery);

                    if(mysqli_num_rows($selectresult) > 0)
                    {
                        while($row = mysqli_fetch_array($selectresult))
                        {

                    ?>

                        <br>
                        <h1> <?php echo $row['restaurantname']?> </h1>
                        <h1> Cuisine : <?php echo $row['cuisineType']?> </h1>
                        <h2> <?php echo $row['areaname']; ?> Branch </h2>
                        <h2> <?php echo $row['deliverycost']; ?> </h2>
                        <h2> <?php echo $row['address']; ?> </h2>
                        <h2> <?php echo $row['openinghrs']; ?> </h2>
                        <h2> <?php echo $row['phoneno']; ?> </h2>                
                        
                    <?php
                    } } } ?>

                    <form action='managerestaurantsinfo.php' method='POST' name='modificationdata'>
                        Cuisine : <input type='text' name='cuisine'><br>
                        Area Name : <input type='text' name='areaname'><br>
                        Delivery Cost : <input type='number' name='deliverycost'><br>
                        Address : <input type='text' name='address'><br>
                        openinghrs : <input type='time' name='openinghrs'><br>
                        phoneno : <input type='text' name='phoneno'><br>
                        <input type='submit' name='modifydata' value='ModifyData'> 
                        <input type='submit' name='adddata' value='AddData'> 
                    </form>

                    <?php 
                        if(isset($_POST['modifydata']))
                        {
                            if($_POST['cuisine'] != "")
                            {
                                $querycuisine = "UPDATE restaurantcuisine SET cuisineType = '" . $_POST['cuisine'] ."' where restaurantID = '" . $_SESSION['selectrestaurantid'] ."' ";
                                $updatecuisine = mysqli_query($conn,$querycuisine);
                            }
                                
                            if($_POST['areaname'] != "")
                            {
                                $areaidquery = "select a.areaID from area a where a.areaname = '" . $_POST['areaname'] ."'";
                                $currentareaid = mysqli_query($conn,$areaidquery); 
                                $row = mysqli_fetch_array($currentareaid);
                                $areaid = $row['areaID'];

                                $areaquery = "UPDATE `branchdeliveryarea` SET areaID = '" . $areaid ."' 
                                 where restaurantID = '" . $_SESSION['selectrestaurantid'] ."' ";
                                $queryarea = mysqli_query($conn,$areaquery);
                            }
                            
                            if($_POST['deliverycost'] != "")
                            {
                                $areaquery = "UPDATE `branchdeliveryarea` SET deliverycost = '". $_POST['deliverycost'] ."'
                                 where restaurantID = '" . $_SESSION['selectrestaurantid'] ."' ";
                                $queryarea = mysqli_query($conn,$areaquery);
                            }
                            
                            
                            if($_POST['address'] != "")
                            {
                                $addressquery = "UPDATE `branch` SET address =  '" . $_POST['address'] ."' 
                                 where restaurantID = '" . $_SESSION['selectrestaurantid'] ."' ";
                                $queryaddress = mysqli_query($conn,$addressquery);
                            }
                             
                            if($_POST['openinghrs'] != "")
                            {
                                $openinghrsquery = "UPDATE `branch` SET openinghrs =  '" . $_POST['openinghrs'] ."' 
                                 where restaurantID = '" . $_SESSION['selectrestaurantid'] ."' ";
                                $queryopeninghrs = mysqli_query($conn,$openinghrsquery);
                            }

                            if($_POST['phoneno'] != "")
                            {
                                $phonequery = "UPDATE `branchphoneno` SET phoneno =  '" . $_POST['phoneno'] ."' 
                                 where restaurantID = '" . $_SESSION['selectrestaurantid'] ."' ";
                                $queryphone = mysqli_query($conn,$phonequery);
                            }

                            echo "<script> location.href='managerestaurantsinfo.php'; </script>";
                        }
        
                        if(isset($_POST['adddata']))
                        {

                            
                            $areaidquery = "select a.areaID from area a where a.areaname = '" . $_POST['areaname'] ."'";
                            $currentareaid = mysqli_query($conn,$areaidquery); 
                            $row = mysqli_fetch_array($currentareaid);
                            $areaid = $row['areaID'];

                            $query1 = "INSERT INTO branch (`branchID`, `restaurantID`, `openinghrs`, `address`) VALUES ('1','" . $_SESSION['selectrestaurantid'] ."', '" . $_POST['openinghrs'] ."','" . $_POST['address'] ."')";
                            $query2 = "INSERT INTO branchdeliveryarea (`branchID`, `restaurantID`, `areaID`, `deliverycost`) VALUES ('1','" . $_SESSION['selectrestaurantid'] ."','" . $areaid ."','" . $_POST['deliverycost'] ."')";
                            $query3 = "INSERT INTO branchphoneno (`branchID`, `restaurantID`, `phoneno`) VALUES ('1','" . $_SESSION['selectrestaurantid'] ."','" . $_POST['phoneno'] ."')";
                            $query4 = "INSERT INTO restaurantcuisine (`restaurantID`, `cuisineType`) VALUES ('" . $_SESSION['selectrestaurantid'] ."','" . $_POST['cuisine'] ."')";
                            $query1_run = mysqli_query($conn,$query1);
                            $query2_run = mysqli_query($conn,$query2);
                            $query3_run = mysqli_query($conn,$query3);
                            $query4_run = mysqli_query($conn,$query4);
                            echo "<script> location.href='managerestaurantsinfo.php'; </script>";
        
                        }
                    
                    ?>
                    </div>
            </header>
        </body>
</html>