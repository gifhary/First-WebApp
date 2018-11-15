<?php include('host.php')?>
<!DOCTYPE html>
<html>
<head>
  <title>Host Registration</title>
  <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
  <div class="header">
  	<h2>Host Registration</h2>
  </div>
	
  <form method="post" action="register_host.php">
  	<?php include('error.php'); ?>
  	
  	<div class="input-group">
  	  <label>Username</label>
  	  <input type="text" name="host_name" value="<?php echo $host_name; ?>">
  	</div>
  	
  	<div class="input-group">
  	  <label>Email</label>
  	  <input type="email" name="email" value="<?php echo $email; ?>">
  	</div>
  	
  	<div class="input-group">
  		<label>Hotel Name</label>
  		<input type="text" name="hotel_name" value="<?php echo $hotel_name; ?>">
  	</div>
  	
  	<div class="input-group">
  		<label>Country</label>
  		<input type="text" name="country" value="<?php echo $country; ?>">
  	</div>
  	
  	<div class="input-group">
  		<label>Phone Number</label>
  		<input type="text" name="phone" value="<?php echo $phone?>" maxlength="20">
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
  	  <button type="submit" class="btn" name="reg_host">Register</button>
  	</div>
  	
  	<p>
  		Already a host? <a href="login_host.php">Log in</a>
  	</p>
  
  	<br>
  	
  	<a href="home.php">Cancel</a>
	<div class="geser">
  		<button type="button" class="btn" onClick="location.href='register.php'">Register Guest</button>
  	</div>
  
  </form>
</body>
</html>