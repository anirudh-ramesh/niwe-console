<?php

include ('../../config/init.php');

error_reporting(1);

$csvfile = $_FILES['csvfile']['name'];
$ext = pathinfo($csvfile, PATHINFO_EXTENSION);
$base_name = pathinfo($csvfile, PATHINFO_BASENAME);

if (isset($_POST['submit'])) {
	if (!$_FILES['csvfile']['name'] == "") {
		if ($ext == "csv") {
			if (file_exists($base_name)) {
				"Error, file already exists: " . $base_name;
			}
			else {

				if (is_uploaded_file($_FILES['csvfile']['tmp_name'])) {
					"<h1>" . "File " . $_FILES['filename']['name'] . " uploaded successfully." . "</h1>";
					readfile($_FILES['csvfile']['tmp_name']);
				}

				$handle = fopen($_FILES['csvfile']['tmp_name'], "r");
				$station = $_POST['number'];
				$station = trim($station);
				if (!isset($station)) {
					"Error, please select 'station' from the menu";
				} else {
					echo "<br>" . "Station: " . $station . "<br>";
				}

				while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
					$query = "INSERT INTO conversion_constant(station,id,wavelength,Gain_DNI,Offset_V1,Gain_V,Offset_V2) VALUES($station,'$data[0]','$data[1]','$data[2]','$data[3]','$data[4]','$data[5]')";
					$result  = sqlsrv_query($sidedatabaseHandle, $query);
				}

				sqlsrv_close($sidedatabaseHandle);
				fclose($handle);
				echo "Import done";
				header("Location: index.php");
				exit;
			}
		} else {
			echo "Error, incorrect file extension: " . $ext;
		}
	} else {
		echo "Error, file not uploaded.";
	}
}

?>