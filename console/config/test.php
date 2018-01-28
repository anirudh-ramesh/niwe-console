<?php

//

$maindatabaseName = "MeteoStation4K";
$sidedatabaseName = "Soreva";

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

$iChannels = 16;
$nChannels = 10;

$granularity = 5;
$start_time = "00:00:00";
$end_time = "00:01:00";
$start_date = "2018-01-07 " . $start_time;
$end_date = "2018-01-07 " . $end_time;

$delimiter = ",";

$station = 2548;
$stateCode = 'DL';

//

// $subquery_prefix = "(SELECT " . $es_value . ", " . $es_stationNumber . ", " . $es_time . " FROM [" . $maindatabaseName . "].[dbo].[" . $es_data . "] WHERE " . $es_stationNumber . " = " . (string)$station . " AND " . $es_functionNumber . " = 0 AND " . $es_parameterNumber . " = ";
// $subquery_suffix = " AND " . $es_time . " BETWEEN '" . $start_date . "' AND '" . $end_date . "')";

// $query_prefix = "SELECT ";
// for ($index = 1; $index <= $nChannels; $index++) {
// 	$query_prefix = $query_prefix . "AVG(set" . (string)$index . "." . $es_value . ") AS voltage" . (string)$index . ", ";
// }
// // $query_prefix = $query_prefix . "set1." . $es_stationNumber . " AS station, ";
// $query_prefix = $query_prefix . "MAX(set1." . $es_time . ") AS timestmp ";
// $query_prefix = $query_prefix . "from ";

// $query = $query_prefix . "\n" . $subquery_prefix . (string)$iChannels . $subquery_suffix . " AS set1 inner join \n";
// for ($channel = $iChannels + 1; $channel <= $iChannels + $nChannels - 1; $channel++) {
// 	$set = $channel - $iChannels + 1;
// 	$query = $query . $subquery_prefix . (string)$channel . $subquery_suffix . " AS set" . (string)$set . " ON set" . (string)($set - 1) . "." . $es_time . " = set" . (string)$set . "." . $es_time . " AND set" . (string)($set - 1) . "." . $es_stationNumber . " = set" . (string)$set . "." . $es_stationNumber;
// 	if ($channel != $iChannels + $nChannels - 1) {
// 		$query = $query . " inner join \n";
// 	}
// 	else {
// 		$query = $query . "\n GROUP BY (DATEPART(MINUTE, set1." . $es_time . ") / " . (string)$granularity . ")";
// 	}
// }

$query = 'SELECT MIN(' . $en_time . ') AS ' . $en_time . ', AVG(' . $en_power . ') AS ' . $en_power . ', AVG(' . $en_frequency . ') AS ' . $en_frequency . ' FROM [Soreva].[dbo].[dispatch_load] WHERE ' . $en_stateCode . ' = \'' . $stateCode . '\' AND ' . $en_time . ' BETWEEN \'' . $start_date . '\' AND \'' . $end_date . '\' GROUP BY DATEPART(YEAR, ' . $en_time . '), DATEPART(MONTH, ' . $en_time . '), DATEPART(DAY, ' . $en_time . '), DATEPART(HOUR, ' . $en_time . '), DATEPART(MINUTE, ' . $en_time . ') / ' . (string)$granularity;

echo $query;

?>