<?php
include ("../check.php");
include("config/config.php");
?>
<!DOCTYPE html>
<html>
   <head>            
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <title>MITRA</title>
      <!--<meta http-equiv="refresh" content="240">-->
      <meta name="description" content="Solar plant operational intelligence software for O&M "><meta name="robots" content="index,follow">
      <meta name="author" content="Suraj Anand">
      <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
      <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
      <link rel="stylesheet" href="plugins/jvectormap/jquery-jvectormap-1.2.2.css">
      <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
      <link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">      
      <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
      <!--added style for input table--> 
      <style>
         table, th, td {
         
         border-collapse: collapse;
            }
            th, td {
                padding: 1px;
                text-align: left;    
      }
      </style>
      <style>
            select {
                padding:3px;
                border-radius:5px;
                background: #f8f8f8;
                color:#000;
                
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
            <a href="index.php" class="logo">
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
                        <img src="dist/img/logo.jpg" class="user-image" alt="User Image"><!--dist/img/sunshine_logo.jpg>
                        <span class="hidden-xs"> <!-- <?php echo $login_user; ?>-->
                                SGS Weather</span>
                        </a>
                        <ul class="dropdown-menu">
                           <li class="user-header">
                              <img src="dist/img/logo.jpg" class="img-circle" alt="User Image">
                              <p><!-- <?php echo $login_user; ?>-->
                                SGS Weather                                 
                              </p>
                           </li>
                           <li class="user-footer">
                              <div class="pull-right">
                                 <a href="../logout.php" class="btn btn-default btn-flat">Sign out</a>
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
                     <img src="dist/img/logo.jpg" class="img-circle" alt="User Image">
                  </div>
                  <div class="pull-left info">
                     <p> <!-- <?php echo $login_user; ?>-->
                                SGS Weather</p>
                     
                  </div>
               </div>
               <ul class="sidebar-menu">

                <li class="treeview">
                     <a href="#">
                     <i class="fa fa-dashboard"></i>
                     <span>Dashboard</span>            
                     </a>      
                     <ul class="treeview-menu">
                        <li><a href="pages/data_visualization/irradiance_time.php"><i class="fa fa-line-chart"></i>View Irradiance-Time Plot</a></li>                        
                     </ul>
                  </li>                  
                  <li>
                     <a href="pages/data_access/">
                     <i class="fa fa-download"></i> <span>Data Access</span>            
                     </a>
                  </li>
                  <li>
                     <a href="pages/data_configuration/">
                     <i class="fa fa-file-text-o"></i> <span>Data Config</span>            
                     </a>
                  </li>
                  
                  
                  <li><a href="pages/about/about.php"><i class="fa fa-info-circle"></i> <span>About</span></a></li>
               </ul>
            </section>
         </aside>
         <div class="content-wrapper">
        <!-- <section class="content">              
               <div class="row">
                  <div class="col-md-2">
                  <center>
                    <table style="margin:0 auto;width:50%" >
                        <tr>
                            <td align="center" height="50">
                                <?php
                                $query = "SELECT Distinct [NumEstacion] FROM [MeteoStation4K].[dbo].[Datos];";
                                $result = sqlsrv_query($pg_index, $query);               
                                ?>
                                <label>Station:
                                    <select name="station" onChange="showTimestmp(this);">
                                        <option value="">Select</option>
                                        <?php  while ($row = sqlsrv_fetch_array($result)){ ?>
                                            <option value="<?php echo $row["NumEstacion"]; ?>"><?php echo $row["NumEstacion"]; ?></option>
                                        <?php }  sqlsrv_close($pg_index);?>
                                    </select>
                                </label>                                
                            </td>
                        </tr>
                        <tr>
                            <td align="center" height="50"><div id="output1"></div> </td>
                        </tr>
                        <tr>
                            <td align="center" height="50"><div id="output2"></div> </td>
                        </tr>
                       
                    </table>                     
                    </center> 
                   </div>
                   <script>
                    function showTimestmp(sel) {
                        var station = sel.options[sel.selectedIndex].value;
                        $("#output1").html("");
                        $("#output2").html("");
                        
                        if (station.length > 0) {

                            $.ajax({
                                type: "POST",
                                url: "pages/dropdown/ajax1.php",
                                data: "station=" + station,
                                cache: false,
                                
                                success: function(html) {
                                    $("#output1").html(html);
                                }
                            });
                        }
                    }

                    function showVoltage(sel) {
                        var timestmp = sel.options[sel.selectedIndex].value;
                        if (timestmp.length > 0) {
                            $.ajax({
                                type: "POST",
                                url: "Highcharts/bar/data/linechart_json.php",
                                data: "timestmp=" + timestmp,
                                cache: false,                           
                                success: function(html) {
                                    $("#output2").html("");
                                }
                            });
                        } else {
                            $("#output2").html("");
                        }
                    }        


        </script>
                  <div class="col-md-10">
                     <div class="box">
                        <div class="box-header with-border">
                           <center><h3 class="box-title">Irradiance Versus Time</h3></center>
                           <div class="box-tools pull-right">
                              <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                              </button>                
                              <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                           </div>
                        </div>
                        <div class="box-body">
                           <div class="row">
                              <div class="col-md-12">
                                 <div class="chart"> 
                                    <iframe src="Highcharts/bar/linechart.php" frameborder="0" scrolling="no" allowtransparency="true"  style="width: 100%;height: 450px;">    
                                    </iframe>                  
                                 </div>
                              </div>                              
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
         <!-- /.content-wrapper -->
         <footer class="main-footer">
            <div class="pull-right hidden-xs">
               <b>Version</b> 1.0
            </div>
            <strong>Copyright &copy; 2017 <a href="http://soreva.co.in" target="_blank">Soreva.co.in</a></strong> All rights
            reserved.
         </footer>
      </div>
      <!-- ./wrapper -->
      <!-- jQuery 2.2.3 -->
      <script src="plugins/jQuery/jquery-2.2.3.min.js"></script>
      <!-- Bootstrap 3.3.6 -->
      <script src="bootstrap/js/bootstrap.min.js"></script>
      <!-- FastClick -->
      <script src="plugins/fastclick/fastclick.js"></script>
      <!-- AdminLTE App -->
      <script src="dist/js/app.min.js"></script>
      <!-- Sparkline -->
      <script src="plugins/sparkline/jquery.sparkline.min.js"></script>
      <!-- jvectormap -->
      <script src="plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
      <script src="plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
      <!-- SlimScroll 1.3.0 -->
      <script src="plugins/slimScroll/jquery.slimscroll.min.js"></script>
      <!-- ChartJS 1.0.1 -->
      <script src="plugins/chartjs/Chart.min.js"></script>
      <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
      <script src="dist/js/pages/dashboard2.js"></script>
      <!-- AdminLTE for demo purposes -->
      <script src="dist/js/demo.js"></script>
   </body>
</html>