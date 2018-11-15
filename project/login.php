<?php include('server.php') ?>
<!DOCTYPE html>
<html>
<head>
  <title>Guest Login</title>
  <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
  <div class="header">
  	<h2>Guest Login</h2>
  </div>
	 
  <form method="post" action="login.php">
  	<?php include('error.php'); ?>
  	<div class="input-group">
  		<label>Username</label>
  		<input type="text" name="guest_name" >
  	</div>
  	<div class="input-group">
  		<label>Password</label>
  		<input type="password" name="password">
  	</div>
  	<div class="input-group">
  		<button type="submit" class="btn" name="login_user">Login</button>
  	</div>
  	<p>
  		Not yet a member? <a href="register.php">Register</a>
  	</p>
  	
  	<br>
  	<br>
  	<a href="home.php">Cancel</a>
 	<div class="geser">
  		<button type="button" class="btn" onClick="location.href='login_host.php'">Login Host</button>
  	</div>
  </form>
</body>
</html>