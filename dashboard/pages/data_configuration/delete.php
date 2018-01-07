<?php
include ('../../config/config.php');

 $query = "DELETE FROM conversion_constant WHERE id = '".$_POST["id"]."'";

 if(sqlsrv_query($pg_index1, $query))
 {
      echo 'Data Deleted';
 }
 sqlsrv_close($pg_index1);
 ?>


