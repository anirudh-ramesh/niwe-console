<?php
	$serverName = "(local),1433";
	$connectionInfo = array("Database" => "Soreva", "UID" => "sa", "PWD" => "sgs@123");
	$connectionHandle = sqlsrv_connect($serverName, $connectionInfo);
?>