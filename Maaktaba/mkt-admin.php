<?php
require_once('includes/connection.php');
session_start();
$connection=mysqli_connect(DB_SERVER,DB_USER,DB_PASSWORD,DB_NAME);
	if(!$connection) {
		die("Connection failed");
	}

$message='';
if(isset($_POST['login'])) {
	$email=mysqli_real_escape_string($connection,$_POST['email']);
	$password=mysqli_real_escape_string($connection,$_POST['password']);
	$selectuser="SELECT * FROM admin WHERE email='{$email}'";
	$runquery=mysqli_query($connection,$selectuser);
	$user=mysqli_fetch_array($runquery);
	if($email===$user['email'] && $user['password']===crypt($password,$user['password'])){
		$_SESSION['email']=$user['email'];
		$_SESSION['adminid']=$user['adminid'];
		header('location:transaction.php');
	}else {
		$message='login failed';
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
						<ul>

						</ul>
					</nav>

				<!-- Main -->
					<div id="main">

						<section id="second" class="main special">
							<header class="major">
								<h2>Log In:<?php echo $message;?></h2>
								<form method="post" action="mkt-admin.php">
									
									<input type="email" name="email" placeholder="someone@anymail.com" style="width:50%; margin:auto; margin-bottom:5px;">
									<input type="password" name="password" placeholder="password" style="width:50%; margin:auto; margin-bottom:10px;">
									<input type="submit" name="login" value="log in">

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
