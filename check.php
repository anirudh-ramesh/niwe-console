<?php
	include ('connection.php');
	session_start();
	$usernameSession = $_SESSION['username'];
	$query      = "SELECT username FROM users WHERE username='$usernameSession';";
	$result     = sqlsrv_query($connectionHandle, $query);
	$row        = sqlsrv_fetch_array($result);
	$usernameDatabase = $row['username'];
	if (!isset($usernameSession)) {
		header("Location: index.php");
	}
?>