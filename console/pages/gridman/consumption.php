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
		<title>Gridviewer - Electricity Consumption</title>
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
					<span class="logo-mini" style="font-size:12px;">Grid</span>
					<span class="logo-lg" style="font-size:12px;">Gridviewer</span>
				</a>
				<nav class="navbar navbar-static-top">
					<a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
						<span class="sr-only">Toggle navigation</span>
					</a>
					<div class="navbar-custom-menu">
						<ul class="nav navbar-nav">
							<li class="dropdown user user-menu">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown">
									<img src="../../dist/img/logo.jpg" class="user-image" alt="User Image">
									<!-- <?php echo $usernameDatabase; ?>-->Soreva
								</a>
								<ul class="dropdown-menu">
									<li class="user-header">
										<img src="../../dist/img/logo.jpg" class="img-circle" alt="User Image">
										<p>
											<!-- <?php echo $usernameDatabase; ?>-->Soreva
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
								<!-- <?php echo $usernameDatabase; ?>-->Soreva
							</p>
						</div>
					</div>
					<ul class="sidebar-menu">
						<li class="treeview">
							<a href="index.php">
								<i class="fa fa-dashboard"></i>
								<span>Visualize</span>
							</a>
							<ul class="active treeview-menu">
								<li>
									<a href="consumption.php">
										<i class="fa fa-line-chart"></i>Consumption
									</a>
								</li>
							</ul>
							<ul class="active treeview-menu">
								<li>
									<a href="generation.php">
										<i class="fa fa-line-chart"></i>Generation
									</a>
								</li>
							</ul>
						</li>
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
										<div class="col-md-3">
											<?php include('fetchStates.php');	?>
											<select name="state" onChange="selectState(this);">
												<option value="">State</option>
												<?php while ($row = sqlsrv_fetch_array($result)){ ?>
												<option value="<?php echo $row[$en_stateCode]; ?>"><?php echo $row[$en_stateCode]; ?></option>
												<?php }  sqlsrv_close($sidedatabaseHandle);?>
											</select>
										</div>
										<div class="col-md-3">
											<select id="granularity" name="granularity">
												<option value="">Granularity</option>
												<option value="5">5 Minutes</option>
												<option value="10">10 Minutes</option>
												<option value="15">15 Minutes</option>
												<option value="20">20 Minutes</option>
												<option value="30">30 Minutes</option>
												<option value="60">60 Minutes</option>
											</select>
										</div>
									</div>
								</div>
								<br>
								<div align="center" class="row">
									<div class="col-md-12">
										<div class="col-md-3">
											<input type="text" name="dateFrom" id="viewChart_dateFrom" class="form-control" placeholder="From Date" />
										</div>
										<div class="col-md-3">
											<input type="text" name="dateTo" id="viewChart_dateTo" class="form-control" placeholder="To Date" />
										</div>
										<div class="col-md-3">
											<input type="button" name="View_Chart" id="View_Chart" value="View Chart" class="btn btn-info" />
										</div>
										<div style="clear:both"></div>
										<br>
									</div>
								</div>
							</div>
							<div class="col-md-12">
								<div class="box">
									<div class="box-header with-border">
										<center><h3 class="box-title">Electricity Consumption - Time</h3></center>
										<div class="box-tools pull-right">
											<button type="button" class="btn btn-box-tool" data-widget="collapse">
												<i class="fa fa-minus"></i>
											</button>
											<button type="button" class="btn btn-box-tool" data-widget="remove">
												<i class="fa fa-times"></i>
											</button>
										</div>
									</div>
									<div class="box-body">
										<div class="chart">
											<div id="container" style="width: 100%; height: 70%; margin: 0 auto ;"></div>
											<!--<div id="container" style="width: 100%; height: 70%; margin: 0 auto ; background: url(ajax-loader.gif); background-repeat: no-repeat, repeat;background-position: center center;"></div>-->
										</div>
									<!-- /.empty-div for ajax call -->
									</div>
								<!-- /.box-footer -->
								</div>
							<!-- /.box -->
							</div>
						<!-- /.col -->
						</div>
					<!-- /.row -->
					</div>
				</section>
			<!-- /.content -->
			</div>
			<!-- /.content-wrapper -->
			<footer class="main-footer">
				<div class="pull-right hidden-xs">
					<b>Version</b> 1.0
				</div>
				<strong>Copyright &copy; 2018 <a href="http://soreva.co.in" target="_blank">Soreva</a></strong> All rights reserved.
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
	function selectState(sel) {
		var state = sel.options[sel.selectedIndex].value;
		$("#container").html("");
		if (state.length > 0) {
			$.ajax({
				type: "POST",
				url: "consumption.php",
				data: "state=" + state,
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
				zoomType: 'xy',
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
				text: 'Gridman',
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
			yAxis: [{
				title: {
					text: 'Load',
					color: '#c3f902'
				},
				labels: {
					format: '{value} MVA',
					color: '#c3f902'
				}
			}, {
				title: {
					text: 'Frequency',
					color: '#0f6307'
				},
				labels: {
					format: '{value} Hz',
					color: '#0f6307'
				},
				opposite: true
			}],
			tooltip: {
				shared: true,
				changeDecimals: 2,
				valueDecimals: 2
			},
			exporting: {
				filename: 'Electricity Consumption - Time'
			},
			series: [{
				name: 'Load',
				type: 'line',
				color: '#c3f902',
				data: [],
				tooltip: {
					valueSuffix: ' MVA'
				}
			}, {
				name: 'Frequency',
				type: 'line',
				color: '#0f6307',
				data: [],
				tooltip: {
					valueSuffix: ' Hz'
				},
				yAxis: 1
			}]
		};
		$(document).ready(function() {
			$.datepicker.setDefaults({
				dateFormat: 'yy-mm-dd'
			});
			$(function() {
				$("#viewChart_dateFrom").datepicker();
				$("#viewChart_dateTo").datepicker();
			});
			$('#View_Chart').click(function() {
				var dateFrom = $('#viewChart_dateFrom').val();
				var dateTo = $('#viewChart_dateTo').val();
				var granularity = $('#granularity').val().toString();
				if(dateFrom != '' && dateTo != '') {
					getAjaxData(dateFrom, dateTo, granularity);
				} else {
					alert("Select Date");
				}
			});
		});
		function getAjaxData(dateFrom, dateTo, granularity) {
			//use getJSON to get the dynamic data via AJAX call
			$.getJSON('../../interfaces/gridman.php', {dateFrom: dateFrom, dateTo: dateTo, granularity: granularity, method: "plot_electricityConsumption"}, function(json) {
				options.xAxis.categories = json[0]['data']; //xAxis: {categories: []}
				options.series[0].data = json[1]['data'];
				options.series[1].data = json[2]['data'];
				chart = new Highcharts.Chart(options);
			});
		}
	});
</script>