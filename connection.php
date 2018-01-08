<?php
	$serverName = "(local),1433";
	$connectionInfo = array("Database" => "Soreva", "UID" => "sa", "PWD" => "sgs@123");
	$pg_connlog = sqlsrv_connect($serverName, $connectionInfo);
?>