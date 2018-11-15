<?php include('server.php') ?>
<!DOCTYPE html>
<html>
<head>
  <title>Guest Registration</title>
  <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
  <div class="header">
  	<h2>Guest Registration</h2>
  </div>
	
  <form method="post" action="register.php">
  	<?php include('error.php'); ?>
  	<div class="input-group">
  	  <label>Username</label>
  	  <input type="text" name="guest_name" value="<?php echo $guest_name; ?>">
  	</div>
  	<div class="input-group">
  	  <label>Email</label>
  	  <input type="email" name="email" value="<?php echo $email; ?>">
  	</div>
  	<div class="input-group">
  	  <label>Password</label>
  	  <input type="password" name="password_1">
  	</div>
  	<div class="input-group">
  	  <label>Confirm password</label>
  	  <input type="password" name="password_2">
  	</div>
  	<div class="input-group">
  	  <button type="submit" class="btn" name="reg_user">Register</button>
  	</div>
  	<p>
  		Already a member? <a href="login.php">Log in</a>
  	</p>
  
  	<br>

  	<a href="home.php">Cancel</a>
  	<div class="geser">
  		<button type="button" class="btn" onClick="location.href='register_host.php'">Register Host</button>
  	</div>
  </form>
</body>
</html>