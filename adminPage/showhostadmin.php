
<?php
   
  include_once'HeaderAdmin.php';
  $db = mysqli_connect('localhost', 'root', '', 'registration');
  ?>
  <!DOCTYPE html>
  <<html>
    <div class = "container">
      <div class="well well-lg" >
	      
	<?php 
	   $sql ="SELECT*FROM hosts;";
	   $user_result = $db->query($sql);
	   $count_user = mysqli_num_rows($user_result);
	   $locationid = 0; 
	   
	        if ($count_user==0){
  		        echo "<span style='color:grey;text-align:centered' class='noHotel'>There is no user</span>";
  		    }else {
  		        while ($user_info = $user_result->fetch_assoc()){
  		            $name = $user_info['host_name'];
  		            $email = $user_info['email'];
					$hotel_name = $user_info['hotel_name'];
  		            $country = $user_info['country'];
					$phone = $user_info['phone'];
  		            $price = $user_info['price'];
					$id = $user_info['id'];
					       echo " <table class='table'>";
                           echo " <thead>";
                           echo " <tr>";
                           echo " <th>host name</th>";
                           echo " <th>Email</th>";
		                   echo " <th>Hotel Name</th>";
		                   echo " <th>Country</th>";
		                   echo " <th>phone</th>";
		                   echo " <th>price</th>";
                           echo " </tr>";
                           echo " </thead>";
					       echo "<tbody>";
                           echo " <tr>";
                           echo " <td>".$name."</td>";
                           echo " <td>".$email."</td>";
						   echo " <td>".$hotel_name."</td>";
                           echo " <td>".$country."</td>";
						   echo " <td>".$phone."</td>";
                           echo " <td>".$price."</td>";
						   echo " <td><a href=\"delete_admin.php?id=".$id."\" class='btn btn-danger' >Delete</a></td>";
                           echo " </tr>";
                           echo " </tbody>";
						   
  		        }
  		    }
		
          			
			
	?>
	
	

             </table>
	    </div> 
  <div>
  </html>