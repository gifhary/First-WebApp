<?php
session_start();

// variable
$host_name = "";
$email    = "";
$hotel_name = "";
$country = "";
$phone = "";
$errors = array();

// connect to the database
$db = mysqli_connect('localhost', 'root', '', 'registration');

// REGISTER USER
if (isset($_POST['reg_host'])) {
    // receive all input values from the form
    $host_name = mysqli_real_escape_string($db, $_POST['host_name']);
    $email = mysqli_real_escape_string($db, $_POST['email']);
    $hotel_name = mysqli_real_escape_string($db, $_POST['hotel_name']);
    $country = mysqli_real_escape_string($db, $_POST['country']);
    $phone = mysqli_real_escape_string($db, $_POST['phone']);
    $password_1 = mysqli_real_escape_string($db, $_POST['password_1']);
    $password_2 = mysqli_real_escape_string($db, $_POST['password_2']);
    
    // form validation: ensure that the form is correctly filled ...
    // by adding (array_push()) corresponding error unto $errors array
    if (empty($host_name)) { array_push($errors, "Username is required"); }
    if (empty($email)) { array_push($errors, "Email is required"); }
    if (empty($hotel_name)) { array_push($errors, "Hotel name is required"); }
    if (empty($country)) { array_push($errors, "Country is required"); }
    if (empty($phone)) { array_push($errors, "Phone number is required"); }
    if (preg_match("/[a-z]/i", $phone)) { array_push($errors, "Phone number cannot include letter");    }
    if (empty($password_1)) { array_push($errors, "Password is required"); }
    if ($password_1 != $password_2) {
        array_push($errors, "The two passwords does not match");
    }
    
    // first check the database to make sure
    // a user does not already exist with the same username and/or email
    $user_check_query = "SELECT * FROM hosts WHERE host_name='$host_name' OR email='$email' OR hotel_name='$hotel_name' OR phone='$phone' LIMIT 1";
    $result = mysqli_query($db, $user_check_query);
    $user = mysqli_fetch_assoc($result);
    
    if ($user) { // if user exists
        if ($user['host_name'] === $host_name) {
            array_push($errors, "Username already exists");
        }
        
        if ($user['email'] === $email) {
            array_push($errors, "email already exists");
        }
        
        if ($user['hotel_name'] === $hotel_name) {
            array_push($errors, "Hotel name already exists");
        }
        
        if ($user['phone'] === $phone) {
            array_push($errors, "Phone number already exists");
        }
    }
    
    // Register
    if (count($errors) == 0) {
        $password = md5($password_1);//encrypt the password before saving in the database
        
        $query = "INSERT INTO hosts (host_name, email, hotel_name, country, phone, password)
  			  VALUES('$host_name', '$email', '$hotel_name', '$country', '$phone', '$password')";
        mysqli_query($db, $query);
        $_SESSION['host_name'] = $host_name;
        header('location: profile_host.php');
    }
}

// Login
if (isset($_POST['login_host'])) {
    $host_name = mysqli_real_escape_string($db, $_POST['host_name']);
    $password = mysqli_real_escape_string($db, $_POST['password']);
    
    if (empty($host_name)) {
        array_push($errors, "Username is required");
    }
    if (empty($password)) {
        array_push($errors, "Password is required");
    }
    
    if (count($errors) == 0) {
        $password = md5($password);
        $query = "SELECT * FROM hosts WHERE host_name='$host_name' AND password='$password'";
        $results = mysqli_query($db, $query);
        if (mysqli_num_rows($results) == 1) {
            $_SESSION['host_name'] = $host_name;
            header('location: profile_host.php');
        }else {
            array_push($errors, "Wrong username/password combination");
        }
    }
}

?>