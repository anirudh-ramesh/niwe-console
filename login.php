<?php
	session_start();
	include("connection.php"); //Establishing connection with our database	
	$error = ""; //Variable for storing our errors.
	if(isset($_POST["submit"]))
	{
		if(empty($_POST["username"]) || empty($_POST["password"]))
		{
			$error = "Both fields are required.";
		}else
		{
			// Define $username and $password
			$username=$_POST['username'];
			$password=$_POST['password'];

			// To protect from MySQL injection
			$username = stripslashes($username);
			$password = stripslashes($password);
			//$username = pg_escape_string($pg_connlog, $username); no function in SQLSRV
			//$password = pg_escape_string($pg_connlog, $password); no function in SQLSRV
			 $password = md5($password);
			
			//Check username and password from database
			$query="SELECT [uid] FROM [Soreva].[dbo].[users] WHERE username='$username' and password='$password'";
		    $result = sqlsrv_query($pg_connlog, $query);			
            while( $row = sqlsrv_fetch_array( $result, SQLSRV_FETCH_ASSOC ) ) {
            if( $row['uid'] > 0)
			{
				$_SESSION['username'] = $username; // Initializing Session
				header("location: dashboard"); // Redirecting To Other Page
			}else
			{
				$error = "Incorrect username or password.";
			}
            }	
			//$row     = sqlsrv_fetch_array($result);
			
			//If username and password exist in our database then create a session.
			//Otherwise echo error.			
			

		}
	}

?>