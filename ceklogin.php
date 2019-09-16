<?php
	session_start();
	if (!isset($_SESSION['idcustomer'])){
		header("Location:logincustomer.php");
	}
	else {
		header("Location:pesantiket.php");
	}
?>