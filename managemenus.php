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
                <form action='managemenus.php' method='POST' name='filter' > 
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
                    $selectallquery = " select * from menu where restaurantID = '".$_POST["selectrestaurantid"]."' ";

                    $selectresult = mysqli_query($conn, $selectallquery);

                    if(mysqli_num_rows($selectresult) > 0)
                    {
                        while($row = mysqli_fetch_array($selectresult))
                        {

                    ?>
                        <h1> <?php echo $row['menuID']?> </h1>
                        <h2> <?php echo $row['menutype']; ?> </h2>
                        <h2> <?php echo $row['startsat']; ?> </h2>
                        <h2> <?php echo $row['endsat']; ?> </h2>                
                        
                    <?php
                    } } } ?>

                    <form action='managemenus.php' method='POST' name='modificationdata'>
                        Menu ID : <input type='number' name='menuid'><br>
                        Menu Type : <input type='text' name='menutype'><br>
                        Starts AT : <input type='time' name='startsat'><br>
                        Ends AT : <input type='time' name='endsat'><br><br>
                        <input type='submit' name='modifydata' value='ModifyData'> 
                        <input type='submit' name='adddata' value='AddData'> 
                    </form>

                    <?php 
                        if(isset($_POST['modifydata']))
                        {
                            
                            $query = "update menu set restaurantID = '".$_SESSION["selectrestaurantid"]."'  ";
                            if($_POST['menutype'] != "")
                                $query .= " , menutype = '" . $_POST['menutype'] ."' ";
                            if($_POST['startsat'] != "")
                                $query .= " , startsat = '" . $_POST['startsat'] ."' ";
                            if($_POST['endsat'] != "")
                                $query .= " , endsat = '" . $_POST['endsat'] ."' ";                            
                            
                            
                            $query .= " where restaurantID = '" . $_SESSION["selectrestaurantid"] ."'
                                        and menuID = '". $_POST['menuid'] ."' ";
                            
                            $query_run = mysqli_query($conn,$query);
                            echo "<script> location.href='managemenus.php'; </script>";
                        }
        
                        if(isset($_POST['add']))
                        {
        
                            $addquery = "INSERT INTO `menu`(`restaurantID`, `menuID`, `menutype`, `startsat`, `endsat`) 
                                         VALUES ('" . $_SESSION["selectrestaurantid"] ."', '" . $_POST['menuid'] ."', 
                                         '" . $_POST['menutype'] ."', '" . $_POST['startsat'] ."', '" . $_POST['endsat'] ."')";
                            $addquery_run = mysqli_query($conn,$addquery);
                            echo "<script> location.href='managemenus.php'; </script>";
        
                        }
                    
                    ?>
                    </div>
            </header>
        </body>
</html>