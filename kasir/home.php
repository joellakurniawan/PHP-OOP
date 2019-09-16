<?php
$con = mysqli_connect("lkmm-td.petra.ac.id", "lkmmtd", "semutnyasar46", "lkmmtd_adsitercinta");
session_start();

class CCustomer{
	public function show($con){
		$sql="SELECT * from customer";
		$result=mysqli_query($con,$sql);
		return $result;
	}
	public function update($con,$id){
		$sql="UPDATE `customer` SET poin_customer=poin_customer-100 WHERE id_customer=$id";
		$result=mysqli_query($con,$sql);
	}
}
class CFilm{
	public function show($con){
		$sql="SELECT * FROM film";
		$result=mysqli_query($con,$sql);
		return $result;
	}
};
$_customer = new CCustomer;
$_film = new CFilm;
//Customer
if(isset($_POST['show_table'])){
	$result = $_customer->show($con);
	while ($row=mysqli_fetch_array($result)) {
			echo '
			<tr>
			<td class="'.$row['id_customer'].'">'.$row['nama_customer'].'</td>
			<td>'.$row['email_customer'].'</td>
			<td>'.$row['poin_customer'].'</td>
			<td>
			<a class="edit" title="Reedem" data-toggle="tooltip"><i class="material-icons">&#xE03B;</i></a>
			</td>
			</tr>
			';
	}
	exit();
}
if(isset($_POST['update_table'])){
	$_customer->update($con,$_POST['id']);
}


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
				echo '<a href="pesantiket.php" style="padding:3px; margin:3px;" class="listjam" val="'.$row3[1].'">'.$row3[0].'</a>';
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
?>
<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang=""> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8" lang=""> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9" lang=""> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang=""> <!--<![endif]-->
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<title>Newline CSS Template with a video background</title>
	<meta name="description" content="">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="apple-touch-icon" href="apple-touch-icon.png">

	<link rel="stylesheet" href="css/bootstrap.min.css">
	<link rel="stylesheet" href="css/bootstrap-theme.min.css">
	<link rel="stylesheet" href="css/fontAwesome.css">
	<link rel="stylesheet" href="css/templatemo-style.css">
	<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">


	<link href="https://fonts.googleapis.com/css?family=Montserrat:100,200,300,400,500,600,700,800,900" rel="stylesheet">

	<script src="js/vendor/modernizr-2.8.3-respond-1.4.2.min.js"></script>

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script> -->
	<style type="text/css">
		body {
			color: #404E67;
			background: #F5F7FA;
			font-family: 'Open Sans', sans-serif;
		}
		.table-wrapper {
			width: 700px;
			margin: 30px auto;
			background: #fff;
			padding: 20px;  
			box-shadow: 0 1px 1px rgba(0,0,0,.05);
		}
		.table-title {
			padding-bottom: 10px;
			margin: 0 0 10px;
		}
		.table-title h2 {
			margin: 6px 0 0;
			font-size: 22px;
		}
		.table-title .add-new {
			float: right;
			height: 30px;
			font-weight: bold;
			font-size: 12px;
			text-shadow: none;
			min-width: 100px;
			border-radius: 50px;
			line-height: 13px;
		}
		.table-title .add-new i {
			margin-right: 4px;
		}
		table.table {
			table-layout: fixed;
		}
		table.table tr th, table.table tr td {
			border-color: #e9e9e9;
		}
		table.table th i {
			font-size: 13px;
			margin: 0 5px;
			cursor: pointer;
		}
		table.table th:last-child {
			width: 100px;
		}
		table.table td a {
			cursor: pointer;
			display: inline-block;
			margin: 0 5px;
			min-width: 24px;
		}    
		table.table td a.add {
			color: #27C46B;
		}
		table.table td a.edit {
			color: #FFC107;
		}
		table.table td a.delete {
			color: #E34724;
		}
		table.table td i {
			font-size: 19px;
		}
		table.table td a.add i {
			font-size: 24px;
			margin-right: -1px;
			position: relative;
			top: 3px;
		}
		table.table .form-control {
			height: 32px;
			line-height: 32px;
			box-shadow: none;
			border-radius: 2px;
		}
		table.table .form-control.error {
			border-color: #f50000;
		}
		table.table td .add {
			display: none;
		}
		table.table td .update {
			display: none;
		}
		.myInput {
			background-image: url('https://www.w3schools.com/css/searchicon.png');
			background-position: 10px 10px;
			background-repeat: no-repeat;
			width: 100%;
			font-size: 16px;
			padding: 12px 20px 12px 40px;
			border: 1px solid #ddd;
			margin-bottom: 12px;
		}
	</style>
	<script type="text/javascript">
		$(document).ready(function(){
			showdata();
			showfilm();
			$('[data-toggle="tooltip"]').tooltip();
    $(document).on("click", ".edit", function(){        
    	var counter = 0;
    	var poin = 0;
    	var id = $(this).closest('tr').children('td:first').attr('class');
    	$(this).parents("tr").find("td:not(:last-child)").each(function(){
    		if(counter == 2){
    			poin = $(this).text();
    			counter++;
    		}
    		else{
    			counter++;
    		}
    	});     
    	if(poin >= 100){
    		$.ajax({
    			url : "home.php",
    			type : "POST",
    			async : false,
    			cache : false,
    			data : {
    				update_table : 1,
    				id : id
    			},
    			success: function(result){
    				alert("Berhasil Reedem");
    			}
    		});
    		showdata();
    	}
    	else{
    		alert("Poin tidak mencukupi");
    	}
    });
	$(".second-content").on("click", ".film", function(){
		var idfilm=$(this).attr("val");
		$.ajax({
			url : "home.php",
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
});
//Kasir
function showdata(){
	$.ajax({
		url : "home.php",
		type : "POST",
		async : false,
		cache : false,
		data : {
			show_table : 1
		},
		success: function(result){
			$(".tbodyReedem").html(result);
		}
	});
}
function searchReedem() {
    var input, filter, table, tr, td, i, txtValue;
    input = document.getElementById("myInputReedem");
    filter = input.value.toUpperCase();
    table = document.getElementById("myTableReedem");
    tr = table.getElementsByTagName("tr");
    for (i = 0; i < tr.length; i++) {
    	td = tr[i].getElementsByTagName("td")[0];
    	if (td) {
    		txtValue = td.textContent || td.innerText;
    		if (txtValue.toUpperCase().indexOf(filter) > -1) {
    			tr[i].style.display = "";
    		} else {  
    			tr[i].style.display = "none";
    		}
    	}       
    }
}
function showfilm(){
		$.ajax({
			url : "home.php",
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

function tdpicker(){
	$('.datepicker').datepicker({
		uiLibrary: 'bootstrap4', showRightIcon: false,format: 'yyyy-dd-mm'
	});
	$('.timepicker').timepicker({
		format: 'HH.MM'
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
							<li class="selected"><a href="#0"><div class="image-icon"><img src="img/customer.png" width=40px></div><h6>Redeem</h6></a></li>
							<li><a href="#0"><div class="image-icon"><img src="img/film.png" width=40px></div><h6>Film</h6></a></li>
							<li><a href="http://lkmm-td.petra.ac.id/asik/admin/"  id="keluar"><div class="image-icon"><img src="img/logout.png" width=40px></div><h6>Logout</h6></a></li>
						</ul>
					</nav> 
				</div> <!-- .cd-slider-nav -->

				<ul class="cd-hero-slider">

					<li class="selected">
						<div class="heading">
							<h1>Reedem</h1>
							<span>Penukaran Poin!</span>
						</div>
						<div class="cd-full-width first-slide">
							<div class="container">
								<div class="content first-content">
									<div class="table-wrapper">
										<div class="table-title">
											<div class="row">
												<div class="col-sm-4"><h2>Reedem <b>Details</b></h2></div>
												<div class="col-sm-4">
													<input type="text" id="myInputReedem" class="myInput" onkeyup="searchReedem()" placeholder="Search for names.." title="Type in a name">
												</div>
											</div>
										</div>
										<table class="table table-bordered tableReedem" id="myTableReedem">
											<thead>
												<tr>
													<th>Nama</th>
													<th>Email</th>
													<th>Poin</th>
													<th>Actions</th>
												</tr>
											</thead>
											<tbody class="tbodyReedem"> 
											</tbody>
										</table>
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

		        </section> <!-- .cd-hero -->

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

		        <footer>
		        	<p>Copyright &copy; 2019 ADSI </p>
		        </footer>
		        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
		        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
		        <script src="js/vendor/bootstrap.min.js"></script>
		        <script src="js/plugins.js"></script>
		        <script src="js/main.js"></script>
		        <script src="https://unpkg.com/gijgo@1.9.13/js/gijgo.min.js" type="text/javascript"></script>
		        <link href="https://unpkg.com/gijgo@1.9.13/css/gijgo.min.css" rel="stylesheet" type="text/css" />
		        <script>
		        	$( function() {
		        		$( "#datepicker" ).datepicker();
		        	} );
		        </script>
		        <script type="text/javascript">
		        	$("#keluar").click(function(){
		        		window.location.replace("http://lkmm-td.petra.ac.id/asik/kasir/");
		        	});
		        </script>
		    </body>
		    </html>