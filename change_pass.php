<!DOCTYPE html>
<html lang="en" >

<head>
  <meta charset="UTF-8">
  <title>Change Password</title>
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
	$error=false;
	?>
	
<?php
$errMSG2="";
if(isset($_POST["Submit"])&&$_SERVER["REQUEST_METHOD"]=="POST")
{
		
		$error2=false;

		$oldpass = trim($_POST['oldpass']);
		$oldpass = strip_tags($oldpass);
		$oldpass = htmlspecialchars($oldpass);

		$pass = trim($_POST['pass']);
		$pass = strip_tags($pass);
		$pass = htmlspecialchars($pass);
		
		$repass = trim($_POST['repass']);
		$repass = strip_tags($repass);
		$repass = htmlspecialchars($repass);

		if(empty($oldpass)){
			$error2 = true;
			$errMSG2 = "Please enter your current password.";
		} 

		else if(empty($pass)||empty($repass)){
			$error2 = true;
			$errMSG2 = "Please enter your new password in both fields.";
		}
		else if($repass!=$pass){
			$error2 = true;
			$errMSG2 = "New passwords don't match.";
		}
		
		if (!$error2) {

			/*
			$password2 = hash('sha256', $lpass); // password hashing using SHA256
			*/
			$res2=mysqli_query($conn,"SELECT password FROM user WHERE email='$email'");
			$row2=mysqli_fetch_array($res2);
			
			if($row2['password']!=$oldpass)
				$errMSG2="Current Password is Incorrect";
			else{
				$res2=mysqli_query($conn,"UPDATE user SET password='$pass' WHERE email='$email'");
				$errMSG2="Password changed!";
			}
			/*if( $count2 == 1 && $row2['password']==$lpass) {
				$_SESSION['user'] = $email;
				header("Location: masonrytry.php");
				$errMSG2="Logged in";
			} else {
				$errMSG2 = "Incorrect Credentials";
			}*/

		}
	}
 
?>
<div class="container">
<center><B>CHANGE PASSWORD</B></center>
<br>
<form name="form1" method="post">
<span class="error">*</span>Current Password
<input type="password" name="oldpass">
<br><br>
<span class="error">*</span>New Password
<input type="password" name="pass">
<br><br>
<span class="error">*</span>Re-enter New Password
<input type="password" name="repass">
<br><br>
<?php echo "<div class='error'>"; echo $errMSG2; echo "</div><br>"; ?>
<center><input type="submit" name="Submit" value="Change password"></center>
</form>
<div class="error">* Required</div>
<br>
<center>
</center>
<a href="toprated.php" class='blue'>&larr; Go back Home</a>
<br>
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
  width: 400px;
  height: 420px;
  position: absolute;
  top: 0;
  right: 0;
  bottom: 0;
  left: 0;
  margin: auto;
  background: #212b3b;
  padding: 10px 10px;
  font-size: 20px;
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
.blue{
	color: #66b3ff;
}
a{
	text-decoration: none;
}
 </style>
</body>
</html>