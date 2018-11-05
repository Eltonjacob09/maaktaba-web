<?php
session_start();
require_once('includes/connection.php');
$connection=mysqli_connect(DB_SERVER,DB_USER,DB_PASSWORD,DB_NAME);
	if(!$connection) {
		die("Connection failed");
	}
if(isset($_SESSION['adminid'])){
	$id=$_GET['id'];
	$status='done';
	$query="UPDATE transaction SET status='{$status}' WHERE transactionid='{$id}'";
	$run=mysqli_query($connection,$query);
	header('location:transaction.php');
	
	
}else {
	header('location:mkt-admin.php');
}

?>