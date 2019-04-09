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
                    
                    <!-- <div>    
                    <form action='startorder.php' method='post' name='filter' > 
                    <select name="filter"> 
                        <option value="Pizza">Pizza</option> 
                        <option value="Fried Chicken">Fried Chicken</option> 
                    </select> 
                    <br/> 
                    <input name="filter" type='submit' value ='filter'> 
                    </form>
                    </div>
                     -->
                </div>

                <?php
                $query = "select r.restaurantname, c.cuisineType from restaurant r, restaurantcuisine c where r.restaurantid = c.restaurantid";
                    
                
                $result = mysqli_query($conn, $query);
                $restaurantsarray = array();

                if(mysqli_num_rows($result) > 0)
				{
					while($row = mysqli_fetch_array($result))
					{
                        $restaurantsarray[$row["restaurantname"]] = $row["restaurantname"];
				?>
			<div class="col-md-1">
				<form class = "form" method="post" action="startorder.php">
                <div style="border:1px solid #333; background-color:transparent; border-radius:3px; padding:4px;" align="center">
						<img src="css/images/<?php echo $row["restaurantname"]; ?>.png" class="restaurantimg" />
						<h4 class="info"><?php echo $row["restaurantname"]; ?></h4>
						<h4 class="info"><?php echo $row["cuisineType"]; ?></h4>
						<input type="hidden" name="hidden_name" value="<?php echo $row["restaurantname"]; ?>" />
						<input type="hidden" name="hidden_price" value="<?php echo $row["cuisineType"]; ?>" />
						<input type="submit" name="currentrestaurant" style="margin-top:5px;" class="btn btn-success" value="<?php echo $row["restaurantname"]; ?>" />
					</div>
				</form>
			</div>
			<?php
					}
                }
                else
                {
                   echo '<script type="text/javascript"> alert("Failure to show restaurants") </script>';        
                }
			?>
            </header>
        </body>
        
        <?php
        if ($_SERVER['REQUEST_METHOD'] === 'POST')
        {
            $_SESSION["currentmenu"] = $_POST["currentrestaurant"];
            echo $_POST["currentrestaurant"];
            header('location:menu.php');
        }    
        ?>



</html>