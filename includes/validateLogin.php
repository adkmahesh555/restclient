<?php 
	session_start();
	if (!isset($_SESSION['loggedIn']) || $_SESSION['loggedIn'] == false){
		header('Location: login.php?error="Unauthorized"');
		return;
	}
?>