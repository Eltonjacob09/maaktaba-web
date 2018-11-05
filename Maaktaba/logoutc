<?php
session_start();
require_once('includes/connection.php');
$connection=mysqli_connect(DB_SERVER,DB_USER,DB_PASSWORD,DB_NAME);
	if(!$connection) {
		die("Connection failed");
	}
if(isset($_SESSION['adminid'])){
	$_SESSION['admin']='';
	unset($_SESSION['adminid']);
	header('location:mkt-admin.php');

}
?>