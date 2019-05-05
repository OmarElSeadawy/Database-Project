<?php
    session_start();
    require 'dbconfig/dbconn.php';

    // echo $_SESSION['currentmenu'];
    ?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Homepage</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" media="screen" href="css/menu.css">
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

            
            <?php
                if ((date("H") >= 9) && (date("H") <= 11))
                    $time = "Morning";
                elseif ((date("H") > 11) && (date("H") <= 23))
                    $time = "Regular";
                else
                    $time = "Closed";
                    
            ?>

            <div style="clear:both"></div>
			<h3 style="color: white; font-weight: bold; font-size: 48px;"><?php echo $_SESSION['currentmenu'] ?> <?php echo $time ?> Menu : </h3>
			<div class="table-responsive">
				<table class="table table-bordered">
					<tr>
						<th width="10%">Item Name</th>
                        <th width="3%">Quantity</th>
                        <th width="40%">Description</th>
						<th width="5%">Price</th>
						<!-- <th width="5%">Action</th> -->
                    </tr>
                    <br/>
                    <?php
                        
                        $query = "
                        select i.itemname,i.itemdescription,c.customname,c.price,c.isAvailable, i.itemid from item i, customitem c
                                    where i.itemid = c.itemid
                                    and i.itemid in
                                    (
                                        select x.itemid
                                        from menuitems x
                                        where x.menuid =
                                        (
                                            select z.menuid
                                            from menu z
                                            where z.menutype= '".$time."'
                                            and z.restaurantid =
                                            (
                                                select restaurantid
                                                from restaurant
                                                where restaurantname = '".$_SESSION['currentmenu']."'
                                            )
                                        )
                                        and x.restaurantid =
                                        (
                                                select restaurantid
                                                from restaurant
                                                where restaurantname = '".$_SESSION['currentmenu']."'

                                        )

                                    )";

                        $result = mysqli_query($conn, $query);
                        if(mysqli_num_rows($result) > 0)
                        {
                            while($row = mysqli_fetch_array($result))
                            {
                    ?>
                    
					<tr class = "menuitems">
                        <?php if($row['isAvailable'] == 1) { ?>
						<td><?php echo $row["itemname"]; ?> <?php echo $row["customname"]; ?></td>
						<td> 1 </td>
						<td> <?php echo $row["itemdescription"]; ?></td>
						<td>$ <?php echo $row['price'];?></td>
						<!-- <td><a href="menu.php?action=add&id=<?php echo $row["itemname"]; ?>"><span class="text-danger">Add</span></a></td> -->
                        <?php } ?>        
                    </tr>

					<?php
                            }
                        }
                    ?>	
				</table>
            </div>
                        <div class='welcome'>
                            <form action='menu.php' method='POST' name='additem' > 
                                <select name='selectitem' id='selectitem'>
                            <?php
                                $result = mysqli_query($conn, $query);
                                if(mysqli_num_rows($result) > 0)
                                {
                                    while($row = mysqli_fetch_array($result))
                                    {
                                        if($row['isAvailable'] == 1)
                                        {
                            ?>
                             <option value=<?php echo $row['itemid']; ?>|<?php echo $row['customname']; ?> > <?php echo $row['itemname']; ?> - <?php echo $row['customname']; ?> </option>";

                            <?php
                                        }
                                    }
                                }
                            ?>	  
                            <input name="addit" type='submit' value ='Add Item to Cart'> 
                        </form>
                        
                        <?php
                            if(isset($_POST['addit']))
                            {
                                $timestamp = date('Y-m-d H:i:s');
                                $explodevalue = explode('|',$_POST['selectitem']);
                                $queryx = " select m.restaurantID,m.menuID,i.itemid,ii.itemname,c.customname,c.price
                                            from menu m, restaurant r,menuitems i,item ii,customitem c
                                            where m.restaurantID = r.restaurantID
                                            AND ii.itemid = i.itemid
                                            AND i.restaurantID = m.restaurantID
                                            AND m.menuID = i.menuID
                                            AND r.restaurantname = '".$_SESSION['currentmenu']."'
                                            AND m.menutype = '".$time."'
                                            AND i.itemid = c.itemid
                                ";
                                $query2 = $queryx . " AND i.itemid = '".$explodevalue[0]."' AND c.customname = '".$explodevalue[1]."'   ";
                                $runquery2 = mysqli_query($conn,$query2);
                                if(mysqli_num_rows($runquery2) > 0)
                                    {
                                       $row = mysqli_fetch_array($runquery2);
                                       $insertquery = "
                                       INSERT INTO `shoppingcart`(`username`, `restaurantID`, `menuID`, `itemID`,
                                                                  `itemname`, `customname`, `price`, `timestamp`) 
                                       VALUES ('".$_SESSION['username']."','".$row['restaurantID']."',
                                               '".$row['menuID']."','".$row['itemid']."',
                                               '".$row['itemname']."','".$row['customname']."',
                                               '".$row['price']."','".$timestamp."')";
                                        $runinsertquery = mysqli_query($conn,$insertquery);
                                    }
                            }
                        
                        ?>
  
                </div>
            </header>
        </body>


</html>

