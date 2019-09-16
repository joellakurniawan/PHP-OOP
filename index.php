<?php
$con = mysqli_connect("localhost", "root", "", "lkmmtd_adsitercinta");
session_start();

class CFilm{
	public function show($con){
		$sql="select * from film";
		$result=mysqli_query($con,$sql);
		return $result;
	}
};

class CMall{
	public function show($con){
		$sql="select * from mall";
		$result=mysqli_query($con,$sql);
		return $result;
	}
};

class CCustomer{
	public function loggedin($con){
		$sql = "SELECT * FROM customer WHERE id_customer='".$_SESSION['idcustomer']."'";
		$result = mysqli_query($con,$sql);
		return $result;
	}
	public function update($con,$namacustomer,$emailcustomer,$usernamecustomer,$passwordcustomer,$notlpcustomer,$nokreditcustomer){
		$sql = "UPDATE customer SET nama_customer='$namacustomer', email_customer='$emailcustomer', username_customer='$usernamecustomer', password_customer='$passwordcustomer', notlp_customer='$notlpcustomer', nokredit_customer='$nokreditcustomer' WHERE id_customer=".$_SESSION['idcustomer']."";
		mysqli_query($con, $sql);
	}
};

$_film = new CFilm;
$_mall = new CMall;
$_customer = new CCustomer;

if(isset($_POST['showfilm'])){
	$result=$_film->show($con);
	while ($row=mysqli_fetch_array($result)) {
		echo '<div class="row">
		<div class="col-md-4 left-image">
		<img src="img/'.$row[3].'.jpg" width=100px>
		</div>
		<div class="col-md-8">
		<div class="right-about-text">
		<h4>'.$row[1].'</h4>
		<p>'.$row[2].'</p>
		<div class="primary-button">
		<a href="#" class="film" data-toggle="modal" data-target="#exampleModal2" val="'.$row[0].'">Schedule</a>
		</div>
		</div>
		</div>
		</div><br>';
	}
	exit();
}
if(isset($_POST['showmall'])){
	$result=$_mall->show($con);
	while ($row=mysqli_fetch_array($result)) {
		echo '<a href="#" class="list-group-item list-group-item-action mall" data-toggle="modal" data-target="#exampleModal1" val="'.$row[0].'">
		'.$row[1].'
		</a>';
	}
	exit();
}
if(isset($_POST['showfilm2'])){
	$idmall = $_POST['id_mall'];
	$sql = "SELECT DISTINCT f.judul_film, f.foto_film
	FROM mall m
	JOIN studio s ON m.id_mall = s.id_mall
	JOIN jadwal j ON s.id_studio = j.id_studio
	JOIN film f ON j.id_film = f.id_film
	WHERE m.id_mall =".$idmall." AND j.tanggal_jadwal = CURDATE() ";
	$result=mysqli_query($con,$sql);
	while ($row=mysqli_fetch_array($result)){
		echo '<div class="row">
		<div class="col-md-4 left-image">
		<img src="img/'.$row[1].'.jpg" width=160px>
		</div>
		<div class="col-md-8">
		<div class="right-about-text">
		<h4>'.$row[0].'</h4>';
		$sql2 = "SELECT DISTINCT j.tanggal_jadwal
		FROM mall m
		JOIN studio s ON m.id_mall = s.id_mall
		JOIN jadwal j ON s.id_studio = j.id_studio
		JOIN film f ON j.id_film = f.id_film
		WHERE m.id_mall =".$idmall." AND f.judul_film='".$row[0]."' AND j.tanggal_jadwal = CURDATE()";
		$result2=mysqli_query($con,$sql2);
		while ($row2=mysqli_fetch_array($result2)){
			echo '<h6>'.$row2[0].'</h6><div class="primary-button">';
			$sql3 = "SELECT j.jam_jadwal, j.id_jadwal
			FROM mall m
			JOIN studio s ON m.id_mall = s.id_mall
			JOIN jadwal j ON s.id_studio = j.id_studio
			JOIN film f ON j.id_film = f.id_film
			WHERE m.id_mall =".$idmall." AND f.judul_film='".$row[0]."' AND j.tanggal_jadwal='".$row2[0]."' ORDER BY j.jam_jadwal";
			$result3=mysqli_query($con,$sql3);
			while ($row3=mysqli_fetch_array($result3)){
				$jam = substr($row3[0], 0, 2);
				$cekjam = (int)$jam;
				if ($jam >= date("H")){
					echo '<a href="ceklogin.php" style="padding:3px; margin:3px;" class="listjam" val="'.$row3[1].'">'.$row3[0].'</a>';
				}
				else {
					echo '<a style="padding:3px; margin:3px; pointer-events:none; cursor:default; background-color: #D3D3D3;" class="listjam">'.$row3[0].'</a>';	
				}
			}
			echo '</div><br>';
		}
		echo '</div></div></div><br>';
	}
	exit();
}
if(isset($_POST['showmall2'])){
	$idfilm = $_POST['id_film'];
	$sql = "SELECT * FROM film WHERE id_film=".$idfilm."";
	$result=mysqli_query($con,$sql);
	while ($row=mysqli_fetch_array($result)){
		echo '<div class="row">
		<div class="col-md-4 left-image">
		<img src="img/'.$row[3].'.jpg" width=160px>
		</div>
		<div class="col-md-8">
		<div class="right-about-text">
		<h4>'.$row[1].'</h4>';
	}
	$sql = "SELECT DISTINCT m.nama_mall
	FROM mall m
	JOIN studio s ON m.id_mall = s.id_mall
	JOIN jadwal j ON s.id_studio = j.id_studio
	JOIN film f ON j.id_film = f.id_film
	WHERE f.id_film=".$idfilm." AND j.tanggal_jadwal = CURDATE()";
	$result=mysqli_query($con,$sql);
	while ($row=mysqli_fetch_array($result)){
		echo '<h6>'.$row[0].'</h6><div class="primary-button">';
		$sql3 = "SELECT DISTINCT j.jam_jadwal, j.id_jadwal
		FROM mall m
		JOIN studio s ON m.id_mall = s.id_mall
		JOIN jadwal j ON s.id_studio = j.id_studio
		JOIN film f ON j.id_film = f.id_film
		WHERE f.id_film =".$idfilm."
		AND m.nama_mall='".$row[0]."'
		AND j.tanggal_jadwal = CURDATE( ) ORDER BY j.jam_jadwal";
		$result3=mysqli_query($con,$sql3);
		while ($row3=mysqli_fetch_array($result3)){
			$jam = substr($row3[0], 0, 2);
			$cekjam = (int)$jam;
			if ($jam >= date("H")){
				echo '<a href="ceklogin.php" style="padding:3px; margin:3px;" class="listjam" val="'.$row3[1].'">'.$row3[0].'</a>';
			}
			else {
				echo '<a style="padding:3px; margin:3px; pointer-events:none; cursor:default; background-color: #D3D3D3;" class="listjam">'.$row3[0].'</a>';	
			}
		}
		echo '</div><br>';
	}
	echo '</div></div></div><br>';
	exit();
}
if(isset($_POST['setidjadwal'])){
	$idjadwal = $_POST['id_jadwal'];
	$_SESSION['idjadwal'] = $idjadwal;
}
if(isset($_POST['showtiketmendatang'])){
	$sql = "SELECT p.id_pesanan, count(id_tiket), m.nama_mall, j.tanggal_jadwal, j.jam_jadwal, f.judul_film, f.foto_film
		FROM pesanan p
		JOIN customer c ON p.id_customer = c.id_customer
		JOIN tiket t ON t.id_pesanan = p.id_pesanan
		JOIN jadwal j ON t.id_jadwal = j.id_jadwal
		JOIN studio s ON s.id_studio = j.id_studio
		JOIN mall m ON m.id_mall=s.id_mall
		JOIN film f ON j.id_film=f.id_film
		WHERE c.id_customer='".$_SESSION['idcustomer']."' AND j.tanggal_jadwal>=CURDATE()
		GROUP BY p.id_pesanan";
	$result=mysqli_query($con,$sql);
	while ($row=mysqli_fetch_array($result)){
		echo '<div class="row">
			<div class="col-md-5 left-image">
				<img src="img/'.$row[6].'.jpg">
			</div>
			<div class="col-md-7">
				<div class="right-feature-text">
					<h4>'.$row[5].'</h4>
					<div class="feature-list">
						<table>
							<tr>
								<td width=30px><i class="fas fa-map-marker-alt"></i></td>
								<td>'.$row[2].'</td>
							</tr>
							<tr>
								<td><i class="fas fa-ticket-alt"></i></td>
								<td> '.$row[1].' Tiket </td>
							</tr>
							<tr>
								<td><i class="fas fa-calendar-alt"></i></td>
								<td>'.$row[3].'</td>
							</tr>
							<tr>
								<td><i class="far fa-clock"></i></td>
								<td>'.$row[4].'</td>
							</tr>
						</table>
					</div>
				</div>
			</div>
			</div><br>';
	}
	exit();
}
if(isset($_POST['showdaftartransaksi'])){
	$sql = "SELECT p.id_pesanan, count(id_tiket), m.nama_mall, j.tanggal_jadwal, j.jam_jadwal, f.judul_film, f.foto_film
		FROM pesanan p
		JOIN customer c ON p.id_customer = c.id_customer
		JOIN tiket t ON t.id_pesanan = p.id_pesanan
		JOIN jadwal j ON t.id_jadwal = j.id_jadwal
		JOIN studio s ON s.id_studio = j.id_studio
		JOIN mall m ON m.id_mall=s.id_mall
		JOIN film f ON j.id_film=f.id_film
		WHERE c.id_customer='".$_SESSION['idcustomer']."' AND j.tanggal_jadwal<CURDATE()
		GROUP BY p.id_pesanan";
	$result=mysqli_query($con,$sql);
	while ($row=mysqli_fetch_array($result)){
		echo '<div class="row">
			<div class="col-md-5 left-image">
				<img src="img/'.$row[6].'.jpg">
			</div>
			<div class="col-md-7">
				<div class="right-feature-text">
					<h4>'.$row[5].'</h4>
					<div class="feature-list">
						<table>
							<tr>
								<td width=30px><i class="fas fa-map-marker-alt"></i></td>
								<td>'.$row[2].'</td>
							</tr>
							<tr>
								<td><i class="fas fa-ticket-alt"></i></td>
								<td> '.$row[1].' Tiket </td>
							</tr>
							<tr>
								<td><i class="fas fa-calendar-alt"></i></td>
								<td>'.$row[3].'</td>
							</tr>
							<tr>
								<td><i class="far fa-clock"></i></td>
								<td>'.$row[4].'</td>
							</tr>
						</table>
					</div>
				</div>
			</div>
			</div><br>';
	}
	exit();
}
if(isset($_POST['cekloggedin'])){
	if (!isset($_SESSION['idcustomer'])){
		echo 'gaada';
	}
	else if (isset($_SESSION['idcustomer'])){
		echo 'ada';
	}
	exit();
}
if(isset($_POST['loggedin'])){
	$result = $_customer->loggedin($con);
	$row = mysqli_fetch_array($result);
	echo '<tr>
			<th scope="row" height=30px width=200px>Nama:</th>
			<td align="left">'.$row[1].'</td>
		</tr>
		<tr>
			<th scope="row" height=30px>Email:</th>
			<td align="left">'.$row[2].'</td>
		</tr>
		<tr>
			<th scope="row" height=30px>No Tlp: </th>
			<td align="left">'.$row[3].'</td>
		</tr>
		<tr>
			<th scope="row" height=30px>No Kartu Kredit: </th>
			<td align="left">'.$row[7].'</td>
		</tr>
		<tr>
			<th scope="row" height=30px>Username:</th>
			<td align="left">'.$row[4].'</td>
		</tr>
		<tr>
			<th scope="row" height=30px>Password: </th>
			<td align="left">'.$row[5].'</td>
		</tr>
		<tr >
			<th scope="row" height=30px>Poin: </th>
			<td align="left">'.$row[6].'</td>
		</tr>';
	exit();
}
if(isset($_POST['editprofile'])){
	$result = $_customer->loggedin($con);
	$row = mysqli_fetch_array($result);
	echo '<form action="javascript:saveeditprofile();"
			<div class="form-group">
			<label for="nama">Nama</label>
			<input type="text" class="form-control" id="namacustomer" value="'.$row[1].'">
			</div>
			<div class="form-group">
			<label for="email">Email</label>
			<input type="text" class="form-control" id="emailcustomer" value="'.$row[2].'">
			</div>
			<div class="form-group">
			<label for="username">Username</label>
			<input type="text" class="form-control" id="usernamecustomer" value="'.$row[4].'">
			</div>
			<div class="form-group">
			<label for="password">Password</label>
			<input type="text" class="form-control" id="passwordcustomer" value="'.$row[5].'">
			</div>
			<div class="form-group">
			<label for="notlp">No Tlp</label>
			<input type="text" class="form-control" id="notlpcustomer" value="'.$row[3].'">
			</div>
			<div class="form-group">
			<label for="nokredit">No Kartu Kredit</label>
			<input type="text" class="form-control" id="nokreditcustomer" value="'.$row[7].'">
			</div>
			<button type="submit" class="btn btn-primary" data-dismiss="modal" id="saveedit">Save</button>
			<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button> </form>';
	exit();
}
if(isset($_POST['saveedit'])){
	$_customer->update($con,$_POST['nama_customer'],$_POST['email_customer'],$_POST['username_customer'],$_POST['password_customer'],$_POST['notlp_customer'],$_POST['nokredit_customer']);
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

<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">

<script>
	$(document).ready(function(){
		showfilm();
		showmall();
		showtiketmendatang();
		showdaftartransaksi();
		cekloggedin();
		$(".list-group").on("click", ".mall", function(){
			var idmall=$(this).attr("val");
			$.ajax({
				url : "index.php",
				type : "POST",
				async : false,
				cache : false,
				data : {
					showfilm2 : 1,
					id_mall : idmall
				},
				success: function(result){
					$(".modal1").html(result);
				}
			});
		});
		$(".second-content").on("click", ".film", function(){
			var idfilm=$(this).attr("val");
			$.ajax({
				url : "index.php",
				type : "POST",
				async : false,
				cache : false,
				data : {
					showmall2 : 1,
					id_film : idfilm
				},
				success: function(result){
					$(".modal2").html(result);
				}
			});
		});
		$(".modal1").on("click", ".listjam", function(){
			var idjadwal = $(this).attr("val");
			$.ajax({
				url : "index.php",
				type : "POST",
				async : false,
				cache : false,
				data : {
					setidjadwal : 1,
					id_jadwal : idjadwal
				},
				success: function(result){
				}
			});
		});
		$(".modal2").on("click", ".listjam", function(){
			var idjadwal = $(this).attr("val");
			$.ajax({
				url : "index.php",
				type : "POST",
				async : false,
				cache : false,
				data : {
					setidjadwal : 1,
					id_jadwal : idjadwal
				},
				success: function(result){
				}
			});
		});
		$(".editprofile").click(function(){
			$.ajax({
				url : "index.php",
				type : "POST",
				async : false,
				cache : false,
				data : {
					editprofile : 1
				},
				success: function(result){
					$(".modal3").html(result);
				}
			});
		});
		$(".modal3").on("click", "#saveedit", function(){
			var namacustomer=$(".modal3 #namacustomer").val();
			var emailcustomer=$(".modal3 #emailcustomer").val();
			var usernamecustomer=$(".modal3 #usernamecustomer").val();
			var passwordcustomer=$(".modal3 #passwordcustomer").val();
			var notlpcustomer=$(".modal3 #notlpcustomer").val();
			var nokreditcustomer=$(".modal3 #nokreditcustomer").val();
			$.ajax({
				url : "index.php",
				type : "POST",
				async : false,
				cache : false,
				data : {
					saveedit : 1,
					nama_customer : namacustomer,
					email_customer : emailcustomer,
					username_customer : usernamecustomer,
					password_customer : passwordcustomer,
					notlp_customer : notlpcustomer,
					nokredit_customer : nokreditcustomer
				},
				success: function(result){
					loggedin();
				}
			});
		});
	});
	function showfilm(){
		$.ajax({
			url : "index.php",
			type : "POST",
			async : false,
			cache : false,
			data : {
				showfilm : 1
			},
			success: function(result){
				$(".second-content").html(result);
			}
		});
	}
	function showmall(){
		$.ajax({
			url : "index.php",
			type : "POST",
			async : false,
			cache : false,
			data : {
				showmall : 1
			},
			success: function(result){
				$(".list-group").html(result);
			}
		});
	}
	function showtiketmendatang(){
		$.ajax({
			url : "index.php",
			type : "POST",
			async : false,
			cache : false,
			data : {
				showtiketmendatang : 1
			},
			success: function(result){
				$("#tiketmendatang").html(result);
			}
		});
	}
	function showdaftartransaksi(){
		$.ajax({
			url : "index.php",
			type : "POST",
			async : false,
			cache : false,
			data : {
				showdaftartransaksi : 1
			},
			success: function(result){
				$("#daftartransaksi").html(result);
			}
		});
	}
	function cekloggedin(){
		$.ajax({
			url : "index.php",
			type : "POST",
			async : false,
			cache : false,
			data : {
				cekloggedin : 1
			},
			success: function(result){
				if (result == 'ada'){
					$(".loggedout").css("visibility", "hidden");
					$(".loggedin").css("visibility", "visible");
					loggedin();
				}
				else {
					$(".loggedout").css("visibility", "visible");
					$(".loggedin").css("visibility", "hidden");
				}
			}
		});
	}
	function loggedin(){
		$.ajax({
			url : "index.php",
			type : "POST",
			async : false,
			cache : false,
			data : {
				loggedin : 1
			},
			success: function(result){
				$(".table").html(result);
			}
		});
	}
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
							<li class="selected"><a href="#0"><div class="image-icon"><img src="img/bioskop.png" width=40px></div><h6>Bioskop</h6></a></li>
							<li><a href="#0"><div class="image-icon"><img src="img/film.png" width=40px></div><h6>Film</h6></a></li>
							<li><a href="#0"><div class="image-icon"><img src="img/account.png" width=40px></div><h6>My Account</h6></a></li>
						</ul>
					</nav> 
				</div> <!-- .cd-slider-nav -->

				<ul class="cd-hero-slider">

					<li class="selected">
						<div class="heading">
							<h1>MALL</h1>
							<span>pilih tempat nonton kamu!</span>
						</div>
						<div class="cd-full-width first-slide">
							<div class="container">
								<div class="row">
									<div class="col-md-12">
										<div class="content first-content">
											<div class="list-group">
											</div>
										</div>
									</div>
								</div>                  
							</div>
						</div>
					</li>

					<li>
						<div class="heading">
							<h1>FILM</h1>
							<span>sedang tayang</span> 
						</div>
						<div class="cd-half-width second-slide">   
							<div class="container">
								<div class="row">
									<div class="col-md-12">
										<div class="content second-content">
										</div>
									</div>
								</div>                  
							</div>
						</div>
					</li>

					<li class="myaccount">
						<div class="heading">
							<h1>My Account</h1>
							<span></span> 
						</div>
						<div class="cd-half-width third-slide">
							<div class="container">
								<div class="row">
									<div class="col-md-12">
										<div class="content third-content">
											<div class="row loggedin" style="visibility: visible;">
												<table align="center">
													<tbody class="table">
													</tbody>
												</table>
												<div class="primary-button">
													<a href="#" class="editprofile" data-toggle="modal" data-target="#exampleModal3" val="">Edit Profile</a>
												</div>
											</div>
											<div class="row loggedout" style="visibility:visible;">
												<div class="primary-button">
													<a href="logincustomer.php" val="">Log In</a>
												</div>
											</div>
											<div class="row loggedin" style="visibility: visible;">
												<div class="col-md-6">
													<h3> TIKET MENDATANG </h3>
														<br><br>
													<div id="tiketmendatang">
														
													</div>
												</div>
												<div class="col-md-6">
													<h3> DAFTAR TRANSAKSI </h3>
														<br><br>
													<div id="daftartransaksi">
														
													</div>
												</div>
											</div>
											<div class="row loggedin" style="visibility: visible;">
												<button type="submit" class="btn btn-secondary" id="logout" onclick="window.location.href='logout.php'"> Log Out </button>
											</div>
										</div>
									</div>
								</div>                  
							</div>
						</div>
					</li>

					<!-- <div class="btn btn-secondary">
						<a href="#">Discover More</a>
					</div> -->
				</ul>
				</section> <!-- .cd-hero -->

				<!-- Modal -->
				<div class="modal fade" id="exampleModal1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
					<div class="modal-dialog" role="document">
						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
									<span aria-hidden="true">&times;</span>
								</button>
								<h5 class="modal-title" id="exampleModalLabel">NOW SHOWING</h5>
							</div>
							<div class="modal-body modal1">

							</div>
							<div class="modal-footer">
								<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
							</div>
						</div>
					</div>
				</div>

				<!-- Modal -->
				<div class="modal fade" id="exampleModal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
					<div class="modal-dialog" role="document">
						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
									<span aria-hidden="true">&times;</span>
								</button>
								<h5 class="modal-title" id="exampleModalLabel">NOW SHOWING</h5>
							</div>
							<div class="modal-body modal2">

							</div>
							<div class="modal-footer">
								<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
							</div>
						</div>
					</div>
				</div>

				<!-- Modal -->
				<div class="modal fade" id="exampleModal3" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
					<div class="modal-dialog" role="document">
						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
									<span aria-hidden="true">&times;</span>
								</button>
								<h5 class="modal-title" id="exampleModalLabel">EDIT PROFILE</h5>
							</div>
							<div class="modal-body modal3">
								
							</div>
							<!-- <div class="modal-footer">
								<button type="button" class="btn btn-primary" data-dismiss="modal" id="saveedit">Save</button>
								<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
							</div> -->
						</div>
					</div>
				</div>

				
				<footer>
					<p>Copyright &copy; 2019 Jesseland 

						<!-- | Designed by <a href="http://www.templatemo.com" target="_parent"><em>templatemo</em></a></p> -->
					</footer>

					<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
					<script>window.jQuery || document.write('<script src="js/vendor/jquery-1.11.2.min.js"><\/script>')</script>

					<script src="js/vendor/bootstrap.min.js"></script>
					<script src="js/plugins.js"></script>
					<script src="js/main.js"></script>

				</body>
				</html>