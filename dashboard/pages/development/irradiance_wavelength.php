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
	$stationName = $row["Nombre"];
}

// If the 'from_date' or 'to_date' are unavailable...
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

$start_date = $_POST['from_date'] . " " . $start_time;
$end_date = $_POST['to_date'] . " " . $end_time;

// echo $start_date;
// echo $end_date;

$subquery_prefix = "(SELECT " . $es_value . ", " . $es_stationNumber . ", " . $es_time . " FROM [" . $maindatabaseName . "].[dbo].[" . $es_data . "] WHERE " . $es_stationNumber . " = " . (string)$station . " AND " . $es_functionNumber . " = 0 AND " . $es_parameterNumber . " = ";
$subquery_suffix = " AND " . $es_time . " BETWEEN '" . $start_date . "' AND '" . $end_date . "')";

// echo $subquery_prefix;
// echo $subquery_suffix;

$query_prefix = "SELECT ";
for ($index = 1; $index <= $nChannels; $index++) {
	$query_prefix = $query_prefix . "set" . (string)$index . "." . $es_value . " AS voltage" . (string)$index . ", ";
}
$query_prefix = $query_prefix . "set1." . $es_stationNumber . " AS station, ";
$query_prefix = $query_prefix . "set1." . $es_time . " AS timestmp ";
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
		$query = $query . "\n";
	}
}

// echo $query;

$result = sqlsrv_query($maindatabaseHandle, $query, array(), array("Scrollable" => "buffered"));
while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC))