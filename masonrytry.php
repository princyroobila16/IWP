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
	Top Rated
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
	
	$mysqli= new mysqli($host, $user, $pass, $db);
	$result=$mysqli->query
		("SELECT * FROM top_rated WHERE num<=11")
		
		or die($mysqli->error);
?>
<?php
	session_start();
	?>

  <!--Navbar-->
  <nav class="navbar navbar-expand-lg navbar-dark" style="background-color: none; ">
  <a class="navbar-brand" href="#" style="font-family: Acme;">iMovies</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item">
        <a class="nav-link" href="#">Home </a>
      </li>
      <li class="nav-item active">
        <a class="nav-link" href="#">Top Rated<span class="sr-only">(current)</span></a>
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
        <a href="movies.html"><button type="button" class="btn btn-dark" style="font-family: Calibri; font-weight: bold; background-color: black;"> Watch movies </button></a><br><br>
         <a href="mail.html"><button type="button" class="btn btn-dark" style="font-family: Calibri; font-weight: bold; background-color: black;"> Recommend to friends </button></a><br><br>
        
        
	<?php }
		else{
			?>
    <a href="loginf.php"><button type="button" class="btn btn-dark" style="font-family: Calibri; font-weight: bold; background-color: black;"> Log-in </button></a>
	&nbsp; 
	<a href="signupf.php"><button type="button" class="btn btn-dark" style="font-family: Calibri; font-weight: bold; background-color: black;"> Sign-Up </button></a>
        <a href="movies.html"><button type="button" class="btn btn-dark" style="font-family: Calibri; font-weight: bold; background-color: black;"> Watch movies </button></a><br><br>
         <a href="mail.html"><button type="button" class="btn btn-dark" style="font-family: Calibri; font-weight: bold; background-color: black;"> Recommend to friends </button></a><br><br>
        
        
	<?php } ?>
	</nav>  
 <br> <br>

<div class="row align-items-center justify-content-center" style="margin-left:5%; margin-right:5%;">
<?php while($roww=$result->fetch_assoc()):
	$movie=$roww['apiname']; 
	$json_str=file_get_contents("http://www.omdbapi.com/?apikey=bf057abd&t=$movie");
	$parsed_json = json_decode($json_str, true);
	?>
<div class="card" style="width: 12rem;">
<center>
<img class="card-img" src="<?php echo $parsed_json['Poster']; ?>" style="width: 90%; height: 90%;" data-toggle="modal" data-target="#<?php echo $roww['mname']; ?>">
<div class="middle">
    <div class="fadeintext"><?php echo $parsed_json['Title'];?></div>
  </div>
</center>
</div>

<!--Modal-->
<div class="modal fade" id="<?php echo $roww['mname']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
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
				 <br>
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
	  <?php 
		if (!isset($_SESSION['user'])){
		?>
		<a href="signupf.php"><button type="button" class="btn btn-dark" style="font-family: Calibri; font-weight: bold;">  Sign-up to view comments  </button></a>
		<?php }
		else{
			?>
        <a href="comment.php?page=<?php echo $parsed_json['Title']; ?>"><button type="button" class="btn btn-dark" style="font-family: Calibri; font-weight: bold;">  View comments  </button></a>
	  <?php } ?>
	  </div>
    </div>
  </div>
</div>
<?php endwhile ?>
</div>

<?php
  $result=$mysqli->query
		("SELECT * FROM top_rated WHERE num>11 AND num<=22")
		
		or die($mysqli->error);
?>

<div class="row align-items-center justify-content-center" style="margin-left:5%; margin-right:5%;">
<?php while($roww=$result->fetch_assoc()):
	$movie=$roww['apiname']; 
	$json_str=file_get_contents("http://www.omdbapi.com/?apikey=bf057abd&t=$movie");
	$parsed_json = json_decode($json_str, true);
	?>
<div class="card" style="width: 12rem;">
<center>
<img class="card-img" src="<?php echo $parsed_json['Poster']; ?>" style="width: 90%; height: 90%;" data-toggle="modal" data-target="#<?php echo $roww['mname']; ?>">
<div class="middle">
    <div class="fadeintext"><?php echo $parsed_json['Title'];?></div>
  </div>
</center>
</div>

<!--Modal-->
<div class="modal fade" id="<?php echo $roww['mname']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
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
	  <?php 
		if (!isset($_SESSION['user'])){
		?>
		<button type="button" class="btn btn-dark" style="font-family: Calibri; font-weight: bold;">  Sign-up to view comments  </button>
		<?php }
		else{
			?>
        <a href="comment.php?page=<?php echo $parsed_json['Title']; ?>"><button type="button" class="btn btn-dark" style="font-family: Calibri; font-weight: bold;">  View comments  </button></a>
	  <?php } ?>
	  </div>
    </div>
  </div>
</div>
<?php endwhile ?>
</div>



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
</style>

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js" integrity="sha384-smHYKdLADwkXOn1EmN1qk/HfnUcbVRZyYmZ4qpPea6sjB/pTJ0euyQp0Mk8ck+5T" crossorigin="anonymous"></script>

  </body>
</html>