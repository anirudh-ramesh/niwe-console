<?php

session_start();

$station = $_SESSION['station'];

include('../../config/init.php');

if (isset($_SESSION['station'], $_POST["view_irr_from_date"], $_POST["view_irr_to_date"])) {

	$start_date = $_POST["view_irr_from_date"] . " 00:00:00";
	$end_date   = $_POST["view_irr_to_date"] . " 23:59:00";

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
			$query = $query . "\n GROUP BY (DATEPART(MINUTE, value1." . $es_time . ") / " . (string)$granularity . ")";
		}
	}

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

?>