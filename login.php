<?php
	session_start();
	include("connection.php");
	$error = "";
	if (isset($_POST["submit"]))
	{
		if (empty($_POST["username"]) || empty($_POST["password"])) {
			$error = "Both fields are required.";
		} else {

			$username=$_POST['username'];
			$password=$_POST['password'];

			$username = stripslashes($username);
			$password = stripslashes($password);

			$password = md5($password);

			while ($row = sqlsrv_fetch_array(sqlsrv_query($pg_connlog, "SELECT [uid] FROM [Soreva].[dbo].[users] WHERE username='$username' and password='$password'"), SQLSRV_FETCH_ASSOC)) {
				if ($row['uid'] > 0) {
					$_SESSION['username'] = $username;
					header("location: dashboard");
				} else {
					$error = "Incorrect username or password.";
				}
			}
		}
	}

?>