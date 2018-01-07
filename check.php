<?php
			include('connection.php');
			session_start();
			$user_check=$_SESSION['username'];
            $query   = "SELECT username FROM users WHERE username='$user_check';";
            $result  = sqlsrv_query($pg_connlog, $query);
            $row     = sqlsrv_fetch_array($result);
            $login_user=$row['username'];
			if(!isset($user_check))
				{
				header("Location: index.php");
				}
?>

