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

            <div class="welcome"> 
                        
			<?php
                echo "<h2><a href='manageadmins.php' style='color:#ccc000'> Manage Admin Accounts </a></h2>";
                echo "<br>";
                echo "<h2><a href='manageordering.php' style='color:#ccc000'> Manage Ordering Staff Accounts </a></h2>";
                echo "<br>";
                echo "<h2><a href='managerestaurants.php' style='color:#ccc000'> Manage Restaurants </a></h2>";
                echo "<br>";
                echo "<h2><a href='managerestaurantsinfo.php' style='color:#ccc000'> Manage Restaurants Info </a></h2>";
                echo "<br>";
                echo "<h2><a href='managemenus.php' style='color:#ccc000'> Manage Menus </a></h2>";
                echo "<br>";
                echo "<h2><a href='manageitems.php' style='color:#ccc000'> Manage Items </a></h2>";
                echo "<br>";
                echo "<h2><a href='managediscounts.php' style='color:#ccc000'> Manage Discounts </a></h2>";
                echo "<br>";
                echo "<h2><a href='managediscountcards.php' style='color:#ccc000'> Manage Discount Cards </a></h2>";
            ?>

            </div>

            </header>

        </body>


</html>