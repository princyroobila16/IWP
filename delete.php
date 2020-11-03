<!DOCTYPE html>
<html lang="en" >

<head>
  <meta charset="UTF-8">
  <title>18BCB0157 Account</title>
  </head>

<body>
 
 <?php
	
	session_start();
 
	define('DBHOST', 'localhost');
	define('DBUSER', 'root');
	define('DBPASS', '');
	define('DBNAME', 'project');
 
	$conn = mysqli_connect(DBHOST,DBUSER,DBPASS, DBNAME) or die("Connection failed : ");
	
	$email=$_SESSION['user'];
	$res2=mysqli_query($conn,"DELETE FROM user WHERE email='$email'");
	if($res2){
		$msg="Your account has been deleted.<br>Join us again soon!!";
		unset($_SESSION['user']);
		session_unset();
		session_destroy();
	}
	else
		$msg="An error was encountered while trying to delete your account."
	?>
	
	<div class="container">
	<?php echo $msg; ?>
	<br><br>
	<center><a href="toprated.php"><button>Back to homepage</button></a></center>
	</div>
<style>
  body{
    background: url("img/bg4.jpg") no-repeat top center fixed;
    background-size: cover;
    margin: 0;
    padding-left: 5%; padding-right:5%;
	padding-top: 2%;
    height: 100%;
    width: 100%;
	color: #c7cbd1;
	overflow-x: hidden;
}
.error{color: red; }
.container {
  width: 300px;
  height: 300px;
  position: absolute;
  top: 0;
  right: 0;
  bottom: 0;
  left: 0;
  margin: auto;
  background: #212b3b;
  padding: 10px 10px;
  font-size: 20px;
  }
 button{
	text-align: center;
	background-color: black;
	border-radius: 2px;
  border: 0;
  text-decoration: none;
  font-size: 12px;
  color: white;
  padding: 5px 24px;
  margin: auto;
}
 </style>
</body>
</html>