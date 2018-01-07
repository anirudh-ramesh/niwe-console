<?php
session_start();
include('../../config/config.php');
$station = $_SESSION['station'];
$query = "SELECT [Nombre] FROM [MeteoStation4K].[dbo].[Estaciones] where NumEstacion=".$station.";";
$result = sqlsrv_query($pg_index, $query);
while ($row = sqlsrv_fetch_array($result)){
	$stationName = $row["Nombre"];
}
 if(isset($_SESSION['station'], $_POST["exp_irr_from_date"], $_POST["exp_irr_to_date"]))
 {
     $start_time = " 00:00:00";
     $end_time = " 23:59:000";
     $start_date = $_POST["exp_irr_from_date"] . $start_time;
	 $end_date   = $_POST["exp_irr_to_date"] . $end_time;
	
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

          $delimiter = ",";
			$filename = "mitra" . date('Y-m-d') . ".csv";
			//create a file pointer
			$f = fopen('php://memory', 'w');
			$fields = array(
				'Timestamp',
				'DNI_299.1nm',
				'DNI_324.4nm',
				'DNI_367.2nm',
				'DNI_496.1nm',
				'DNI_614.2nm',
				'DNI_671.3nm',
				'DNI_782.9nm',
				'DNI_869.2nm',
				'DNI_938.1nm',
				'DNI_1037.8nm'
			);
			fputcsv($f, $fields, $delimiter);
			$query = $query;
			$result = sqlsrv_query($pg_index, $query, array() , array("Scrollable" => "buffered"));
			while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC))
			{
				$y[0] = $row['timestmp'];
				$i = 1;
				while ($i <= 10)
				{
					$query2 = "SELECT * FROM [Soreva].[dbo].[conversion_constant] where id=$i AND station=$station;";
					$result2 = sqlsrv_query($pg_index1, $query2, array() , array(
						"Scrollable" => "buffered"
					));
					while ($row1 = sqlsrv_fetch_array($result2, SQLSRV_FETCH_ASSOC))
					{
						$y[$i] = ($row["variable" . "$i"] - $row1['Offset_V1'] * $row1['Gain_V'] - $row1['Offset_V2']) / ($row1['Gain_V'] * $row1['Gain_DNI']);
					}
					$i++;
				}
				$lineData = array(
					date_format($y[0], "Y-m-d H:i") ,
					number_format((float)$y[1], 3, '.', '') ,
					number_format((float)$y[2], 3, '.', '') ,
					number_format((float)$y[3], 3, '.', '') ,
					number_format((float)$y[4], 3, '.', '') ,
					number_format((float)$y[5], 3, '.', '') ,
					number_format((float)$y[6], 3, '.', '') ,
					number_format((float)$y[7], 3, '.', '') ,
					number_format((float)$y[8], 3, '.', '') ,
					number_format((float)$y[9], 3, '.', '') ,
					number_format((float)$y[10], 3, '.', '')
				);
				fputcsv($f, $lineData, $delimiter);
			}
			//move back to beginning of file
			fseek($f, 0);
			//set headers to download file rather than displayed
			header('Content-Type: text/csv');
			header('Station-Number: '.$stationName);
			//header('Content-Disposition: attachment; filename="data.csv";');
			//output all remaining data on a file pointer
			fpassthru($f);
			exit;
 }
 ?>