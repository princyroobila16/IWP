<?php
$host='localhost';
	$user='root';
	$pass='';
	$db='project';
	
	$mysqli= new mysqli($host, $user, $pass, $db);
	/*$result=$mysqli->query
		("SELECT name FROM scifi WHERE num=36")
		
		or die($mysqli->error);*/
		$page='The Godfather';
		$result=$mysqli->query
		("SELECT comment, fname, social_media FROM comments, user WHERE comments.email=user.email AND movie='$page'")
		
		or die($mysqli->error);	
if(mysqli_num_rows($result)==0)
	echo "No comments yet";
else
{
while($roww=$result->fetch_assoc()):

  echo $roww['fname']." ".$roww['comment']." ".$roww['social_media'];
	//$movie=str_replace(" ", "%20", $roww['name']); 
//echo $movie;
	//$json_str=file_get_contents("http://www.omdbapi.com/?apikey=bf057abd&t=$movie");
	//$parsed_json = json_decode($json_str, true);
	
	/*$mname=$roww['mname'];*/
	/*$title=$parsed_json['Title'];
	$poster=$parsed_json['Poster'];
	$runtime=$parsed_json['Runtime'];
	$imdbrating=$parsed_json['imdbRating'];
	$year=$parsed_json['Year'];
	$plot=$parsed_json['Plot'];
	$genre=$parsed_json['Genre'];
	$actors=$parsed_json['Actors'];
	
	$plot=mysqli_real_escape_string($mysqli, $plot);
	$title=mysqli_real_escape_string($mysqli, $title);
	$actors=mysqli_real_escape_string($mysqli, $actors);
	
	//$sql=$mysqli->query("UPDATE scifi_movies SET Title='$title', Poster='$poster', Year='$year', Genre='$genre', Plot='$plot', Actors='$actors', Runtime='$runtime', imdbRating='$imdbrating' WHERE id=6")
	//or die($mysqli->error);
	
	$sql=$mysqli->query("INSERT INTO scifi_movies (Title, Poster, Year, Genre, Plot, Actors, Runtime, imdbRating)  VALUES ('$title', '$poster', '$year', '$genre', '$plot', '$actors', '$runtime', '$imdbrating')")
	or die($mysqli->error);
	*/
endwhile;
}



echo "Complete";

?>