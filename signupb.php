<!DOCTYPE html>
<html lang="en" >

<head>
  <meta charset="UTF-8">
  <title>Sign-Up/Login Form</title>
  <link href='https://fonts.googleapis.com/css?family=Titillium+Web:400,300,600' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Acme">
  
      <link rel="stylesheet" href="logsign/css/style.css">
      <link href="dist_search/css/bootstrap.css" rel="stylesheet">
  
</head>

<body>
<style>
  body{
    background: url("img/bg4.jpg") no-repeat top center fixed;
    background-size: cover;
    margin: 0;
    padding-left: 5%; padding-right:5%;
	padding-top: 2%;
    height: 100%;
    width: 100%;
}
 </style> 
 
  <?php
	
	session_start();
 
	define('DBHOST', 'localhost');
	define('DBUSER', 'root');
	define('DBPASS', '');
	define('DBNAME', 'project');
 
	$conn = mysqli_connect(DBHOST,DBUSER,DBPASS, DBNAME) or die("Connection failed : ");
	
	$error=false;
	?>
	
	<!--Navbar-->
  <nav class="navbar navbar-expand-lg navbar-dark">
  <a class="navbar-brand" href="#" style="font-family: Acme;">iMovies</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item">
        <a class="nav-link" href="#">Home </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="masonrytry.php">Top Rated<span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          By Genre
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="#">Action</a>
          <a class="dropdown-item" href="#">Horror</a>
          <a class="dropdown-item" href="#">Romedy</a>
		  <a class="dropdown-item" href="#">Sci-Fi</a>
      </li>
    </ul>
    <form class="form-inline my-2 my-lg-0" action="search.php" method="POST">
      <input class="form-control mr-sm-2" name="to_search" type="text" placeholder="Search" aria-label="Search">
      <button class="btn btn-outline-light my-2 my-sm-0" type="submit">Search</button>
    </form>
  </div>
</nav>  
 
 <?php
 if(isset($_GET['stat']))
 {$stat=$_GET['stat'];}
	$act='active';
	if($stat==-1){?>
	<h4 style="color: white;"><center>
	<?php echo "Invalid input!"; ?> </center></h4>
	<?php }
	else if($stat==2) { ?>
	<h4 style="color:white;"><center>
	<?php echo "Invalid email/password";?></center></h4>
	<?php }?>
 

	<?php
	if ( isset($_POST['action']) ) {

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
		
		$pass = trim($_POST['pass']);
		$pass = strip_tags($pass);
		$pass = htmlspecialchars($pass);
		
		$name= $firstname." ".$lastname;
		// basic name validation
		if (empty($firstname)or(empty($lastname))) {
			$error = true;
			$errMSG = "Please enter your full name.";
		} else if (strlen($name) < 3) {
			$error = true;
			$errMSG = "Name must have atleat 3 characters.";
		} else if (!preg_match("/^[a-zA-Z ]+$/",$name)) {
			$error = true;
			$errMSG = "Name must contain alphabets and space.";
		}

		//basic email validation
		if ( !filter_var($mail,FILTER_VALIDATE_EMAIL)or empty($mail )) {
			$error = true;
			$errMSG = "Please enter valid email address.";
		} else {
			// check email exist or not
			$query = "SELECT email FROM user WHERE email='$mail'";
			$result = mysqli_query($conn,$query);
			$count = mysqli_num_rows($result);
			if($count!=0){
				$error = true;
				$errMSG = "Provided Email is already in use.";
			}
		}
		// password validation
		if (empty($pass)){
			$error = true;
			$errMSG = "Please enter password.";
		} else if(strlen($pass) < 6) {
			$error = true;
			$errMSG = "Password must have atleast 6 characters.";
		}

		// password encrypt using SHA256();
		/*
		$password = hash('sha256', $pass);
		*/
		// if there's no error, continue to signup
		if( !$error ) {

			$query = "INSERT INTO user(fname,lname,password,email) VALUES('$firstname','$lastname','$pass','$mail')";
			$res = mysqli_query($conn,$query);

			if ($res) {
				$errTyp = "success";
				$errMSG = "Successfully registered, you may login now";
				unset($firstname);
				unset($lastname);
				unset($mail);
				unset($pass);
				header("Location: signupb.php?stat=1");
			} else {
				$errTyp = "danger";
				$errMSG = "Something went wrong, try again later...";
			}

		}
		else {
			header("Location: signupb.php?stat=-1");
		}
	}
	
	#for login:
	
	
	
	if( isset($_POST['action2']) ) {
		
		$error2=false;

		$email = trim($_POST['login_mail']);
		$email = strip_tags($email);
		$email = htmlspecialchars($email);

		$lpass = trim($_POST['login_pass']);
		$lpass = strip_tags($lpass);
		$lpass = htmlspecialchars($lpass);

		if(empty($email)){
			$error2 = true;
			$errMSG2 = "Please enter your email address.";
		} else if ( !filter_var($email,FILTER_VALIDATE_EMAIL) ) {
			$error2 = true;
			$errMSG2 = "Please enter valid email address.";
		}

		if(empty($lpass)){
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

			if( $count2 == 1 && $row2['password']==$lpass) {
				$_SESSION['user'] = $email;
				header("Location: masonrytry.php");
				$errMSG2="Logged in";
			} else {
				$errMSG2 = "Incorrect Credentials, Try again...";
				header("Location: signupb.php?stat=2");
			}

		}
	}
 
?>
 

  <div class="form">
      
      <ul class="tab-group">
        <li class="tab <?php if ($stat<=0) {echo $act;} ?>"><a href="#signup">Sign Up</a></li>
        <li class="tab <?php if ($stat>=1) {echo $act;} ?>"><a href="#login">Log In</a></li>
      </ul>
      
      <div class="tab-content">
	  <?php if($stat<=0) 
	  {
		  ?>
        <div id="signup">   
          <h1>Sign Up for Free</h1>
          
          <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
          
          <div class="top-row">
            <div class="field-wrap">
              <label>
                First Name<span class="req">*</span>
              <br></label>
              <input type="text" required autocomplete="off" name="firstname"/>
            </div>
        
            <div class="field-wrap">
              <label>
                Last Name<span class="req">*</span>
              </label>
              <input type="text"required autocomplete="off" name="lastname"/>
            </div>
          </div>

          <div class="field-wrap">
            <label>
              Email Address<span class="req">*</span>
            </label>
            <input type="email"required autocomplete="off" name="mail"/>
          </div>
          
          <div class="field-wrap">
            <label>
              Set A Password<span class="req">*</span>
            </label>
            <input type="password"required autocomplete="off" name="pass"/>
          </div>
          
          <button type="submit" class="button button-block" name="action"/>Go</button>
          
          </form>
		
        </div>
		
		<div id="login">   
          Welcome Back!
          
          <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
          
            <div class="field-wrap">
            <label>
              Email Address <span class="req">*</span>
            </label>
            <input type="email" name="login_mail" required autocomplete="off"/>
          </div>
          
          <div class="field-wrap">
            <label>
              Password<span class="req">*</span>
            </label>
            <input type="password" name="login_pass" required autocomplete="off"/>
          </div>
          
          
          <button class="button button-block" type="submit" name="action2"/>Log In</button>
          
          </form>
		  
        </div>
        <?php } ?>
	  <?php if($stat>=1) 
	  {
		  ?>
        <div id="login">   
          Welcome Back!
          
          <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
          
            <div class="field-wrap">
            <label>
              Email Address <span class="req">*</span>
            </label>
            <input type="email" name="login_mail" required autocomplete="off"/>
          </div>
          
          <div class="field-wrap">
            <label>
              Password<span class="req">*</span>
            </label>
            <input type="password" name="login_pass" required autocomplete="off"/>
          </div>
          
          
          <button class="button button-block" type="submit" name="action2"/>Log In</button>
          
          </form>
		  
        </div>
		
		<div id="signup">   
          <h1>Sign Up for Free</h1>
          
          <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
          
          <div class="top-row">
            <div class="field-wrap">
              <label>
                First Name<span class="req">*</span>
              <br></label>
              <input type="text" required autocomplete="off" name="firstname"/>
            </div>
        
            <div class="field-wrap">
              <label>
                Last Name<span class="req">*</span>
              </label>
              <input type="text"required autocomplete="off" name="lastname"/>
            </div>
          </div>

          <div class="field-wrap">
            <label>
              Email Address<span class="req">*</span>
            </label>
            <input type="email"required autocomplete="off" name="mail"/>
          </div>
          
          <div class="field-wrap">
            <label>
              Set A Password<span class="req">*</span>
            </label>
            <input type="password"required autocomplete="off" name="pass"/>
          </div>
          
          <button type="submit" class="button button-block" name="action"/>Go</button>
          
          </form>
		
        </div>
        
		<?php } ?>
		
      </div><!-- tab-content -->
      
</div> <!-- /form -->
		<?php  if (isset($errMSG)) {echo $errMSG;} ?>
		<?php if(isset($errMSG2)) {echo $errMSG2;} ?>
  <script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
    <script  src="logsign/js/index.js"></script>

</body>

</html>
