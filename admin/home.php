<?php
$con = mysqli_connect("lkmm-td.petra.ac.id", "lkmmtd", "semutnyasar46", "lkmmtd_adsitercinta");
session_start();

class CKasir{
	public function show($con){
		$sql="SELECT * from pegawai";
		$result=mysqli_query($con,$sql);
		return $result;	
	}
	public function add($con,$name,$username,$password){
		$sql="INSERT INTO `pegawai`(`id_pegawai`, `nama_pegawai`, `username_pegawai`, `password_pegawai`, `status_pegawai`) VALUES (NULL,'$name','$username','$password',1)";
		mysqli_query($con,$sql);
		exit();
	}
	public function update($con,$name,$username,$password,$id){
		$sql="UPDATE `pegawai` SET `nama_pegawai`='$name',`username_pegawai`='$username',`password_pegawai`='$password' WHERE id_pegawai=$id";
		mysqli_query($con,$sql);
		exit();
	}
	public function delete($con,$id){
		$sql="DELETE FROM `pegawai` WHERE id_pegawai=$id";
		mysqli_query($con,$sql);
		exit();
	}
};

class CFilm{
	public function show($con){
		$sql="SELECT * from film";
		$result=mysqli_query($con,$sql);
		return $result;
	}
	public function add($con,$name,$deskripsi,$foto){
		$sql="INSERT INTO `film`(`id_film`, `judul_film`, `deskripsi_film`, `foto_film`) VALUES (NULL,'$name','$deskripsi','$foto')";
		mysqli_query($con,$sql);
		exit();
	}
	public function update($con,$name,$deskripsi,$foto,$id){
		$sql="UPDATE `film` SET `judul_film`='$name',`deskripsi_film`='$deskripsi',`foto_film`='$foto' WHERE id_film=$id";
		mysqli_query($con,$sql);
		exit();
	}
	public function delete($con,$id){
		$sql="DELETE FROM `film` WHERE id_film=$id";
		mysqli_query($con,$sql);
		exit();
	}
	public function carijudul($con,$namafilm){
		$sql="SELECT * from film where judul_film='$namafilm'";
		$result = mysqli_query($con,$sql);
		return $result;
	}
}

class CBioskop{
	public function show($con){
		$sql="SELECT * from mall";
		$result=mysqli_query($con,$sql);
		return $result;
	}
	public function add($con,$name){
		$sql="INSERT INTO `mall`(`id_mall`, `nama_mall`) VALUES (NULL,'$name')";
		mysqli_query($con,$sql);
		exit();
	}
	public function update($con,$name,$id){
		$sql="UPDATE `mall` SET `nama_mall`='$name' WHERE id_mall=$id";
		mysqli_query($con,$sql);
		exit();
	}
	public function delete($con,$id){
		$sql="DELETE FROM `mall` WHERE id_mall=$id";
		mysqli_query($con,$sql);
		exit();
	}
	public function carinama($con,$nama){
		$sql="SELECT * from mall where nama_mall='$nama'";
		$result = mysqli_query($con,$sql);
		return $result;
	}
};
class CStudio{
	public function show($con){
		$sql="SELECT DISTINCT s.id_studio,s.nama_studio, m.nama_mall
		FROM mall m
		JOIN studio s ON m.id_mall = s.id_mall";
		$result=mysqli_query($con,$sql);
		return $result;
	}
	public function add($con,$name,$idmall){
		$sql="INSERT INTO `studio`(`id_studio`,`nama_studio`, `id_mall`) VALUES (NULL,$name,$idmall)";
		mysqli_query($con,$sql);
		exit();
	}
	public function update($con,$name,$idmall,$idstudio){
		$sql="UPDATE `studio` SET `nama_studio`=$name,`id_mall`=$idmall WHERE id_studio=$idstudio";
		mysqli_query($con,$sql);
		exit();
	}
	public function delete($con,$idstudio){
		$sql="DELETE FROM `studio` WHERE id_studio=$idstudio";
		mysqli_query($con,$sql);
		exit();
	}
	public function carimall($con,$idmall){
		$sql="SELECT * from studio WHERE id_mall=$idmall";
		$result=mysqli_query($con,$sql);
		return $result;
	}
	public function carinamastudiodanidmall($con,$namastudio,$idmall){
		$sql="SELECT * from studio where nama_studio=$namastudio AND id_mall=$idmall";
		$result = mysqli_query($con,$sql);
		return $result;
	}
}
class CJadwal{
	public function show($con){
		$sql="SELECT DISTINCT j.id_jadwal,j.tanggal_jadwal, j.jam_jadwal,s.nama_studio,m.nama_mall,f.judul_film,j.harga_tiket
		FROM jadwal j
		JOIN studio s ON j.id_studio = s.id_studio
		JOIN film f ON j.id_film = f.id_film
		JOIN mall m ON s.id_mall = m.id_mall";
		$result=mysqli_query($con,$sql);
		return $result;
	}
	public function palingakhir($con){
		$sql="SELECT * from `jadwal` ORDER BY id_jadwal DESC";
		$result = mysqli_query($con,$sql);
		return $result;
	}
	public function add($con,$tanggal,$jam,$idstudio,$idfilm,$harga){
		$sql="INSERT INTO `jadwal`(`id_jadwal`,`tanggal_jadwal`,`jam_jadwal`,`id_studio`,`id_film`, `harga_tiket`) VALUES (NULL,'$tanggal','$jam',$idstudio,$idfilm,$harga)";
		mysqli_query($con,$sql);
	}
	public function update($con,$harian,$waktuan,$idstudio,$idfilm,$hargaan,$idjadwal){
		$sql="UPDATE `jadwal` SET `tanggal_jadwal`='$harian',`jam_jadwal`='$waktuan',`id_studio`=$idstudio,`id_film`='$idfilm', `harga_tiket`=$hargaan WHERE id_jadwal=$idjadwal";
		mysqli_query($con,$sql);
	}
	public function delete($con,$idjadwal){
		$sql="DELETE FROM `jadwal` WHERE id_jadwal=$idjadwal";
		mysqli_query($con,$sql);
	}
}
class CTiket{
	public function add($con,$row){
		for($j = 1;$j<=16;$j++){
			$temp = 'A'.$j;
			$sql="INSERT INTO `tiket`(`id_tiket`, `nomor_kursi`, `status_tiket`, `id_pesanan`, `id_jadwal`) VALUES (NULL,'$temp',0,0,$row)";
			mysqli_query($con,$sql);
		}
		for($j = 1;$j<=16;$j++){
			$temp = 'B'.$j;
			$sql="INSERT INTO `tiket`(`id_tiket`, `nomor_kursi`, `status_tiket`, `id_pesanan`, `id_jadwal`) VALUES (NULL,'$temp',0,0,$row)";
			mysqli_query($con,$sql);
		}
		for($j = 1;$j<=16;$j++){
			$temp = 'C'.$j;
			$sql="INSERT INTO `tiket`(`id_tiket`, `nomor_kursi`, `status_tiket`, `id_pesanan`, `id_jadwal`) VALUES (NULL,'$temp',0,0,$row)";
			mysqli_query($con,$sql);
		}
	}
	public function delete($con,$idjadwal){
		$sql="DELETE FROM `tiket` WHERE id_jadwal=$idjadwal";
		mysqli_query($con,$sql);
	}
}

$_kasir = new CKasir;
$_film = new CFilm;
$_bioskop = new CBioskop;
$_studio = new CStudio;
$_jadwal = new CJadwal;
$_tiket = new CTiket;
//Kasir
if(isset($_POST['show_table'])){
	$result = $_kasir->show($con);
	while ($row=mysqli_fetch_array($result)) {
		if($row['status_pegawai']==1){
			echo '
			<tr>
			<td class="'.$row['id_pegawai'].'">'.$row['nama_pegawai'].'</td>
			<td>'.$row['username_pegawai'].'</td>
			<td>'.$row['password_pegawai'].'</td>
			<td>
			<a class="add" title="Add" data-toggle="tooltip"><i class="material-icons">&#xE03B;</i></a>
			<a class="update" title="Update" data-toggle="tooltip"><i class="material-icons">&#xE03B;</i></a>
			<a class="edit" title="Edit" data-toggle="tooltip"><i class="material-icons">&#xE254;</i></a>
			<a class="delete" title="Delete" data-toggle="tooltip"><i class="material-icons">&#xE872;</i></a>
			</td>
			</tr>
			';
		}   
	}
	exit();
}
if(isset($_POST['add_table'])){
	$_kasir->add($con,$_POST['name'],$_POST['username'],$_POST['password']);
}
if(isset($_POST['update_table'])){
	$_kasir->update($con,$_POST['name'],$_POST['username'],$_POST['password'],$_POST['id']);
}
if(isset($_POST['delete_table'])){
	$_kasir->delete($con,$_POST['id']);
}
//Film
if(isset($_POST['show_tableFilm'])){
	$result = $_film->show($con);
	while ($row=mysqli_fetch_array($result)) {
		echo '
		<tr>
		<td class="'.$row['id_film'].'">'.$row['judul_film'].'</td>
		<td>'.$row['deskripsi_film'].'</td>
		<td>'.$row['foto_film'].'</td>
		<td>
		<a class="addFilm" title="AddFilm" data-toggle="tooltip"><i class="material-icons">&#xE03B;</i></a>
		<a class="updateFilm" title="UpdateFilm" data-toggle="tooltip"><i class="material-icons">&#xE03B;</i></a>
		<a class="editFilm" title="EditFilm" data-toggle="tooltip"><i class="material-icons">&#xE254;</i></a>
		<a class="deleteFilm" title="Delete" data-toggle="tooltip"><i class="material-icons">&#xE872;</i></a>
		</td>
		</tr>
		';
	}
	exit();
}
if(isset($_POST['add_tableFilm'])){
	$_film->add($con,$_POST['name'],$_POST['username'],$_POST['password']);
}
if(isset($_POST['update_tableFilm'])){
	$_film->update($con,$_POST['name'],$_POST['username'],$_POST['password'],$_POST['id']);
}
if(isset($_POST['delete_tableFilm'])){
	$_film->delete($con,$_POST['id']);
}
//Bioskop
if(isset($_POST['show_tableMall'])){
	$result = $_bioskop->show($con);
	while ($row=mysqli_fetch_array($result)) {
		echo '
		<tr>
		<td class="'.$row['id_mall'].'">'.$row['nama_mall'].'</td>
		<td>
		<a class="addMall" title="AddMall" data-toggle="tooltip"><i class="material-icons">&#xE03B;</i></a>
		<a class="updateMall" title="UpdateMall" data-toggle="tooltip"><i class="material-icons">&#xE03B;</i></a>
		<a class="editMall" title="EditMall" data-toggle="tooltip"><i class="material-icons">&#xE254;</i></a>
		<a class="deleteMall" title="DeleteMall" data-toggle="tooltip"><i class="material-icons">&#xE872;</i></a>
		</td>
		</tr>
		';
	}
	exit();
}
if(isset($_POST['add_tableMall'])){
	$_bioskop->add($con,$_POST['name']);
}
if(isset($_POST['update_tableMall'])){
	$_bioskop->update($con,$_POST['name'],$_POST['id']);
}
if(isset($_POST['delete_tableMall'])){
	$_bioskop->delete($con,$_POST['id']);
}
//Studio
if(isset($_POST['show_tableStudio'])){
	$result = $_studio->show($con);
	while ($row=mysqli_fetch_array($result)) {
		echo '
		<tr>
		<td class="'.$row[0].'">'.$row[1].'</td>
		<td>'.$row[2].'</td>
		<td>
		<a class="addStudio" title="AddStudio" data-toggle="tooltip"><i class="material-icons">&#xE03B;</i></a>
		<a class="updateStudio" title="UpdateStudio" data-toggle="tooltip"><i class="material-icons">&#xE03B;</i></a>
		<a class="editStudio" title="EditStudio" data-toggle="tooltip"><i class="material-icons">&#xE254;</i></a>
		<a class="deleteStudio" title="DeleteStudio" data-toggle="tooltip"><i class="material-icons">&#xE872;</i></a>
		</td>
		</tr>
		';
	}
	exit();
}
if(isset($_POST['pilih_studio'])){
	$result=$_bioskop->show($con);
	echo "<select class='form-control'>";
	while ($row=mysqli_fetch_array($result)) {
		echo '
		<option>'.$row['nama_mall'].'</option>
		';
	}
	echo "</select>";
	exit();
}
if(isset($_POST['add_tableStudio'])){
	$result=$_bioskop->carinama($con,$_POST['pilih']);
	$row = mysqli_fetch_array($result);
	$_studio->add($con,$_POST['name'],$row[0]);
}
if(isset($_POST['edit_studio'])){
	$result=$_bioskop->show($con);
	echo "<select class='form-control ganti'>";
	while ($row=mysqli_fetch_array($result)) {
		if($row['nama_mall']==$_POST['pilihan']){
			echo '
			<option selected>'.$row['nama_mall'].'</option>
			';	
		}
		else{
			echo '
			<option>'.$row['nama_mall'].'</option>
			';	
		}
	}
	echo "</select>";
	exit();
}
if(isset($_POST['update_tableStudio'])){
	$result=$_bioskop->carinama($con,$_POST['pilih']);
	$row = mysqli_fetch_array($result);
	$_studio->update($con,$_POST['name'],$row[0],$_POST['id']);
}
if(isset($_POST['delete_tableStudio'])){
	$_studio->delete($con,$_POST['id']);
}
//jadwal
if(isset($_POST['show_tableJadwal'])){
	$result=$_jadwal->show($con);
	while ($row=mysqli_fetch_array($result)) {
		echo '
		<tr>
		<td class="'.$row[0].'">'.$row[1].'</td>
		<td>'.$row[2].'</td>
		<td>'.$row[3].'</td>
		<td>'.$row[4].'</td>
		<td>'.$row[5].'</td>
		<td>'.$row[6].'</td>
		<td>
		<a class="addJadwal" title="AddJadwal" data-toggle="tooltip"><i class="material-icons">&#xE03B;</i></a>
		<a class="updateJadwal" title="UpdateJadwal" data-toggle="tooltip"><i class="material-icons">&#xE03B;</i></a>
		<a class="editJadwal" title="EditJadwal" data-toggle="tooltip"><i class="material-icons">&#xE254;</i></a>
		<a class="deleteJadwal" title="DeleteJadwal" data-toggle="tooltip"><i class="material-icons">&#xE872;</i></a>
		</td>
		</tr>
		';
	}
	exit();
}
if(isset($_POST['pilih_film'])){
	$result=$_film->show($con);
	echo "<select class='form-control'>";
	while ($row=mysqli_fetch_array($result)) {
		echo '
		<option>'.$row['judul_film'].'</option>
		';
	}
	echo "</select>";
	exit();
}
if(isset($_POST['pilih_mall'])){
	$result=$_bioskop->show($con);
	echo "<select class='form-control ganti'>";
	while ($row=mysqli_fetch_array($result)) {
		echo '
		<option>'.$row['nama_mall'].'</option>
		';
	}
	echo "</select>";
	exit();
}
if(isset($_POST['pilihannya'])){
	$permintaan = $_POST['mall'];
	$result=$_bioskop->carinama($con,$permintaan);
	$row=mysqli_fetch_array($result);
	$idnya = $row[0];
	$result=$_studio->carimall($con,$idnya);
	echo "<select class='form-control daftar_studio'>";
	while ($row=mysqli_fetch_array($result)) {
		echo '
		<option>'.$row['nama_studio'].'</option>
		';
	}
	echo "</select>";
	exit();
}
if(isset($_POST['add_tableJadwal'])){
	$namamall = $_POST['mall'];
	$result = $_bioskop->carinama($con,$namamall);
	$row = mysqli_fetch_array($result);
	$a = $row[0];
	$namastudio = $_POST['nama'];
	$result = $_studio->carinamastudiodanidmall($con,$namastudio,$a);
	$row = mysqli_fetch_array($result);
	$idstudio = $row[0];
	$namafilm = $_POST['film'];
	$result = $_film->carijudul($con,$namafilm);
	$row = mysqli_fetch_array($result);
	$idfilm = $row[0];
	$_jadwal->add($con,$_POST['hari'],$_POST['waktu'],$idstudio,$idfilm,$_POST['harga']);
	$result = $_jadwal->palingakhir($con);
	$row = mysqli_fetch_array($result);
	$row = $row[0];
	$_tiket->add($con,$row);
    // echo $idstudio.$idfilm.$_POST['hari'].$_POST['waktu'].$_POST['harga'];
	exit();
}
if(isset($_POST['pilihannyajadwal'])){
	$permintaan = $_POST['mall'];
	$result=$_bioskop->carinama($con,$permintaan);
	$row=mysqli_fetch_array($result);
	$idnya = $row[0];
	$result=$_studio->carimall($con,$idnya);
	echo "<select class='form-control daftar_studio2'>";
	while ($row=mysqli_fetch_array($result)) {
		if($row['nama_studio']==$_POST['pilihan']){
			echo '
			<option selected>'.$row['nama_studio'].'</option>
			';	
		}
		else{
			echo '
			<option>'.$row['nama_studio'].'</option>
			';	
		}
	}
	echo "</select>";
	exit();
}
if(isset($_POST['edit_studiojadwal'])){
	$result=$_bioskop->show($con);
	echo "<select class='form-control ganti2'>";
	while ($row=mysqli_fetch_array($result)) {
		if($row['nama_mall']==$_POST['pilihan']){
			echo '
			<option selected>'.$row['nama_mall'].'</option>
			';	
		}
		else{
			echo '
			<option>'.$row['nama_mall'].'</option>
			';	
		}
	}
	echo "</select>";
	exit();
}
if(isset($_POST['edit_film'])){
	$result = $_film->show($con);
	echo "<select class='form-control'>";
	while ($row=mysqli_fetch_array($result)) {
		if($row['judul_film']==$_POST['pilihan']){
			echo '
			<option selected>'.$row['judul_film'].'</option>
			';	
		}
		else{
			echo '
			<option>'.$row['judul_film'].'</option>
			';	
		}
	}
	echo "</select>";
	exit();
}
if(isset($_POST['delete_tableJadwal'])){
	$_jadwal->delete($con,$_POST['id']);
	$_tiket->delete($con,$_POST['id']);
	exit();
}
if(isset($_POST['update_tableJadwal'])){
	$namamall = $_POST['mall'];
	$result = $_bioskop->carinama($con,$namamall);
	$row = mysqli_fetch_array($result);
	$a = $row[0];
	$namastudio = $_POST['nama'];
	$result = $_studio->carinamastudiodanidmall($con,$namastudio,$a);
	$row = mysqli_fetch_array($result);
	$idstudio = $row[0];
	$namafilm = $_POST['film'];
	$result = $_film->carijudul($con,$namafilm);
	$row = mysqli_fetch_array($result);
	$idfilm = $row[0];
	$harian = $_POST['hari'];
	$waktuan = $_POST['waktu'];
	$hargaan = $_POST['harga'];
	$_jadwal->update($con,$harian,$waktuan,$idstudio,$idfilm,$hargaan,$_POST['id']);
	exit();
}
if(isset($_POST['cari_ganti'])){
	$permintaan = $_POST['gantian'];
	$result=$_bioskop->carinama($con,$permintaan);
	$row=mysqli_fetch_array($result);
	$idnya = $row[0];
	$result=$_studio->carimall($con,$idnya);
	echo "<select class='form-control'>";
	while ($row=mysqli_fetch_array($result)) {
		echo '
		<option>'.$row['nama_studio'].'</option>
		';
	}
	echo "</select>";
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
		table.table td a.addFilm {
			color: #27C46B;
		}
		table.table td a.editFilm {
			color: #FFC107;
		}
		table.table td a.deleteFilm {
			color: #E34724;
		}
		table.table td a.addMall {
			color: #27C46B;
		}
		table.table td a.editMall {
			color: #FFC107;
		}
		table.table td a.deleteMall {
			color: #E34724;
		}
		table.table td a.addStudio {
			color: #27C46B;
		}
		table.table td a.editStudio {
			color: #FFC107;
		}
		table.table td a.deleteStudio {
			color: #E34724;
		}
		table.table td a.addJadwal {
			color: #27C46B;
		}
		table.table td a.editJadwal {
			color: #FFC107;
		}
		table.table td a.deleteJadwal {
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
		table.table td a.addFilm i {
			font-size: 24px;
			margin-right: -1px;
			position: relative;
			top: 3px;
		}
		table.table td a.addMall i {
			font-size: 24px;
			margin-right: -1px;
			position: relative;
			top: 3px;
		} 
		table.table td a.addStudio i {
			font-size: 24px;
			margin-right: -1px;
			position: relative;
			top: 3px;
		}
		table.table td a.addJadwal i {
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
		table.table td .addFilm {
			display: none;
		}
		table.table td .updateFilm {
			display: none;
		}
		table.table td .addMall {
			display: none;
		}
		table.table td .updateMall {
			display: none;
		}
		table.table td .addStudio {
			display: none;
		}
		table.table td .updateStudio {
			display: none;
		}
		table.table td .addJadwal {
			display: none;
		}
		table.table td .updateJadwal {
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
			showdataFilm();
			showdataMall();
			showdataStudio();
			showdataJadwal();
			$('[data-toggle="tooltip"]').tooltip();
			var actions = $(".tableKasir td:last-child").html();
			var actions2 = $(".tableFilm td:last-child").html();
			var actions3 = $(".tableBioskop td:last-child").html();
			var actions4 = $(".tableStudio td:last-child").html();
			var actions5 = $(".tableJadwal td:last-child").html();
    // Append table with add row form on add new button click
	//Kasir
	$(".add-newKasir").click(function(){
    	$(this).attr("disabled", "disabled");
    	var index = $(".tableKasir .tbodyKasir tr:last-child").index();
    	var row = '<tr>' +
    	'<td><input type="text" class="form-control" name="name" id="name"></td>' +
    	'<td><input type="text" class="form-control" name="department" id="department"></td>' +
    	'<td><input type="text" class="form-control" name="phone" id="phone"></td>' +
    	'<td>' + actions + '</td>' +
    	'</tr>';
    	$(".tableKasir").append(row);     
    	$(".tableKasir .tbodyKasir tr").eq(index + 1).find(".add, .edit").toggle();
    	$('[data-toggle="tooltip"]').tooltip();
    });
	$(document).on("click", ".add", function(){
    	var empty = false;
    	var input = $(this).parents("tr").find('input[type="text"]');
    	input.each(function(){
    		if(!$(this).val()){
    			$(this).addClass("error");
    			empty = true;
    		} else{
    			$(this).removeClass("error");
    		}
    	});
    	$(this).parents("tr").find(".error").first().focus();
    	var arr = [];
    	var counter = 0;
    	if(!empty){
    		input.each(function(){
    			arr[counter] = $(this).val();
    			counter++;
    			$(this).parent("td").html($(this).val());
    		});         
    		$(this).parents("tr").find(".add, .edit").toggle();
    		$(".add-newKasir").removeAttr("disabled");
    		$.ajax({
    			url : "home.php",
    			type : "POST",
    			async : false,
    			cache : false,
    			data : {
    				add_table : 1,
    				name : arr[0],
    				username : arr[1],
    				password : arr[2]
    			},
    			success: function(result){
    			}
    		});
    		showdata();
    	}       
    });
    $(document).on("click", ".edit", function(){        
    	$(this).parents("tr").find("td:not(:last-child)").each(function(){
    		$(this).html('<input type="text" class="form-control" value="' + $(this).text() + '">');
    	});     
    	$(this).parents("tr").find(".update, .edit").toggle();
    	$(".add-newKasir").attr("disabled", "disabled");
    });
	$(document).on("click", ".update", function(){
    	id = $(this).closest('tr').children('td:first').attr('class');
    	var empty = false;
    	var input = $(this).parents("tr").find('input[type="text"]');
    	input.each(function(){
    		if(!$(this).val()){
    			$(this).addClass("error");
    			empty = true;
    		} else{
    			$(this).removeClass("error");
    		}
    	});
    	$(this).parents("tr").find(".error").first().focus();
    	var arr = [];
    	var counter = 0;
    	if(!empty){
    		input.each(function(){
    			arr[counter] = $(this).val();
    			counter++;
    			$(this).parent("td").html($(this).val());
    		});      
    		$(this).parents("tr").find(".update, .edit").toggle();
    		$(".add-newKasir").removeAttr("disabled");
    		$.ajax({
    			url : "home.php",
    			type : "POST",
    			async : false,
    			cache : false,
    			data : {
    				update_table : 1,
    				id : id,
    				name : arr[0],
    				username : arr[1],
    				password : arr[2]
    			},
    			success: function(result){
    			}
    		});
    		showdata();
    	}       
    });
	$(document).on("click", ".delete", function(){
    	id = $(this).closest('tr').children('td:first').attr('class');
    	$(this).parents("tr").remove();
    	$(".add-newKasir").removeAttr("disabled");
    	$.ajax({
    		url : "home.php",
    		type : "POST",
    		async : false,
    		cache : false,
    		data : {
    			delete_table : 1,
    			id : id
    		},
    		success: function(result){
    		}
    	});
    });
	//Film
	$(".add-newFilm").click(function(){
    	$(this).attr("disabled", "disabled");
    	var index = $(".tableFilm .tbodyFilm tr:last-child").index();
    	var row = '<tr>' +
    	'<td><input type="text" class="form-control" name="name" id="name"></td>' +
    	'<td><input type="text" class="form-control" name="department" id="department"></td>' +
    	'<td><input type="text" class="form-control" name="phone" id="phone"></td>' +
    	'<td>' + actions2 + '</td>' +
    	'</tr>';
    	$(".tableFilm").append(row);     
    	$(".tableFilm .tbodyFilm tr").eq(index + 1).find(".addFilm, .editFilm").toggle();
    	$('[data-toggle="tooltip"]').tooltip();
    });
    $(document).on("click", ".addFilm", function(){
    	var empty = false;
    	var input = $(this).parents("tr").find('input[type="text"]');
    	input.each(function(){
    		if(!$(this).val()){
    			$(this).addClass("error");
    			empty = true;
    		} else{
    			$(this).removeClass("error");
    		}
    	});
    	$(this).parents("tr").find(".error").first().focus();
    	var arr = [];
    	var counter = 0;
    	if(!empty){
    		input.each(function(){
    			arr[counter] = $(this).val();
    			counter++;
    			$(this).parent("td").html($(this).val());
    		});         
    		$(this).parents("tr").find(".addFilm, .editFilm").toggle();
    		$(".add-newFilm").removeAttr("disabled");
    		$.ajax({
    			url : "home.php",
    			type : "POST",
    			async : false,
    			cache : false,
    			data : {
    				add_tableFilm : 1,
    				name : arr[0],
    				username : arr[1],
    				password : arr[2]
    			},
    			success: function(result){
    			}
    		});
    		showdataFilm();
    	}       
    });
    $(document).on("click", ".editFilm", function(){        
    	$(this).parents("tr").find("td:not(:last-child)").each(function(){
    		$(this).html('<input type="text" class="form-control" value="' + $(this).text() + '">');
    	});     
    	$(this).parents("tr").find(".updateFilm, .editFilm").toggle();
    	$(".add-newFilm").attr("disabled", "disabled");
    });
    $(document).on("click", ".updateFilm", function(){
    	id = $(this).closest('tr').children('td:first').attr('class');
    	var empty = false;
    	var input = $(this).parents("tr").find('input[type="text"]');
    	input.each(function(){
    		if(!$(this).val()){
    			$(this).addClass("error");
    			empty = true;
    		} else{
    			$(this).removeClass("error");
    		}
    	});
    	$(this).parents("tr").find(".error").first().focus();
    	var arr = [];
    	var counter = 0;
    	if(!empty){
    		input.each(function(){
    			arr[counter] = $(this).val();
    			counter++;
    			$(this).parent("td").html($(this).val());
    		});      
    		$(this).parents("tr").find(".updateFilm, .editFilm").toggle();
    		$(".add-newFilm").removeAttr("disabled");
    		$.ajax({
    			url : "home.php",
    			type : "POST",
    			async : false,
    			cache : false,
    			data : {
    				update_tableFilm : 1,
    				id : id,
    				name : arr[0],
    				username : arr[1],
    				password : arr[2]
    			},
    			success: function(result){
    			}
    		});
    		showdataFilm();
    	}       
    });
    $(document).on("click", ".deleteFilm", function(){
    	id = $(this).closest('tr').children('td:first').attr('class');
    	$(this).parents("tr").remove();
    	$(".add-newFilm").removeAttr("disabled");
    	$.ajax({
    		url : "home.php",
    		type : "POST",
    		async : false,
    		cache : false,
    		data : {
    			delete_tableFilm : 1,
    			id : id
    		},
    		success: function(result){
    		}
    	});
    	showdataFilm();
    });
    //BIOSKOP
    $(".add-newMall").click(function(){
    	$(this).attr("disabled", "disabled");
    	var index = $(".tableBioskop .tbodyBioskop tr:last-child").index();
    	var row = '<tr>' +
    	'<td><input type="text" class="form-control" name="name" id="name"></td>' +
    	'<td>' + actions3 + '</td>' +
    	'</tr>';
    	$(".tableBioskop").append(row);     
    	$(".tableBioskop .tbodyBioskop tr").eq(index + 1).find(".addMall, .editMall").toggle();
    	$('[data-toggle="tooltip"]').tooltip();
    });
    $(document).on("click", ".addMall", function(){
    	var empty = false;
    	var input = $(this).parents("tr").find('input[type="text"]');
    	input.each(function(){
    		if(!$(this).val()){
    			$(this).addClass("error");
    			empty = true;
    		} else{
    			$(this).removeClass("error");
    		}
    	});
    	$(this).parents("tr").find(".error").first().focus();
    	var arr = [];
    	var counter = 0;
    	if(!empty){
    		input.each(function(){
    			arr[counter] = $(this).val();
    			counter++;
    			$(this).parent("td").html($(this).val());
    		});         
    		$(this).parents("tr").find(".addMall, .editMall").toggle();
    		$(".add-newMall").removeAttr("disabled");
    		$.ajax({
    			url : "home.php",
    			type : "POST",
    			async : false,
    			cache : false,
    			data : {
    				add_tableMall : 1,
    				name : arr[0],
    			},
    			success: function(result){
    			}
    		});
    		showdataMall();
    	}       
    });
    $(document).on("click", ".editMall", function(){        
    	$(this).parents("tr").find("td:not(:last-child)").each(function(){
    		$(this).html('<input type="text" class="form-control" value="' + $(this).text() + '">');
    	});     
    	$(this).parents("tr").find(".updateMall, .editMall").toggle();
    	$(".add-newMall").attr("disabled", "disabled");
    });
    $(document).on("click", ".updateMall", function(){
    	id = $(this).closest('tr').children('td:first').attr('class');
    	var empty = false;
    	var input = $(this).parents("tr").find('input[type="text"]');
    	input.each(function(){
    		if(!$(this).val()){
    			$(this).addClass("error");
    			empty = true;
    		} else{
    			$(this).removeClass("error");
    		}
    	});
    	$(this).parents("tr").find(".error").first().focus();
    	var arr = [];
    	var counter = 0;
    	if(!empty){
    		input.each(function(){
    			arr[counter] = $(this).val();
    			counter++;
    			$(this).parent("td").html($(this).val());
    		});      
    		$(this).parents("tr").find(".updateMall, .editMall").toggle();
    		$(".add-newMall").removeAttr("disabled");
    		$.ajax({
    			url : "home.php",
    			type : "POST",
    			async : false,
    			cache : false,
    			data : {
    				update_tableMall : 1,
    				id : id,
    				name : arr[0]
    			},
    			success: function(result){
    			}
    		});
    		showdataMall();
    	}       
    });
    $(document).on("click", ".deleteMall", function(){
    	id = $(this).closest('tr').children('td:first').attr('class');
    	$(this).parents("tr").remove();
    	$(".add-newMall").removeAttr("disabled");
    	$.ajax({
    		url : "home.php",
    		type : "POST",
    		async : false,
    		cache : false,
    		data : {
    			delete_tableMall : 1,
    			id : id
    		},
    		success: function(result){
    		}
    	});
    });
    //Studio
    $(".add-newStudio").click(function(){
    	$(this).attr("disabled", "disabled");
    	var index = $(".tableStudio .tbodyStudio tr:last-child").index();
    	var temp = "";
    	$.ajax({
    		url : "home.php",
    		type : "POST",
    		async : false,
    		cache : false,
    		data : {
    			pilih_studio : 1
    		},
    		success: function(result){
    			temp = result;
    		}
    	});
    	var row = '<tr>' +
    	'<td><input type="text" class="form-control" name="name" id="name"></td>' +
    	'<td>'+temp+'</td>'+
    	'<td>' + actions4 + '</td>' +
    	'</tr>';
    	$(".tableStudio").append(row);     
    	$(".tableStudio .tbodyStudio tr").eq(index + 1).find(".addStudio, .editStudio").toggle();
    	$('[data-toggle="tooltip"]').tooltip();
    });
    $(document).on("click", ".addStudio", function(){
    	var empty = false;
    	var input = $(this).parents("tr").find('input[type="text"]');
    	input.each(function(){
    		if(!$(this).val()){
    			$(this).addClass("error");
    			empty = true;
    		} else{
    			$(this).removeClass("error");
    		}
    	});
    	$(this).parents("tr").find(".error").first().focus();
    	var arr = [];
    	var counter = 0;
    	if(!empty){
    		input.each(function(){
    			arr[counter] = $(this).val();
    			counter++;
    			$(this).parent("td").html($(this).val());
    		});   
    		$('select').each(function(){
    			arr[counter] = $(this).children("option:selected").val();
    			$(this).parent("td").html(arr[counter]);
    		})     
    		$(this).parents("tr").find(".addStudio, .editStudio").toggle();
    		$(".add-newStudio").removeAttr("disabled");
    		$.ajax({
    			url : "home.php",
    			type : "POST",
    			async : false,
    			cache : false,
    			data : {
    				add_tableStudio : 1,
    				name : arr[0],
    				pilih : arr[1]
    			},
    			success: function(result){
    			}
    		});
    		showdataStudio();
    	}
    	else{
    		alert("masih kosong");
    	}       
    });
    $(document).on("click", ".editStudio", function(){    
    	var counter = 0;
    	$(this).parents("tr").find("td:not(:last-child)").each(function(){
    		if(counter == 0){
    			$(this).html('<input type="text" class="form-control" value="' + $(this).text() + '">');
    			counter++;
    		}
    		else{
    			var temp = "";
    			$.ajax({
    				url : "home.php",
    				type : "POST",
    				async : false,
    				cache : false,
    				data : {
    					edit_studio : 1,
    					pilihan : $(this).text()
    				},
    				success: function(result){
    					temp = result;
    				}
    			});
    			$(this).html(temp);
    		}
    	});
    	$(this).parents("tr").find(".updateStudio, .editStudio").toggle();
    	$(".add-newStudio").attr("disabled", "disabled");
    });
    $(document).on("click", ".updateStudio", function(){
    	id = $(this).closest('tr').children('td:first').attr('class');
    	var empty = false;
    	var input = $(this).parents("tr").find('input[type="text"]');
    	input.each(function(){
    		if(!$(this).val()){
    			$(this).addClass("error");
    			empty = true;
    		} else{
    			$(this).removeClass("error");
    		}
    	});
    	$(this).parents("tr").find(".error").first().focus();
    	var arr = [];
    	var counter = 0;
    	if(!empty){
    		input.each(function(){
    			arr[counter] = $(this).val();
    			counter++;
    			$(this).parent("td").html($(this).val());
    		});
    		$('select').each(function(){
    			arr[counter] = $(this).children("option:selected").val();
    			$(this).parent("td").html(arr[counter]);
    		})     
    		$(this).parents("tr").find(".updateStudio, .editStudio").toggle();
    		$(".add-newStudio").removeAttr("disabled");
    		$.ajax({
    			url : "home.php",
    			type : "POST",
    			async : false,
    			cache : false,
    			data : {
    				update_tableStudio : 1,
    				id : id,
    				name : arr[0],
    				pilih : arr[1]
    			},
    			success: function(result){
    			}
    		});
    		showdataStudio();
    	}      
    });
    $(document).on("click", ".deleteStudio", function(){
    	id = $(this).closest('tr').children('td:first').attr('class');
    	$(this).parents("tr").remove();
    	$(".add-newStudio").removeAttr("disabled");
    	$.ajax({
    		url : "home.php",
    		type : "POST",
    		async : false,
    		cache : false,
    		data : {
    			delete_tableStudio : 1,
    			id : id
    		},
    		success: function(result){
    		}
    	});
    });
    //Jadwal
    $(".add-newJadwal").click(function(){
    	$(this).attr("disabled", "disabled");
    	var index = $(".tableJadwal .tbodyJadwal tr:last-child").index();
    	var tempfilm = "";
    	$.ajax({
    		url : "home.php",
    		type : "POST",
    		async : false,
    		cache : false,
    		data : {
    			pilih_film : 1
    		},
    		success: function(result){
    			tempfilm = result;
    		}
    	});
    	var tempmall = "";
    	$.ajax({
    		url : "home.php",
    		type : "POST",
    		async : false,
    		cache : false,
    		data : {
    			pilih_mall : 1
    		},
    		success: function(result){
    			tempmall = result;
    		}
    	});
    	var tempstudio ="";
    	$.ajax({
    		url : "home.php",
    		type : "POST",
    		async : false,
    		cache : false,
    		data : {
    			pilihannya : 1,
    			mall : "Grand City"
    		},
    		success: function(result){
    			tempstudio = result;
    		}
    	});
    	var row = '<tr>' +
    	'<td class="tanggal"><input class="datepicker" width="76"></td>' +
    	'<td class="waktu"><input class="timepicker" width="76"></td>'+
    	'<td>'+tempstudio+'</td>'+
    	'<td>'+tempmall+'</td>'+
    	'<td>'+tempfilm+'</td>'+
    	'<td><input type="text" class="form-control"></td>'+
    	'<td>' + actions5 + '</td>' +
    	'</tr>';
    	$(".tableJadwal").append(row);     
    	$(".tableJadwal .tbodyJadwal tr").eq(index + 1).find(".addJadwal, .editJadwal").toggle();
    	$('[data-toggle="tooltip"]').tooltip();
    	tdpicker();
    	ganti();
    });
    $(document).on("click", ".addJadwal", function(){
    	var empty = false;
    	var input = $(this).parents("tr").find('input[type="text"]');
    	input.each(function(){
    		if(!$(this).val()){
    			$(this).addClass("error");
    			empty = true;
    		} else{
    			$(this).removeClass("error");
    		}
    	});
    	$(this).parents("tr").find(".error").first().focus();
    	var arr = [];
    	var counter = 0;
    	var hari ="";
    	var waktu = "";
    	if(!empty){
    		hari = $('.datepicker').val();
    		$('.datepicker').parent("td").html(hari);
    		$('.tanggal').html(hari);
    		waktu = $('.timepicker').val();
    		$('.waktu').html(waktu)
    		$('select').each(function(){
    			arr[counter] = $(this).children("option:selected").val();
    			$(this).parent("td").html(arr[counter]);
    			counter++;
    		});
    		input.each(function(){
    			arr[counter] = $(this).val();
    			counter++;
    			$(this).parent("td").html($(this).val());
    		});        
    		$(this).parents("tr").find(".addJadwal, .editJadwal").toggle();
    		$(".add-newJadwal").removeAttr("disabled");
            $.ajax({
            	url : "home.php",
            	type : "POST",
            	async : false,
            	cache : false,
            	data : {
            		add_tableJadwal : 1,
            		hari : hari,
            		waktu : waktu,
            		nama : arr[0],
            		mall : arr[1],
            		film : arr[2],
            		harga : arr[3]
            	},
            	success: function(result){
            	}
            });
            showdataJadwal();
        }
        else{
        	alert("masih kosong");
        }       
    });
    $(document).on("click", ".editJadwal", function(){    
    	var counter = 0;
    	var counter2 = 0;
    	var xx ="";
    	$(this).parents("tr").find("td:not(:last-child)").each(function(){
    		if(counter2 == 3){
    			xx = $(this).text();
    			counter2++;
    		}
    		else{
    			counter2++;
    		}
    	});
    	$(this).parents("tr").find("td:not(:last-child)").each(function(){
    		if(counter == 0){
    			$(this).addClass("tanggal");
    			$(this).html('<input class="datepicker" width="76" value=' + $(this).text() + '>');
    			counter++;
    		}
    		else if(counter == 1){
    			$(this).addClass("waktu");
    			$(this).html('<input class="timepicker" width="76" value=' + $(this).text() + '>');
    			counter++;
    		}
    		else if(counter == 2){
    			var temp = "";
    			$.ajax({
    				url : "home.php",
    				type : "POST",
    				async : false,
    				cache : false,
    				data : {
    					pilihannyajadwal : 1,
    					pilihan : $(this).text(),
    					mall : xx
    				},
    				success: function(result){
    					temp = result;
    				}
    			});
    			$(this).html(temp);
    			counter++;
    		}
    		else if(counter == 3){
    			var temp = "";
    			$.ajax({
    				url : "home.php",
    				type : "POST",
    				async : false,
    				cache : false,
    				data : {
    					edit_studiojadwal : 1,
    					pilihan : $(this).text()
    				},
    				success: function(result){
    					temp = result;
    				}
    			});
    			$(this).html(temp);
    			counter++;
    		}
    		else if(counter == 4){
    			var temp = "";
    			$.ajax({
    				url : "home.php",
    				type : "POST",
    				async : false,
    				cache : false,
    				data : {
    					edit_film : 1,
    					pilihan : $(this).text()
    				},
    				success: function(result){
    					temp = result;
    				}
    			});
    			$(this).html(temp);
    			counter++;
    		}
    		else{
    			$(this).html('<input type="text" class="form-control" value="' + $(this).text() + '">');
    			counter++;
    		}
    	});
    	$(this).parents("tr").find(".updateJadwal, .editJadwal").toggle();
    	$(".add-newJadwal").attr("disabled", "disabled");
    	tdpicker();
    	ganti2();
    });
    $(document).on("click", ".updateJadwal", function(){
    	$(this).closest('tr').children('td:first').removeClass('tanggal');
    	id = $(this).closest('tr').children('td:first').attr('class');
    	var empty = false;
    	var input = $(this).parents("tr").find('input[type="text"]');
    	input.each(function(){
    		if(!$(this).val()){
    			$(this).addClass("error");
    			empty = true;
    		} else{
    			$(this).removeClass("error");
    		}
    	});
    	$(this).parents("tr").find(".error").first().focus();
    	var arr = [];
    	var counter = 0;
    	var hari ="";
    	var waktu = "";
    	if(!empty){
    		hari = $('.datepicker').val();
    		$('.datepicker').parent("td").html(hari);
    		$('.tanggal').html(hari);
    		waktu = $('.timepicker').val();
    		$('.waktu').html(waktu)
    		$('select').each(function(){
    			arr[counter] = $(this).children("option:selected").val();
    			$(this).parent("td").html(arr[counter]);
    			counter++;
    		});
    		input.each(function(){
    			arr[counter] = $(this).val();
    			counter++;
    			$(this).parent("td").html($(this).val());
    		});      
    		$(this).parents("tr").find(".updateJadwal, .editJadwal").toggle();
    		$(".add-newJadwal").removeAttr("disabled");
    		$.ajax({
    			url : "home.php",
    			type : "POST",
    			async : false,
    			cache : false,
    			data : {
    				update_tableJadwal : 1,
    				id : id,
    				hari : hari,
    				waktu : waktu,
    				nama : arr[0],
    				mall : arr[1],
    				film : arr[2],
    				harga : arr[3]
    			},
    			success: function(result){
    			}
    		});
    		showdataJadwal();
    	}      
    });
    $(document).on("click", ".deleteJadwal", function(){
    	id = $(this).closest('tr').children('td:first').attr('class');
    	$(this).parents("tr").remove();
    	$(".add-newStudio").removeAttr("disabled");
    	$.ajax({
    		url : "home.php",
    		type : "POST",
    		async : false,
    		cache : false,
    		data : {
    			delete_tableJadwal : 1,
    			id : id
    		},
    		success: function(result){
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
			$(".tbodyKasir").html(result);
		}
	});
}
function searchKasir() {
    //alert("nas");
    var input, filter, table, tr, td, i, txtValue;
    input = document.getElementById("myInputKasir");
    filter = input.value.toUpperCase();
    table = document.getElementById("myTableKasir");
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
//Film
function showdataFilm(){
	$.ajax({
		url : "home.php",
		type : "POST",
		async : false,
		cache : false,
		data : {
			show_tableFilm : 1
		},
		success: function(result){
			$(".tbodyFilm").html(result);
		}
	});
};
function searchFilm() {
    //alert("nas");
    var input, filter, table, tr, td, i, txtValue;
    input = document.getElementById("myInputFilm");
    filter = input.value.toUpperCase();
    table = document.getElementById("myTableFilm");
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
//Bioskop
function showdataMall(){
	$.ajax({
		url : "home.php",
		type : "POST",
		async : false,
		cache : false,
		data : {
			show_tableMall : 1
		},
		success: function(result){
			$(".tbodyBioskop").html(result);
		}
	});
};
function searchMall() {
    var input, filter, table, tr, td, i, txtValue;
    input = document.getElementById("myInputBioskop");
    filter = input.value.toUpperCase();
    table = document.getElementById("myTableBioskop");
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
//Studio
function searchStudio() {
    //alert("nas");
    var input, filter, table, tr, td, i, txtValue;
    input = document.getElementById("myInputStudio");
    filter = input.value.toUpperCase();
    table = document.getElementById("myTableStudio");
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
function showdataStudio(){
	$.ajax({
		url : "home.php",
		type : "POST",
		async : false,
		cache : false,
		data : {
			show_tableStudio : 1
		},
		success: function(result){
			$(".tbodyStudio").html(result);
		}
	});
};
//Jadwal
function searchJadwal() {
    //alert("nas");
    var input, filter, table, tr, td, i, txtValue;
    input = document.getElementById("myInputJadwal");
    filter = input.value.toUpperCase();
    table = document.getElementById("myTableJadwal");
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
function showdataJadwal(){
	$.ajax({
		url : "home.php",
		type : "POST",
		async : false,
		cache : false,
		data : {
			show_tableJadwal : 1
		},
		success: function(result){
			$(".tbodyJadwal").html(result);
		}
	});
};
//Custom
function ganti2(){
	$('.ganti2').change(function(){
		var pengganti = $(this).val();
		$.ajax({
			url : "home.php",
			type : "POST",
			async : false,
			cache : false,
			data : {
				cari_ganti : 1,
				gantian : pengganti
			},
			success: function(result){
                // $(".tbodyKasir").html(result);
                //alert(result);
                $('.daftar_studio2').html(result);
            }
        });
	});
}
function ganti(){
	$('.ganti').change(function(){
		var pengganti = $(this).val();
		$.ajax({
			url : "home.php",
			type : "POST",
			async : false,
			cache : false,
			data : {
				cari_ganti : 1,
				gantian : pengganti
			},
			success: function(result){
                // $(".tbodyKasir").html(result);
                //alert(result);
                $('.daftar_studio').html(result);
            }
        });
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
							<li class="selected"><a href="#0"><div class="image-icon"><img src="img/pegawai.png" width=40px></div><h6>Kasir</h6></a></li>
							<li><a href="#0"><div class="image-icon"><img src="img/film.png" width=40px></div><h6>Film</h6></a></li>
							<li><a href="#0"><div class="image-icon"><img src="img/bioskop.png" width=40px></div><h6>Bioskop</h6></a></li>
							<li><a href="#0"><div class="image-icon"><img src="img/monitor.png" width=40px></div><h6>Studio</h6></a></li>
							<li><a href="#0"><div class="image-icon"><img src="img/jadwal.png" width=40px></div><h6>Jadwal</h6></a></li>
							<li><a href="http://lkmm-td.petra.ac.id/asik/admin/"  id="keluar"><div class="image-icon"><img src="img/logout.png" width=40px></div><h6>Logout</h6></a></li>
						</ul>
					</nav> 
				</div> <!-- .cd-slider-nav -->

				<ul class="cd-hero-slider">

					<li class="selected">
						<div class="heading">
							<h1>Kasir</h1>
							<span>Atur anggota kasir anda!</span>
						</div>
						<div class="cd-full-width first-slide">
							<div class="container">
								<div class="content first-content">
									<div class="table-wrapper">
										<div class="table-title">
											<div class="row">
												<div class="col-sm-4"><h2>Kasir <b>Details</b></h2></div>
												<div class="col-sm-4">
													<button type="button" class="btn btn-info add-new add-newKasir"><i class="fa fa-plus"></i> Add New</button>
												</div>
												<div class="col-sm-4">
													<input type="text" id="myInputKasir" class="myInput" onkeyup="searchKasir()" placeholder="Search for names.." title="Type in a name">
												</div>
											</div>
										</div>
										<table class="table table-bordered tableKasir" id="myTableKasir">
											<thead>
												<tr>
													<th>Nama</th>
													<th>Username</th>
													<th>Password</th>
													<th>Actions</th>
												</tr>
											</thead>
											<tbody class="tbodyKasir"> 
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
							<span>Atur Film Anda!</span>
						</div>
						<div class="cd-full-width first-slide">
							<div class="container">
								<div class="content first-content">
									<div class="table-wrapper">
										<div class="table-title">
											<div class="row">
												<div class="col-sm-4"><h2>Movie <b>Details</b></h2></div>
												<div class="col-sm-4">
													<button type="button" class="btn btn-info add-newFilm"><i class="fa fa-plus"></i> Add New</button>
												</div>
												<div class="col-sm-4">
													<input type="text" class="myInput" id="myInputFilm" onkeyup="searchFilm()" placeholder="Search for names.." title="Type in a name">
												</div>
											</div>
										</div>
										<table class="table table-bordered tableFilm" id="myTableFilm">
											<thead>
												<tr>
													<th>Title</th>
													<th>Description</th>
													<th>Postername</th>
													<th>Actions</th>
												</tr>
											</thead>
											<tbody class="tbodyFilm"> 
											</tbody>
										</table>
									</div>
								</div>               
							</div>
						</div>
					</li>

					<li>
						<div class="heading">
							<h1>Bioskop</h1>
							<span>Atur Bioskop Anda!</span>
						</div>
						<div class="cd-full-width first-slide">
							<div class="container">
								<div class="content first-content">
									<div class="table-wrapper">
										<div class="table-title">
											<div class="row">
												<div class="col-sm-4"><h2>Bioskop <b>Details</b></h2></div>
												<div class="col-sm-4">
													<button type="button" class="btn btn-info add-newMall"><i class="fa fa-plus"></i> Add New</button>
												</div>
												<div class="col-sm-4">
													<input type="text" class="myInput" id="myInputBioskop" onkeyup="searchMall()" placeholder="Search for names.." title="Type in a name">
												</div>
											</div>
										</div>
										<table class="table table-bordered tableBioskop" id="myTableBioskop">
											<thead>
												<tr>
													<th>Mall Name</th>
													<th>Actions</th>
												</tr>
											</thead>
											<tbody class="tbodyBioskop"> 
											</tbody>
										</table>
									</div>
								</div>               
							</div>
						</div>
					</li>
					<li>
						<div class="heading">
							<h1>Studio</h1>
							<span>Atur Studio Anda!</span>
						</div>
						<div class="cd-full-width first-slide">
							<div class="container">
								<div class="content first-content">
									<div class="table-wrapper">
										<div class="table-title">
											<div class="row">
												<div class="col-sm-4"><h2>Studio <b>Details</b  ></h2></div>
												<div class="col-sm-4">
													<button type="button" class="btn btn-info add-newStudio"><i class="fa fa-plus"></i> Add New</button>
												</div>
												<div class="col-sm-4">
													<input type="text" class="myInput" id="myInputStudio" onkeyup="searchStudio()" placeholder="Search for names.." title="Type in a name">
												</div>
											</div>
										</div>
										<table class="table table-bordered tableStudio" id="myTableStudio">
											<thead>
												<tr>
													<th>Studio Name</th>
													<th>Mall Name</th>
													<th>Actions</th>
												</tr>
											</thead>
											<tbody class="tbodyStudio"> 
											</tbody>
										</table>

									</div>
								</div>               
							</div>

						</div>

					</li>
					<li>
						<div class="heading">
							<h1>Jadwal</h1>
							<span>Atur Jadwal Anda!</span>
						</div>
						<div class="cd-full-width first-slide">
							<div class="container">
								<div class="content first-content">
									<div class="table-wrapper">
										<div class="table-title">
											<div class="row">
												<div class="col-sm-4"><h2>Jadwal <b>Details</b  ></h2></div>
												<div class="col-sm-4">
													<button type="button" class="btn btn-info add-newJadwal"><i class="fa fa-plus"></i> Add New</button>
												</div>
												<div class="col-sm-4">
													<input type="text" class="myInput" id="myInputJadwal" onkeyup="searchJadwal()" placeholder="Search for names.." title="Type in a name">
												</div>
											</div>
										</div>
										<table class="table table-bordered tableJadwal" id="myTableJadwal">
											<thead>
												<tr>
													<th>Tanggal Jadwal</th>
													<th>Jam</th>
													<th>Studio</th>
													<th>Mall</th>
													<th>Film</th>
													<th>Harga Tiket</th>
													<th>Actions</th>
												</tr>
											</thead>
											<tbody class="tbodyJadwal"> 
											</tbody>
										</table>
                                        <!-- <select class='form-control' id='ganti'>
		        							<option>1</option>
		        							<option>2</option>
		        						</select> -->
		        					</div>
		        				</div>               
		        			</div>
		        		</div>                         
		        	</li>
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
		        		window.location.replace("http://lkmm-td.petra.ac.id/asik/admin/");
		        	});
		        </script>
		    </body>
		    </html>