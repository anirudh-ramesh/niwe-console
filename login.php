<?php

	session_start();

	include("connection.php");

	$error = "";

	if (isset($_POST["submit"])) {

		if (empty($_POST["username"]) || empty($_POST["password"])) {
			$error = "Both fields are required.";
		} else {

			$username = stripslashes($_POST['username']);
			$password = md5(stripslashes($_POST['password']));

			$result = sqlsrv_query($connectionHandle, "SELECT [uid] FROM [Soreva].[dbo].[users] WHERE username='$username' and password='$password'");
			while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
				if ($row['uid'] > 0) {
					$_SESSION['username'] = $username;
					header('location: console');
				} else {
					$error = "Incorrect username or password.";
				}
			}
		}
	}

?>