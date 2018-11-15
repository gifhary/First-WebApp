<?php
session_start();

// variable
$guest_name = "";
$email    = "";
$errors = array(); 

// connect to the database
$db = mysqli_connect('localhost', 'root', '', 'registration');

// REGISTER USER
if (isset($_POST['reg_user'])) {
  // receive all input values from the form
  $guest_name = mysqli_real_escape_string($db, $_POST['guest_name']);
  $email = mysqli_real_escape_string($db, $_POST['email']);
  $password_1 = mysqli_real_escape_string($db, $_POST['password_1']);
  $password_2 = mysqli_real_escape_string($db, $_POST['password_2']);

  // form validation: ensure that the form is correctly filled ...
  // by adding (array_push()) corresponding error unto $errors array
  if (empty($guest_name)) { array_push($errors, "Username is required"); }
  if (empty($email)) { array_push($errors, "Email is required"); }
  if (empty($password_1)) { array_push($errors, "Password is required"); }
  if ($password_1 != $password_2) {
	array_push($errors, "The two passwords does not match");
  }

  // first check the database to make sure 
  // a user does not already exist with the same username and/or email
  $user_check_query = "SELECT * FROM users WHERE guest_name='$guest_name' OR email='$email' LIMIT 1";
  $result = mysqli_query($db, $user_check_query);
  $user = mysqli_fetch_assoc($result);
  
  if ($user) { // if user exists
    if ($user['guest_name'] === $guest_name) {
      array_push($errors, "Username already exists");
    }

    if ($user['email'] === $email) {
      array_push($errors, "email already exists");
    }
  }

  // Register
  if (count($errors) == 0) {
  	$password = md5($password_1);//encrypt the password before saving in the database

  	$query = "INSERT INTO users (guest_name, email, password) 
  			  VALUES('$guest_name', '$email', '$password')";
  	mysqli_query($db, $query);
  	$_SESSION['guest_name'] = $guest_name;
  	header('location: home.php');
  }
}

// Login
if (isset($_POST['login_user'])) {
    $guest_name = mysqli_real_escape_string($db, $_POST['guest_name']);
    $password = mysqli_real_escape_string($db, $_POST['password']);
    
    if (empty($guest_name)) {
        array_push($errors, "Username is required");
    }
    if (empty($password)) {
        array_push($errors, "Password is required");
    }
    
    if (count($errors) == 0) {
        $password = md5($password);
        $query = "SELECT * FROM users WHERE guest_name='$guest_name' AND password='$password'";
        $results = mysqli_query($db, $query);
        if (mysqli_num_rows($results) == 1) {
            $_SESSION['guest_name'] = $guest_name;
            header('location: home.php');
        }else {
            array_push($errors, "Wrong username/password combination");
        }
    }
}

?>