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
$bookid=mysqli_real_escape_string($connection,$_GET['id']);
$query="SELECT * FROM books WHERE bookid='{$bookid}' LIMIT 1";
$run=mysqli_query($connection,$query);
$book=mysqli_fetch_array($run);

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
    <script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-106144895-1', 'auto');
  ga('send', 'pageview');

</script>
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

						<section id="intro" class="main">
							<div class="spotlight">
								<div class="content">

									<header class="major">
										<h2><?php echo $book['booktitle']." by ".$book['bookauthor'];?></h2>
									</header>

									<h3 style="font-weight:bold; font-size:28px; text-decoration:underline;">Buy</h3>
									<p>
										 Our pickup location is Kwa Warioba Mikocheni B

									</p>
									<h4 style="font-weight:bold; font-size:20px;"> Price: <?php echo $book['bookcost'];?>Tshs</h4>
									<p style="margin:10px;">  </p>
									
									<h3 style="font-weight:bold; font-size:28px; text-decoration:underline;">Buy & Delivery</h3>
									<p>
										The book will be delivered to you and they will be additional charges

									</p>
									<h4 style="font-weight:bold; font-size:20px;"> Price: <?php echo $book['bookcost']+3000;?>Tshs</h4>
									<p style="margin:10px;">  </p>
									
									<h3 style="font-weight:bold; font-size:28px; text-decoration:underline;">Rent</h3>
									<p>
										Renting duration is two weeks. You do pay the total cost of the book and half of the amount will be refunded if you return the book is the same condition as your borrowed.
									</p>
									<h4 style="font-weight:bold; font-size:20px;"> Price: <?php echo $book['bookcost'];?>Tshs</h4>
									<p style="margin:20px;">  </p>
									
									 
									<ul class="actions">
										<li><a href="cost.php?id=<?php echo $book['bookid'];?>&option=buy" class="button">Buy</a></li>
										<li><a href="cost.php?id=<?php echo $book['bookid'];?>&option=delivery" class="button">Buy& Delivery</a></li>
										<li><a href="cost.php?id=<?php echo $book['bookid'];?>&option=rent" class="button">Rent</a></li>
									</ul>
								</div>
									<img src="uploads/<?php echo $book['bookimage'];?>" alt="" style="height:300px;"/>
							</div>
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
