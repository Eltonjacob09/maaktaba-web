<?php
session_start();
require_once('includes/connection.php');
$connection=mysqli_connect(DB_SERVER,DB_USER,DB_PASSWORD,DB_NAME);
	if(!$connection) {
		die("Connection failed");
	}

$message='';
if(isset($_POST['signup'])){
	$errrors=array();
	
	if(!empty($_POST['firstname']) || $_POST['firstname']!==''){
		$firstname=$_POST['firstname'];
		$ffirstname=mysqli_real_escape_string($connection,$firstname);
	}else {
		$errors['firstexist']='Fistname is empty';
	}
	
	if(!empty($_POST['surname']) || $_POST['surname']!==''){
		$surname=$_POST['surname'];
		$fsurname=mysqli_real_escape_string($connection,$surname);
	}else {
		$errors['surexist']='surname is empty';
	}

	if(!empty($_POST['email']) || $_POST['email']!==''){
		$email=$_POST['email'];
		$femail=mysqli_real_escape_string($connection,$email);
	}else {
		$errors['emailexist']='email is empty';
	}
	
	if(!empty($_POST['phone']) || $_POST['phone']!==''){
		$phone=$_POST['phone'];
		$fphone=mysqli_real_escape_string($connection,$phone);
	}else {
		$errors['phoneexist']='phone is empty';
	}
	
	
	if($_POST['password']===$_POST['cpassword']){
	$password=crypt($_POST['password']);
}else {
	$errors['passwordmatch']="password does not match";
}	
$selectstudent="SELECT * FROM admin WHERE email='{$email}'";
$runquery=mysqli_query($connection,$selectstudent);
$selecteduser=mysqli_fetch_array($runquery);

if($selecteduser['email']===$email){
	$errors['userexit']="user already exist";
}
	
if(empty($errors)){
$user="INSERT INTO admin(firstname,surname,email,phone,password) VALUES('{$ffirstname}','{$fsurname}','{$femail}','{$fphone}','{$password}')";
$userquery=mysqli_query($connection,$user);
header("location:mkt-admin.php");
}else {
	$message="Please correct the errors";
	
}
}
?>




<!DOCTYPE HTML>

<html>
	<head>
		<title>MAAKTABA</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<!--[if lte IE 8]><script src="assets/js/ie/html5shiv.js"></script><![endif]-->
		<meta name="description" content="Maaktaba is an online platform that lets user buy, order and rent books at a cheap and affordable price">
  		<meta name="keywords" content="Ordering books,Dar es Salaam,Renting books,">
		<link rel="shortcut icon" href="images/favicon%20(1).ico" type="image/x-icon" />
		<link rel="stylesheet" href="assets/css/main.css" />
		<!--[if lte IE 9]><link rel="stylesheet" href="assets/css/ie9.css" /><![endif]-->
		<!--[if lte IE 8]><link rel="stylesheet" href="assets/css/ie8.css" /><![endif]-->
	</head>
	<body>

		<!-- Wrapper -->
			<div id="wrapper">

				<!-- Header -->
					<header id="header" class="alt" style="margin-bottom:0px;">
						<span class="logo"><img src="images/literature-xxl.png" style="height:150px;" alt="" /></span>
						<h1>Maaktaba</h1>
					</header>

				<!-- Nav -->
					<nav id="nav">
					</nav>

				<!-- Main -->
					<div id="main">

						<section id="second" class="main special">
							<header class="major">
								<h2>Sign up Admin</h2>
								<p><?php echo $message;?></p>
								<form method="post" action="mkt-adminr.php">
									<input type="text" name="firstname" placeholder="First name" style="width:50%; margin:auto; margin-bottom:5px; background-color:white; border:none; border:solid 1px rgba(0,0,0,0.5);">
									<input type="text" name="surname" placeholder="Surname" style="width:50%; margin:auto; margin-bottom:5px; background-color:white; border:none; border:solid 1px rgba(0,0,0,0.5);">
									<input type="email" name="email" placeholder="someone@anymail.com" style="width:50%; margin:auto; margin-bottom:5px; background-color:white; border:none; border:solid 1px rgba(0,0,0,0.5);">
									<input type="password" name="password" placeholder="password" style="width:50%; margin:auto; margin-bottom:15px; background-color:white; border:none; border:solid 1px rgba(0,0,0,0.5);">
									<input type="password" name="cpassword" placeholder="Confirm password" style="width:50%; margin:auto; margin-bottom:15px; background-color:white; border:none; border:solid 1px rgba(0,0,0,0.5);">
									<input type="tel" name="phone" placeholder="0757713445" style="width:50%; margin:auto; margin-bottom:15px; background-color:white; display:block; height:45px; border:none; border:solid 1px rgba(0,0,0,0.5); border-radius:5px; box-sizing:border-radius; padding:10px 15px 10px 5px;">
									<input type="submit" name="signup" value="Sign up">

								</form>

							</header>

						</section>






				<!-- Footer -->
					<footer id="footer">
						<section>
							<h2>About us</h2>
							<p>Maaktaba is an online platform that enables dar es salaam users to order books online at an affordable price. </p>
							<!--<ul class="actions">
								<li><a href="generic.html" class="button">Learn More</a></li>
								<li><a href="generic.html" class="button">Learn More</a></li>
							</ul>
						-->
						</section>
						<section>
							<h2>Contact us</h2>
							<dl class="alt">
								<dt>Address</dt>
								<dd>Shamo Park &bull; Mbezi beach, Dar es Salaam &bull; Tanzania</dd>
								<dt>Phone</dt>
								<dd>+255624079021</dd>
								<dt>Email</dt>
								<dd>mashy_hassan007@yahoo.com</dd>
							</dl>
							<ul class="icons">
								<!--<li><a href="#" class="icon fa-twitter alt"><span class="label">Twitter</span></a></li>
								<li><a href="#" class="icon fa-facebook alt"><span class="label">Facebook</span></a></li>
								<li><a href="#" class="icon fa-instagram alt"><span class="label">Instagram</span></a></li>
							-->


							</ul>
						</section>
						<p class="copyright">Created by Elton Jacob</p>
					</footer>

			</div>

		<!-- Scripts -->
			<script src="assets/js/jquery.min.js"></script>
			<script src="assets/js/jquery.scrollex.min.js"></script>
			<script src="assets/js/jquery.scrolly.min.js"></script>
			<script src="assets/js/skel.min.js"></script>
			<script src="assets/js/util.js"></script>
			<!--[if lte IE 8]><script src="assets/js/ie/respond.min.js"></script><![endif]-->
			<script src="assets/js/main.js"></script>

	</body>
</html>
