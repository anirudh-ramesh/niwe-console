<?php

// Retrieve database connection handles
include('../config/init.php');

// Start the access session
session_start();

// If the 'state' session variable is unavailable...
if (!isset($_SESSION['state'])) {
	// ...echo a message...
	echo "Error: 'state' unavailable in this session.";
	// ...and exit
	exit;
} else {
	$stateCode = $_SESSION['state'];
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

	$granularity = ($_POST["granularity"] <> "") ? $_POST["granularity"] : "10";

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

	$granularity = ($_GET["granularity"] <> "") ? $_GET["granularity"] : "10";

}

// echo $start_date;
// echo $end_date;
// echo $method;
// echo $granularity;

if ($method == 'plot_electricityConsumption') {

	$query = 'SELECT MIN(' . $en_time . ') AS ' . $en_time . ', AVG(' . $en_power . ') AS ' . $en_power . ', AVG(' . $en_frequency . ') AS ' . $en_frequency . ' FROM [' . $sidedatabaseName . '].[dbo].[' . $en_consumptionTable . '] WHERE ' . $en_stateCode . ' = \'' . $stateCode . '\' AND ' . $en_time . ' BETWEEN \'' . $start_date . '\' AND \'' . $end_date . '\' GROUP BY DATEPART(YEAR, ' . $en_time . '), DATEPART(MONTH, ' . $en_time . '), DATEPART(DAY, ' . $en_time . '), DATEPART(HOUR, ' . $en_time . '), DATEPART(MINUTE, ' . $en_time . ') / ' . (string)$granularity;

	$time['name'] = 'Timestamp';
	$load['name'] = 'Electrical Load';
	$frequency['name'] = 'Grid Frequency';

	$payload = array();

	$measurementSets = sqlsrv_query ($sidedatabaseHandle, $query, array(), array("Scrollable" => "buffered"));
	while ($measurementSet = sqlsrv_fetch_array ($measurementSets, SQLSRV_FETCH_ASSOC)) {
		$time['data'][] = date_format ($measurementSet['Timestamp'], "Y-m-d  H:i");
		$load['data'][] = $measurementSet['power'];
		$frequency['data'][] = $measurementSet['frequency'];
	}

	array_push($payload, $time);
	array_push($payload, $load);
	array_push($payload, $frequency);

	print json_encode($payload, JSON_NUMERIC_CHECK);

	sqlsrv_close($sidedatabaseHandle);

	exit;

}

if ($method == 'plot_electricityGeneration') {
	exit;
}

?>