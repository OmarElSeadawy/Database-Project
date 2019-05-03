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
                    $selectquery = "select * from discountcode";
                    $selectquery_run = mysqli_query($conn,$selectquery);
                
                    if(mysqli_num_rows($selectquery_run) > 0)
				    {
					while($row = mysqli_fetch_array($selectquery_run))
					{
                    ?>
                    <h3> Discount ID : <?php echo $row['codeID'] ?> - <?php echo $row['discountpercentage']*100 ?> % </h3><br>
                    <h3> Number of Uses : <?php echo $row['uses'] ?> </h3><br>
                    <?php } } ?>
            

            <form action='managediscountcards.php' method='POST'>
                    Discount ID : <input type='number' name='codeid'> <p>
                    <input type='submit' name='drop' value='Delete'> <p> 
            </form>
                    <?php 
                        if(isset($_POST['drop']))
                        {
                            $dropquery = "delete from discountcode where codeID = '" . $_POST['codeid'] ."' ";
                            $dropquery_run = mysqli_query($conn,$dropquery);
                            echo "<script> location.href='managediscountcards.php'; </script>";
                        }
                        ?>
           
            <form action='managediscountcards.php' method='POST'>
                Discount Code ID : <input type='text' name='codeid'><br>
                Discount Precentage : <input type='number' step='0.01' name='discountpercentage'><p>
                Uses : <input type='number' name='uses'><br>
                <input type='submit' name='modify' value='Modify Discount'> 
                <input type='submit' name='add' value='Add Discount'> 
            </form>

            <?php

            
                if(isset($_POST['add']))
                {
                    $addquery = "INSERT INTO `discountcode`(`codeID`, `discountpercentage`, `uses`)
                                 VALUES ('".$_POST['codeid']."','".$_POST['discountpercentage']."','".$_POST['uses']."')";
                    $addquery_run = mysqli_query($conn,$addquery);
                    echo "<script> location.href='managediscountcards.php'; </script>";

                }
                if(isset($_POST['modify']))
                {
                    
                    if($_POST['discountpercentage'] != "")
                    {
                        $query = "update discountcode set discountpercentage = '".$_POST['discountpercentage']."' 
                                  where codeID = '".$_POST['codeid']."' ";
                        $query_run = mysqli_query($conn,$query);
                    }   
                    
                    if($_POST['uses'] != "")
                    {
                        $query = "update discountcode set uses = '".$_POST['uses']."' 
                                  where codeID = '".$_POST['codeid']."' ";
                        $query_run = mysqli_query($conn,$query);
                    }   
                    
                    echo "<script> location.href='managediscountcards.php'; </script>";
                }
            
            ?>
            </div>
        </body>


</html>