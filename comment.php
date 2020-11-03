<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	
	<!-- Bootstrap core CSS -->
    <link href="dist_search/css/bootstrap.css" rel="stylesheet">
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Acme">
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
	
	$email=$_SESSION['user'];
	$name='';
	
	if (isset($_SESSION['user']))
	{
		$result=$conn->query("SELECT fname,lname FROM user WHERE email='".$_SESSION['user']."'")
		or die($conn->error);
		$row2=$result->fetch_assoc();
		$name=$row2['fname']." ".$row2['lname'];
	}
	?>
 
 <?php 
	$page=$_GET['page'];
	$mv=str_replace(' ', '%20', $page);
	$json_str=file_get_contents("http://www.omdbapi.com/?apikey=bf057abd&t=$mv");
	$parsed_json = json_decode($json_str, true);
?>
 
  <!--Navbar-->
  <nav class="navbar navbar-expand-lg navbar-dark">
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
 <h1 style="color: white; font-family: Proza;"><i>Comments</h1>
<br><br>  
  
  <div class="card comm" style="border: none;">
        <div class="row">
            <div class="col-auto">
			<center>
                <!--<img src="img/av1.jpg" class="img-fluid" alt="" style="height: 35rem;">-->
				<div class="flip-container" ontouchstart="this.classList.toggle('hover');">
	<div class="flipper">
		<div class="front" style="opacity: 1; !important">
		<img src="<?php echo $parsed_json['Poster']; ?>" style="height: 35rem; width: 20rem; ">
		</div>
		<div class="back text-white" style="padding-left: 0.5%; font-weight: bold;">
		<p>
			 <?php echo $parsed_json['Title']; ?>
        </p>
		<p align="left">
			Runtime: <?php echo $parsed_json['Runtime']; ?>
		</p>
		<p align="left">
			 Genre: <?php echo $parsed_json['Genre']; ?>
        </p>
		<p align="left">
			Actors: <?php echo $parsed_json['Actors']; ?>
		</p>
		<p align="left">
			Director: <?php echo $parsed_json['Director']; ?>
		</p>
		<p align="left">
			Plot: <?php echo $parsed_json['Plot']; ?>
		</p>
		<p align="left">
			Awards: <?php echo $parsed_json['Awards']; ?>
		</p>
		<p align="left">
		  IMDb Rating: <?php echo $parsed_json['imdbRating']; ?>
		</p>
		</div>
	</div>
</div>
			</center>
			</div>
<?php
$result=$conn->query
		("SELECT comment, fname, social_media FROM comments, user WHERE comments.email=user.email AND movie='$page'")
		
		or die($conn->error);	
		if(mysqli_num_rows($result)==0)
	echo "<p style='color: white; font-size: 16px;'>No comments yet</p>";
else
{
?>
			<div class="col"  style="height: 35rem; overflow-y: scroll; opacity: 0.8;">
	<div class="card-columns">
	<?php
while($roww=$result->fetch_assoc()):	   
		   ?>
      <div class="card text-white border-light bg-secondary p-3">
    <blockquote class="blockquote mb-0 card-body">
      <p><?php echo $roww['comment']; ?></p>
      <footer class="blockquote-footer">
        <small class="text-muted">
          <?php echo $roww['fname']; ?> <cite title="Source Title"><?php echo $roww['social_media']; ?></cite>
        </small>
      </footer>
    </blockquote>
  </div>
<?php endwhile;
}
  ?>
 <!-- <div class="card text-white border-light bg-secondary p-3">
    <blockquote class="blockquote mb-0 card-body">
      <p>tf izfkkgi gh izgg. hyg guUKIFug fjhfggf sg zhih zuuuztg gzggfgzkug ukzhk</p>
      <footer class="blockquote-footer">
        <small class="text-muted">
          Someone famous in <cite title="Source Title">Source Title</cite>
        </small>
      </footer>
    </blockquote>
  </div>
   <div class="card text-white border-light bg-secondary p-3">
    <blockquote class="blockquote mb-0 card-body">
      <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer posuere erat a ante.</p>
      <footer class="blockquote-footer">
        <small class="text-muted">
          Someone famous in <cite title="Source Title">Source Title</cite>
        </small>
      </footer>
    </blockquote>
  </div>
  <div class="card text-white border-light bg-secondary p-3">
    <blockquote class="blockquote mb-0 card-body">
      <p>Good</p>
      <footer class="blockquote-footer">
        <small class="text-muted">
          Someone famous in <cite title="Source Title">Source Title</cite>
        </small>
      </footer>
    </blockquote>
  </div>
  <div class="card text-white border-light bg-secondary p-3">
    <blockquote class="blockquote mb-0 card-body">
      <p>Good but can be better</p>
      <footer class="blockquote-footer">
        <small class="text-muted">
          Someone famous in <cite title="Source Title">Source Title</cite>
        </small>
      </footer>
    </blockquote>
  </div>
   <div class="card text-white border-light bg-secondary p-3">
    <blockquote class="blockquote mb-0 card-body">
      <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer posuere erat a ante.</p>
      <footer class="blockquote-footer">
        <small class="text-muted">
          Someone famous in <cite title="Source Title">Source Title</cite>
        </small>
      </footer>
    </blockquote>
  </div>
  <div class="card text-white border-light bg-secondary p-3">
    <blockquote class="blockquote mb-0 card-body">
      <p>tf izfkkgi gh izgg. hyg guUKIFug fjhfggf sg zhih zuuuztg gzggfgzkug ukzhk</p>
      <footer class="blockquote-footer">
        <small class="text-muted">
          Someone famous in <cite title="Source Title">Source Title</cite>
        </small>
      </footer>
    </blockquote>
  </div>
  <div class="card text-white border-light bg-secondary p-3">
    <blockquote class="blockquote mb-0 card-body">
      <p>Good but can be better</p>
      <footer class="blockquote-footer">
        <small class="text-muted">
          Someone famous in <cite title="Source Title">Source Title</cite>
        </small>
      </footer>
    </blockquote>
  </div>
  <div class="card text-white border-light bg-secondary p-3">
    <blockquote class="blockquote mb-0 card-body">
      <p>Not to watch. Horrendous!!!</p>
      <footer class="blockquote-footer">
        <small class="text-muted">
          Someone famous in <cite title="Source Title">Source Title</cite>
        </small>
      </footer>
    </blockquote>
  </div> -->
	</div>
	</div>
	</div>
	<br>
	<div class="row justify-content-end">
	<div class="input-group input-group-sm col-md-4">
	<form id="comment-form" action="<?php $_PHP_SELF ?>" method="post">
	<textarea name="comment" form="comment-form" type="text" placeholder="Leave a comment" aria-label="Search"></textarea>
	<input type="submit" value="Post" name="post_comment">
	</form>
	</div>
	</div>
</div>

<?php

if (isset($_POST['post_comment'])&&isset($_POST['comment']))
{
	$com=$_POST['comment'];
	$mov=$parsed_json['Title'];
	$sql="INSERT INTO comments (Movie, Email, Comment) VALUES ('$mov', '$email', '$com')";
	$result=$conn->query($sql)		
		or die($conn->error);
	header("Refresh: 0");
}

?>
<body>
  <div class="rate">
    <input type="radio" id="star5" name="rate" value="5" />
    <label for="star5" title="text">5 stars</label>
    <input type="radio" id="star4" name="rate" value="4" />
    <label for="star4" title="text">4 stars</label>
    <input type="radio" id="star3" name="rate" value="3" />
    <label for="star3" title="text">3 stars</label>
    <input type="radio" id="star2" name="rate" value="2" />
    <label for="star2" title="text">2 stars</label>
    <input type="radio" id="star1" name="rate" value="1" />
    <label for="star1" title="text">1 star</label>
<form id="rate-form" action="<?php $_PHP_SELF ?>" method="post">
	<textarea name="rate" form="rate-form" type="text" placeholder="give your rate" aria-label="Search"></textarea>
    <input type="submit" value="Post" name="post_rate">
  </div>
<?php

if (isset($_POST['post_rate'])&&isset($_POST['rate']))
{
	$rate=$_POST['rate'];
	$mov=$parsed_json['Title'];
	$sql="INSERT INTO rates (Movie, Email, rate) VALUES ('$mov', '$email', '$rate')";
	$result=$conn->query($sql)		
		or die($conn->error);
	header("Refresh: 0");
}

?>

<style>
.comm{
padding-left: 1%;
padding-top: 2%;
padding-right: 2%;
padding-bottom: 0.5%;
background: none;
}
.flip-container {
	perspective: 1000px;
}
	/* flip the pane when hovered */
	.flip-container:hover .flipper, .flip-container.hover .flipper {
		transform: rotateY(180deg);
	}

.flip-container, .front, .back {
	
	height: 35rem;
	width: 20rem;
}

/* flip speed goes here */
.flipper {
	transition: 1s;
	transform-style: preserve-3d;

	position: relative;
}

/* hide back of pane during swap */
.front, .back {
	backface-visibility: hidden;

	position: absolute;
	top: 0;
	left: 0;
}

/* front pane, placed above back */
.front {
	z-index: 2;
	/* for firefox 31 */
	transform: rotateY(0deg);
}

/* back, initially hidden pane */
.back {
	transform: rotateY(180deg);
	background-color: #6c757d;
	opacity: 0.8;
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