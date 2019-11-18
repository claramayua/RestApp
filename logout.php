<?php
	//Setting session dan destroy session and go back to home.php
	session_start();
	session_destroy();
	header('Location: http://localhost/restapp/home.php');
?>