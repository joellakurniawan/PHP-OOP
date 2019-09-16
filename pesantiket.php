<?php
$con = mysqli_connect("localhost", "root", "", "lkmmtd_adsitercinta");
session_start();
if(!isset($_SESSION['idjadwal'])){
	header("Location:index.php");
}
class CTiket{
	public function show($con){
		$sql="SELECT id_tiket, nomor_kursi,status_tiket, id_pesanan FROM tiket WHERE id_jadwal=".$_SESSION['idjadwal']."";
		$result=mysqli_query($con,$sql);
		return $result;
	}
};

$_tiket = new CTiket;

if(isset($_POST['showjudul'])){
	$sql="SELECT f.judul_film
	FROM jadwal j JOIN film f ON j.id_film=f.id_film
	JOIN studio s ON j.id_studio=s.id_studio
	JOIN mall m ON s.id_mall=m.id_mall
	WHERE j.id_jadwal =".$_SESSION['idjadwal']."";
	$result=mysqli_query($con,$sql);
	$hasil=mysqli_fetch_array($result);
	echo ($hasil[0]);
	exit();
}
if(isset($_POST['showketerangan'])){
	$sql="SELECT m.nama_mall, j.jam_jadwal, s.nama_studio
	FROM jadwal j JOIN film f ON j.id_film=f.id_film
	JOIN studio s ON j.id_studio=s.id_studio
	JOIN mall m ON s.id_mall=m.id_mall
	WHERE j.id_jadwal =".$_SESSION['idjadwal']."";
	$result=mysqli_query($con,$sql);
	$hasil=mysqli_fetch_array($result);
	echo ''.$hasil[0].' | '.$hasil[1].' | Studio '.$hasil[2].'';
	exit();
}
if(isset($_POST['showtiket'])){
	$result=$_tiket->show($con);
	$counter=0;
	while ($row=mysqli_fetch_array($result)){
		$counter = $counter + 1;
		if($row[2]==1){
			if ($counter<8){
				echo '<a href="#" style="width:30px; padding:3px; margin:3px;pointer-events: none;background-color: #D3D3D3;" class="listkursi" disabled val="'.$row[0].'">'.$row[1].'</a>';
			}
			elseif ($counter==8){
				echo '<a href="#" style="width:30px; padding:3px; margin:3px;pointer-events: none;background-color: #D3D3D3;" class="listkursi" disabled val="'.$row[0].'">'.$row[1].'</a>';
				echo '<span style="display:inline-block; width: 50px;"></span>';
			}
			elseif ($counter==16) {
				echo '<a href="#" style="width:30px; padding:3px; margin:3px;pointer-events: none;background-color: #D3D3D3;" class="listkursi" disabled val="'.$row[0].'">'.$row[1].'</a><br>';
				$counter=0;
			}
			elseif ($counter>8 && $counter<16){
				echo '<a href="#" style="width:30px; padding:3px; margin:3px;pointer-events: none;background-color: #D3D3D3;" class="listkursi" disabled val="'.$row[0].'">'.$row[1].'</a>';
			}
		}
		else{
			if($row[3]==0){
				if ($counter<8){
					echo '<a href="#" style="width:30px; padding:3px; margin:3px;background-color: #ffbb05;" class="listkursi" val="'.$row[0].'" idpesanan="'.$row[3].'">'.$row[1].'</a>';
				}
				elseif ($counter==8){
					echo '<a href="#" style="width:30px; padding:3px; margin:3px;background-color: #ffbb05;" class="listkursi" val="'.$row[0].'" idpesanan="'.$row[3].'">'.$row[1].'</a>';
					echo '<span style="display:inline-block; width: 50px;"></span>';
				}
				elseif ($counter==16) {
					echo '<a href="#" style="width:30px; padding:3px; margin:3px;background-color: #ffbb05;" class="listkursi" val="'.$row[0].'" idpesanan="'.$row[3].'">'.$row[1].'</a><br>';
					$counter=0;
				}
				elseif ($counter>8 && $counter<16){
					echo '<a href="#" style="width:30px; padding:3px; margin:3px;background-color: #ffbb05;" class="listkursi" val="'.$row[0].'" idpesanan="'.$row[3].'">'.$row[1].'</a>';
				}
			}
			else{
				if ($counter<8){
					echo '<a href="#" style="width:30px; padding:3px; margin:3px;background-color: #a1ff89;" class="listkursi" val="'.$row[0].'" idpesanan="'.$row[3].'">'.$row[1].'</a>';
				}
				elseif ($counter==8){
					echo '<a href="#" style="width:30px; padding:3px; margin:3px;background-color: #a1ff89;" class="listkursi" val="'.$row[0].'" idpesanan="'.$row[3].'">'.$row[1].'</a>';
					echo '<span style="display:inline-block; width: 50px;"></span>';
				}
				elseif ($counter==16) {
					echo '<a href="#" style="width:30px; padding:3px; margin:3px;background-color: #a1ff89;" class="listkursi" val="'.$row[0].'" idpesanan="'.$row[3].'">'.$row[1].'</a><br>';
					$counter=0;
				}
				elseif ($counter>8 && $counter<16){
					echo '<a href="#" style="width:30px; padding:3px; margin:3px;background-color: #a1ff89;" class="listkursi" val="'.$row[0].'" idpesanan="'.$row[3].'">'.$row[1].'</a>';
				}
			}
		}	
	}
	exit();
}
if(isset($_POST['pilihtiket'])){
	$idtiket = $_POST['id_tiket'];
	$sql0 = "SELECT id_pesanan FROM tiket WHERE id_tiket=".$idtiket."";
	$result0 = mysqli_query($con,$sql0);
	$hasil0 = mysqli_fetch_array($result0);
	if ( $hasil0[0] == '0'){
		$sql = "SELECT max(id_pesanan) FROM pesanan";
		$result = mysqli_query($con,$sql);
		$hasil = mysqli_fetch_array($result);
		$idpesanan = $hasil[0] + 1;
		$sql = "UPDATE tiket SET id_pesanan=".$idpesanan." WHERE id_tiket=".$idtiket."";
		mysqli_query($con,$sql);
	}
	else {
		$sql = "UPDATE tiket SET id_pesanan=0 WHERE id_tiket=".$idtiket."";
		mysqli_query($con,$sql);
	}
	exit();
}
if(isset($_POST['updatetotal'])){
	$sql = "SELECT max(id_pesanan) FROM pesanan";
	$result = mysqli_query($con,$sql);
	$hasil = mysqli_fetch_array($result);
	$idpesanan = $hasil[0] + 1;
	$sql = "SELECT SUM( j.harga_tiket ) 
	FROM tiket t
	JOIN jadwal j ON t.id_jadwal = j.id_jadwal
	WHERE t.id_pesanan =".$idpesanan."";
	$result = mysqli_query($con,$sql);
	$hasil = mysqli_fetch_array($result);
	echo ($hasil[0]);
	exit();
}
if(isset($_POST['getidpesanan'])){
	$sql = "SELECT max(id_pesanan) FROM pesanan";
	$result = mysqli_query($con,$sql);
	$hasil = mysqli_fetch_array($result);
	$idpesanan = $hasil[0] + 1;
	echo ($idpesanan);
	exit();
}
if(isset($_POST['detailpesanan'])){
	$sql = "SELECT * FROM customer WHERE id_customer=".$_SESSION['idcustomer']."";
	$result = mysqli_query($con,$sql);
	$hasil = mysqli_fetch_array($result);
	$sql = "SELECT f.judul_film, j.tanggal_jadwal, j.jam_jadwal
	FROM film f
	JOIN jadwal j ON f.id_film = j.id_film
	WHERE j.id_jadwal=".$_SESSION['idjadwal']."";
	$result = mysqli_query($con,$sql);
	while ($row=mysqli_fetch_array($result)){
		echo '<tr>
		<th scope="row"> Nama </th>
		<td>'.$hasil[1].' 
		</tr>
		<tr>
		<th scope="row" width=100px>Movie Title</th>
		<td>'.$row[0].'</td>
		</tr>
		<tr>
		<th scope="row">Date</th>
		<td>'.$row[1].'</td>
		</tr>
		<tr>
		<th scope="row">Time</th>
		<td>'.$row[2].'</td>
		</tr>';
	}
	exit();
}
if(isset($_POST['detailpesanan2'])){
	$sql = "SELECT max(id_pesanan) FROM pesanan";
	$result = mysqli_query($con,$sql);
	$hasil = mysqli_fetch_array($result);
	$idpesanan = $hasil[0] + 1;
	$sql = "SELECT nomor_kursi
	FROM tiket
	WHERE id_pesanan=".$idpesanan."";
	$result = mysqli_query($con,$sql);
	echo '<tr> <th scope="row"> Ticket(s) </th> <td> ';
	while ($row=mysqli_fetch_array($result)){
		echo ''.$row[0].'  ';
	}
	echo '</td></tr>';
	exit();
}
if(isset($_POST['detailpesanan3'])){
	$sql = "SELECT max(id_pesanan) FROM pesanan";
	$result = mysqli_query($con,$sql);
	$hasil = mysqli_fetch_array($result);
	$idpesanan = $hasil[0] + 1;
	$sql = "SELECT SUM( j.harga_tiket ) 
	FROM tiket t
	JOIN jadwal j ON t.id_jadwal = j.id_jadwal
	WHERE t.id_pesanan =".$idpesanan."";
	$result = mysqli_query($con,$sql);
	$hasil = mysqli_fetch_array($result);
	echo '<tr><th scope="row">Total</th><td>'.$hasil[0].'</td></tr>';
	exit();
}
if(isset($_POST['purchase'])){
	$sql = "SELECT max(id_pesanan) FROM pesanan";
	$result = mysqli_query($con,$sql);
	$hasil = mysqli_fetch_array($result);
	$idpesanan = $hasil[0] + 1;
	$sql = "SELECT SUM( j.harga_tiket ) 
	FROM tiket t
	JOIN jadwal j ON t.id_jadwal = j.id_jadwal
	WHERE t.id_pesanan =".$idpesanan."";
	$result = mysqli_query($con,$sql);
	$hasil = mysqli_fetch_array($result);
	$totalharga = $hasil[0];
	$jenispembayaran = $_POST['jenis_pembayaran'];
	$inputno = $_POST['input_no'];
	if ($jenispembayaran == 2){
		$sql = "SELECT notlp_customer FROM customer WHERE id_customer=".$_SESSION['idcustomer']."";
		$result = mysqli_query($con,$sql);
		$hasil = mysqli_fetch_array($result);
		if ($inputno == $hasil[0]){
			$sql = "INSERT INTO pesanan VALUES (NULL, 1,".$jenispembayaran.", ".$_SESSION['idcustomer'].", 0, ".$totalharga.")";
			mysqli_query($con,$sql);
			$sql = "UPDATE tiket SET status_tiket=1 WHERE id_pesanan=".$idpesanan."";
			mysqli_query($con,$sql);
			$sql = "SELECT COUNT( t.id_tiket ) 
					FROM tiket t
					JOIN pesanan p ON t.id_pesanan = p.id_pesanan
					WHERE p.id_customer =".$_SESSION['idcustomer']."";
			$result = mysqli_query($con,$sql);
			$hasil=mysqli_fetch_array($result);
			$poin = (int)$hasil[0] * 5;
			$sql = "UPDATE customer SET poin_customer=".$poin." WHERE id_customer=".$_SESSION['idcustomer']."";
			mysqli_query($con, $sql);
			echo 'SUCCESS!';			
		}
		else {
			echo 'Nomor HP tidak sesuai!';
		}
	}
	else if ($jenispembayaran == 3){
		$sql = "SELECT nokredit_customer FROM customer WHERE id_customer=".$_SESSION['idcustomer']."";
		$result = mysqli_query($con,$sql);
		$hasil = mysqli_fetch_array($result);
		if ($inputno == $hasil[0]){
			$sql = "INSERT INTO pesanan VALUES (NULL, 1,".$jenispembayaran.", ".$_SESSION['idcustomer'].", 0, ".$totalharga.")";
			mysqli_query($con,$sql);
			$sql = "UPDATE tiket SET status_tiket=1 WHERE id_pesanan=".$idpesanan."";
			mysqli_query($con,$sql);
			$sql = "SELECT COUNT( t.id_tiket ) 
					FROM tiket t
					JOIN pesanan p ON t.id_pesanan = p.id_pesanan
					WHERE p.id_customer =".$_SESSION['idcustomer']."";
			$result = mysqli_query($con,$sql);
			$hasil=mysqli_fetch_array($result);
			$poin = (int)$hasil[0] * 5;
			$sql = "UPDATE customer SET poin_customer=".$poin." WHERE id_customer=".$_SESSION['idcustomer']."";
			mysqli_query($con, $sql);
			echo 'SUCCESS!';
		}
		else {
			echo 'Nomor kartu kredit tidak sesuai!';
		}
	}
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
		showjudul();
		showketerangan();
		showtiket();
		showtotal();
		var jenispembayaran;
		$(".table").on("change","input:radio[name=metodepembayaran]", function() {
			var a = $("input:radio[name=metodepembayaran]:checked").val();
			if (a == 'cashless'){
				$(".inputnohp").removeAttr('disabled');
				$(".inputnokredit").prop('disabled', true);
				jenispembayaran = 2;
			}
			else if (a == 'credit') {
				$(".inputnokredit").removeAttr('disabled');
				$(".inputnohp").prop('disabled', true);
				jenispembayaran = 3;
			}
		});
		$("#purchase").click(function(){
			var inputno;
			if (jenispembayaran == 2){
				inputno = $(".inputnohp").val();
			}
			else if (jenispembayaran == 3){
				inputno = $(".inputnokredit").val();	
			}
			$.ajax({
				url : "pesantiket.php",
				type : "POST",
				async : false,
				cache : false,
				data : {
					purchase : 1,
					jenis_pembayaran : jenispembayaran,
					input_no : inputno
				},
				success: function(result){
					$(".modal-body").html(result);
					if (result == "SUCCESS!"){
						$(".modal-footer").html('<button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="window.location.href=\'index.php\'">OK</button>');
					}
					else {
						$(".modal-footer").html('<button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="window.location.href=\'pesantiket.php\'">Coba Lagi</button>');
					}
				}
			});
		});
		$(".primary-button").on("click", ".listkursi", function(){
			var idtiket = $(this).attr("val");
			$.ajax({
				url : "pesantiket.php",
				type : "POST",
				async : false,
				cache : false,
				data : {
					pilihtiket : 1,
					id_tiket : idtiket
				},
				success: function(result){
				}
			});
			$.ajax({
				url : "pesantiket.php",
				type : "POST",
				async : false,
				cache : false,
				data : {
					updatetotal : 1,
					id_tiket : idtiket
				},
				success: function(result){
					$(".total").html("Total: "+result);
				}
			});
			showtiket();
		});
		$(".cancelbutton").click(function(){
			$(".table").html('<tr><th scope="row"> Metode Pembayaran </th><td><div class="row"><div class="col-lg-6"><div class="input-group"><span class="input-group-addon"><input type="radio" name="metodepembayaran" value="cashless"> Cashless</span><input type="text" class="form-control inputnohp" disabled="true"></div></div><div class="col-lg-6"><div class="input-group"><span class="input-group-addon"><input type="radio" name="metodepembayaran" value="credit"> Credit</span><input type="text" class="form-control inputnokredit" disabled="true"></div></div></div></td></tr>');
		});
		$(".addpesanan").click(function(){
			$.ajax({
				url : "pesantiket.php",
				type : "POST",
				async : false,
				cache : false,
				data : {
					getidpesanan : 1
				},
				success: function(result){
					$(".modal-title").html("ORDER "+result+" DETAILS");
				}
			});
			$.ajax({
				url : "pesantiket.php",
				type : "POST",
				async : false,
				cache : false,
				data : {
					detailpesanan3 : 1
				},
				success: function(result){
					var temp = $(".table").html();
					$(".table").html(result);
					$(".table").append(temp);
				}
			});
			$.ajax({
				url : "pesantiket.php",
				type : "POST",
				async : false,
				cache : false,
				data : {
					detailpesanan2 : 1
				},
				success: function(result){
					var temp = $(".table").html();
					$(".table").html(result);
					$(".table").append(temp);
				}
			});
			$.ajax({
				url : "pesantiket.php",
				type : "POST",
				async : false,
				cache : false,
				data : {
					detailpesanan : 1
				},
				success: function(result){
					var temp = $(".table").html();
					$(".table").html(result);
					$(".table").append(temp);
				}
			});
		});
	});
	function showjudul(){
		$.ajax({
			url : "pesantiket.php",
			type : "POST",
			async : false,
			cache : false,
			data : {
				showjudul : 1
			},
			success: function(result){
				$(".judulfilm").html(result);
			}
		});
	}
	function showketerangan(){
		$.ajax({
			url : "pesantiket.php",
			type : "POST",
			async : false,
			cache : false,
			data : {
				showketerangan : 1
			},
			success: function(result){
				$(".ketjadwal").html(result);
			}
		});
	}
	function showtiket(){
		$.ajax({
			url : "pesantiket.php",
			type : "POST",
			async : false,
			cache : false,
			data : {
				showtiket : 1
			},
			success: function(result){
				$(".listkursis").html(result);
			}
		});
	}
	function showtotal(){
		$.ajax({
			url : "pesantiket.php",
			type : "POST",
			async : false,
			cache : false,
			data : {
				updatetotal : 1
			},
			success: function(result){
				$(".total").html("Total: "+result);
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

				<ul class="cd-hero-slider">

					<li class="selected">
						<div class="heading">
							<h1 class="judulfilm"></h1>
							<span class="ketjadwal"></span>
						</div>
						<div class="cd-full-width first-slide">
							<div class="container">
								<div class="row">
									<div class="col-md-12">
										<div class="content first-content">
											<div class="primary-button listkursis">
											</div>
											<br><br><br>
											<p class="total" style="font-size: 20px;"> </p>
											<div class="primary-button">
												<a href="#" style="background-color: #a1ff89;" class="addpesanan" data-toggle="modal" data-target="#exampleModal2">Pesan</a>
											</div>
										</div>
									</div>
								</div>
							</div>                  
						</div>
					</div>
				</li>

			</ul>	
		</section> <!-- .cd-hero -->

		<div class="modal fade" id="exampleModal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
						<h5 class="modal-title" id="exampleModalLabel"></h5>
					</div>
					<div class="modal-body">
						<table>
							<tbody class="table">
								<tr>
									<th scope="row"> Metode Pembayaran </th>
									<td>
										<div class="row">
											<div class="col-lg-6">
												<div class="input-group">
													<span class="input-group-addon">
														<input type="radio" name="metodepembayaran" value="cashless"> Cashless
													</span>
													<input type="text" class="form-control inputnohp" disabled="true">
												</div>
											</div>
											<div class="col-lg-6">
												<div class="input-group">
													<span class="input-group-addon">
														<input type="radio" name="metodepembayaran" value="credit"> Credit
													</span>
													<input type="text" class="form-control inputnokredit" disabled="true">
												</div>
											</div>
										</div>
									</td>
								</tr>
							</tbody>
						</table>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-primary" id="purchase">Purchase</button>
						<button type="button" class="btn btn-secondary cancelbutton" data-dismiss="modal">Cancel</button>
					</div>
				</div>
			</div>
		</div>

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