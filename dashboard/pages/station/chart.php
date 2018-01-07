<?php
   include("../../../check.php");
   ?>
<html>
   <head>
	  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
      <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>  
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />  
      <script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>  
      <link rel="stylesheet" href="http://code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">      
      <script src="http://code.highcharts.com/highcharts.js"></script>
      <script src="http://code.highcharts.com/modules/exporting.js"></script>
	  <script src="https://code.highcharts.com/modules/no-data-to-display.js"></script>
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
      <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
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
   </head>
   <body class="hold-transition skin-blue sidebar-mini" oncontextmenu="return true" ">
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
                              <img src="../../dist/img/logo.jpg
                                 " class="img-circle" alt="User Image">
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
                     <ul class="active treeview-menu">
                        <li><a href="chart.php"><i class="fa fa-line-chart"></i>View Irradiance</a></li>                        
                     </ul>
                  </li>
                  <li>
                     <a href="../data_access/">
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
                              $query = "SELECT [NumEstacion],[Nombre] FROM [MeteoStation4K].[dbo].[Estaciones] ;";
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
                     <input type="text" name="view_chart_from_date" id="view_chart_from_date" class="form-control" placeholder="From Date" />  
                </div>  
                <div class="col-md-3">  
                     <input type="text" name="view_chart_to_date" id="view_chart_to_date" class="form-control" placeholder="To Date" />  
                </div> 
                <div class="col-md-3">  
                     <input type="button" name="View_Chart" id="View_Chart" value="View Irradiance" class="btn btn-info" />  
                </div>  
                <div style="clear:both"></div>
				<br>				 
				</div>          
				</div>			 
           </div>
		   <div class="col-md-12">
                     <div class="box">
                        <div class="box-header with-border">
                           <center><h3 class="box-title">Solar Plot</h3></center>
                           <div class="box-tools pull-right">
                              <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                              </button>                
                              <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                           </div>
                        </div>
                        <div class="box-body">                            
                                 <div class="chart"> 
                                     <div id="container" style="width: 100%; height: 70%; margin: 0 auto ;"></div>
                                 <!--<div id="container" style="width: 100%; height: 70%; margin: 0 auto ; background: url(ajax-loader.gif); background-repeat: no-repeat, repeat;background-position: center center;"></div>-->
								 </div><!-- /.empty-div for ajax call -->
                        </div>
                        <!-- /.box-footer -->
                     </div>
                     <!-- /.box -->
                  </div>
                  <!-- /.col -->
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
										$("#container").html("");
									 if (station.length > 0) {                    
										 $.ajax({
											 type: "POST",
											 url: "chart.php",
											 data: "station=" + station,
											 cache: false,                                 
											 success: function(html) {
												 $("#container").html("");
											 }
										 });
									 }
								 }
								 
         $(function () {  
         var options = {
                             chart: {
								  loading: {
									hideDuration: 1000,
									showDuration: 1000
								},
                                 renderTo: 'container',
                                 type: 'line',
                                 zoomType: 'x',
                                 borderWidth: 0,
                                 resetZoomButton: {
                                     position: {                                         
                                         x: -10,
                                         y: 10
                                     },
                                     relativeTo: 'chart'
                                 }
                             },
                             credits: {
                                 //enabled: false
                                  text: 'NIWE AMS',
                                  href: '#'
                             },                             
                             title: {
                                 text: '',
                                 x: -20 //center
                             },
                             subtitle: {
                                 text: '',
                                 x: -20
                             },
                             xAxis: {
                                 categories: []
                             },
                             yAxis: {
                                 title: {
                                     text: 'Direct Normal Irradiance (W/m2)/nm'
                                 },
                                 plotLines: [{
                                         value: 0,
                                         width: 1,
                                         color: '#808080'
                                     }]
                             },
                             tooltip: {
                                 pointFormat: '<span style="color:{series.color}">{series.name}</span>:<b>{point.y}</b> (W/m2)/nm <br/>',
         						changeDecimals: 2,
         						valueDecimals: 2
                             },
                             exporting: {
                                     filename: 'Irradiance_vs_Time'
                                 },
                             series: []
                         };			 
							   $(document).ready(function(){  
							   $.datepicker.setDefaults({  
									dateFormat: 'yy-mm-dd'   
							   });  
							   $(function(){  
									$("#view_chart_from_date").datepicker();  
									$("#view_chart_to_date").datepicker();  
							   });								 
							   $('#View_Chart').click(function(){				
									var view_chart_from_date = $('#view_chart_from_date').val();  
									var view_chart_to_date = $('#view_chart_to_date').val();  
									if(view_chart_from_date != '' && view_chart_to_date != '')  
									{  
									 getAjaxData(view_chart_from_date, view_chart_to_date);	   
									}  
									else  
									{  
										 alert("Select Date");  
									}  
							   });								
						  });
						  
                 function getAjaxData(view_chart_from_date, view_chart_to_date ){					 
                 //use getJSON to get the dynamic data via AJAX call
                 $.getJSON('chart_data.php', {view_chart_from_date: view_chart_from_date,view_chart_to_date:view_chart_to_date}, function(json) { 
                 
				 options.xAxis.categories = json[0]['data']; //xAxis: {categories: []}
                                options.series[0] = json[1];
                                options.series[1] = json[2];
                                options.series[2] = json[3];
                                options.series[3] = json[4];
                                options.series[4] = json[5];
                                options.series[5] = json[6];
                                options.series[6] = json[7];
                                options.series[7] = json[8];
                                options.series[8] = json[9];
                                options.series[9] = json[10];                        
                                chart = new Highcharts.Chart(options);					   
                                }); 
                 }             
         });
      </script>