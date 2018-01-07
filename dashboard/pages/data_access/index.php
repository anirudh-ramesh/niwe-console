<?php
   include("../../../check.php");
   include ('../../config/config.php');
   ?>
<!DOCTYPE html>
<html>
   <head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
      <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>  
      <script type="text/javascript" src="../../moment.js"></script>
	  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />  
      <script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>  
      <link rel="stylesheet" href="http://code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">      
      <script src="http://code.highcharts.com/highcharts.js"></script>
      <script src="http://code.highcharts.com/modules/exporting.js"></script>
	  <script src="https://code.highcharts.com/modules/no-data-to-display.js"></script>
	  
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <title>MITRA</title>
      <!-- Tell the browser to be responsive to screen width -->
      <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
      <!-- Bootstrap 3.3.6 -->
      <link rel="stylesheet" href="../../bootstrap/css/bootstrap.min.css">
      <!-- Font Awesome -->
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
      <!-- Ionicons -->
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
      <!-- fullCalendar 2.2.5-->
      <link rel="stylesheet" href="../../plugins/fullcalendar/fullcalendar.min.css">
      <link rel="stylesheet" href="../../plugins/fullcalendar/fullcalendar.print.css" media="print">
      <!-- Theme style -->
      <link rel="stylesheet" href="../../dist/css/AdminLTE.min.css">
      <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
      <link rel="stylesheet" href="../../dist/css/skins/_all-skins.min.css">
      <!-- iCheck -->
      <link rel="stylesheet" href="../../plugins/iCheck/flat/blue.css">     
    
      <!--added style for input table--> 
     
     <style>
         table, th, td {
         border: 1px solid black;
         border-collapse: collapse;
         }
         table {
         width:90%;
         }
         th, td {
         padding: 1px;
         text-align: center;   
         }
      </style>
      <style>
         select { 
         padding:5px;
         border: 1px solid gray;
         border-radius:5px;
         background: #f8f8f8;
         color:#00c0ef;
         outline:none;
         display: inline-block;
         width:140px;
         cursor:pointer;
         text-align:center;
         font:inherit;
         }
      </style>
      <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
   </head>
   <body class="hold-transition skin-blue sidebar-mini" oncontextmenu="return true" onload="startTime()">
      <div class="wrapper">
         <header class="main-header">
            <a href="../../index.php" class="logo">
           <span class="logo-mini" style="font-size:12px;">NIWE Advance Station Console</span>
            <span class="logo-lg" style="font-size:12px;">NIWE Advance Station Console</span>
            </a>
            <nav class="navbar navbar-static-top">
               <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
               <span class="sr-only">Toggle navigation</span>
               </a>
               <div class="navbar-custom-menu">
                  <ul class="nav navbar-nav">
                     <li class="dropdown user user-menu">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                           <img src="../../dist/img/logo.jpg" class="user-image" alt="User Image"><!--dist/img/sunshine_logo.jpg>
                              <span class="hidden-xs"> <!-- <?php echo $login_user; ?>-->
                           SGS Weather</span>
                        </a>
                        <ul class="dropdown-menu">
                           <li class="user-header">
                              <img src="../../dist/img/logo.jpg" class="img-circle" alt="User Image">
                              <p>
                                 <!-- <?php echo $login_user; ?>-->
                                 SGS Weather                                 
                              </p>
                           </li>
                           <li class="user-footer">
                              <div class="pull-right">
                                 <a href="../../../logout.php" class="btn btn-default btn-flat">Sign out</a>
                              </div>
                           </li>
                        </ul>
                     </li>
                  </ul>
               </div>
            </nav>
         </header>
         <aside class="main-sidebar">
            <section class="sidebar">
               <div class="user-panel">
                  <div class="pull-left image">
                     <img src="../../dist/img/logo.jpg" class="img-circle" alt="User Image">
                  </div>
                  <div class="pull-left info">
                     <p>
                        <!-- <?php echo $login_user; ?>-->
                        SGS Weather
                     </p>
                     
                  </div>
               </div>
               <ul class="sidebar-menu">
                  <li class="treeview">
                     <a href="../../index.php">
                     <i class="fa fa-dashboard"></i>
                     <span>Dashboard</span>            
                     </a>      
                     <ul class="treeview-menu">
                        <li><a href="../station/irradiance_time.php"><i class="fa fa-line-chart"></i>View Irradiance-Time Plot</a></li>
                        
                     </ul>
                  </li> 
                  <li>
                     <a href="#">
                     <i class="fa fa-download"></i> <span>Data Access</span>            
                     </a>
                  </li>
                  <li>
                     <a href="../upload_csv/">
                     <i class="fa fa-file-text-o"></i> <span>Data Config</span>            
                     </a>
                  </li>
                  
                  <li><a href="../about/about.php"><i class="fa fa-info-circle"></i> <span>About</span></a></li>
               </ul>
            </section>
         </aside>
          <div class="content-wrapper">
            <section class="content">
            <div class="row">
			<div class="col-md-12">			
            <div class="container" style="width:100%;">
			<br>
				<div align="left" class="row">
				<div class="col-md-12">				
                           <?php
						   session_start();
						   $station = ($_REQUEST["station"] <> "") ? trim($_REQUEST["station"]) : "";
						   $_SESSION['station'] = $_REQUEST["station"];
						   include('../../config/config.php');
                              $query = "SELECT [NumEstacion],[Nombre] FROM $database_name.[dbo].[Estaciones] ;";
                                $result = sqlsrv_query($pg_index, $query);             
                              ?> 
							  <label>Station &nbsp</label>
							  <select name="station" onChange="selectStation(this);">
                                        <option value="">Select</option>
                                        <?php  while ($row = sqlsrv_fetch_array($result)){ ?>
                                            <option value="<?php echo $row["NumEstacion"]; ?>"><?php echo $row["Nombre"]; ?></option>
                                        <?php }  sqlsrv_close($pg_index);?>
                              </select>                
                </div> 
				</div><br>		
				<div align="center" class="row">
			    <div class="col-md-12">
                <div class="col-md-3">  
                     <input type="text" name="view_irr_from_date" id="view_irr_from_date" class="form-control" placeholder="From Date" />  
                </div>  
                <div class="col-md-3">  
                     <input type="text" name="view_irr_to_date" id="view_irr_to_date" class="form-control" placeholder="To Date" />  
                </div> 
                <div class="col-md-3">  
                     <input type="button" name="View_Irr" id="View_Irr" value="View Irradiance" class="btn btn-info" />  
                </div>  
                <div style="clear:both"></div>
				<br>				 
				</div>          
				</div>
				<div align="center" class="row">
			    <div class="col-md-12">
                <div class="col-md-3">  
                     <input type="text" name="exp_irr_from_date" id="exp_irr_from_date" class="form-control" placeholder="From Date" />  
                </div>  
                <div class="col-md-3">  
                     <input type="text" name="exp_irr_to_date" id="exp_irr_to_date" class="form-control" placeholder="To Date" />  
                </div> 
                <div class="col-md-3">  
                     <input type="button" name="Exp_Irr" id="Exp_Irr" value="Export Irradiance" class="btn btn-info" />  
                </div>  
                <div style="clear:both"></div>
				<br>				 
				</div>          
				</div>
				<div align="center" class="row">
			    <div class="col-md-12">
                <div class="col-md-3">  
                     <input type="text" name="exp_vol_from_date" id="exp_vol_from_date" class="form-control" placeholder="From Date" />  
                </div>  
                <div class="col-md-3">  
                     <input type="text" name="exp_vol_to_date" id="exp_vol_to_date" class="form-control" placeholder="To Date" />  
                </div> 
                <div class="col-md-3">  
                     <input type="button" name="Exp_Vol" id="Exp_Vol" value="Export Voltage" class="btn btn-info" />  
                </div>  
                <div style="clear:both"></div>
				<br>				 
				</div>          
				</div>
				<br>
				<div id="table"></div> 
				</div>		   
               </div>
               <!-- /.row -->
               <!-- /.row -->
            </section>
            <!-- /.content -->
			</div>
         </div>
         <!-- /.content-wrapper -->
         <footer class="main-footer">
            <div class="pull-right hidden-xs">
               <b>Version</b> 1.0
            </div>
            <strong>Copyright &copy; 2017 <a href="http://soreva.co.in" target="_blank">Soreva.co.in</a></strong> All rights
            reserved.
         </footer>
      </div>      
      <!-- Bootstrap 3.3.6 -->
      <script src="../../bootstrap/js/bootstrap.min.js"></script>
      <!-- FastClick -->
      <script src="../../plugins/fastclick/fastclick.js"></script>
      <!-- AdminLTE App -->
      <script src="../../dist/js/app.min.js"></script>
      <!-- AdminLTE for demo purposes -->
      <script src="../../dist/js/demo.js"></script>
   </body>
</html>
<script>

		                            function selectStation(sel) {
									 var station = sel.options[sel.selectedIndex].value;  
										$("#table").html("");
									 if (station.length > 0) {                    
										 $.ajax({
											 type: "POST",
											 url: "index.php",
											 data: "station=" + station,
											 cache: false,                                 
											 success: function(html) {
												 $("#table").html("");
											 }
										 });
									 }
								 }
								 
          
</script>
<script>
				$(document).ready(function(){  
							   $.datepicker.setDefaults({  
									dateFormat: 'yy-mm-dd'   
							   });  
							   $(function(){  
									$("#view_irr_from_date").datepicker();  
									$("#view_irr_to_date").datepicker();  
							   });  
							   $('#View_Irr').click(function(){				
									var view_irr_from_date = $('#view_irr_from_date').val();  
									var view_irr_to_date = $('#view_irr_to_date').val();  
									if(view_irr_from_date != '' && view_irr_to_date != '')  
									{  
										 $.ajax({  
											  url:"view_irr.php",  
											  method:"POST", 
											  data:{view_irr_from_date:view_irr_from_date, view_irr_to_date:view_irr_to_date},
											  beforeSend: function() {
													 $('#table').html('Loading, please wait...');
													 },
											  success:function(data)  
											  {  
												   console.log(data);
												   $('#table').html(data);  
											  }  
										 });  
									}  
									else  
									{  
										 alert("Select Date");  
									}  
							   });  
						  }); 
						  
                          
         
      </script>
	  <script>
	  $(document).ready(function(){  
							   $.datepicker.setDefaults({  
									dateFormat: 'yy-mm-dd'   
							   });  
							   $(function(){  
									$("#exp_irr_from_date").datepicker();  
									$("#exp_irr_to_date").datepicker();  
							   });  
							   $('#Exp_Irr').click(function(){				
									var exp_irr_from_date = $('#exp_irr_from_date').val();  
									var exp_irr_to_date = $('#exp_irr_to_date').val();  
									if(exp_irr_from_date != '' && exp_irr_to_date != '')  
									{  
										 $.ajax({  
											  url:"exp_irr.php",  
											  method:"POST", 
											  data:{exp_irr_from_date:exp_irr_from_date, exp_irr_to_date:exp_irr_to_date},
											  beforeSend: function() {
													 $('#table').html('Exporting Irradiance, please wait...');
													 },
											  success: function(response, status, xhr) {
									 $('#table').html('Exported Irradiance'); 
									// check for a filename
									var filename = xhr.getResponseHeader('Station-Number')+"_DNI_"+exp_irr_from_date.replace(/-/g, '')+"0000"+"_"+exp_irr_to_date.replace(/-/g, '')+"2359"+"_1minute_"+moment().format("YYYYMMDDhhmm")+".csv";
									var disposition = xhr.getResponseHeader('Content-Disposition');
									if (disposition && disposition.indexOf('attachment') !== -1) {
										var filenameRegex = /filename[^;=\n]*=((['"]).*?\2|[^;\n]*)/;
										var matches = filenameRegex.exec(disposition);
										if (matches != null && matches[1]) filename = matches[1].replace(/['"]/g, '');
									}
									var type = xhr.getResponseHeader('Content-Type');
									var blob = new Blob([response], { type: type });
									if (typeof window.navigator.msSaveBlob !== 'undefined') {
										// IE workaround for "HTML7007: One or more blob URLs were revoked by closing the blob for which they were created. These URLs will no longer resolve as the data backing the URL has been freed."
										window.navigator.msSaveBlob(blob, filename);
									} else {
										var URL = window.URL || window.webkitURL;
										var downloadUrl = URL.createObjectURL(blob);
										if (filename) {
											// use HTML5 a[download] attribute to specify filename
											var a = document.createElement("a");
											// safari doesn't support this yet
											if (typeof a.download === 'undefined') {
												window.location = downloadUrl;
											} else {
												a.href = downloadUrl;
												a.download = filename;
												document.body.appendChild(a);
												a.click();
											}
										} else {
											window.location = downloadUrl;
										}
										setTimeout(function () { URL.revokeObjectURL(downloadUrl); }, 100); // cleanup
									}
								}  
										 });  
									}  
									else  
									{  
										 alert("Select Date");  
									}  
							   });  
						  });
	  </script>
	   <script>
	  $(document).ready(function(){  
							   $.datepicker.setDefaults({  
									dateFormat: 'yy-mm-dd'   
							   });  
							   $(function(){  
									$("#exp_vol_from_date").datepicker();  
									$("#exp_vol_to_date").datepicker();  
							   });  
							   $('#Exp_Vol').click(function(){				
									var exp_vol_from_date = $('#exp_vol_from_date').val();  
									var exp_vol_to_date = $('#exp_vol_to_date').val();  
									if(exp_vol_from_date != '' && exp_vol_to_date != '')  
									{  
										 $.ajax({  
											  url:"exp_vol.php",  
											  method:"POST", 
											  data:{exp_vol_from_date:exp_vol_from_date, exp_vol_to_date:exp_vol_to_date},
											  beforeSend: function() {
													 $('#table').html('Exporting Voltage, please wait...');
													 },
											  success: function(response, status, xhr) {
									 $('#table').html('Exported Voltage');
									// check for a filename
									var filename = xhr.getResponseHeader('Station-Number')+"_V_"+exp_vol_from_date.replace(/-/g, '')+"0000"+"_"+exp_vol_to_date.replace(/-/g, '')+"2359"+"_1minute_"+moment().format("YYYYMMDDhhmm")+".csv";
									var disposition = xhr.getResponseHeader('Content-Disposition');
									if (disposition && disposition.indexOf('attachment') !== -1) {
										var filenameRegex = /filename[^;=\n]*=((['"]).*?\2|[^;\n]*)/;
										var matches = filenameRegex.exec(disposition);
										if (matches != null && matches[1]) filename = matches[1].replace(/['"]/g, '');
									}
									var type = xhr.getResponseHeader('Content-Type');
									var blob = new Blob([response], { type: type });
									if (typeof window.navigator.msSaveBlob !== 'undefined') {
										// IE workaround for "HTML7007: One or more blob URLs were revoked by closing the blob for which they were created. These URLs will no longer resolve as the data backing the URL has been freed."
										window.navigator.msSaveBlob(blob, filename);
									} else {
										var URL = window.URL || window.webkitURL;
										var downloadUrl = URL.createObjectURL(blob);
										if (filename) {
											// use HTML5 a[download] attribute to specify filename
											var a = document.createElement("a");
											// safari doesn't support this yet
											if (typeof a.download === 'undefined') {
												window.location = downloadUrl;
											} else {
												a.href = downloadUrl;
												a.download = filename;
												document.body.appendChild(a);
												a.click();
											}
										} else {
											window.location = downloadUrl;
										}
										setTimeout(function () { URL.revokeObjectURL(downloadUrl); }, 100); // cleanup
									}
								}  
										 });  
									}  
									else  
									{  
										 alert("Select Date");  
									}  
							   });  
						  });
	  </script>