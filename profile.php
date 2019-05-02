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
                            <li onclick="window.location.href='index.php'"> <a>Logout</a></li>
                    </ul>
                </div>

                <?php
                $query = "select * from user where username = '" . $_SESSION["username"] ."' ";
                    
                
                $result = mysqli_query($conn, $query);

                if(mysqli_num_rows($result) > 0)
				{
					while($row = mysqli_fetch_array($result))
					{
                       $_SESSION['currentpassword'] = $row['password'];
				?>

                <div class="welcome"> 
                    <h3> Username : <?php echo $row["username"]; ?> </h3> 
                    <h3> Birthdate : <?php echo $row["bdate"]; ?> </h3>  
                    <h3> First Name : <?php echo $row["fname"]; ?> </h3>  
                    <h3> Last Name : <?php echo $row["lname"]; ?> </h3>  
                    <h3> Gender : <?php echo $row["gender"]; ?> </h3>  
                    <h3> Email : <?php echo $row["email"]; ?> </h3> 
                    <h3> Usertype :
                    <?php if($row["usertype"] == 0)
                            echo "Administrator Account";
                          else if($row["usertype"] == 1)
                            echo "Ordering Staff Account"; 
                          else
                            echo "Enduser Account";  ?> </h3>
                        
			<?php
					}
                }
                else
                {
                   echo '<script type="text/javascript"> alert("Failure") </script>';        
                }
                
                echo "<a href='myorders.php' style='color:#ccc000'> My Orders </a>";
                echo "<br>";
                echo "<a href='modifyaccount.php' style='color:#ccc000'> Modify Information </a>";
                echo "<br>";
                echo "<a href='changepassword.php' style='color:#ccc000'> Change Password </a>";
                echo "<br>";
                echo "<a href='manageaddresses.php' style='color:#ccc000'> Manage Addresses </a>";
			?>

            </div>

            </header>

        </body>


</html>