<?php

session_start();

include ('../../config/init.php');

$station = ($_REQUEST["station"] <> "") ? trim($_REQUEST["station"]) : "";

if ($station <> "") {
	$_SESSION['station'] = $_REQUEST["station"];
	$output = '';
	$query = "SELECT * FROM [Soreva].[dbo].[conversion_constant] where station = $station;";
	$result  = sqlsrv_query( $sidedatabaseHandle,$query, array(), array("Scrollable"=>"buffered"));
	$output .= '<div class="table-responsive">
					<table class="table table-bordered">
						<tr>
							<th width="3%">Id</th>
							<th width="3%">Wavelength<br>(nm)</th>
							<th width="3%">Station</th>
							<th width="7.5%">Sensitivity<br>(V/((W/m^2)/nm))</th>
							<th width="7.5%">Offset_V1<br>(V)</th>
							<th width="7.5%">Gain_V<br>(Counts/V)</th>
							<th width="7.5%">Offset_V2<br>(Counts)</th>
							<th width="10%">Delete</th>
						</tr>';
	if (sqlsrv_num_rows($result) > 0) {
		while ($row = sqlsrv_fetch_array($result,SQLSRV_FETCH_ASSOC)) {
			$output .= '<tr>
							<td>'.$row["id"].'</td>
							<td class="wavelength" data-id1="'.$row["id"].'" contenteditable>'.$row["wavelength"].'</td>
							<td class="station" data-id1="'.$row["id"].'" contenteditable>'.$row["station"].'</td>
							<td class="Gain_DNI" data-id2="'.$row["id"].'" contenteditable>'.$row["Gain_DNI"].'</td>
							<td class="Offset_V1" data-id3="'.$row["id"].'" contenteditable>'.$row["Offset_V1"].'</td>
							<td class="Gain_V" data-id4="'.$row["id"].'" contenteditable>'.$row["Gain_V"].'</td>
							<td class="Offset_V2" data-id5="'.$row["id"].'" contenteditable>'.$row["Offset_V2"].'</td>
							<td><button type="button" name="delete_btn" data-id6="'.$row["id"].'" class="btn btn-xs btn-danger btn_delete">x</button></td>
						</tr>';
		}
		$output .= '<tr>
						<td></td>
						<td id="wavelength" contenteditable></td>
						<td id="station" contenteditable></td>
						<td id="Gain_DNI" contenteditable></td>
						<td id="Offset_V1" contenteditable></td>
						<td id="Gain_V" contenteditable></td>
						<td id="Offset_V2" contenteditable></td>
						<td><button type="button" name="btn_add" id="btn_add" class="btn btn-xs btn-success">+</button></td>
					</tr>';
	} else {
		$output .= '<tr>
						<td colspan="4">Data not Found</td>
					</tr>';
	}

	$output .= '</table>
				</div>';

	echo $output;
}

sqlsrv_close($sidedatabaseHandle);

?>