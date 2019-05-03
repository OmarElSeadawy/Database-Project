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
            <table id="dtBasicExample" class="table table-striped table-bordered table-sm" cellspacing="0" width="100%">
                <thead>
                    <tr>
                    <th class="th-sm">Branch ID
                    </th>
                    <th class="th-sm">Restaurant ID
                    </th>
                    <th class="th-sm">Order ID
                    </th>
                    <th class="th-sm">Discount ID
                    </th>
                    <th class="th-sm">Code ID
                    </th>
                    <th class="th-sm">Orderstatus
                    </th>
                    <th class="th-sm">Comments
                    </th>
                    </tr>
                </thead>
                <tbody>
                <?php
                         $selectquery = "select * from orders o, orderaddress a where o.orderID = a.orderID
                                                                                and a.username = '".$_SESSION['username']."' ";
                         $runquery = mysqli_query($conn,$selectquery);

                         if(mysqli_num_rows($runquery) > 0)
                         {
                             while($row = mysqli_fetch_array($runquery))
                             {
                        ?>
                    
                    <tr>
                    <td> <?php echo $row['branchID'] ?></td>
                    <td> <?php echo $row['restaurantID'] ?></td>
                    <td> <?php echo $row['orderID'] ?></td>
                    <td> <?php echo $row['discountID'] ?></td>
                    <td> <?php echo $row['codeID'] ?></td>
                    <td> <?php echo $row['orderstatus'] ?></td>
                    <td> <?php echo $row['comments'] ?></td>
                    </tr>
                    <?php } }?>

                    <tr><td> <br></td> </tr>
                    <tr><td> <br></td> </tr>
                    <tr><td> <br></td> </tr>
                    <tr><td> <br></td> </tr>

                </tbody>
                </table>
                         
                    </div>
            </header>
        </body>
</html>