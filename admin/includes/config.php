<?php
/** 	Koneksi ke Basis Data, dengan nama file config.php  **/
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "skripsiakhir";

$connection = mysqli_connect($servername, $username, $password, $dbname);
if(!$connection) /** Cek Koneksi ke basis data berhasil atau tidak**/
    { die("Connection Failed : ".mysqli_connect_error());
    }
?>
