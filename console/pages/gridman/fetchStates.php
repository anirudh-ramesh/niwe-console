<?php

session_start();

include('../../config/init.php');

$state = ($_REQUEST["state"] <> "") ? trim($_REQUEST["state"]) : "";

$_SESSION['state'] = $_REQUEST["state"];

$query = "SELECT DISTINCT [" . $en_stateCode . "] FROM [" . $sidedatabaseName . "].[dbo].[" . $en_plants . "] ;";
$result = sqlsrv_query($sidedatabaseHandle, $query);

?>