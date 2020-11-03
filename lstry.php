<!doctype html>
<html>
<body>
	 <?php
	session_start();
	?>
	<?php 
		if (isset($_SESSION['user'])){
		?>
		<a href="logout.php"><button type="button" class="btn btn-dark" style="font-family: Calibri; font-weight: bold; "> Log-out </button></a>
	&nbsp; 
		<?php }
		else{
			?>
	<a href="signupb.php?stat=1"><button type="button" class="btn btn-dark" style="font-family: Calibri; font-weight: bold; "> Log-in </button></a>
	&nbsp; 
	<a href="signupb.php?stat=0"><button type="button" class="btn btn-dark" style="font-family: Calibri; font-weight: bold;"> Sign-Up </button></a>
		<?php } ?>



</body>
</html>