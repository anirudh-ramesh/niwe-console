<?php

session_start();

$station = $_SESSION['station'];

include('../../config/init.php');

$query = "SELECT [" . $es_number . "] FROM [" . $maindatabaseName . "].[dbo].[" . $es_stations . "] where " . $es_stationNumber . "=".$station.";";
$result = sqlsrv_query($maindatabaseHandle, $query);
while ($row = sqlsrv_fetch_array($result)){
	$stationName = $row[$es_number];
}

if (isset($_SESSION['station'], $_POST["exp_vol_from_date"], $_POST["exp_vol_to_date"])) {

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
		'Voltage_299.1nm',
		'Voltage_324.4nm',
		'Voltage_367.2nm',
		'Voltage_496.1nm',
		'Voltage_614.2nm',
		'Voltage_671.3nm',
		'Voltage_782.9nm',
		'Voltage_869.2nm',
		'Voltage_938.1nm',
		'Voltage_1037.8nm'
	);
	fputcsv($f, $fields, $delimiter);
	$result = sqlsrv_query($maindatabaseHandle, $query, array() , array("Scrollable" => "buffered"));
	while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
		$lineData = array(
			date_format($row['timestmp'], "Y-m-d H:i"),
			number_format((float)$row['variable1'], 3, '.', ''),
			number_format((float)$row['variable2'], 3, '.', ''),
			number_format((float)$row['variable3'], 3, '.', ''),
			number_format((float)$row['variable4'], 3, '.', ''),
			number_format((float)$row['variable5'], 3, '.', ''),
			number_format((float)$row['variable6'], 3, '.', ''),
			number_format((float)$row['variable7'], 3, '.', ''),
			number_format((float)$row['variable8'], 3, '.', ''),
			number_format((float)$row['variable9'], 3, '.', ''),
			number_format((float)$row['variable10'], 3, '.', '')
		);
		fputcsv($f, $lineData, $delimiter);
	}
	// Move to the beginning of the file
	fseek($f, 0);
	// Set headers to download the file
	header('Content-Type: text/csv');
	header('Station-Number: '.$stationName);
	// header('Content-Disposition: attachment; filename="' . $filename . '";');
	// Throw all remaining data on a file pointer
	fpassthru($f);
	exit;
}

?>