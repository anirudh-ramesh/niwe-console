<?php
	include('login.php'); // Include Login Script
	if ((isset($_SESSION['username']) != '')) 
	{
		header('Location: dashboard');
	}	
	?>
<html>
  <head>
  <meta charset="utf-8">
  <link rel="stylesheet" href="css/style.css"/>	
  <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
	<script type="text/javascript">
	$(window).load(function() {
	$(".loader").fadeOut("slow");
	})
</script>
  </head>
  <body oncontextmenu="return false">
  <div class="loader"></div>
	<center>
	<div>	
	<div class="logo"><img src="soreva2.png" alt="logo" height="85" width="250"><hr></div>
	 <div class="main">
	  <span style="color:#006666;">MITRA</span>
		<form id="form_id" method="post"  action="" name="myform">
		
		<label for="username">Username</label></br>				  
		  <input type="text" name="username" id="username" required/></br>

		 <label for="password">Password</label></br>
		  <input type="password" name="password" id="password" required/></br>

		  <input type="submit" name="submit" value="Login!" />	
		  <span class="error"><?php echo $error;?></span>  
		</form>
	 </div>	  
			</div>
	<h6 style="color:#006666;">Login to Continue</h6> 
	</center>
 </body>
</html>