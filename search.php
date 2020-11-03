<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	
	<!-- Bootstrap core CSS -->
    <link href="dist_orig/css/bootstrap.css" rel="stylesheet">
	
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Permanent+Marker">
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Acme">
	
	<title>
	Search
	</title>
	
  </head>
  
  <body>
  <style>
  body{
    background: url("img/bg.jpg") no-repeat top center fixed;
    background-size: cover;
    margin: 0;
    padding-left: 20px; padding-right: 20px;
    height: 100%;
    width: 100%;
}
</style>

<?php
	$host='localhost';
	$user='root';
	$pass='';
	$db='project';
	
	$name='';
	
	session_start();
	
	$mysqli= new mysqli($host, $user, $pass, $db);
	
	if (isset($_SESSION['user']))
	{
		$result=$mysqli->query("SELECT fname,lname FROM user WHERE email='".$_SESSION['user']."'")
		or die($mysqli->error);
		$row2=$result->fetch_assoc();
		$name=$row2['fname']." ".$row2['lname'];
	}
	?>

<!--Navbar-->
  <nav class="navbar navbar-expand-lg navbar-dark" style="background-color: none; ">
  <p class="navbar-brand" style="font-family: Acme;">iMovies</p>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item">
        <a class="nav-link" href="toprated.php">Home </a>
      </li>
      <!--<li class="nav-item">
        <a class="nav-link" href="masonrytry.php">Top Rated<span class="sr-only">(current)</span></a>
      </li>-->
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          By Genre
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <!--<a class="dropdown-item" href="#">Action</a>
          <a class="dropdown-item" href="#">Horror</a>-->
          <a class="dropdown-item" href="romcom.php">RomCom</a>
		  <a class="dropdown-item" href="scifi.php">Sci-Fi</a>
      </li>
    </ul>
	</div>
    <form class="form-inline my-2 my-lg-0" action="search.php" method="POST">
      <input class="form-control mr-sm-2" name="to_search" type="text" placeholder="Search" aria-label="Search">
      <button class="btn btn-outline-light my-2 my-sm-0" type="submit">Search</button>
    </form>
	&nbsp; &nbsp; &nbsp;
	<?php 
		if (isset($_SESSION['user'])){
		?>
	<a href="logout.php"><button type="button" class="btn btn-dark" style="font-family: Calibri; font-weight: bold; background-color: black;"> Log out </button></a>
	&nbsp; 
	<a href="account.php"><button type="button" class="btn btn-dark" style="font-family: Calibri; font-weight: bold; background-color: black;"> Account Settings </button></a>
	
		<?php }
		else{
			?>
    <a href="loginf.php"><button type="button" class="btn btn-dark" style="font-family: Calibri; font-weight: bold; background-color: black;"> Log-in </button></a>
	&nbsp; 
	<a href="signupf.php"><button type="button" class="btn btn-dark" style="font-family: Calibri; font-weight: bold; background-color: black;"> Sign-Up </button></a>
	<?php } ?>
	</div>
	</nav>  
	<?php 
		if (isset($_SESSION['user'])){
			echo "<div style='float: right; font-family: penna; font-size: 24px;'><button style='color: #fffa6e;'><i><b>Welcome, ".$name."</i></b>&nbsp; &nbsp;</button></div>";
		}
		?>
 <h1 style="color: white; font-family: Proza;"><i>Search Results</h1>
<br><br>
 <?php

	$movie=$_POST['to_search'];
	$mv=str_replace(' ', '%20', $movie);
	$json_str=file_get_contents("http://www.omdbapi.com/?apikey=bf057abd&t=$mv");
	//echo "$json_str";
	$parsed_json = json_decode($json_str, true);
	if($parsed_json['Response']=='False')
	
		echo "<center><button>Your search request had no results</button></center>";
	else
	{
?>

 <div class="row align-items-center justify-content-center" style="margin-left:5%; margin-right:5%;">
	<div class="card" style="width: 12rem;">
	<center>
	<img class="card-img" src="<?php echo $parsed_json['Poster']; ?>" style="width: 90%; height: 90%;" data-toggle="modal" data-target="#mod1">
	<div class="middle">
    <div class="fadeintext"><?php echo $parsed_json['Title'];?></div>
	</div>
	</center>
	</div>
  </div>
  
  <!--Modal-->
  <div class="modal fade" id="mod1" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text-uppercase" id="exampleModalCenterTitle" style="font-family: Permanent Marker;"><?php echo $parsed_json['Title']; ?> (<?php echo $parsed_json['Year']; ?>)</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
	  <div class="container-fluid">
        <div class="row">
			  <div class="col-md-4">
				<img src="<?php echo $parsed_json['Poster']; ?>" width="100%">
			  </div>
			  <div class="col-md-8 ml-auto">
				<div class="row">
				  <div class="col-md-4">
					<?php echo $parsed_json['Runtime']; ?>
				  </div>
				  <div class="col-md-4">
					<?php echo $parsed_json['Genre']; ?>
				  </div>
				  <div class="col-md-4">
					IMDb: <?php echo $parsed_json['imdbRating']; ?>/10
				  </div>
				 </div>
				 <div class="row">
				   Stars: <?php echo $parsed_json['Actors']; ?>
				 <br><br>
				   <?php echo $parsed_json['Plot']; ?>
			  </div>
			 </div>
            </div>
      </div>
	  </div>
      <div class="modal-footer justify-content-center">
        <a href="comment.php?page=<?php echo $parsed_json['Title']; ?>"><button type="button" class="btn btn-dark" style="font-family: Calibri; font-weight: bold;">  View comments  </button></a>
	  </div>
    </div>
  </div>
</div>
	<?php } ?>
<style>
.card-img {
  opacity: 1;
  transition: .5s ease;
  backface-visibility: hidden;
}

.middle {
  transition: .5s ease;
  opacity: 0;
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  -ms-transform: translate(-50%, -50%)
}

.card:hover .card-img {
  bgcolor:white;
  opacity: 0.3;
}

.card:hover .middle {
  opacity: 1;
}

.fadeintext {
  font-family: Permanent Marker;
  color: white;
  font-size: 1.5em;
 
}
button{
	text-align: center;
	background-color: black;
	border-radius: 2px;
  border: 0;
  text-decoration: none;
  font-size: 20px;
  color: white;
  padding: 5px 24px;
  margin: auto;
}
</style> 
 
 <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js" integrity="sha384-smHYKdLADwkXOn1EmN1qk/HfnUcbVRZyYmZ4qpPea6sjB/pTJ0euyQp0Mk8ck+5T" crossorigin="anonymous"></script>

  </body>
</html>