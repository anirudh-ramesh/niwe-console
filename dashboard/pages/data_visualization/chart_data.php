<?php
session_start();
include('../../config/config.php');
$station = $_SESSION['station'];
 if(isset($_SESSION['station'], $_GET["view_chart_from_date"], $_GET["view_chart_to_date"]))
 {
     $start_time = " 00:00:00";
     $end_time = " 23:59:000";
     $start_date = $_GET["view_chart_from_date"] . $start_time;
	 $end_date   = $_GET["view_chart_to_date"] . $end_time;	

    $query = "Select
          value1.NumEstacion as station,
          value1.Fecha as timestmp,
          value1.Valor as variable1,
          value2.Valor as variable2,
          value3.Valor as variable3,
          value4.Valor as variable4,
          value5.Valor as variable5,
          value6.Valor as variable6,
          value7.Valor as variable7,
          value8.Valor as variable8,
          value9.Valor as variable9,
          value10.Valor as variable10
          from

            (select Valor,NumEstacion,Fecha from $database_name.[dbo].[Datos] where NumEstacion='$station' and NumParametro = 16 and NumFuncion=0 and Fecha BETWEEN '$start_date' AND '$end_date') as value1
            inner join

            (select Valor,NumEstacion,Fecha from $database_name.[dbo].[Datos] where NumEstacion='$station' and NumParametro = 17 and NumFuncion=0 and Fecha BETWEEN '$start_date' AND '$end_date') as value2 on value1.Fecha=value2.Fecha
            and value1.NumEstacion=value2.NumEstacion
            inner join

            (select Valor,NumEstacion,Fecha from $database_name.[dbo].[Datos] where NumEstacion='$station' and NumParametro = 18 and NumFuncion=0 and Fecha BETWEEN '$start_date' AND '$end_date') as value3 on value2.Fecha=value3.Fecha
            and value3.NumEstacion=value2.NumEstacion
            inner join

            (select Valor,NumEstacion,Fecha from $database_name.[dbo].[Datos] where NumEstacion='$station' and NumParametro = 19 and NumFuncion=0 and Fecha BETWEEN '$start_date' AND '$end_date') as value4 on value3.Fecha=value4.Fecha
            and value4.NumEstacion=value3.NumEstacion
              inner join

              (select Valor,NumEstacion,Fecha from $database_name.[dbo].[Datos] where NumEstacion='$station' and NumParametro = 20 and NumFuncion=0 and Fecha BETWEEN '$start_date' AND '$end_date') as value5 on value4.Fecha=value5.Fecha
            and value5.NumEstacion=value4.NumEstacion
              inner join

               (select Valor,NumEstacion,Fecha from $database_name.[dbo].[Datos] where NumEstacion='$station' and NumParametro = 21 and NumFuncion=0 and Fecha BETWEEN '$start_date' AND '$end_date') as value6 on value5.Fecha=value6.Fecha
            and value6.NumEstacion=value5.NumEstacion
              inner join

              (select Valor,NumEstacion,Fecha from $database_name.[dbo].[Datos] where NumEstacion='$station' and NumParametro = 22 and NumFuncion=0 and Fecha BETWEEN '$start_date' AND '$end_date') as value7 on value6.Fecha=value7.Fecha
            and value7.NumEstacion=value6.NumEstacion
              inner join

              (select Valor,NumEstacion,Fecha from $database_name.[dbo].[Datos] where NumEstacion='$station' and NumParametro = 23 and NumFuncion=0 and Fecha BETWEEN '$start_date' AND '$end_date') as value8 on value7.Fecha=value8.Fecha
            and value8.NumEstacion=value7.NumEstacion
              inner join

              (select Valor,NumEstacion,Fecha from $database_name.[dbo].[Datos] where NumEstacion='$station' and NumParametro = 24 and NumFuncion=0 and Fecha BETWEEN '$start_date' AND '$end_date') as value9 on value8.Fecha=value9.Fecha
            and value9.NumEstacion=value8.NumEstacion
              inner join

              (select Valor,NumEstacion,Fecha from $database_name.[dbo].[Datos] where NumEstacion='$station' and NumParametro = 25 and NumFuncion=0 and Fecha BETWEEN '$start_date' AND '$end_date') as value10 on value9.Fecha=value10.Fecha
            and value10.NumEstacion=value9.NumEstacion;";


    $bln           = array();
    $arr0['name'] = 'Timestamp';
    $arr[1]['name'] = 'DNI_299.1nm';
    $arr[2]['name']  = 'DNI_324.4nm';
    $arr[3]['name']  = 'DNI_367.2nm';
    $arr[4]['name']  = 'DNI_496.1nm';
    $arr[5]['name']  = 'DNI_614.2nm';
    $arr[6]['name']  = 'DNI_671.3nm';
    $arr[7]['name']  = 'DNI_782.9nm';
    $arr[8]['name']  = 'DNI_869.2nm';
    $arr[9]['name'] = 'DNI_938.1nm';
    $arr[10]['name'] = 'DNI_1037.8nm';


   $result = sqlsrv_query( $pg_index,$query, array(), array("Scrollable"=>"buffered"));
    while ($row = sqlsrv_fetch_array($result,SQLSRV_FETCH_ASSOC)) {
    $arr0['data'][] = date_format($row['timestmp'],"Y-m-d  H:i");
	$i=1;
	while($i<=10){
    $query2 = "SELECT * FROM [Soreva].[dbo].[conversion_constant] where id=$i AND station=$station;";
    $result2 = sqlsrv_query( $pg_index1,$query2, array(), array("Scrollable"=>"buffered"));
		while ($row1 = sqlsrv_fetch_array($result2,SQLSRV_FETCH_ASSOC)) {
			$arr[$i]['data'][] = ($row["variable"."$i"] - $row1['Offset_V1'] * $row1['Gain_V'] - $row1['Offset_V2']) / ($row1['Gain_V'] * $row1['Gain_DNI']);
		}$i++;
	}
}
	$rslt = array();
	array_push($rslt, $arr0);
    array_push($rslt, $arr[1]);
    array_push($rslt, $arr[2]);
    array_push($rslt, $arr[3]);
    array_push($rslt, $arr[4]);
    array_push($rslt, $arr[5]);
    array_push($rslt, $arr[6]);
    array_push($rslt, $arr[7]);
    array_push($rslt, $arr[8]);
    array_push($rslt, $arr[9]);
    array_push($rslt, $arr[10]);
    print json_encode($rslt, JSON_NUMERIC_CHECK);
    sqlsrv_close($pg_index);
 }
    ?>