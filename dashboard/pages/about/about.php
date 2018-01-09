<?php
	include("../../../check.php");
?>
<!DOCTYPE html>
<html>
	<head>
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
	</head>
	<body class="hold-transition skin-blue sidebar-mini" oncontextmenu="return false">
		<div class="wrapper">
			<header class="main-header">
				<!-- Logo -->
				<a href="../../index.php" class="logo">
					<!-- mini logo for sidebar mini 50x50 pixels -->
					<span class="logo-mini"style="font-size:12px;">NIWE Advance Station Console</span>
					<!-- logo for regular state and mobile devices -->
					<span class="logo-lg"style="font-size:12px;">NIWE Advance Station Console</span>
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
								</div>
								<div class="pull-left info">
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
								<li>
									<a href="../data_visualization/irradiance_time.php">
										<i class="fa fa-line-chart"></i>View Irradiance-Time Plot
									</a>
								</li>
							</ul>
							<ul class="active treeview-menu">
								<li>
									<a href="../data_visualization/irradiance_wavelength.php">
										<i class="fa fa-line-chart"></i>View Irradiance-λ Plot
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
							<a href="index.php">
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
			</aside>
			<!-- Content Wrapper. Contains page content -->
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
				<!-- /.content-wrapper -->
				<footer class="main-footer">
					<div class="pull-right hidden-xs">
							<b>Version</b> 1.0
					</div>
					<strong>Copyright &copy; 2017 <a href="http://soreva.co.in" target="_blank">Soreva.co.in</a>.</strong> All rights
					reserved.
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