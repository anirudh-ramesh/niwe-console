<?php

	include("../../../check.php");

	if ($_SESSION['username'] != 'root') {
		header('Location: prohibit.php');
	}

?>
<!DOCTYPE html>
<html>
	<head>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
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
				text-align: left;
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
		<script>
			$(document).ready(function() {
				$(document).on('click', '#btn_add', function(){

					var id = $('#id').text();
					var station = $('#station').text();
					var Gain_DNI = $('#Gain_DNI').text();
					var Offset_V1 = $('#Offset_V1').text();
					var Gain_V = $('#Gain_V').text();
					var Offset_V2 = $('#Offset_V2').text();

					if(id == '') {
						alert("id");
						return false;
					}
					if(station == '') {
						alert("Enter Station ");
						return false;
					}
					if(Gain_DNI == '') {
						alert("Enter Gain_DNI ");
						return false;
					}
					if(Offset_V1 == '') {
						alert("Enter Offset_V1");
						return false;
					}
					if(Gain_V == '') {
						alert("Enter Gain_V ");
						return false;
					}
					if(Offset_V2 == '') {
						alert("Enter Offset_V2");
						return false;
					}

					$.ajax({
						url:"insert.php",
						method:"POST",
						data:{id:id,station:station,Gain_DNI:Gain_DNI,Offset_V1:Offset_V1,Gain_V:Gain_V,Offset_V2:Offset_V2},
						dataType:"text",
						success:function(data) {
							alert(data);
							fetch_data();
						}
					})
				});

				function edit_data(id, text, column_name)
				{
					$.ajax({
						url:"edit.php",
						method:"POST",
						data:{id:id, text:text, column_name:column_name},
						dataType:"text",
						success:function(data){}
					});
				}
				$(document).on('blur', '.station', function() {
					var id = $(this).data("id1");
					var station = $(this).text();
					edit_data(id, station, "station");
				});
				$(document).on('blur', '.Gain_DNI', function() {
					var id = $(this).data("id2");
					var Gain_DNI = $(this).text();
					edit_data(id, Gain_DNI, "Gain_DNI");
				});
				$(document).on('blur', '.Offset_V1', function() {
					var id = $(this).data("id3");
					var Offset_V1 = $(this).text();
					edit_data(id,Offset_V1, "Offset_V1");
				});
				$(document).on('blur', '.Gain_V', function() {
					var id = $(this).data("id4");
					var Gain_V = $(this).text();
					edit_data(id, Gain_V, "Gain_V");
				});
				$(document).on('blur', '.Offset_V2', function() {
					var id = $(this).data("id5");
					var Offset_V2 = $(this).text();
					edit_data(id,Offset_V2, "Offset_V2");
				});
				$(document).on('click', '.btn_delete', function() {
					var id=$(this).data("id6");
					if (confirm("Are you sure you want to delete this?")) {
						$.ajax({
							url:"delete.php",
							method:"POST",
							data:{id:id},
							dataType:"text",
							success:function(data) {
								alert(data);
								fetch_data();
							}
						});
					}
				});
			});
		</script>
	</head>
	<body class="hold-transition skin-blue sidebar-mini" oncontextmenu="return true">
		<div class="wrapper">
			<header class="main-header">
				<!-- Logo -->
				<a href="../../index.php" class="logo">
					<!-- mini logo for sidebar mini 50x50 pixels -->
					<span class="logo-mini"style="font-size:12px;">MITRA<sub>1.0</sub></span>
					<!-- logo for regular state and mobile devices -->
					<span class="logo-lg"style="font-size:12px;">MITRA <sub>1.0</sub></span>
				</a>
				<!-- Header Navbar: style can be found in header.less -->
				<nav class="navbar navbar-static-top">
					<!-- Sidebar toggle button-->
					<a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
						<span class="sr-only">Toggle navigation</span>
					</a>
					<!-- Navbar Right Menu -->
					<div class="navbar-custom-menu">
						<ul class="nav navbar-nav">
							<!-- Notifications: style can be found in dropdown.less -->
							<!-- User Account: style can be found in dropdown.less -->
							<li class="dropdown user user-menu">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown">
									<img src="../../dist/img/logo.jpg" class="user-image" alt="User Image">
									<span class="hidden-xs">
										<!--<?php echo $login_user;?>-->SGS Weather
									</span>
								</a>
								<ul class="dropdown-menu">
									<!-- User image -->
									<li class="user-header">
										<img src="../../dist/img/logo.jpg" class="img-circle" alt="User Image">
										<p>
										<!--<?php echo $login_user;?>-->SGS Weather
										</p>
									</li>
									<!-- Menu Body -->
									<!-- Menu Footer-->
									<li class="user-footer">
										<div class="pull-right">
											<a href="../../../logout.php" class="btn btn-default btn-flat">Sign out</a>
										</div>
									</li>
								</ul>
							</li>
						<!-- Control Sidebar Toggle Button -->
						</ul>
					</div>
				</nav>
			</header>
				<!-- Left side column. contains the logo and sidebar -->
				<aside class="main-sidebar">
					<!-- sidebar: style can be found in sidebar.less -->
					<section class="sidebar">
						<!-- Sidebar user panel -->
						<div class="user-panel">
							<div class="pull-left image">
								<img src="../../dist/img/logo.jpg" class="img-circle" alt="User Image">
							</div>
							<div class="pull-left info">
								<p>
									<!--<?php echo $login_user;?>-->SGS Weather
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
									<li>
										<a href="../data_visualization/irradiance_time.php">
											<i class="fa fa-line-chart"></i>View DNI-Time Plot
										</a>
									</li>
								</ul>
								<ul class="active treeview-menu">
									<li>
										<a href="../data_visualization/irradiance_wavelength.php">
											<i class="fa fa-line-chart"></i>View DNI-λ Plot
										</a>
									</li>
								</ul>
							</li>
							<li>
								<a href="../data_access/">
									<i class="fa fa-download"></i>
									<span>Data Access</span>
								</a>
							</li>
							<li>
								<a href="#">
									<i class="fa fa-file-text-o"></i>
									<span>Data Config</span>
								</a>
							</li>
							<li>
								<a href="../about/about.php">
									<i class="fa fa-info-circle"></i>
									<span>About</span>
								</a>
							</li>
						</ul>
					</section>
					<!-- /.sidebar -->
				</aside>
				<!-- Content Wrapper. Contains page content -->
				<div class="content-wrapper">
					<!-- Content Header (Page header) -->
					<!-- Main content -->
					<section class="content">
						<div class="row">
							<div class="col-md-12">				
								<div class="col-md-2">
									<span style="margin:0 auto;width:50%:">
										<?php

											include ('../../config/init.php');

											$query = "SELECT [" . $es_stationNumber . "],[" . $es_number . "] FROM [" . $maindatabaseName . "].[dbo].[" . $es_stations . "] ;";
											$result = sqlsrv_query($maindatabaseHandle, $query);

										?>
										<label>Station:
											<select name="station" onChange="fetch_data(this);">
												<option value="">Select</option>
												<?php while ($row = sqlsrv_fetch_array($result)){ ?>
												<option value="<?php echo $row[$es_stationNumber]; ?>"><?php echo $row[$es_number]; ?></option>
												<?php }  sqlsrv_close($maindatabaseHandle);?>
											</select>
										</label>
									</span>
								</div>
								<script>
									function fetch_data(sel) {
										var station = sel.options[sel.selectedIndex].value;
										if (station.length > 0) {
											$.ajax({
												type: "POST",
												url: "select.php",
												data: "station=" + station,
												cache: false,
												success: function(html) {
													$("#live_data").html(html);
												}
											});
										}
									}
									fetch_data();
								</script>
								<div class="table-responsive">
									<div id="live_data"></div>
								</div>
							</div>
							<div class="col-md-12">
								<center>
									<form name="form" method="post" enctype="multipart/form-data" action="upload.php">
										<table>
											<tr>
												<th>Upload configuration file here
													<td>
														<select name="number" onchange="this.form.submit();" method="post">
															<option value="">  Select Station</option>
															<option value="2546">AMS_CHE</option>
															<option value="2547">AMS_PDPU</option>
															<option value="2548">AMS_SEC</option>
															<option value="2550">AMS_HWH</option>
														</select>
													</td>
												</th>
												<td><input type="file" value="Upload CSV Format" name="csvfile" /></td>
												<td><input type="submit" value="Upload" name="submit" /></td>
											</tr>
										</table>
									</form>
								</center>
							</div>
						</div>
					<!-- /.row -->
					</section>
				<!-- /.content -->
				</div>
			<!-- /.content-wrapper -->
			<footer class="main-footer">
				<div class="pull-right hidden-xs">
						<b>Version</b> 1.0
				</div>
				<strong>Copyright &copy; 2018 <a href="http://soreva.co.in" target="_blank">Soreva</a>.</strong> All rights reserved.
			</footer>
			<!-- Control Sidebar -->
			<!-- /.control-sidebar -->
			<!-- Add the sidebar's background. This div must be placed
				immediately after the control sidebar -->
		</div>
		<!-- ./wrapper -->
		<!-- jQuery 2.2.3 -->
		<script src="../../plugins/jQuery/jquery-2.2.3.min.js"></script>
		<!-- Bootstrap 3.3.6 -->
		<script src="../../bootstrap/js/bootstrap.min.js"></script>
		<!-- Slimscroll -->
		<script src="../../plugins/slimScroll/jquery.slimscroll.min.js"></script>
		<!-- FastClick -->
		<script src="../../plugins/fastclick/fastclick.js"></script>
		<!-- AdminLTE App -->
		<script src="../../dist/js/app.min.js"></script>
		<!-- iCheck -->
		<script src="../../plugins/iCheck/icheck.min.js"></script>
		<!-- Page Script -->
		<script src="../../dist/js/demo.js"></script>
	</body>
</html>