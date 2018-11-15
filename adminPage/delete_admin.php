<?php 
   $db=mysqli_connect("localhost","root","","registration");
    // Check connection
    if (mysqli_connect_errno()) {
         echo "Failed to connect to MySQL: " . mysqli_connect_error();
    }
	
    $id =(int)$_GET['id']; // $id is now defined
    
     // or assuming your column is indeed an int
     // $id = (int)$_GET['id'];
  
     mysqli_query($db,"DELETE FROM hosts WHERE id=".$id."");
     mysqli_close($db);
	 header("Refresh:0; url=showhostadmin.php");
	 
	 echo $id;
?> 