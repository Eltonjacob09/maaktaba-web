<?php
session_start();
require_once('includes/connection.php');
$connection=mysqli_connect(DB_SERVER,DB_USER,DB_PASSWORD,DB_NAME);
	if(!$connection) {
		die("Connection failed");
	}
if(isset($_SESSION['adminid'])){
	$bookid=$_GET['id'];
	$query="DELETE FROM neededbooks WHERE bookid='{$bookid}'";
	$runquery=mysqli_query($connection,$query);
	$number=mysqli_num_rows($runquery);
	header('location:nbooks.php');
	
	
}