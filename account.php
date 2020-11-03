<!DOCTYPE html>
<html lang="en" >

<head>
  <meta charset="UTF-8">
  <title>18BCB0159 Account</title>
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
	$res2=mysqli_query($conn,"SELECT fname, lname, gender, social_media FROM user WHERE email='$email'");
			$row2=mysqli_fetch_array($res2);
			
			
			
	if (isset($_POST['submit']))
	{
		$sql="UPDATE user SET fname='".$_POST['fname']."',lname='".$_POST['lname']."', gender='".$_POST['gender']."', social_media='".$_POST['social']."'  WHERE email='$email'";
		$result=$conn->query($sql)		
		or die($conn->error);
		header("Refresh:0");
	}
	?>
	
	<!--<div class="container">
	<center style="color: white; "><b>ACCOUNT DETAILS</b></center>
	<br><br>
	<?php //echo "Name: <i>".$row2['fname']." ".$row2['lname']."</i><br><br>Email: <i>".$row2['email']."</i>"; ?>
	<br><br>
	<center><a href="delete.php"><button>Delete Account</button></a></center>
	</div>-->
	
	<div class="container">
	<center style="color: white; "><h2>ACCOUNT DETAILS</h2></center>
	<br><br>
	<form method="post" action="<?php $_PHP_SELF ?>">
	First Name: 
	<br>
	<input type="text" name="fname" value="<?php echo $row2['fname'];?>">
	<br><br>
	Last Name:
	<br>	
	<input type="text" name="lname" value="<?php echo $row2['lname'];?>">
	<br><br>
	Gender:<br>
<input type="radio" name="gender" value="M" <?php if($row2['gender']=='M') echo "checked"; ?>>Male</input>
<input type="radio" name="gender" value="F" <?php if($row2['gender']=='F') echo "checked"; ?>>Female</input>
<input type="radio" name="gender" value="N" <?php if($row2['gender']=='N') echo "checked"; ?>>Other</input>
<br><br>
Social Media Handle:<br>
<input type="text" name="social" value="<?php echo $row2['social_media'];?>">
<br><br>
Email: 
	<br>
	<input type="text" name="mail" value="<?php echo $email;?>" disabled>
	<br><br>
	<center><input type="submit" name="submit" value="Save"></center>
</form>
<br><br>
<center>
<a href="change_pass.php"><button>Change Password</button></a>
<a href="delete.php"><button>Delete account</button></a>	
</center>
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
  width: 500px;
  height: 550px;
  position: absolute;
  top: 0;
  right: 0;
  bottom: 0;
  left: 0;
  margin: auto;
  background: #212b3b;
  padding: 3% 3%;
  font-size: 16px;
  border: 1px solid white;
  }
input[type=text], input[type=password], input[type=email] {
  border-radius: 2px;
  border: 0;
  text-decoration: none;
  color: white;
  padding: 5px 24px;
  width: 80%;
  background-color: #212b3b;
  border: 1px solid #8c8e91;
}
input[type=text]:disabled{
  opacity: 0.5;
}
input[type=submit]{
	text-align: center;
	background-color: #324c73;
	border-radius: 2px;
  border: 0;
  text-decoration: none;
  font-size: 12px;
  color: white;
  padding: 5px 24px;
  margin: auto;
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