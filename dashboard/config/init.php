<?php

$serverName = "(local),1433";

$maindatabaseName = "MeteoStation4K";
$sidedatabaseName = "Soreva";

$username = "sa";
$password = "sgs@123";

$es_stations = "Estaciones";
$es_stationNumber = "NumEstacion";
$es_number = "Nombre";
$es_time = "Fecha";
$es_value = "Valor";
$es_data = "Datos";
$es_parameterNumber = "NumParametro";
$es_functionNumber = "NumFuncion";

$iChannels = 16;
$nChannels = 10;

$start_time = "00:00:00";
$end_time = "23:59:00";

$maindatabaseHandle = sqlsrv_connect($serverName, array("Database" => $maindatabaseName, "UID" => $username, "PWD" => $password));
$sidedatabaseHandle = sqlsrv_connect($serverName, array("Database" => $sidedatabaseName, "UID" => $username, "PWD" => $password));

?>