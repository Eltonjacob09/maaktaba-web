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
if(isset($_SESSION['adminid'])){
	
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
		}else {
			$errors['bookcost']='bookcost is empty';
		}

		if(!empty($_POST['bookimage']) || $_POST['bookimage']!==''){
			$bookimage=$_POST['bookimage'];
			$fbookimage=mysqli_real_escape_string($connection,$bookimage);
		}else {
			$errors['bookimage']='bookimage is empty';
		}

		if(!empty($_POST['sfirstname']) || $_POST['sfirstname']!==''){
			$sfirstname=$_POST['sfirstname'];
			$fsfirstname=mysqli_real_escape_string($connection,$sfirstname);
		}else {
			$errors['sfirstname']='sfirstname is empty';
		}

		if(!empty($_POST['slastname']) || $_POST['slastname']!==''){
			$slastname=$_POST['slastname'];
			$fslastname=mysqli_real_escape_string($connection,$slastname);
		}else {
			$errors['sfirstname']='sfirstname is empty';
		}

		if(!empty($_POST['semail']) || $_POST['semail']!==''){
			$semail=$_POST['semail'];
			$fsemail=mysqli_real_escape_string($connection,$semail);
		}else {
			$errors['semail']='semail is empty';
		}

		if(!empty($_POST['sphone']) || $_POST['sphone']!==''){
			$sphone=$_POST['sphone'];
			$fsphone=mysqli_real_escape_string($connection,$sphone);
		}else {
			$errors['semail']='semail is empty';
		}
		
		$status='approved';


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
			$errors='format is not allowed';

		}
		if(empty($errors)){
		$ava='present';
		$status='approve';
		$query="INSERT INTO books(booktitle,bookauthor,bookcategory,bookimage,bookcost,bookinfo,supplierfirstname,supplierlastname,supplierphone,supplieremail,status,available) VALUES('{$fbooktitle}','{$fbookauthor}','{$fbookcategory}','{$filnamenew}','{$fbookcost}','{$fbookinfo}','{$fsfirstname}','{$fslastname}','{$fsphone}','{$fsemail}','{$status}','{$ava}')";

		$run=mysqli_query($connection,$query);
		if(!$run){
			die('Query failed');
		}
		
		}else {
			header('location:index.php');
			$output='ensure all information are entered correctly';
		}
	}
}else {
	header('location:mkt-admin.php');

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
							<li><a href="registerbook.php" class="active">Add book</a></li>
							<li><a href="bookrequest.php">Book request</a></li>
							<li><a href="nbooks.php">Needed books</a></li>
							<li><a href="logout.php">log out</a></li>
						</ul>
					</nav>

				<!-- Main -->
					<div id="main">

						<section id="second" class="main special">
							<header class="major">
								<h2>Register a book</h2>
								<p style="color:red;"><?php echo $output;?></p>
								<form method="post" action="registerbook.php" enctype="multipart/form-data">
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
									<label style="font-size:25px; margin-bottom:0;">Supplier firstname</label>
									<input type="text" name="sfirstname" placeholder="Supplier firstname" required style="width:50%; margin:auto; margin-bottom:15px; background-color:white; border:none; border:solid 1px rgba(0,0,0,0.5);">
									<label style="font-size:25px; margin-bottom:0;">Supplier lastname</label>
									<input type="text" name="slastname" placeholder="Supplier lastname" required style="width:50%; margin:auto; margin-bottom:15px; background-color:white; border:none; border:solid 1px rgba(0,0,0,0.5);">
									<label style="font-size:25px; margin-bottom:0;">Supplier Phone</label>
									<input type="number" name="sphone" required placeholder="0757713445 this format please" style="width:50%; margin:auto; margin-bottom:15px; background-color:white; display:block; height:45px; border:none; border:solid 1px rgba(0,0,0,0.5); border-radius:5px; box-sizing:border-radius; padding:10px 15px 10px 5px;">
									<label style="font-size:25px; margin-bottom:0;">Supplier email</label>
									<input type="email" name="semail" placeholder="Supplier email" required style="width:50%; margin:auto; margin-bottom:15px; background-color:white; border:none; border:solid 1px rgba(0,0,0,0.5);">
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
