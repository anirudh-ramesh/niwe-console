<?php
   include("../../../check.php");
	if ($_SESSION['username'] == 'root') 
	{
		header('Location: home.php');
	}  
	else
	{
		header('Location: prohibit.php');
	}
   ?>