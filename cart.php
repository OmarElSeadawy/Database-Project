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
    <script src="https://code.jquery.com/jquery-1.9.1.js"></script>
    <!-- <script>
        function ck()
        {
            $('#inlinesubmit_button').click(function(){
                $.ajax({
                    type: "POST",
                    url: "cart.php",
                data: {text:$('#discountc').val()}
                });
            });

            var discountc = document.getElementById('discountc').value;
            var dataString = 'discountc='+discountc;
            $.ajax(
                {
                    type:"post",
                    url: "cart.php",
                    data:dataString,
                    cache:false,
                    success: function(html)
                    {
                        $('#msg').html(html);
                    }
                }
            );
            return false;
        }
    </script> -->
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
            <?php $total = 0; ?>
            <table id="dtBasicExample" class="table table-striped table-bordered table-sm" cellspacing="0" width="100%">
                <thead>
                    <tr>
                    <th class="th-sm">Restaurant ID
                    </th>
                    <th class="th-sm">Menu ID
                    </th>
                    <th class="th-sm">Item ID
                    </th>
                    <th class="th-sm">Item Name
                    </th>
                    <th class="th-sm">Custom Name
                    </th>
                    <th class="th-sm">Price
                    </th>
                    </tr>
                </thead>
                <tbody>
                <?php
                        $selectquery = "select * from shoppingcart where username = '".$_SESSION['username']."' ";
                        $runquery = mysqli_query($conn,$selectquery);

                        if(mysqli_num_rows($runquery) > 0)
                        {
                            while($row = mysqli_fetch_array($runquery))
                            {
                                $_SESSION['restaurantidforcost'] = $row['restaurantID'];
                    ?>
                    
                    <tr>
                    <td> <?php echo $row['restaurantID'] ?></td>
                    <td> <?php echo $row['menuID'] ?></td>
                    <td> <?php echo $row['itemID'] ?></td>
                    <td> <?php echo $row['itemname'] ?></td>
                    <td> <?php echo $row['customname'] ?></td>
                    <td> <?php echo $row['price'] ?></td>
                    <?php if($total == 0)
                            $total = $row['price'];
                          else 
                            $total = $total + $row['price'];
                    ?>
                    </tr>
                    <?php } }?>

                    <tr><td> <br></td> </tr>
                    <tr><td> <br></td> </tr>
                    <tr><td> <br></td> </tr>
                    <tr><td> <br></td> </tr>

                </tbody>
                </table>
                
                
                    

                <h2> To Remove Item from Cart </h2>
                <form method='POST' name='dropitemcart' action='cart.php'>
                    Item ID : <input type='text' name='cartitemid'> <br>
                    Custom Name : <input type='text' name='cartcustomname'> <br>
                    <input type='submit' name='dropcartitem' value='Remove Item from Cart'> <br> 
                </form>

                <?php
                    if(isset($_POST['dropcartitem']))
                    {
                        $deletequery = "delete from shoppingcart where itemID = '".$_POST['cartitemid']."'  AND customname = '".$_POST['cartcustomname']."'  ";
                        $runquery = mysqli_query($conn,$deletequery);
                        echo "<script> location.href='cart.php'; </script>";
                    }
                ?>

                <h2> Check Your Discount Code Before Writing Comments or Placing Order </h2>                
                <form name='discountform' action='cart.php' method='POST'>
                        Discount Code : <input type='number' name='discountc'><br>
                        <input type='submit' value='Check Code' name='checkdiscountcode'>
                </form>
                
                <?php
                    if(isset($_POST['checkdiscountcode']))
                        {
                            $discountquery = "select discountpercentage from discountcode where codeID = '".$_POST['discountc']."'
                                      AND uses >= ( select count(orderID) from orders where codeID =  '".$_POST['discountc']."' ) ";
                            $rundiscountquery = mysqli_query($conn,$discountquery);

                            if(mysqli_num_rows($rundiscountquery) > 0)
                                {
                                    $row = mysqli_fetch_array($rundiscountquery);
                                    $_SESSION['discountcoderun'] = $row['discountpercentage'];
                                }
                            else
                                {
                                    $_SESSION['discountcoderun'] = "Invalid Discount Code";
                                }
                        }

                ?>

                <?php echo $_SESSION['discountcoderun']; ?>
                <h2> To Place an Order with Items in cart </h2>
                <form method='POST' name='placeorder' action='cart.php'>

                    Comments on Order : <input type='text' name='comments'>
                    <br>
                    Addresses : <select name='selectaddressid' id='selectaddressid'> 
                    <?php
                         $selectquery = "select * from useraddress where username= '".$_SESSION['username']."' ";
                         $runquery = mysqli_query($conn,$selectquery);

                         if(mysqli_num_rows($runquery) > 0)
                         {
                             while($row = mysqli_fetch_array($runquery))
                             {
                        ?>
                            <option value= <?php echo $row['addressid'] ?> > <?php echo $row['address'] ?> </option>";
                        <?php } }?> 
                        </select>
                    <br> 
                    
                    <?php
                        $querydelivery = "select deliverycost from branchdeliveryarea where restaurantID = '".$_SESSION['restaurantidforcost']."' ";
                        $runcost = mysqli_query($conn,$querydelivery);
                        $cost = mysqli_fetch_array($runcost);
                        
                        
                        $currentdate = date("Y-m-d");
                        $selectquery = "select * from discount where startdate <= '".$currentdate."' AND enddate >= '".$currentdate."' ";
                        $selectquery_run = mysqli_query($conn,$selectquery);
                        $discount = mysqli_fetch_array($selectquery_run);
                        $discountidused = $discount['discountID'];

                        $finaldiscount = 0;
                        if($_SESSION['discountcoderun'] != "Invalid Discount Code")
                        {
                            if($discount['discountpercentage'] >= $_SESSION['discountcoderun'])
                                $finaldiscount = $discount['discountpercentage'];
                            else
                                $finaldiscount = $_SESSION['discountcoderun'];      
                        }
                        else
                        {
                            if(isset($discount['discountpercentage']))
                                $finaldiscount = $discount['discountpercentage'];
                            echo "Invalid Discount Code";
                        }

                    ?>
                    <br>
                    <h3> Total Price : <?php echo $total; ?> EGP </h3>
                    <h3> Gross Price (+VAT) : <?php echo $total*1.14; ?> EGP </h3> 
                    <h3> Net Price (+Delivery) : <?php echo $total*1.14 + $cost['deliverycost']; ?> EGP </h3> 
                    <h3> Net Price (-Discount) : <?php echo $total*1.14 + $cost['deliverycost'] - ($total*$finaldiscount) ?> EGP </h3> <br>
                    <input name="place" type='submit' value ='Place Order'>
                    
                </form>

                <?php 
                    if(isset($_POST['place']))
                    {
                        $query1 = "INSERT INTO `orders`(`branchID`, `restaurantID`, `orderID`, `discountID`,
                                                         `codeID`, `orderstatus`, `comments`)
                                    VALUES ('1','".$_SESSION['restaurantidforcost']."',NULL,
                                            NULL,NULL ,
                                            'Sent','".$_POST['comments']."')";
                        $query1run = mysqli_query($conn,$query1);
                        echo $query1;
                        $testquery = "select * from orders";
                        $testqueryrun = mysqli_query($conn,$testquery);
                        if(mysqli_num_rows($testqueryrun) > 0)
                        {
                            while($row = mysqli_fetch_array($testqueryrun))
                            {
                                $finalorderID = $row['orderID'];
                            }   
                        }

                        $query2 = "INSERT INTO `orderaddress`(`orderID`, `username`, `addressid`) 
                                   VALUES ('".$finalorderID."','".$_SESSION['username']."','".$_POST['selectaddressid']."')";
                        $query2run = mysqli_query($conn,$query2);


                        $selectquery = "select * from shoppingcart where username = '".$_SESSION['username']."' ";
                        $runquery = mysqli_query($conn,$selectquery);

                        if(mysqli_num_rows($runquery) > 0)
                        {
                            while($row = mysqli_fetch_array($runquery))
                            {

                                    $query3 = "INSERT INTO `orderitems`(`orderID`, `itemID`, `customname`) 
                                                VALUES ('".$finalorderID."','".$row['itemID']."','".$row['customname']."')";
                                    $query3run = mysqli_query($conn,$query3);

                            }
                        }

                        $deletequeryall = "delete from shoppingcart where username = '".$_SESSION['username']."' ";
                        $deletallrun = mysqli_query($conn,$deletequeryall);

                        // echo "<script> location.href='cart.php'; </script>";

                    }
                
                ?>
                    </div>
            </header>
        </body>
</html>