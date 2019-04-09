<?php 
    require 'dbconfig/dbconn.php';
 ?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Registration Page</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" media="screen" href="css/index.css">
    <script src="js/index.js"></script>
</head>
<body style="background-color:#bdc3c7">
	<div id="main-wrap">
        <center>
            <h2>Registration Form</h2>
            <img src="css/avatar.png" alt="Avatar" class="avatar">   
        </center>
    
        
        <form class="form" action="register.php" method="post">
            <label><b> Username: </b></label><br>
            <input name="username" type="text" class="inputvalues" placeholder="Please Enter Username" required/><br>
            <label><b> Password: </b></label><br>
            <input name="password" type="password" class="inputvalues" placeholder="Your Password" required/><br>
            <label><b> Confirm Password: </b></label><br>
            <input name="cpassword" type="password" class="inputvalues" placeholder="Confirm Your Password" required/><br>

            <label><b> Birthdate: </b></label><br>
            <input name="birthdate" type="date" class="inputvalues" placeholder="Enter Your birthdate" required/><br>

            <label><b> Gender: </b></label><br>
            <input name="gender" type="radio" class="radiovalues" value="M" checked> M<br>
            <input name="gender" type="radio" class="radiovalues" value="F"> F<br>
            
            <label><b> First Name: </b></label><br>
            <input name="fname" type="text" class="inputvalues" placeholder="Please Enter your First Name" required/><br>
            
            <label><b> Last Name: </b></label><br>
            <input name="lname" type="text" class="inputvalues" placeholder="Please Enter your Last Name" required/><br>

            <label><b> Email: </b></label><br>
            <input name="email" type="email" class="inputvalues" placeholder="Please enter your Email" required/><br>

            <input name="submit_button" type="submit" id="register_button" value="Register"/><br>
            <a href="index.php"><input type="button" id="backtologin_button" value="Back to Login"/></a>

        </form>

        <?php 
            if(isset($_POST['submit_button']))
                {
                    $username = $_POST['username'];
                    $password = $_POST['password'];
                    $cpassword = $_POST['cpassword'];
                    $bdate = date('Y-m-d', strtotime(str_replace('-', '/', $_POST['birthdate'])));
                    $gender = $_POST['gender'];
                    $usertype = "2";
                    $fname = $_POST['fname'];
                    $lname = $_POST['lname'];
                    $email = $_POST['email'];
                    $isActive = "1";
                
                    if($password == $cpassword)
                    {
                        $query = "select * from user WHERE username='$username'";
                        $query_run = mysqli_query($conn,$query);


                        if(mysqli_num_rows($query_run) > 0)
                        {
                            echo '<script type="text/javascript"> alert("User already exists") </script>';
                        }
                        else
                        {
                           
                           $query = "INSERT INTO user (`UUID`, `username`, `password`, `bdate`, `gender`, `usertype`, `fname`,
                             `lname`, `email`, `isActive`) 
                             VALUES (NULL, '".$username."', '".$password."', '".$bdate."', '".$gender."' , '".$usertype."', '".$fname."', '".$lname."', '".$email."', '".$isActive."')";

                            if (!mysqli_query($conn, $query)) {
                                printf("Errormessage: %s\n", mysqli_error($conn));
                            }
                            else
                            {
                                echo '<script type="text/javascript"> alert("User Registered") </script>';
                            }
                        }
                    }
                    else
                    {
                        echo '<script type="text/javascript"> alert("Passwords dont match") </script>';
                    }
                }
        ?>
    </div>


</body>
</html>