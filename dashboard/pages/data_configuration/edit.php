<?php

include ('../../config/config.php');

session_start();

$id = $_POST["id"];
$text = $_POST["text"];
$column_name = $_POST["column_name"];

$station = $_SESSION['station'];

$query = "UPDATE [Soreva].[dbo].[conversion_constant] SET ".$column_name."='".$text."' WHERE id='".$id."' AND station ='".$station."' ";
if (sqlsrv_query($pg_index1, $query)) {
	echo 'Data Updated';
}

sqlsrv_close($pg_index1);

?>