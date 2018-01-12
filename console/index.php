<?php
	include ("../check.php");
	include("config/config.php");
?>
<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<title>NIWE - AMS Console</title>
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
					<span class="logo-mini" style="font-size:12px;">AMS Console</span>
					<span class="logo-lg" style="font-size:12px;">AMS Console</span>
				</a>
				<nav class="navbar navbar-static-top">
					<a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
						<span class="sr-only">Toggle navigation</span>
					</a>
					<div class="navbar-custom-menu">
						<ul class="nav navbar-nav">
							<li class="dropdown user user-menu">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown">
									<img src="dist/img/logo.jpg" class="user-image" alt="User Image">
									<!-- <?php echo $login_user; ?> -->SGS Weather
								</a>
								<ul class="dropdown-menu">
									<li class="user-header">
										<img src="dist/img/logo.jpg" class="img-circle" alt="User Image">
										<!-- <?php echo $login_user; ?>-->SGS Weather
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
							<!-- <?php echo $login_user; ?>-->SGS Weather
						</div>
					</div>
					<ul class="sidebar-menu">
						<li class="treeview">
							<a href="#">
								<i class="fa fa-dashboard"></i>
								<span>Dashboard</span>
							</a>
							<ul class="treeview-menu">
								<li>
									<a href="pages/data_visualization/irradiance_time.php">
										<i class="fa fa-line-chart"></i>View DNI-Time Plot
									</a>
								</li>
								<li>
									<a href="pages/data_visualization/irradiance_wavelength.php">
										<i class="fa fa-line-chart"></i>View DNI-λ Plot
									</a>
								</li>
							</ul>
						</li>
						<li>
							<a href="pages/data_access/">
								<i class="fa fa-download"></i>
								<span>Data Access</span>
							</a>
						</li>
						<li>
							<a href="pages/date_configuration/">
								<i class="fa fa-file-text-o"></i>
								<span>Data Config</span>
							</a>
						</li>
						<li>
							<a href="pages/about/about.php">
								<i class="fa fa-info-circle"></i>
								<span>About</span>
							</a>
						</li>
					</ul>
				</section>
			</aside>
			<div class="content-wrapper">
				<!-- Content Header (Page header) -->
				<!-- Main content -->
				<section class="content">
					<div class="row">
						<div class="col-md-3"></div>
						<div class="col-md-6">
							<br>
							<br>
							<br>
							<p>The SPUV is a precision sun photometer that measures direct solar spectral irradiance at up to ten discrete wavelengths in the UV-B and visible regions. The SPUV exceeds the WMO specifications for sun photometers and is the first commercial sun photometer to measure narrow bandwidths in the UV-B.</p>

							<p>The SPUV is normally used to measure the optical depth of an atmospheric constituent, for example ozone or aerosols. The principle of measurement is based on Beer's Law.</p>

							<p>The SPUV is mounted on a user-supplied solar tracker and is maintained pointed directly at the sun. The flat universal mounting plate on the SPUV enables it to be attached to most trackers. State-of-the-art thin film interference filters permit only photons within a prescribed wavelength to reach a dedicated detector. Filtered, monochromatic light is detected by solid state photodiodes and the resulting photocurrents are amplified by highly sensitive, ultra low noise electronic circuitry. Analog outputs, one for each wavelength are proportional to incident spectral irradiance.</p>

							<p>A Geonica MeteoStation data acquisition and control system digitizes each analog channel and the associated web application software converts data into spectral irradiance calibrated in W/m2-nm.</p>
						</div>
					</div>
					<!-- /.row -->
				</section>
				<!-- /.content -->
			</div>
			<footer class="main-footer">
				<div class="pull-right hidden-xs">
					<b>Version</b> 1.0
				</div>
				<strong>Copyright &copy; 2018 <a href="http://soreva.co.in" target="_blank">Soreva</a></strong> All rights reserved.
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