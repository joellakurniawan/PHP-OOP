<?php
    $con = mysqli_connect("lkmm-td.petra.ac.id", "lkmmtd", "semutnyasar46", "lkmmtd_adsitercinta");
    session_start();
    if($_SERVER['REQUEST_METHOD'] == "POST"){
        $user=$_POST['username'];
        $pass=$_POST['password'];
        $sql = mysqli_query($con,"SELECT * FROM pegawai WHERE username_pegawai = '$user' AND password_pegawai = '$pass' AND status_pegawai=2");            
        $hasil = mysqli_fetch_array($sql);
        if (mysqli_num_rows($sql) == 1) {
            $_SESSION['username']=$_POST["username"];
            $_SESSION['idpegawai']=$hasil[0];
            header("Location: home.php");
        }
        else{
        	echo "<script>window.alert('Username/password salah');window.location.href='index.php';</script>";
        }
    }
?>