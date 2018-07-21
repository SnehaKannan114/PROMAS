<?php
	
if(isset($_GET['logout']))
{
	session_start();
	unset($_SESSION['username']);
	session_destroy();
	$message = 'Logout Successful';
	echo "<script type='text/javascript'>var conf = confirm('$message');</script>"; 
	//echo 'you have been logged out';
	echo "<script>setTimeout(\"location.href = './login.html';\",1500);</script>";
	//header("Location:./login.html");
	exit;
}

?>