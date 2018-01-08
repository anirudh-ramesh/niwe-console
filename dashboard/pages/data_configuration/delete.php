<?php

include ('../../config/init.php');

$query = "DELETE FROM conversion_constant WHERE id = '".$_POST["id"]."'";

if (sqlsrv_query($sidedatabaseHandle, $query)) {
	echo 'Data Deleted';
}

sqlsrv_close($sidedatabaseHandle);

?>