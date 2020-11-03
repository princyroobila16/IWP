<?php
$conn = new mysqli('localhost','root','','project');
if((isset($_POST['name'])&&($_POST['mailid'])&&($_POST['message'])!= ''))
{
$name = $_POST['name'];
$mailid= $_POST['mailid'];
$message = $_POST['message'];
$sql="insert into recommend(name,mailid,message) values ('$name','$mailid','$message')";
if(mysqli_query($conn,$sql))
{
	echo"Mail Sent Successfully";
}
else
{
	echo"Mail Not Sent";
}
}
?>