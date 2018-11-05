<?php
session_start();
require_once('includes/connection.php');
$connection=mysqli_connect(DB_SERVER,DB_USER,DB_PASSWORD,DB_NAME);
	if(!$connection) {
		die("Connection failed");
	}

$selectcategory="SELECT * FROM category";
$runquery=mysqli_query($connection,$selectcategory);
$output='';
if(isset($_SESSION['supplierid'])){
	
	if(isset($_POST['addbook'])){
		$errors=array();
		if(!empty($_POST['booktitle']) || $_POST['booktitle']!==''){
			$booktitle=$_POST['booktitle'];
			$fbooktitle=mysqli_real_escape_string($connection,$booktitle);
		}else {
			$errors['booktitle']='booktitle is empty';
		}

		if(!empty($_POST['bookauthor']) || $_POST['bookauthor']!==''){
			$bookauthor=$_POST['bookauthor'];
			$fbookauthor=mysqli_real_escape_string($connection,$bookauthor);
		}else {
			$errors['bookauthor']='bookauthor is empty';
		}

		if(!empty($_POST['bookcategory']) || $_POST['bookcategory']!==''){
			$bookcategory=$_POST['bookcategory'];
			$fbookcategory=mysqli_real_escape_string($connection,$bookcategory);
		}else {
			$errors['bookcategory']='bookcategory is empty';
		}

		if(!empty($_POST['bookinfo']) || $_POST['bookinfo']!==''){
			$bookinfo=$_POST['bookinfo'];
			$fbookinfo=mysqli_real_escape_string($connection,$bookinfo);
		}else {
			$errors['bookinfo']='bookinfo is empty';
		}

		if(!empty($_POST['bookcost']) || $_POST['bookcost']!==''){
			$bookcost=$_POST['bookcost'];
			$fbookcost=mysqli_real_escape_string($connection,$bookcost);
			$fbookcost=$fbookcost+2000;
		}else {
			$errors['bookcost']='bookcost is empty';
		}

		if(!empty($_POST['bookimage']) || $_POST['bookimage']!==''){
			$bookimage=$_POST['bookimage'];
			$fbookimage=mysqli_real_escape_string($connection,$bookimage);
		}else {
			$errors['bookimage']='bookimage is empty';
		}

		$findsupplier="SELECT * FROM supplier WHERE supplierid='{$_SESSION['supplierid']}'";
		$runfindsupplier=mysqli_query($connection,$findsupplier);
		$supplierinfo=mysqli_fetch_array($runfindsupplier);
		
		$fsfirstname=$supplierinfo['firstname'];
		$fslastname=$supplierinfo['lastname'];
		$fsphone=$supplierinfo['phone'];
		$fsemail=$supplierinfo['email'];
		
		$status="disapproved";


		$file=$_FILES['file'];
		$filename=$_FILES['file']['name'];
		$filetype=$_FILES['file']['type'];
		$filetmpname=$_FILES['file']['tmp_name'];
		$fileerror=$_FILES['file']['error'];
		$filesize=$_FILES['file']['size'];

		$fileexplode=explode('.',$filename);
		$filenameext=strtolower(end($fileexplode));
		$allowed=array('jpg','jpeg','png');
		if(in_array($filenameext,$allowed)){
			if($fileerror===0){
				if($filesize<1000000){
					$filnamenew=uniqid('',true).'.'.$filenameext;
					$destination='uploads/'.$filnamenew;
					move_uploaded_file($filetmpname,$destination);
					header('location:index.php');

				}else {
					echo 'errors present';

				}

			}else {
				echo 'errors present';
			}

		}else {
			$error='format is not allowed';

		}
		if(empty($errors)){

		$insertquery="INSERT INTO books(booktitle,bookauthor,bookcategory,bookinfo,bookcost,bookimage,supplierfirstname,supplierlastname,supplierphone,supplieremail,status) VALUES('{$fbooktitle}','{$fbookauthor}','{$fbookcategory}','{$fbookinfo}','{$fbookcost}','{$filnamenew}','{$fsfirstname}','{$fslastname}','{$fsphone}','{$fsemail}','{$status}')";
		$run=mysqli_query($connection,$insertquery);
		if($run){	
	///Prepare th message by creating a new instance
	//setTo adds to a single receipent addTo you can add multiple recipient
	$message= Swift_Message::newInstance()
		->setSubject('Book added by a supplier')
		->setFrom(['admin@maaktaba.com' =>'Maaktaba'])
		->addTo('admins@maaktaba.com')
		->setBody('The following book has been added by supplier please visit the admin section to approve or disapprove'. '
        ' .'Booktitle:'.$fbooktitle.'
        '.'Book author:'.$fbookauthor.'
        '.'Book category:'.$fbookcategory.'
        '.'Book cost:'.$fbookcost.'
        '.'Supplier firstname:'.$femail.'
        '.'Supplier lastname:'.$fphone.'
        '.'Supplier phone:'.$fsphone.'
        '.' Supplier email:'.$fsemail);
		$transport= Swift_SmtpTransport::newInstance($smtp_server,465,'ssl')
			->setUsername($username)
			->setPassword($password);
	$mailer=Swift_Mailer::newInstance($transport);
	$result=$mailer->send($message);
	if($result){
		unset($_SESSION['booktitle']);
		unset($_SESSION['bookauthor']);
		header('location:bookadded.php');
		
		
	}else {
		die("Query failed");
	}
		
	}
}else {
	header('location:logins.php');

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
						<form action="index.php" method="post" style="width:100%;">
							<input type="search" placeholder="Book title" style="width:80%; margin:auto; height:40px; margin-bottom:0; color:#242424; box-sizing:border-box; padding:5px; border-radius:5px;">

						</form>
					</header>

				<!-- Nav -->
					<nav id="nav">
						<ul>
                            <li><a href="supplierprogress.php">Progress</a></li>
                            <li><a href="registerbooks.php" class="active">Add book</a></li>
							<li><a href="logouts.php">log out</a></li>
						</ul>
					</nav>

				<!-- Main -->
					<div id="main">

						<section id="second" class="main special">
							<header class="major">
								<h2>Register a book</h2>
								<p style="color:red;"><?php echo $output;?></p>
								<form method="post" action="registerbooks.php" enctype="multipart/form-data">
									<label style="font-size:25px; margin-bottom:0;">Book title</label>
									<input type="text" name="booktitle" placeholder="Book title" required style="width:50%; margin:auto; margin-bottom:5px; background-color:white; border:none; border:solid 1px rgba(0,0,0,0.5);">
									<label style="font-size:25px; margin-bottom:0;">Book Author</label>
									<input type="text" name="bookauthor" placeholder="Author" required style="width:50%; margin:auto; margin-bottom:5px; background-color:white; border:none; border:solid 1px rgba(0,0,0,0.5);">
									<label style="font-size:25px; margin-bottom:0;">Category</label>
									<select name="bookcategory" style="width:50%; margin:auto; margin-bottom:5px; background-color:white; border:none; border:solid 1px rgba(0,0,0,0.5);" required>
										<?php
										while($categorylist=mysqli_fetch_array($runquery)){
										
										
										?>
										<option value="<?php echo $categorylist['category'];?>" ><?php echo $categorylist['category'];?></option>
									<?php
										}
											?>
									
									</select>
					
									<label style="font-size:25px; margin-bottom:0;">Book image</label>
									<input type="file" name="file" value="image" required style="width:50%; margin:auto; margin-bottom:5px; background-color:white; border:none; border:solid 1px rgba(0,0,0,0.5);">
									<label style="font-size:25px; margin-bottom:0;">Book info</label>
									<input type="text" name="bookinfo" placeholder="Awards" required style="width:50%; margin:auto; margin-bottom:15px; background-color:white; border:none; border:solid 1px rgba(0,0,0,0.5);">
									<label style="font-size:25px; margin-bottom:0;">Book cost</label>
									<input type="number" name="bookcost" required placeholder="Price in Tshs" style="width:50%; margin:auto; margin-bottom:15px; background-color:white; display:block; height:45px; border:none; border:solid 1px rgba(0,0,0,0.5); border-radius:5px; box-sizing:border-radius; padding:10px 15px 10px 5px;">
									<input type="submit" name="addbook" value="Register">

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
