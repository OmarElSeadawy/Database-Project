<!-- <?php
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
    <link rel="stylesheet" type="text/css" media="screen" href="css/index.css">
    <script src="js/index.js"></script>
</head>
<body style="background-color:#bdc3c7">
	<div id="main-wrap">
        <center>
            <h2>Homepage</h2>
            <h3>Welcome
            <?php echo $_SESSION['username']?>
             to Food&Chill </h3>
            <img src="css/avatar.png" alt="Avatar" class="avatar">   
        </center>
    
        
        <form class="form" action="homepage.php" method="post">
            <input name="logout" type="submit" id="logout_button" value="Logout"/>
        </form>
     
     
     <?php 
        if(isset($_POST['logout']))
        {
            session_destroy();
            header('location:index.php');
        }
     ?>

    </div>


</body>
</html> -->