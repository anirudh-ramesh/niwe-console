<?php

session_start();

$station = $_SESSION['station'];

include('../../config/init.php');

$query = "SELECT [" . $es_number . "] FROM [" . $maindatabaseName . "].[dbo].[" . $es_stations . "] where " . $es_stationNumber . "=".$station.";";
$result = sqlsrv_query($maindatabaseHandle, $query);
while ($row = sqlsrv_fetch_array($result)){
	$stationName = $row[$es_number];
}

if (isset($_SESSION['station'], $_POST["exp_irr_from_date"], $_POST["exp_irr_to_date"])) {

	$start_date = $_POST["exp_vol_from_date"] . " 00:00:00";
	$end_date   = $_POST["exp_vol_to_date"] . " 23:59:00";

	$subquery_prefix = "(SELECT " . $es_value . ", " . $es_stationNumber . ", " . $es_time . " FROM [" . $maindatabaseName . "].[dbo].[" . $es_data . "] WHERE " . $es_stationNumber . " = " . (string)$station . " AND " . $es_functionNumber . " = 0 AND " . $es_parameterNumber . " = ";
	$subquery_suffix = " AND " . $es_time . " BETWEEN '" . $start_date . "' AND '" . $end_date . "')";

	$query_prefix = "SELECT ";
	for ($index = 1; $index <= $nChannels; $index++) {
		$query_prefix = $query_prefix . "value" . (string)$index . "." . $es_value . " AS variable" . (string)$index . ", ";
	}
	$query_prefix = $query_prefix . "value1." . $es_stationNumber . " AS station, ";
	$query_prefix = $query_prefix . "value1." . $es_time . " AS timestmp ";
	$query_prefix = $query_prefix . "from ";

	$query = $query_prefix . "\n" . $subquery_prefix . (string)$iChannels . $subquery_suffix . " AS value1 inner join \n";
	for ($channel = $iChannels + 1; $channel <= $iChannels + $nChannels - 1; $channel++) {
		$value = $channel - $iChannels + 1;
		$query = $query . $subquery_prefix . (string)$channel . $subquery_suffix . " AS value" . (string)$value . " ON value" . (string)($value - 1) . "." . $es_time . " = value" . (string)$value . "." . $es_time . " AND value" . (string)($value - 1) . "." . $es_stationNumber . " = value" . (string)$value . "." . $es_stationNumber;
		if ($channel != $iChannels + $nChannels - 1) {
			$query = $query . " inner join \n";
		}
		else {
			$query = "\n";
		}
	}

	$delimiter = ",";
	$f = fopen('php://memory', 'w');
	$fields = array(
		'Timestamp',
		'DNI_299.1nm',
		'DNI_324.4nm',
		'DNI_367.2nm',
		'DNI_496.1nm',
		'DNI_614.2nm',
		'DNI_671.3nm',
		'DNI_782.9nm',
		'DNI_869.2nm',
		'DNI_938.1nm',
		'DNI_1037.8nm'
	);
	fputcsv($f, $fields, $delimiter);
	$result = sqlsrv_query($maindatabaseHandle, $query, array() , array("Scrollable" => "buffered"));
	while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
		$y[0] = $row['timestmp'];
		
		for ($i = 1; $i <= 10; $i++) {
			$query2 = "SELECT * FROM [Soreva].[dbo].[conversion_constant] where id=$i AND station=$station;";
			$result2 = sqlsrv_query($sidedatabaseHandle, $query2, array() , array("Scrollable" => "buffered"));
			while ($row1 = sqlsrv_fetch_array($result2, SQLSRV_FETCH_ASSOC)) {
				$y[$i] = ($row["variable" . "$i"] - $row1['Offset_V1'] * $row1['Gain_V'] - $row1['Offset_V2']) / ($row1['Gain_V'] * $row1['Gain_DNI']);
			}
		}
		$lineData = array(
			date_format($y[0], "Y-m-d H:i") ,
			number_format((float)$y[1], 3, '.', '') ,
			number_format((float)$y[2], 3, '.', '') ,
			number_format((float)$y[3], 3, '.', '') ,
			number_format((float)$y[4], 3, '.', '') ,
			number_format((float)$y[5], 3, '.', '') ,
			number_format((float)$y[6], 3, '.', '') ,
			number_format((float)$y[7], 3, '.', '') ,
			number_format((float)$y[8], 3, '.', '') ,
			number_format((float)$y[9], 3, '.', '') ,
			number_format((float)$y[10], 3, '.', '')
		);
		fputcsv($f, $lineData, $delimiter);
	}
	// Move to the beginning of the file
	fseek($f, 0);
	// Set headers to download the file
	header('Content-Type: text/csv');
	header('Station-Number: '.$stationName);
	//header('Content-Disposition: attachment; filename="data.csv";');
	// Throw all remaining data on a file pointer
	fpassthru($f);
	exit;
}

?>