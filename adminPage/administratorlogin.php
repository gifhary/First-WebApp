<?php
session_start();

$username = 'admin';
$password = '81dc9bdb52d04dc20036dbd8313ed055'; //encrypted password
$errors = array();


if (isset($_POST['login_admin'])) {
    $admin_name = $_POST['admin_name'];
    $pwd = $_POST['pwd'];
    $pass = md5($pwd);
    
    if (empty($admin_name)) {
        array_push($errors, "Username is required");
    }
    if (empty($pwd)) {
        array_push($errors, "Password is required");
    }
    if ($admin_name != $username){
        array_push($errors, "Wrong username!");
    }
    if ($pass != $password){
        array_push($errors, "Wrong password!");
    }
    
    if (count($errors) == 0) {
        $_SESSION['admin_name'] = $admin_name;
        header('location: showhostadmin.php');
    }
}

 ?>
<html lang="en">
<head>
  <title>Administrator Hotel.me</title>
   
   
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" type="text/css" href="HeaderAdmin.css">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script
   
</head>

<body>
<div class="container">
  <div class="jumbotron" style="height: 280px;">
    <h1>Administrator</h1> 
    <p>this page is only meant for administrator of hotelme.com .</p>
    
    <?php  if (count($errors) > 0) : ?>
  		<div class="error" style="color: #a94442; text-align: left;">
  	<?php foreach ($errors as $error) : ?>
  		<p><?php echo $error ?></p>
  	<?php endforeach ?>
  		</div>
	<?php  endif ?>
	
  </div>
</div>

<div class="container"" style="margin-top:50px;padding-right:200px;padding-left:200px;" > 

    <form class="form-horizontal" method="post" action="administratorlogin.php">
	
  <div class="form-group" >
    <label class="control-label col-sm-2" >Admin:</label>
    <div class="col-sm-10">
      <input class="form-control" name="admin_name" placeholder="Enter username">
    </div>
  </div>
  
  <div class="form-group">
    <label class="control-label col-sm-2" for="pwd">Password:</label>
    <div class="col-sm-10"> 
      <input type="password" class="form-control" name="pwd" placeholder="Enter password">
    </div>
  </div>
  <div class="form-group"> 
    <div class="col-sm-offset-2 col-sm-10">
    </div>
  </div>
  <div class="form-group"> 
    <div class="col-sm-offset-2 col-sm-10">
      <button type="submit" name="login_admin" class="btn btn-default">Log in</button>
    </div>
  </div>
</form>
</div>
</body>
