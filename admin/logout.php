<?php
	session_start();
	$_SESSION['admin_id']; 

	unset($_SESSION['admin_id']);
	
	session_unset();
	session_destroy();
	
	header("location:login.php")
?>