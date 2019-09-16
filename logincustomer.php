<?php
$con = mysqli_connect("localhost", "root", "", "lkmmtd_adsitercinta");
session_start();

class CCustomer{
	public function add($con,$nama,$email,$nohp,$username,$password,$nokredit){
		$sql = "INSERT INTO customer values(NULL,'$nama','$email','$nohp','$username', '$password', 0, '$nokredit')";
		mysqli_query($con,$sql);
	}
	public function login($con,$username,$password){
		$sql = "SELECT * FROM customer WHERE username_customer='$username' and password_customer='$password'";
		$result = mysqli_query($con,$sql);
		return $result;
	}
};

$_customer = new CCustomer;

if(isset($_POST['login'])){
	$query = $_customer->login($con,$_POST['logUsername'],$_POST['logPassword']);
	$hasil = mysqli_fetch_array($query);
	echo (mysqli_num_rows($query));
	if (mysqli_num_rows($query) == 1){
		$_SESSION['idcustomer'] = $hasil[0];
	}
	exit();
}
if(isset($_POST['signup'])){
	$_customer->add($con,$_POST['signNama'],$_POST['signEmail'],$_POST['signNohp'],$_POST['signUsername'],$_POST['signPassword'],$_POST['signNokredit']);
	exit();
}
?>
<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang=""> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8" lang=""> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9" lang=""> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang=""> <!--<![endif]-->
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<title>ADSI</title>
<!--
Newline Template
http://www.templatemo.com/tm-503-newline
-->
<meta name="description" content="">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="apple-touch-icon" href="apple-touch-icon.png">

<link rel="stylesheet" href="css/bootstrap.min.css">
<link rel="stylesheet" href="css/bootstrap-theme.min.css">
<link rel="stylesheet" href="css/fontAwesome.css">
<link rel="stylesheet" href="css/templatemo-style.css">

<link href="https://fonts.googleapis.com/css?family=Montserrat:100,200,300,400,500,600,700,800,900" rel="stylesheet">

<script src="js/vendor/modernizr-2.8.3-respond-1.4.2.min.js"></script>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

<script>
	$(document).ready(function(){
		$("#login").click(function(){
			var username = $("#inputUsername").val();
			var password = $("#inputPassword").val();
			$.ajax({
				url : "logincustomer.php",
				type : "POST",
				async : false,
				cache : false,
				data : {
					login : 1,
					logUsername : username,
					logPassword : password
				},
				success: function(result){
					if(result == "1"){
						window.location.href="pesantiket.php";
					}
					else{
						window.location.href="logincustomer.php";
					}
				}
			});
		});
		$("#signup").click(function(){
			var nama = $("#daftarNama").val();
			var email = $("#daftarEmail").val();
			var nohp = $("#daftarNohp").val();
			var nokredit = $("#daftarNokredit").val();
			var username = $("#daftarUsername").val();
			var password = $("#daftarPassword").val();
			$.ajax({
				url : "logincustomer.php",
				type : "POST",
				async : false,
				cache : false,
				data : {
					signup : 1,
					signNama : nama,
					signEmail : email,
					signNohp : nohp,
					signUsername : username,
					signPassword : password,
					signNokredit : nokredit
				},
				success: function(result){
					window.location.href="logincustomer.php";
				}
			});
		});
	});
</script>

</head>
<body>

	<div class="overlay"></div>
	<section class="top-part">
		<video controls autoplay loop>
			<source src="videos/video.mp4" type="video/mp4">
				<source src="videos/video.ogg" type="video/ogg">
					Your browser does not support the video tag.
				</video>
			</section>

			<section class="cd-hero">

				<div class="cd-slider-nav">
					<nav>
						<span class="cd-marker item-1"></span>
						<ul>
							<li class="selected"><a href="#0"><div class="image-icon"><img src="img/login.png" width=40px></div><h6>Log In</h6></a></li>
							<li><a href="#0"><div class="image-icon"><img src="img/signup.png" width=40px></div><h6>Sign Up</h6></a></li>
						</ul>
					</nav> 
				</div> <!-- .cd-slider-nav -->

				<ul class="cd-hero-slider">

					<li class="selected">
						<div class="heading">
							<h1>LOG IN</h1>
							<span></span>
						</div>
						<div class="cd-full-width first-slide">
							<div class="container">
								<div class="row">
									<div class="col-md-12">
										<div class="content first-content">
											<div class="form-group">
												<label for="exampleInputEmail1">Username</label>
												<input type="text" class="form-control" id="inputUsername" aria-describedby="emailHelp" placeholder="Enter username">
											</div>
											<div class="form-group">
												<label for="exampleInputPassword1">Password</label>
												<input type="password" class="form-control" id="inputPassword" placeholder="Password">
											</div>
											<button type="submit" class="btn btn-primary" id="login">Log in</button>
										</div>
									</div>
								</div>                  
							</div>
						</div>
					</li>

					<li>
						<div class="heading">
							<h1>SIGN UP</h1>
							<span>create your account</span>
						</div>
						<div class="cd-full-width first-slide">
							<div class="container">
								<div class="row">
									<div class="col-md-12">
										<div class="content first-content">
											<div class="form-group">
												<label for="exampleInputEmail1">Nama</label>
												<input type="text" class="form-control" id="daftarNama" placeholder="Nama">
											</div>
											<div class="form-group">
												<label for="exampleInputEmail1">Email</label>
												<input type="text" class="form-control" id="daftarEmail" placeholder="Email">
											</div>
											<div class="form-group">
												<label for="exampleInputEmail1">No HP</label>
												<input type="text" class="form-control" id="daftarNohp" placeholder="No HP">
											</div>
											<div class="form-group">
												<label for="exampleInputEmail1">No Kartu Kredit</label>
												<input type="text" class="form-control" id="daftarNokredit" placeholder="No Kartu Kredit">
											</div>
											<div class="form-group">
												<label for="exampleInputEmail1">Username</label>
												<input type="text" class="form-control" id="daftarUsername" placeholder="Username">
											</div>
											<div class="form-group">
												<label for="exampleInputPassword1">Password</label>
												<input type="password" class="form-control" id="daftarPassword" placeholder="Password">
											</div>
											<button type="submit" class="btn btn-primary" id="signup">Sign Up</button>
										</div>
									</div>
								</div>                  
							</div>
						</div>
					</li>

				</ul>	

			</section> <!-- .cd-hero -->


			<footer>
				<p>Copyright &copy; 2017 Your Company 

					| Designed by <a href="http://www.templatemo.com" target="_parent"><em>templatemo</em></a></p>
				</footer>

				<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
				<script>window.jQuery || document.write('<script src="js/vendor/jquery-1.11.2.min.js"><\/script>')</script>

				<script src="js/vendor/bootstrap.min.js"></script>
				<script src="js/plugins.js"></script>
				<script src="js/main.js"></script>

			</body>
			</html>