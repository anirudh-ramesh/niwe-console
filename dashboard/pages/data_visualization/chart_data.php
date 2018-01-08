<?php

session_start();

$station = $_SESSION['station'];

include('../../config/init.php');

if (isset($_SESSION['station'], $_GET["view_chart_from_date"], $_GET["view_chart_to_date"])) {

	$start_date = $_GET["view_chart_from_date"] . " 00:00:00";
	$end_date   = $_GET["view_chart_to_date"] . " 23:59:00";

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

	$bln             = array();
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

}

?>