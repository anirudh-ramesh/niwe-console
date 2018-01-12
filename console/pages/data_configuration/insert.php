<?php

include ('../../config/init.php');

$query = "INSERT INTO conversion_constant(id,station,variable1,variable2,variable3,variable4) VALUES('".$_POST["id"]."','".$_POST["station"]."','".$_POST["variable1"]."', '".$_POST["variable2"]."', '".$_POST["variable3"]."', '".$_POST["variable4"]."')";

if(sqlsrv_query($sidedatabaseHandle, $query)) {
		echo 'Data Inserted';
}

sqlsrv_close($sidedatabaseHandle);

?> 