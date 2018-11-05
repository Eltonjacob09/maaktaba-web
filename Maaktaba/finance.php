<?php
session_start();
require_once('includes/connection.php');
$connection=mysqli_connect(DB_SERVER,DB_USER,DB_PASSWORD,DB_NAME);
	if(!$connection) {
		die("Connection failed");
	}
if(isset($_SESSION['adminid'])){
	$status='undone';
	$query="SELECT * FROM transaction ORDER BY status";
	$runquery=mysqli_query($connection,$query);
	$number=mysqli_num_rows($runquery);
    
    
    /*$info='undone';
    $undone="SELECT * FROM transaction WHERE status='{$info}'";
    $processundone=mysqli_query($connection,$undone);
    $values=mysqli_fetch_array($processundone);
    $expectedAmount=array_sum($values['bookcost']);
    
    $info2='done';
    $done="SELECT * FROM transaction WHERE status='{$info2}'";
    $processdone=mysqli_query($connection,$done);
    $values2=mysqli_fetch_array($processdone);
    $expectedAmount2=array_sum($values2['bookcost']);*/
	
	
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
                            <li><a href="finance.php" class="active">Transaction</a></li>
							<li><a href="registerbook.php">Add book</a></li>
							<li><a href="bookrequest.php">Book request</a></li>
							<li><a href="nbooks.php">Needed books</a></li>
							<li><a href="logout.php">log out</a></li>
						</ul>
					</nav>

				<!-- Main -->
					<div id="main">

						

						<!-- First Section -->
							<section id="first" class="main special">
								<header class="major">
									<h2>Finance</h2>
								</header>
                                <h4>Actual amount: <?php echo $expectedAmount2;?></h4>
                                <h4>Expected amount: <?php echo $expectedAmount;?></h4>
								<table>
									<tr>
										<td style="font-weight: 600;">Transaction</td>
                                        <td style="font-weight: 600;">Bundle</td>
                                        <td style="font-weight: 600;">Price</td>
                                        <td style="font-weight: 600;">Status</td>
										
									
									
									</tr>
                                    <?php
                                      while($all=mysqli_fetch_array($runquery)){
                                          
                                          
                                    ?>
                                          
                                     
                                    
                                    
									<tr>
										<td><?php echo $all['booktitle'];?></td>
										<td><?php echo $all['bundleoption'];?></td>
										<td><?php echo $all['bookcost'];?></td>
										<td><?php echo $all['status'];?></td>
									
									
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
								<dd>Kwa Warioba &bull; Mikocheni , Dar es Salaam &bull; Tanzania</dd>
								<dt>Phone</dt>
								<dd>+255757713445</dd>
								<dt>Email</dt>
								<dd>elton.jacob@uwcmaastricht.nl</dd>
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
