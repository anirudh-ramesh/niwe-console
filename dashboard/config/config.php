<?php
$serverName = "(local),1433";
$database_name = "[MeteoStation4K]";
$connectionInfo = array( "Database"=>"MeteoStation4K", "UID"=>"sa", "PWD"=>"sgs@123");  
$connectionInfo1 = array( "Database"=>"Soreva", "UID"=>"sa", "PWD"=>"sgs@123"); 

$pg_index = sqlsrv_connect( $serverName, $connectionInfo);//for Database=>CWET_Advance
$pg_index1 = sqlsrv_connect( $serverName, $connectionInfo1);//for Database=>Soreva 
?>
