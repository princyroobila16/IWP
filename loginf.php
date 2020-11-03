<!DOCTYPE html>
<html lang="en" >

<head>
  <meta charset="UTF-8">
  <title>Login Form</title>
  </head>

<body>
 
 <?php
	
	session_start();
 
	define('DBHOST', 'localhost');
	define('DBUSER', 'root');
	define('DBPASS', '');
	define('DBNAME', 'project');
 
	$conn = mysqli_connect(DBHOST,DBUSER,DBPASS, DBNAME) or die("Connection failed : ");
	
	$error=false;
	?>
	
<?php
$errMSG2="";
if(isset($_POST["Submit"])&&$_SERVER["REQUEST_METHOD"]=="POST")
{
		
		$error2=false;

		$email = trim($_POST['mail']);
		$email = strip_tags($email);
		$email = htmlspecialchars($email);

		$lpass = trim($_POST['pass']);
		$lpass = strip_tags($lpass);
		$lpass = htmlspecialchars($lpass);

		if(empty($email)){
			$error2 = true;
			$errMSG2 = "Please enter your email address.";
		} else if ( !filter_var($email,FILTER_VALIDATE_EMAIL) ) {
			$error2 = true;
			$errMSG2 = "Please enter valid email address.";
		}

		else if(empty($lpass)){
			$error2 = true;
			$errMSG2 = "Please enter your password.";
		}
		
		if (!$error2) {

			/*
			$password2 = hash('sha256', $lpass); // password hashing using SHA256
			*/
			$res2=mysqli_query($conn,"SELECT fname, lname, password FROM user WHERE email='$email'");
			$row2=mysqli_fetch_array($res2);
			$count2 = mysqli_num_rows($res2); // if uname/pass correct it returns must be 1 row

			if($count2<1)
				$errMSG2="Email does not exist.";
			else if($row2['password']!=$lpass)
				$errMSG2="Invalid Password";
			else{
				$_SESSION['user'] = $email;
				header("Location: toprated.php");
				$errMSG2="Logged in";
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
<center><B>LOG IN</B></center>
<br>
<form name="loginform" method="post">
<span class="error">*</span>Email
<input type="email" name="mail">
<br><br>
<span class="error">*</span>Password
<input type="password" name="pass">
<br><br>
<?php echo "<div class='error'>"; echo $errMSG2; echo "</div><br>"; ?>
<center><input type="submit" name="Submit" value="Log in"></center>
</form>
<div class="error">* Required</div>
<br>
<center>
<p class="blue">Don't have an account yet?</p>
<a href="signupf.php"><button>Sign Up Now!!</button></a>
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