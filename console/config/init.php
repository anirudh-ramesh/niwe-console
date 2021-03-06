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

$en_stationNumber = "stationNumber";
$en_wavelength = "wavelength";
$en_parameters = "parameters";
$en_parameterNumber = "parameterNumber";
$en_channelNumber = "channelNumber";
$en_voltage2irradiance = "voltage2irradiance";

$en_plants = "plants";
$en_time = "Timestamp";
$en_stateCode = "stateCode";
$en_power = "power";
$en_frequency = "frequency";
$en_consumptionTable = "dispatch_load";
$en_generationTable = "dispatch_source";

$start_time = "00:00:00";
$end_time = "23:59:00";

$delimiter = ",";

$maindatabaseHandle = sqlsrv_connect($serverName, array("Database" => $maindatabaseName, "UID" => $username, "PWD" => $password));
$sidedatabaseHandle = sqlsrv_connect($serverName, array("Database" => $sidedatabaseName, "UID" => $username, "PWD" => $password));

$response = sqlsrv_query($sidedatabaseHandle, "SELECT count([" . $en_channelNumber . "]) AS count FROM [" . $sidedatabaseName . "].[dbo].[" . $en_parameters . "];");
while ($element = sqlsrv_fetch_array($response)) {
	$nChannels = $element['count'];
}
$response = sqlsrv_query($sidedatabaseHandle, "SELECT min([" . $en_parameterNumber . "]) AS min FROM [" . $sidedatabaseName . "].[dbo].[" . $en_parameters . "];");
while ($element = sqlsrv_fetch_array($response)) {
	$iChannels = $element['min'];
}

?>