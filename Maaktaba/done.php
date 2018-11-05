<?php
session_start();
require_once('includes/connection.php');
$connection=mysqli_connect(DB_SERVER,DB_USER,DB_PASSWORD,DB_NAME);
	if(!$connection) {
		die("Connection failed");
	}
if(isset($_SESSION['adminid'])){
	$id=$_GET['id'];
	$status=$_GET['status'];
	if($status==='approve'){
		$allow='approve';
		$available='present';
		$query="UPDATE books SET status='{$allow}',available='{$available}' WHERE bookid='{$id}'";
		$run=mysqli_query($connection,$query);
		header('location:bookrequest.php');
	}else {
		$allow='reject';
		$available='present';
		$qquery="UPDATE books SET status='{$allow}',available='{$available}' WHERE bookid='{$id}'";
		$rman=mysqli_query($connection,$qquery);
		header('location:bookrequest.php');
	}
	
	
}

?>