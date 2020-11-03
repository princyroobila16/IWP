<!DOCTYPE html>
<html lang="en" >

<head>
  <meta charset="UTF-8">
  <title>Sign-Up Form</title>
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
	$nameErr=$nameErr2=$socialErr=$mailErr=$passErr=$repassErr="";
	$errMSG="";
	if(isset($_POST["Submit"])&&$_SERVER["REQUEST_METHOD"]=="POST")
	{

		// clean user inputs to prevent sql injections
		$firstname = trim($_POST['firstname']);
		$firstname = strip_tags($firstname);
		$firstname = htmlspecialchars($firstname);

		$lastname = trim($_POST['lastname']);
		$lastname = strip_tags($lastname);
		$lastname = htmlspecialchars($lastname);

		$mail = trim($_POST['mail']);
		$mail = strip_tags($mail);
		$mail = htmlspecialchars($mail);
		
		
		if(isset($_POST['gender']))
		{
		$gender = trim($_POST['gender']);
		}
		else
			$gender="NULL";
		
		
		if(isset($_POST['social'])&&strlen($_POST['social'])>1)
		{
		$social = trim($_POST['social']);
		$social = strip_tags($social);
		$social = htmlspecialchars($social);
		}
		else
			$social="NULL";
		
		$pass = trim($_POST['pass']);
		$pass = strip_tags($pass);
		$pass = htmlspecialchars($pass);
		
		$repass = trim($_POST['repass']);
		$repass = strip_tags($repass);
		$repass = htmlspecialchars($repass);
		
		$name= $firstname." ".$lastname;
		// basic name validation
		if (empty($firstname)or(empty($lastname))) {
			$error = true;
			$nameErr = "Please enter your full name.";
		} else if (strlen($name) < 3) {
			$error = true;
			$nameErr = "Name must have atleat 3 characters.";
		} else if (!preg_match("/^[a-zA-Z ]+$/",$name)) {
			$error = true;
			$nameErr = "Name must contain alphabets and space.";
		}
		
		//social handel validation
		if($social!='NULL'&&$social[0]!='@') {
			$error=true;
			$socialErr="Social media handle should start with @";
		}

		//basic email validation
		if (empty($mail)) {
			$error = true;
			$mailErr = "Please enter your email address.";
		}
		else if (!preg_match("/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/",$mail)) {
			$error = true;
			$mailErr = "Please enter valid email address.";
		} else {
			// check email exist or not
			$query = "SELECT email FROM user WHERE email='$mail'";
			$result = mysqli_query($conn,$query);
			$count = mysqli_num_rows($result);
			if($count!=0){
				$error = true;
				$mailErr = "Provided Email is already in use.";
			}
		}
		// password validation
		if (empty($pass)){
			$error = true;
			$passErr = "Please enter password.";
		} else if(strlen($pass) < 6) {
			$error = true;
			$passErr = "Password must have atleast 6 characters.";
		}
		
		//re-enteres password validation
		if (empty($repass)){
			$error = true;
			$repassErr = "Please re-enter password.";
		} else if(strlen($repass) < 6) {
			$error = true;
			$repassErr = "Password must have atleast 6 characters.";
		}  else if ($pass!=$repass) {
			$error=true;
			$repassErr="Passwords don't match.";
		}

		// password encrypt using SHA256();
		/*
		$password = hash('sha256', $pass);
		*/
		// if there's no error, continue to signup
		if( !$error ) {

			$query = "INSERT INTO user(fname,lname,gender,social_media,password,email) VALUES('$firstname','$lastname', '$gender', '$social', '$pass','$mail')";
			$res = mysqli_query($conn,$query);

			if ($res) {
				$errTyp = "success";
				$errMSG = "Successfully registered...!!<br>Name:<i> $name</i><br>E-mail: <i>$mail</i>
				<br><br><center><a href='loginf.php'><button>Proceed to Login</button></a></center>";
				
				if($gender=="NULL")
				{
				$res2=$conn->query("UPDATE user SET gender=NULL WHERE email='$mail'")
	or die($mysqli->error);
				}
				if($social=="NULL")
				{
				$res2=$conn->query("UPDATE user SET social_media=NULL WHERE email='$mail'")
	or die($mysqli->error);
				}
				unset($firstname);
				unset($lastname);
				unset($mail);
				unset($pass);
				unset($gender);
				unset($social);
			} else {
				$errTyp = "danger";
				$errMSG = "Something went wrong, try again later...";
			}
			

		}
	}
	?>
	<div class="container">
	<center><h1>SIGN UP</h1></center>
	<form name="signupform" method="post">
<span class="error">*</span>First Name<br>
<input type="text" name="firstname">
<br>
<?php echo "<div class='error'>"; echo $nameErr2; echo "</div><br>"; ?>
<span class="error">*</span>Last Name<br>
<input type="text" name="lastname">
<br>
<?php echo "<div class='error'>"; echo $nameErr; echo "</div><br>"; ?>
Gender<br>
<input type="radio" name="gender" value="M">Male</input>
<input type="radio" name="gender" value="F">Female</input>
<input type="radio" name="gender" value="N">Other</input>
<br><br>
Social media handle<br>
<input type="text" name="social" value="@">
<?php echo "<div class='error'>"; echo $socialErr; echo "</div><br>"; ?>

<span class="error">*</span>Email<br>
<input type="text" name="mail">
<br>
<?php echo "<div class='error'>"; echo $mailErr; echo "</div><br>"; ?>
<span class="error">*</span>Password<br>
<input type="password" name="pass">
<br>
<?php echo "<div class='error'>"; echo $passErr; echo "</div><br>"; ?>
<span class="error">*</span>Re-enter Password<br>
<input type="password" name="repass">
<br>
<?php echo "<div class='error'>"; echo $repassErr; echo "</div><br>"; ?>
<center><input type="submit" name="Submit" value="Submit"></center>
</form>

<div class="error">* Required</div>

<?php if ($errMSG==''){?>
<br>
<center>
<p class="blue">Already have an account?</p>
<a href="signupf.php"><button>Log in</button></a>
</center>
<?php }
else{
 echo $errMSG;
}
?>

<a href="toprated.php" class='blue'>&larr; Go back Home</a>
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
  height: 670px;
  position: absolute;
  top: 0;
  right: 0;
  bottom: 0;
  left: 0;
  margin: auto;
  background: #212b3b;
  padding: 1% 3%;
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
input[type=submit], button{
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
.blue{
	color: #66b3ff;
}
a{
	text-decoration: none;
}
 </style> 
 
</body>
</html>