
<!DOCTYPE html>

<html lang="en"><head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <body>
    <center>

<form name="form" method="post" enctype="multipart/form-data" action="<?=$PHP_SELF?>">

<table>

<tr>

<td>
  <select name="number" onchange="this.form.submit();" method="post">
                                        <option value="">Select Staion</option>
                                       <option value="1">Chennai-NIWE</option>
                                       <option value="2">Gandhinagar-PDPU</option>
                                       <option value="3">Gurgaon-NISE</option>
                                       <option value="4">Howrah</option>   
  </select>
</td>
<td>Upload CCF CSV File Here:-  </td><td><input type="file" value="Upload CSV Format" name="csvfile" />

<input type="submit" value="Upload" name="submit" /></td>

</tr>

</table>

</form>

</center> 
</head>

  </body></html> 
<?php

include ('../../config/config.php');
error_reporting(1);

$csvfile = $_FILES['csvfile']['name'];

$ext = pathinfo($csvfile, PATHINFO_EXTENSION);

$base_name = pathinfo($csvfile, PATHINFO_BASENAME);

if (isset($_POST['submit'])) {
    
    if (!$_FILES['csvfile']['name'] == "") {
        
        if ($ext == "csv") {
            
            if (file_exists($base_name)) {
                echo "file already exist" . $base_name;
                
            }
            
            else {
                
                if (is_uploaded_file($_FILES['csvfile']['tmp_name'])) {
                    
                    echo "<h1>" . "File " . $_FILES['filename']['name'] . " uploaded successfully." . "</h1>";
                    
                    readfile($_FILES['csvfile']['tmp_name']);
                }
                $handle = fopen($_FILES['csvfile']['tmp_name'], "r");

                $station = $_POST['number'];
                $station = trim($station);
                  if(!isset($station)){
                print "Please select from the menu";
                } else{
                print "<br>" . "Station: " . $station . "<br>";
                }                                
                while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                    
                    $query = "INSERT INTO conversion_constant(id,station,variable1,variable2,variable3,variable4)
                    VALUES(DEFAULT,$station,'$data[0]','$data[1]','$data[2]','$data[3]')";

                    $result  = pg_query($pg_index, $query);    
                     }
                pg_close($pg_index);
                
                fclose($handle);
                echo "Import done";
            }
            
        }
        
        else {
            
            echo " Check Extension. your extension is ." . $ext;
            
        }
        
    }
    
    else {
        echo "Please Upload File";
    }
}

?>
