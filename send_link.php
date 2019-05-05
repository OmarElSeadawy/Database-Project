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
    
        <?php

if(isset($_POST['submitmail']) && $_POST['email'])
{
  $select = "select email,password from user where email='".$email."' ";
  $runquery = mysqli_query($conn,$select);

  if(mysql_num_rows($runquery)==1)
  {
    while($row=mysql_fetch_array($runquery))
    {
      $email=md5($row['email']);
      $pass=md5($row['password']);
    }
    $link="<a href='reset.php?key='".$email."'&reset='".$pass."''>Click To Reset password</a>";
    require_once('PHPMailer-master/src/PHPMailer.php');
    $mail = new PHPMailer();
    $mail->CharSet =  "utf-8";
    $mail->IsSMTP();
    // enable SMTP authentication
    $mail->SMTPAuth = true;                  
    // GMAIL username
    $mail->Username = "ikazlac@gmail.com";
    // GMAIL password
    $mail->Password = "afk4lifE";
    $mail->SMTPSecure = "ssl";  
    // sets GMAIL as the SMTP server
    $mail->Host = "smtp.gmail.com";
    // set the SMTP port for the GMAIL server
    $mail->Port = "465";
    $mail->From='ikazlac@gmail.com';
    $mail->FromName='your_name';
    $mail->AddAddress($email, 'No-Reply');
    $mail->Subject  =  'Reset Password';
    $mail->IsHTML(true);
    $mail->Body    = 'Click On This Link to Reset Password '.$pass.'';
    if($mail->Send())
    {
      echo "Check Your Email and Click on the link sent to your email";
    }
    else
    {
      echo "Mail Error - >".$mail->ErrorInfo;
    }
  }	
}
?>
    </div>


</body>
</html>