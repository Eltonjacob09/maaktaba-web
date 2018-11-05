<?php
session_start();
require_once('includes/connection.php');
$connection=mysqli_connect(DB_SERVER,DB_USER,DB_PASSWORD,DB_NAME);
	if(!$connection) {
		die("Connection failed");
	}
if(isset($_SESSION['adminid'])){
	$status='disapproved';
	$query="SELECT * FROM books WHERE status='{$status}'";
	$runquery=mysqli_query($connection,$query);
	$number=mysqli_num_rows($runquery);
	
	
}else {
	header('location:index.php');
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
						<form action="index.php" method="post" style="width:100%;">
							<input type="search" placeholder="Book title" style="width:80%; margin:auto; height:40px; margin-bottom:0; color:#242424; box-sizing:border-box; padding:5px; border-radius:5px;">

						</form>
					</header>

				<!-- Nav -->
					<nav id="nav">
						<ul>

							<li><a href="transaction.php">Transaction</a></li>
							<li><a href="registerbook.php">Add book</a></li>
							<li><a href="bookrequest.php" class="active"s>Book request</a></li>
							<li><a href="nbooks.php">Needed books</a></li>
							<li><a href="logout.php">log out</a></li>
						</ul>
					</nav>

				<!-- Main -->
					<div id="main">


						<!-- First Section -->
							<section id="first" class="main special">
								<header class="major">
									<h2>Books Order:(<?php echo $number;?>)</h2>
								</header>
						
									<ul class="features">
									<?php
										while($transaction=mysqli_fetch_array($runquery)) {
									
									?>
									<li>

	<img src="uploads/<?php echo $transaction['bookimage']; ?>" style="height:300px;">
										<p style="font-size:15px; margin-bottom:0;">
											No:<?php echo $transaction['bookid'];?><br>
											Booktitle:<?php echo $transaction['booktitle'];?><br>
											Bookauthor:<?php echo $transaction['bookauthor'];?><br>
											Bookcategory:<?php echo $transaction['bookauthor'];?><br>
											Bookcost:<?php echo $transaction['bookcost'];?><br>
											Supplierfirstname:<?php echo $transaction['supplierfirstname'];?><br>
											Suppliersurname:<?php echo $transaction['supplierlastname'];?><br>
											Supplierphone:<?php echo $transaction['supplierphone'];?><br>
											Supplieremail:<?php echo $transaction['supplieremail'];?><br>
											
										</p>
									
										<a href="done.php?status=approve&id=<?php echo $transaction['bookid'];?>" class="button" style="margin-bottom:5px;">Approve</a>
										<a href="done.php?status=disapprove&id=<?php echo $transaction['bookid'];?>" class="button">Disapprove</a>
										
										


									</li>
									<?php
										}
											
									
									?>
									
									
								</ul>
							</section>
									
									</tr>
									<?php
										while($transaction=mysqli_fetch_array($runquery)){
									
									?>
									<tr>
										<td><?php echo $transaction['transactionid'];?></td>
										<td><?php echo $transaction['firstname'].' '.$transaction['surname'];?></td>
										<td><?php echo $transaction['email'];?></td>
										<td><?php echo $transaction['booktitle'];?></td>
										<td><?php echo $transaction['bookcost'];?></td>
										<td><?php echo $transaction['bundleoption'];?></td>
										<td><?php echo $transaction['deliveryplace'];?></td>
										<td><?php echo $transaction['phone'];?></td>
										<td><?php echo $transaction['supplierfirstname'].' '.$transaction['supplierlastname'];?></td>
										<td><?php echo $transaction['supplieremail'];?></td>
										<td><?php echo $transaction['supplierphone'];?></td>
										
						
									
									</tr>
								<?php
										}
											
											?>
								
								
								</table>
								
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
