<?php
session_start();
clearstatcache();

if (!isset($_SESSION['admin_name'])) {
    header('location: administratorlogin.php');
}

if (isset($_GET['logout'])) {
    session_destroy();
    unset($_SESSION['admin_name']);
    header('location: administratorlogin.php');
}

?>

<!DOCTYPE html>
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
<nav class="navbar navbar-default">

  <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand" href="#">Admin Page</a>
    </div>
    <ul class="nav navbar-nav">
      <li><a href="showhostadmin.php">Host</a></li>
      <li><a href="showuseradmin.php">User</a></li>
	  <li><a href="HeaderAdmin.php?logout='1'">Log out</a></li>  
    </ul>
	<div style="float:right;">
      <p class="navbar-text" ><strong><?php echo $_SESSION['admin_name']; ?></strong></p>
    </div>
	
  </div>
  
  
</nav>
</div> 
</body>
</html>
