<?php
session_start();
require_once('includes/connection.php');
$connection=mysqli_connect(DB_SERVER,DB_USER,DB_PASSWORD,DB_NAME);
	if(!$connection) {
		die("Connection failed");
	}
$present='';
if(isset($_SESSION['userid'])){
	$query="SELECT * FROM users WHERE userid='{$_SESSION['userid']}'";
	$runquery=mysqli_query($connection,$query);
	$loginuser=mysqli_fetch_array($runquery);
	$username=$loginuser['firstname'].$loginuser['surname'];
	$present="ipo";
	$link='profile.php';
}else {
	$username='';
	$present="haipo";
	$link='index.php';
}
$category=mysqli_real_escape_string($connection,$_GET['category']);
$selectquery="SELECT * FROM books WHERE bookcategory='{$category}'";
$run=mysqli_query($connection,$selectquery);



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
						<form action="search.php" method="post" style="width:100%;">
							<input type="text" name="search" placeholder="Search for books" style="width:80%; margin:auto; height:40px; margin-bottom:0; color:#242424; box-sizing:border-box; padding:5px; border-radius:5px; background-color:white; color:black;">
							<input type="submit" name="submit" value="Search" style="margin-top:5px;">

						</form>
					</header>

				<!-- Nav -->
					<nav id="nav">
						<ul>

							<li><a href="index.php">Books</a></li>
							<li><a href="Categories.php" class="active">Categories</a></li>
							<li><a href="login.php">Log In</a></li>
							<li><a href="signup.php">Sign up</a></li>
							<?php
							 if($present==='ipo'){
								 echo "<li><a href='$link'> $username</a></li>";
}
							?>
						</ul>
					</nav>

				<!-- Main -->
					<div id="main">

						<!-- First Section -->
							<section id="first" class="main special">
								<header class="major">
									<h2>Category: <?php echo $category;?></h2>
								</header>
								<ul class="features">
									<?php
										while($allbooks=mysqli_fetch_array($run)) {
									
									?>
									<li>
										<a href="book.php?id=<?php echo $allbooks['bookid'];?>">
										<img src="uploads/<?php echo $allbooks['bookimage']; ?>" style="height:300px;">
										<h3 style="margin-bottom:0; font-weight:bold;"><?php echo $allbooks['booktitle']." by ". $allbooks['bookauthor'];?></h3>
										<p style="font-size:15px; margin-bottom:0;"><?php echo $allbooks['bookinfo'];?></p>
										<h4 style="font-weight:bold; font-size:30px;"> Price:<?php echo $allbooks['bookcost'];?>Tshs</h4>
									</a>
										<a href="book.php?id=<?php echo $allbooks['bookid'];?>" class="button">Order</a>


									</li>
									<?php
										}
											
							
									?>
									
									
								</ul>
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
