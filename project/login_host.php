<?php include('host.php') ?>
<!DOCTYPE html>
<html>
<head>
  <title>Host Login</title>
  <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
  <div class="header">
  	<h2>Host Login</h2>
  </div>
	 
  <form method="post" action="login_host.php">
  	<?php include('error.php'); ?>
  	<div class="input-group">
  		<label>Username</label>
  		<input type="text" name="host_name" >
  	</div>
  	<div class="input-group">
  		<label>Password</label>
  		<input type="password" name="password">
  	</div>
  	<div class="input-group">
  		<button type="submit" class="btn" name="login_host">Login</button>
  	</div>
  	<p>
  		Not yet a member? <a href="register_host.php">Register</a>
  	</p>

  	<br>
  	<br>
  	<a href="home.php">Cancel</a>
 	<div class="geser">
  	<button type="button" class="btn" onClick="location.href='login.php'">Login Guest</button>
  	</div>
  </form>
</body>
</html>