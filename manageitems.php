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
                <form action='manageitems.php' method='POST' name='filter' > 
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
                        
                        <select name='selectmenuid' id='selectmenuid'> 
                    <?php
                         $selectquery = "select * from menu where restaurantID = '".$_POST["selectrestaurantid"]."'";
                         $runquery = mysqli_query($conn,$selectquery);

                         if(mysqli_num_rows($runquery) > 0)
                         {
                             while($row = mysqli_fetch_array($runquery))
                             {
                        ?>
                            <option value= <?php echo $row['menuID'] ?> > <?php echo $row['menuID'] ?> </option>";
                        <?php } }?> 
                        </select>

                    <br/> 
                    <input name="show" type='submit' value ='show'> 
                </form>

                <?php

                if(isset($_POST['show']))
                {
                    $_SESSION['selectrestaurantid'] = $_POST['selectrestaurantid'];
                    $_SESSION['selectmenuid'] = $_POST['selectmenuid'];
                    $selectallquery = " select c.customname,c.price,c.isAvailable,i.itemname,i.itemdescription,i.itemID
                                        from menuitems m, item i, customitem c 
                                        where i.itemID = m.itemID 
                                        AND c.itemID = i.itemID
                                        AND restaurantID = '".$_POST["selectrestaurantid"]."'
                                        AND menuID =  '".$_POST['selectmenuid']."'";
                
                    $selectresult = mysqli_query($conn, $selectallquery);

                    if(mysqli_num_rows($selectresult) > 0)
                    {
                        while($row = mysqli_fetch_array($selectresult))
                        {

                    ?>
                        <h2> <?php echo $row['itemID'] ?> - <?php echo $row['itemname']?> </h2>
                        <h3> <?php echo $row['itemdescription']; ?> </h3>
                        <h4> <?php echo $row['customname']; ?> </h4>
                        <h4> <?php echo $row['price']; ?> </h4>
                        <h4> 
                        <?php if($row['isAvailable'] == 1)
                                echo "Item Available";
                              else
                                echo "Item Unavailable";
                        ?> </h4>
                        <br>                
                        
                    <?php
                    } } } ?>

                    <form action='manageitems.php' method='POST' name='modificationdata'>
                        Item ID : <input type='number' name='itemid'><br>
                        Item Name : <input type='text' name='itemname'><br>
                        Item Description : <input type='text' name='itemdescription'><br>
                        Custom Name : <input type='text' name='customname'><br>
                        Price : <input type='number' name='price'><br><br>
                        Availability : <input type='number' name='availability'><br><br>
                        <input type='submit' name='modifydata' value='Modify Item'> 
                        <input type='submit' name='adddata' value='Add Item'> 
                        <input type='submit' name='dropdata' value='Drop Item'>
                    </form>


                    <?php 
                        if(isset($_POST['adddata']))
                        {
        
                            $additem = "INSERT INTO item (`itemid`, `itemname`, `itemdescription`) 
                                        VALUES ('".$_POST['itemid']."','".$_POST['itemname']."','".$_POST['itemdescription']."')";
                            $addquery_run = mysqli_query($conn,$additem);
                            
                            $addtomenu = "INSERT INTO `menuitems`(`restaurantID`, `menuID`, `itemID`) 
                                          VALUES ('".$_SESSION['selectrestaurantid']."','".$_SESSION['selectmenuid']."','".$_POST['itemid']."')";
                            echo $addtomenu;
                            $addquery_run = mysqli_query($conn,$addtomenu);

                            $addcustomitem = "INSERT INTO `customitem`(`customname`, `itemID`, `isAvailable`, `price`)
                                              VALUES ('".$_POST['itemname']."','".$_POST['itemid']."','".$_POST['availability']."','".$_POST['price']."')";
                            $addquery_run = mysqli_query($conn,$addcustomitem);
                            echo "<script> location.href='manageitems.php'; </script>";
        
                        }
        
                        if(isset($_POST['dropdata']))
                        {
                            $query1 = "update customitem set isAvailable = 0 where itemID = '".$_POST['itemid']."'";
                            $query_run = mysqli_query($conn,$query1);
                        }
                        if(isset($_POST['modifydata']))
                        {
                            
                            if($_POST['itemname'] != "")
                            {
                                $query = "update item set itemname = '" . $_POST['itemname'] ."' where itemid = '".$_POST['itemid']."' ";
                                $query_run = mysqli_query($conn,$query);
                            }
                            if($_POST['itemdescription'] != "")
                            {
                                $query = "update item set itemdescription = '" . $_POST['itemdescription'] ."' where itemid = '".$_POST['itemid']."' ";
                                $query_run = mysqli_query($conn,$query);
                            }
                            if($_POST['customname'] != "")
                            {
                                $query = "update customitem set customname = '" . $_POST['customname'] ."' where itemid = '".$_POST['itemid']."' ";
                                $query_run = mysqli_query($conn,$query);    
                            }                            
                            if($_POST['price'] != "")
                            {
                                $query = "update customitem set price = '" . $_POST['price'] ."' where itemid = '".$_POST['itemid']."' ";
                                $query_run = mysqli_query($conn,$query);    
                            }                            
                            if($_POST['availability'] != "")
                            {
                                $query = "update customitem set isAvailable = '" . $_POST['availability'] ."' where itemid = '".$_POST['itemid']."' ";
                                $query_run = mysqli_query($conn,$query);    
                            }                            
                            
                            echo "<script> location.href='manageitems.php'; </script>";
                        }            
                    ?>
                    </div>
            </header>
        </body>
</html>