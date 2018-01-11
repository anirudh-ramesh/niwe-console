<?php

// Retrieve database connection handles
include('../../config/init.php');

// Start the access session
session_start();

// If the 'station' session variable is unavailable...
if (!isset($_SESSION['station']))
{
	// ...echo a message...
	echo "Error: 'station' unavailable in this session.";
	// ...and exit...
	exit;
}

// ...otherwise, retrieve the station name
$result = sqlsrv_query($maindatabaseHandle, "SELECT [" . $es_number . "] FROM [" . $maindatabaseName . "].[dbo].[" . $es_stations . "] WHERE " . $es_stationNumber . " = " . $_SESSION['station'] . ";");
while ($row = sqlsrv_fetch_array($result)) {
	$stationName = $row[$es_number];
}

// If the 'from_date', 'to_date', 'granularity' or 'method' are unavailable...
if (!$_POST['from_date'])
{
	// ...echo a message...
	echo "Error: 'from_date' unavailable in this HTTP POST request's body.";
	// ...and exit...
	exit;
}
if (!$_POST['to_date'])
{
	// ...echo a message...
	echo "Error: 'to_date' unavailable in this HTTP POST request's body.";
	// ...and exit...
	exit;
}
if (!$_POST['granularity'])
{
	// ...echo a message...
	echo "Error: 'granularity' unavailable in this HTTP POST request's body.";
	// ...and exit...
	exit;
}
if (!$_POST['method'])
{
	// ...echo a message...
	echo "Error: 'method' unavailable in this HTTP POST request's body.";
	// ...and exit...
	exit;
}

$start_date = $_POST['from_date'] . " " . $start_time;
$end_date = $_POST['to_date'] . " " . $end_time;
$granularity = $_POST['granularity'];

// echo $start_date;
// echo $end_date;

$subquery_prefix = "(SELECT " . $es_value . ", " . $es_stationNumber . ", " . $es_time . " FROM [" . $maindatabaseName . "].[dbo].[" . $es_data . "] WHERE " . $es_stationNumber . " = " . (string)$station . " AND " . $es_functionNumber . " = 0 AND " . $es_parameterNumber . " = ";
$subquery_suffix = " AND " . $es_time . " BETWEEN '" . $start_date . "' AND '" . $end_date . "')";

// echo $subquery_prefix;
// echo $subquery_suffix;

$query_prefix = "SELECT ";
for ($index = 1; $index <= $nChannels; $index++) {
	$query_prefix = $query_prefix . "AVG(set" . (string)$index . "." . $es_value . ") AS voltage" . (string)$index . ", ";
}
// $query_prefix = $query_prefix . "set1." . $es_stationNumber . " AS station, ";
$query_prefix = $query_prefix . "MAX(set1." . $es_time . ") AS timestmp ";
$query_prefix = $query_prefix . "from ";

// echo $query_prefix;

$query = $query_prefix . "\n" . $subquery_prefix . (string)$iChannels . $subquery_suffix . " AS set1 inner join \n";
for ($channel = $iChannels + 1; $channel <= $iChannels + $nChannels - 1; $channel++) {
	$set = $channel - $iChannels + 1;
	$query = $query . $subquery_prefix . (string)$channel . $subquery_suffix . " AS set" . (string)$set . " ON set" . (string)($set - 1) . "." . $es_time . " = set" . (string)$set . "." . $es_time . " AND set" . (string)($set - 1) . "." . $es_stationNumber . " = set" . (string)$set . "." . $es_stationNumber;
	if ($channel != $iChannels + $nChannels - 1) {
		$query = $query . " inner join \n";
	}
	else {
		$query = $query . "\n GROUP BY (DATEPART(MINUTE, set1." . $es_time . ") / " . (string)$granularity . ")";
	}
}

// echo $query;

if ($_POST['method'] == 'export_voltage') {

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

if ($_POST['method'] == 'export_irradiance') {

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

if ($_POST['method'] == 'view_irradiance') {

	$result = sqlsrv_query($maindatabaseHandle, $query, array(), array("Scrollable" => "buffered"));
	if (sqlsrv_num_rows($result) > 0) {
		echo "<table class='table table-bordered'>";
		echo "<tr>";
		echo "<th align='center' width='40'>" . 'Timestamp' . "</th>";
		echo "<th align='center' width='40'>" . 'DNI_299.1nm' . "</th>";
		echo "<th align='center' width='40'>" . 'DNI_324.4nm' . "</th>";
		echo "<th align='center' width='40'>" . 'DNI_367.2nm' . "</th>";
		echo "<th align='center' width='40'>" . 'DNI_496.1nm' . "</th>";
		echo "<th align='center' width='40'>" . 'DNI_614.2nm' . "</th>";
		echo "<th align='center' width='40'>" . 'DNI_671.3nm' . "</th>";
		echo "<th align='center' width='40'>" . 'DNI_782.9nm' . "</th>";
		echo "<th align='center' width='40'>" . 'DNI_869.2nm' . "</th>";
		echo "<th align='center' width='40'>" . 'DNI_938.1nm' . "</th>";
		echo "<th align='center' width='40'>" . 'DNI_1037.8nm' . "</th>";
		echo "</tr>";
		while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
			$y[0] = $row['timestmp'];
			
			for ($i = 1; $i <= 10; $i++) {
				$query2 = "SELECT * FROM [Soreva].[dbo].[conversion_constant] where id=$i AND station=$station;";
				$result2 = sqlsrv_query($sidedatabaseHandle, $query2, array() , array("Scrollable" => "buffered"));
				while ($row1 = sqlsrv_fetch_array($result2, SQLSRV_FETCH_ASSOC)) {
					$y[$i] = ($row["variable" . "$i"] - $row1['Offset_V1'] * $row1['Gain_V'] - $row1['Offset_V2']) / ($row1['Gain_V'] * $row1['Gain_DNI']);
				}
			}

			echo "<tr>";
			echo "<td align='center' width='40'>" . date_format($y[0], "Y-m-d H:i") . "</td>";
			echo "<td align='center' width='40'>" . number_format((float)$y[1], 3, '.', '') . "</td>";
			echo "<td align='center' width='40'>" . number_format((float)$y[2], 3, '.', '') . "</td>";
			echo "<td align='center' width='40'>" . number_format((float)$y[3], 3, '.', '') . "</td>";
			echo "<td align='center' width='40'>" . number_format((float)$y[4], 3, '.', '') . "</td>";
			echo "<td align='center' width='40'>" . number_format((float)$y[5], 3, '.', '') . "</td>";
			echo "<td align='center' width='40'>" . number_format((float)$y[6], 3, '.', '') . "</td>";
			echo "<td align='center' width='40'>" . number_format((float)$y[7], 3, '.', '') . "</td>";
			echo "<td align='center' width='40'>" . number_format((float)$y[8], 3, '.', '') . "</td>";
			echo "<td align='center' width='40'>" . number_format((float)$y[9], 3, '.', '') . "</td>";
			echo "<td align='center' width='40'>" . number_format((float)$y[10], 3, '.', '') . "</td>";
			echo "</tr>";
		}
		echo "</table>";
	}
	else echo "No data to display!<br>";

}

if ($_POST['method'] == 'plot_irradiance_time') {

	$arr0['name']    = 'Timestamp';
	$arr[1]['name']  = 'DNI_299.1nm';
	$arr[2]['name']  = 'DNI_324.4nm';
	$arr[3]['name']  = 'DNI_367.2nm';
	$arr[4]['name']  = 'DNI_496.1nm';
	$arr[5]['name']  = 'DNI_614.2nm';
	$arr[6]['name']  = 'DNI_671.3nm';
	$arr[7]['name']  = 'DNI_782.9nm';
	$arr[8]['name']  = 'DNI_869.2nm';
	$arr[9]['name']  = 'DNI_938.1nm';
	$arr[10]['name'] = 'DNI_1037.8nm';

	$result = sqlsrv_query ($maindatabaseHandle,$query, array(), array("Scrollable"=>"buffered"));
	while ($row = sqlsrv_fetch_array ($result, SQLSRV_FETCH_ASSOC)) {

		$arr0['data'][] = date_format ($row['timestmp'],"Y-m-d  H:i");

		for ($i = 1; $i <= 10; $i++) {

			$query2 = "SELECT * FROM [Soreva].[dbo].[conversion_constant] where id=$i AND station=$station;";

			$result2 = sqlsrv_query ($sidedatabaseHandle,$query2, array(), array("Scrollable"=>"buffered"));

			while ($row1 = sqlsrv_fetch_array ($result2, SQLSRV_FETCH_ASSOC)) {
				$arr[$i]['data'][] = ($row["variable"."$i"] - $row1['Offset_V1'] * $row1['Gain_V'] - $row1['Offset_V2']) / ($row1['Gain_V'] * $row1['Gain_DNI']);
			}

		}
	}

	$payload = array();
	array_push($payload, $arr0);
	array_push($payload, $arr[1]);
	array_push($payload, $arr[2]);
	array_push($payload, $arr[3]);
	array_push($payload, $arr[4]);
	array_push($payload, $arr[5]);
	array_push($payload, $arr[6]);
	array_push($payload, $arr[7]);
	array_push($payload, $arr[8]);
	array_push($payload, $arr[9]);
	array_push($payload, $arr[10]);
	print json_encode($payload, JSON_NUMERIC_CHECK);

	sqlsrv_close($maindatabaseHandle);

	exit;

}

?>