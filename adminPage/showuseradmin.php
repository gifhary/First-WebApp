
<?php
   
  include_once'HeaderAdmin.php';
  $db = mysqli_connect('localhost', 'root', '', 'registration');
  ?>
  <!DOCTYPE html>
  <<html>
  <div class = "container">
      <div class="well well-lg" >
	      <table class="table">
    
	<?php 
	   $sql ="SELECT*FROM users;";
	   $user_result = $db->query($sql);
	   $count_user = mysqli_num_rows($user_result);
	   
	   
	        if ($count_user==0){
  		        echo "<span style='color:grey' class='noHotel'>There is no user</span>";
  		    }else {
				
  		        while ($user_info = $user_result->fetch_assoc()){
  		            $name = $user_info['guest_name'];
  		            $email = $user_info['email'];
					$id = $user_info['id'];
					       echo " <table class='table'>";
                           echo " <thead>";
                           echo " <tr>";
                           echo " <th>name</th>";
                           echo " <th>email</th>";
						   echo " <th>id</th>";
		                   echo " <th>action</th>";
						   echo " </tr>";
                           echo " </thead>";
					       echo " <tbody>";
                           echo " <tr>";
                           echo " <td>".$name."</td>";
                           echo " <td>".$email."</td>";
						   echo " <td>".$id."</td>";
						   echo " <td><a href=\"delete_user.php?id=".$id."\" class='btn btn-danger' >Delete</a></td>";
                           echo " </tr>";
                           echo " </tbody>"; 
						   
  		        }
  		    }
				
			
		
          			
			
	?>
	
	

             </table>
	    </div> 
  <div>
  </html>