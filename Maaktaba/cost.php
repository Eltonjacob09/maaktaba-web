<?php
session_start();
require_once('includes/connection.php');
$connection=mysqli_connect(DB_SERVER,DB_USER,DB_PASSWORD,DB_NAME);
	if(!$connection) {
		die("Connection failed");
	}
$present='';
$loginuser['firstname']='';
$loginuser['surname']='';
$loginuser['email']='';
$loginuser['phone']='';
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
$totalprice="";
$bookid=mysqli_real_escape_string($connection,$_GET['id']);
$option=mysqli_real_escape_string($connection,$_GET['option']);
$query="SELECT * FROM books WHERE bookid='{$bookid}'";
$runquery=mysqli_query($connection,$query);
$selectedbook=mysqli_fetch_array($runquery);


if($option==="buy"){
	$totalprice=$selectedbook['bookcost'];
	$bundletype="Buy";
}elseif($option==="delivery") {
	$totalprice=$selectedbook['bookcost']+3000;
	$bundletype="Buy and Delivery";
	
}elseif($option==="rent"){
	$totalprice=$selectedbook['bookcost']/2;
	$bundletype='Rent';
	$bundle="Rent".$selectedbook['bookcost']/2;
	
}else {
	$totalprice="";
	$bundletype='';
	$bundle="";
}

if(isset($_POST['order'])){
	$errors=array();
	
	if(!empty($_POST['firstname']) || $_POST['firstname']!==''){
		$firstname=$_POST['firstname'];
		$ffirstname=mysqli_real_escape_string($connection,$firstname);
	}else {
		$errors['firstname']='firstname is empty';
	}
	
	if(!empty($_POST['surname']) || $_POST['surname']!==''){
		$surname=$_POST['surname'];
		$fsurname=mysqli_real_escape_string($connection,$surname);
	}else {
		$errors['surname']='surname is empty';
	}
	
	if(!empty($_POST['email']) || $_POST['email']!==''){
		$email=$_POST['email'];
		$femail=mysqli_real_escape_string($connection,$email);
	}else {
		$errors['email']='email is empty';
	}
	
	if(!empty($_POST['location']) || $_POST['location']!==''){
		$location=$_POST['location'];
		$flocation=mysqli_real_escape_string($connection,$location);
	}else {
		$errors['location']='location is empty';
	}
	
	if(!empty($_POST['phone']) || $_POST['phone']!==''){
		$phone=$_POST['phone'];
		$fphone=mysqli_real_escape_string($connection,$phone);
	}else {
		$errors['phone']='phone is empty';
	}
	if(empty($errors)){
	$booktitle=$selectedbook['booktitle'];
	$supplierfirstname=$selectedbook['supplierfirstname'];
	$supplierlastname=$selectedbook['supplierlastname'];
	$supplierphone=$selectedbook['supplierphone'];
	$supplieremail=$selectedbook['supplieremail'];
	$bookcost=$totalprice;
	$status='undone';
	$insertquery="INSERT INTO transaction(firstname,surname,email,deliveryplace,phone,booktitle,bookcost,bundleoption,supplierfirstname,supplierlastname,supplierphone,supplieremail,status) VALUES('{$ffirstname}','{$fsurname}','{$femail}','{$flocation}','{$fphone}','{$booktitle}','{$bookcost}','{$bundletype}','{$supplierfirstname}','{$supplierlastname}','{$supplierphone}','{$supplieremail}','{$status}')";
	$processquery=mysqli_query($connection,$insertquery);
	
	if($processquery){
		
	
	///Prepare th message by creating a new instance
	//setTo adds to a single receipent addTo you can add multiple recipient
	$message= Swift_Message::newInstance()
		->setSubject('New Order')
		->setFrom(['admin@maaktaba.com' =>'Maaktaba'])
		->addTo('admins@maaktaba.com')
		->setBody('A new order has been placed by'.'
        '.'firstname:'.$ffirstname.'
        '.'Surname:'.$fsurname.'
        '.'Email:'.$femail.'
        '.'location:'.$flocation.'
        '.'Phone:'.$fphone.'
        '.'Booktitle:'.$booktitle.'
        '.'Bookcost:'.$bookcost.'
        '.'Bundleoption:'.$bundletype.'
        '.'Supplier firstname:'.$supplierfirstname.'
        '.'Supplier lastname:'.$supplierlastname.'
        '.'Supplier phone'.$supplierphone.'
        '.'Supplier email'.$supplieremail);
		$transport= Swift_SmtpTransport::newInstance($smtp_server,465,'ssl')
			->setUsername($username)
			->setPassword($password);
	$mailer=Swift_Mailer::newInstance($transport);
	$result=$mailer->send($message);
	if($result){
		$update="DELETE FROM books WHERE bookid='{$bookid}'";
		$rundelete=mysqli_query($connection,$update);
		header("location:order.php");
		
	}else {
		die("Query failed");
	}
		
	}
	
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
										<h2><?php echo $selectedbook['booktitle']." by ".$selectedbook['bookauthor'] ;?></h2>
									</header>
								
									<p><?php echo $bundletype;?></p>
									<h4 style="font-weight:bold; font-size:30px;"> Total cost: <?php echo $totalprice;?>Tshs</h4>
									
								</div>
									<img src="uploads/<?php echo $selectedbook['bookimage'];?>" alt="" style="height:300px;" />
							</div>
						</section>
						
							<section id="second" class="main special">
							<header class="major">
								<h2>Sign up</h2>
								<form method="post" action="cost.php?id=<?php echo $bookid;?>&option=<?php echo $option;?>">
									<label style="font-size:25px; margin-bottom:0;">First name</label>
									<input type="text" name="firstname" placeholder="First name" value="<?php echo $loginuser['firstname'];?>" required style="width:50%; margin:auto; margin-bottom:5px; background-color:white; border:none; border:solid 1px rgba(0,0,0,0.5);">
									<label style="font-size:25px; margin-bottom:0;">Surname</label>
									<input type="text" name="surname" placeholder="Surname" required value="<?php echo $loginuser['surname'];?>" style="width:50%; margin:auto; margin-bottom:5px; background-color:white; border:none; border:solid 1px rgba(0,0,0,0.5);">
									<label style="font-size:25px; margin-bottom:0;">Email</label>
									<input type="email" name="email" placeholder="someone@anymail.com" value="<?php echo $loginuser['email'];?>" required style="width:50%; margin:auto; margin-bottom:5px; background-color:white; border:none; border:solid 1px rgba(0,0,0,0.5);">
									<label style="font-size:25px; margin-bottom:0;">Your location</label>
									<input type="text" name="location" placeholder="your location" required style="width:50%; margin:auto; margin-bottom:15px; background-color:white; border:none; border:solid 1px rgba(0,0,0,0.5);">
									<label style="font-size:25px; margin-bottom:0;">Phone (in this format 0757713445)</label>
									<input type="tel" name="phone" placeholder="0757713445" required value="<?php echo '0'.$loginuser['phone'];?>" style="width:50%; margin:auto; margin-bottom:15px; background-color:white; display:block; height:45px; border:none; border:solid 1px rgba(0,0,0,0.5); border-radius:5px; box-sizing:border-radius; padding:10px 15px 10px 5px;">
									<input type="submit" name="order" value="Order <?php echo $totalprice;?>Tshs">

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
