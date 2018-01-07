<?php  
include ('../../config/config.php');
   
 $query = "INSERT INTO conversion_constant(id,station,variable1,variable2,variable3,variable4) VALUES('".$_POST["id"]."','".$_POST["station"]."','".$_POST["variable1"]."', '".$_POST["variable2"]."', '".$_POST["variable3"]."', '".$_POST["variable4"]."')";  
 if(sqlsrv_query($pg_index1, $query))  
 {  
      echo 'Data Inserted';  
 } 
 sqlsrv_close($pg_index1); 
 ?> 