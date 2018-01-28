<?php

// Retrieve database connection handles
include('../config/init.php');

$nameChannel = "set";
$nameVoltage = "voltage";

// Start the access session
session_start();

// If the 'station' session variable is unavailable...
if (!isset($_SESSION['station'])) {
	// ...echo a message...
	echo "Error: 'station' unavailable in this session.";
	// ...and exit...
	exit;
} else {
	$stationNumber = $_SESSION['station'];
}

// ...otherwise, retrieve the station name
$stations = sqlsrv_query($maindatabaseHandle, "SELECT [" . $es_number . "] FROM [" . $maindatabaseName . "].[dbo].[" . $es_stations . "] WHERE " . $es_stationNumber . " = " . $stationNumber . ";");
while ($station = sqlsrv_fetch_array($stations)) {
	$stationName = $station[$es_number];
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

	// If the 'dateFrom', 'dateTo' or 'method' are unavailable...
	if (!$_POST['dateFrom']) {
		// ...echo a message...
		echo "Error: 'dateFrom' unavailable in this HTTP POST request's body.";
		// ...and exit...
		// exit;
	} else {
		$start_date = $_POST['dateFrom'] . " " . $start_time;
	}
	if (!$_POST['dateTo']) {
		// ...echo a message...
		echo "Error: 'dateTo' unavailable in this HTTP POST request's body.";
		// ...and exit...
		// exit;
	} else {
		$end_date = $_POST['dateTo'] . " " . $end_time;
	}
	if (!$_POST['method']) {
		// ...echo a message...
		echo "Error: 'method' unavailable in this HTTP POST request's body.";
		// ...and exit...
		// exit;
	} else {
		$method = $_POST['method'];
	}

	$granularity = ($_POST["granularity"] <> "") ? $_POST["granularity"] : "1";

} elseif ($_SERVER['REQUEST_METHOD'] == 'GET') {

	// If the 'dateFrom', 'dateTo' or 'method' are unavailable...
	if (!$_GET['dateFrom']) {
		// ...echo a message...
		echo "Error: 'dateFrom' unavailable in this HTTP GET request.";
		// ...and exit...
		// exit;
	} else {
		$start_date = $_GET['dateFrom'] . " " . $start_time;
	}
	if (!$_GET['dateTo']) {
		// ...echo a message...
		echo "Error: 'dateTo' unavailable in this HTTP GET request.";
		// ...and exit...
		// exit;
	} else {
		$end_date = $_GET['dateTo'] . " " . $end_time;
	}
	if (!$_GET['method'])
	{
		// ...echo a message...
		echo "Error: 'method' unavailable in this HTTP GET request.";
		// ...and exit...
		// exit;
	} else {
		$method = $_GET['method'];
	}

	$granularity = ($_GET["granularity"] <> "") ? $_GET["granularity"] : "1";

}

// echo $start_date;
// echo $end_date;
// echo $method;
// echo $granularity;

$subquery_prefix = "(SELECT " . $es_value . ", " . $es_stationNumber . ", " . $es_time . " FROM [" . $maindatabaseName . "].[dbo].[" . $es_data . "] WHERE " . $es_stationNumber . " = " . $stationNumber . " AND " . $es_functionNumber . " = 0 AND " . $es_parameterNumber . " = ";
$subquery_suffix = " AND " . $es_time . " BETWEEN '" . $start_date . "' AND '" . $end_date . "')";

// echo $subquery_prefix;
// echo $subquery_suffix;

$query_prefix = "SELECT ";
for ($index = 1; $index <= $nChannels; $index++) {
	$query_prefix = $query_prefix . "AVG(" . $nameChannel . (string)$index . "." . $es_value . ") AS " . $nameVoltage . (string)$index . ", ";
}
// $query_prefix = $query_prefix . "MAX(" . $nameChannel . "1." . $es_stationNumber . ") AS station, ";
$query_prefix = $query_prefix . "MAX(" . $nameChannel . "1." . $es_time . ") AS timestmp ";
$query_prefix = $query_prefix . "from ";

// echo $query_prefix;

$query = $query_prefix . "\n" . $subquery_prefix . (string)$iChannels . $subquery_suffix . " AS " . $nameChannel . "1 inner join \n";
for ($channel = $iChannels + 1; $channel <= $iChannels + $nChannels - 1; $channel++) {
	$set = $channel - $iChannels + 1;
	$query = $query . $subquery_prefix . (string)$channel . $subquery_suffix . " AS " . $nameChannel . (string)$set . " ON " . $nameChannel . (string)($set - 1) . "." . $es_time . " = " . $nameChannel . (string)$set . "." . $es_time . " AND " . $nameChannel . (string)($set - 1) . "." . $es_stationNumber . " = " . $nameChannel . (string)$set . "." . $es_stationNumber;
	if ($channel != $iChannels + $nChannels - 1) {
		$query = $query . " inner join \n";
	} else {
		$query = $query . "\n GROUP BY DATEPART(YEAR, " . $nameChannel . "1." . $es_time . "), DATEPART(MONTH, " . $nameChannel . "1." . $es_time . "), DATEPART(DAY, " . $nameChannel . "1." . $es_time . "), DATEPART(HOUR, " . $nameChannel . "1." . $es_time . "), (DATEPART(MINUTE, " . $nameChannel . "1." . $es_time . ") / " . (string)$granularity . ")";
	}
}

// echo $query;

$wavelengths = sqlsrv_query($sidedatabaseHandle, "SELECT [" . $en_wavelength . "] FROM [" . $sidedatabaseName . "].[dbo].[" . $en_voltage2irradiance . "] WHERE [" . $en_stationNumber . "] = " . (string)$stationNumber . " ORDER BY [" . $en_channelNumber . "] ASC;");

if ($method == 'export_voltage') {

	$fields = array();
	array_push($fields, 'Timestamp');
	while ($wavelength = sqlsrv_fetch_array($wavelengths)) {
		array_push($fields, "Voltage_" . $wavelength[$en_wavelength]);
	}

	$fileHandle = fopen('php://memory', 'w');
	fputcsv($fileHandle, $fields, $delimiter);

	$measurementSets = sqlsrv_query($maindatabaseHandle, $query, array(), array("Scrollable" => "buffered"));
	while ($measurementSet = sqlsrv_fetch_array($measurementSets, SQLSRV_FETCH_ASSOC)) {

		$lineData = array();

		array_push($lineData, date_format($measurementSet['timestmp'], "Y-m-d H:i"));

		for ($channel = 1; $channel <= $nChannels; $channel++) {
			array_push($lineData, number_format((float)$measurementSet[$nameVoltage . (string)$channel], 3, '.', ''));
		}

		fputcsv($fileHandle, $lineData, $delimiter);

	}

	// Move to the beginning of the file
	fseek($fileHandle, 0);
	// Set headers to download the file
	header('Content-Type: text/csv');
	header('Station-Name: ' . $stationName);
	// header('Content-Disposition: attachment; filename="' . $filename . '";');
	// Throw all remaining data on a file pointer
	fpassthru($fileHandle);
	exit;

}

if ($method == 'export_irradiance') {

	$fields = array();
	array_push($fields, 'Timestamp');
	while ($wavelength = sqlsrv_fetch_array($wavelengths)) {
		array_push($fields, "DNI_" . $wavelength[$en_wavelength]);
	}

	$fileHandle = fopen('php://memory', 'w');
	fputcsv($fileHandle, $fields, $delimiter);

	$measurementSets = sqlsrv_query($maindatabaseHandle, $query, array(), array("Scrollable" => "buffered"));
	while ($measurementSet = sqlsrv_fetch_array($measurementSets, SQLSRV_FETCH_ASSOC)) {

		$lineData = array();

		array_push($lineData, date_format($measurementSet['timestmp'], "Y-m-d H:i"));

		for ($channel = 1; $channel <= $nChannels; $channel++) {

			$configurationSet = sqlsrv_query($sidedatabaseHandle, "SELECT * FROM [" . $sidedatabaseName . "].[dbo].[" . $en_voltage2irradiance . "] WHERE " . $en_channelNumber . " = " . (string)$channel . " AND " . $en_stationNumber . " = " . (string)$stationNumber . ";", array(), array("Scrollable" => "buffered"));

			while ($configuration = sqlsrv_fetch_array($configurationSet, SQLSRV_FETCH_ASSOC)) {
				$irradiance[$channel] = ($measurementSet[$nameVoltage . (string)$channel] - $configuration['Offset_DNI'] * $configuration['Gain'] - $configuration['Offset_V']) / ($configuration['Gain'] * $configuration['Sensitivity']);
			}

			array_push($lineData, number_format((float)$irradiance[$channel], 3, '.', ''));

		}

		fputcsv($fileHandle, $lineData, $delimiter);

	}

	// Move to the beginning of the file
	fseek($fileHandle, 0);
	// Set headers to download the file
	header('Content-Type: text/csv');
	header('Station-Name: ' . $stationName);
	//header('Content-Disposition: attachment; filename="data.csv";');
	// Throw all remaining data on a file pointer
	fpassthru($fileHandle);
	exit;

}

if ($method == 'view_irradiance') {

	$measurementSets = sqlsrv_query($maindatabaseHandle, $query, array(), array("Scrollable" => "buffered"));
	if (sqlsrv_num_rows($measurementSets) > 0) {

		echo "<table class='table table-bordered'>";
		echo "<tr>";
		echo "<th align='center' width='40'>" . 'Timestamp' . "</th>";

		while ($wavelength = sqlsrv_fetch_array($wavelengths)) {
			echo "<th align='center' width='40'>DNI_" . $wavelength[$en_wavelength] . "</th>";
		}

		echo "</tr>";

		while ($measurementSet = sqlsrv_fetch_array($measurementSets, SQLSRV_FETCH_ASSOC)) {

			echo "<tr>";
			echo "<td align='center' width='40'>" . date_format($measurementSet['timestmp'], "Y-m-d H:i") . "</td>";
			
			for ($channel = 1; $channel <= $nChannels; $channel++) {

				$configurationSet = sqlsrv_query($sidedatabaseHandle, "SELECT * FROM [" . $sidedatabaseName . "].[dbo].[" . $en_voltage2irradiance . "] WHERE " . $en_channelNumber . " = " . (string)$channel . " AND " . $en_stationNumber . " = " . (string)$stationNumber . ";", array(), array("Scrollable" => "buffered"));

				while ($configuration = sqlsrv_fetch_array($configurationSet, SQLSRV_FETCH_ASSOC)) {
					$irradiance[$channel] = ($measurementSet[$nameVoltage . (string)$channel] - $configuration['Offset_DNI'] * $configuration['Gain'] - $configuration['Offset_V']) / ($configuration['Gain'] * $configuration['Sensitivity']);
				}

			echo "<td align='center' width='40'>" . number_format((float)$irradiance[$channel], 3, '.', '') . "</td>";

			}

			echo "</tr>";

		}

		echo "</table>";

	}

	else echo "No data to display!<br>";

}

if ($method == 'plot_irradiance_time') {

	$time['name'] = 'Timestamp';
	$channel = 0;
	while ($wavelength = sqlsrv_fetch_array($wavelengths)) {
		$channel = $channel + 1;
		$irradiance[$channel]['name'] = "DNI_" . $wavelength[$en_wavelength];
	}

	$payload = array();

	$measurementSets = sqlsrv_query ($maindatabaseHandle, $query, array(), array("Scrollable" => "buffered"));
	while ($measurementSet = sqlsrv_fetch_array ($measurementSets, SQLSRV_FETCH_ASSOC)) {

		$time['data'][] = date_format ($measurementSet['timestmp'], "Y-m-d  H:i");

		for ($channel = 1; $channel <= $nChannels; $channel++) {

			$configurationSet = sqlsrv_query ($sidedatabaseHandle, "SELECT * FROM [" . $sidedatabaseName . "].[dbo].[" . $en_voltage2irradiance . "] WHERE " . $en_channelNumber . " = " . (string)$channel . " AND " . $en_stationNumber . " = " . (string)$stationNumber . ";", array(), array("Scrollable" => "buffered"));

			while ($configuration = sqlsrv_fetch_array ($configurationSet, SQLSRV_FETCH_ASSOC)) {
				$irradiance[$channel]['data'][] = ($measurementSet[$nameVoltage . (string)$channel] - $configuration['Offset_DNI'] * $configuration['Gain'] - $configuration['Offset_V']) / ($configuration['Gain'] * $configuration['Sensitivity']);
			}

		}

	}

	array_push($payload, $time);

	for ($channel = 1; $channel <= $nChannels; $channel++) {
		array_push($payload, $irradiance[$channel]);
	}

	print json_encode($payload, JSON_NUMERIC_CHECK);

	sqlsrv_close($maindatabaseHandle);

	exit;

}

?>