<?php

session_start();

include('../../config/init.php');

$state = ($_REQUEST["state"] <> "") ? trim($_REQUEST["state"]) : "";

$_SESSION['state'] = $_REQUEST["state"];

$query = "SELECT DISTINCT [" . $en_stateName . "] FROM [" . $sidedatabaseName . "].[dbo].[" . $en_plants . "] ;";
$result = sqlsrv_query($sidedatabaseHandle, $query);

?>