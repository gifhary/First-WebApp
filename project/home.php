<?php  
  session_start();
  if (isset($_GET['logout'])) {
  	session_destroy();
  	unset($_SESSION['guest_name']);
  }
  
  $db = mysqli_connect('localhost', 'root', '', 'registration');
?>

<!DOCTYPE html>
<html>
	<head>
		<title>Home</title>
		<link rel="stylesheet" type="text/css" href="home.css">		
	</head>
	
	<body>
	
		<!--navigasi bar-->
		<div class="navbar">
		
			<!--logo sekaligus link home-->
			<div class="logo">
				<a href="home.php">
				<img alt="Home" src="bagong.png" width="100" height="31" style="padding: 6px 11px;">
				</a>
			</div>
			
			<!--tombol home, about us-->	
			<div class="option">
				<a href="home.php">Home</a>
				<a href="#">About Us</a>
			</div>
			
			
			<!--username, logout, login, register-->
			<div class="info">
				<!--display username sama link logout kalau udh login-->				
				<?php  if (isset($_SESSION['guest_name'])) : ?>
   					<a href="home.php?logout='1'" style="color: red;">logout</a>
					<strong class="name"><?php echo $_SESSION['guest_name']; ?></strong>
    			
    			<!--display tombol login&register kalau belum login-->
    			<?php else : ?>
       				<a href="register.php">Register</a>
    				<a href="login.php">Login</a>    								
    			<?php endif ?>
			</div>
			
			<!--Bagian search-->
			<form class="search-group" action="home.php" method="post">
				<?php include('search.php')?>
				<input type="text" name="search" placeholder="Search...">
				<button class="btn" type="submit" name="search_btn" id="searchBtn" style="margin-right: 28%" >
					<img alt="search" src="search.png" width="37" height="34">
				</button>
			</form>
		</div>
		
		<div class="offer" id="offer">
			<span class="closeOfferBtn">&times;</span>
			<br>
			Do you own a hotel company or houses
			<p>for rent, that you want to offer?
			<input id="modalBtn" type="button" value="Click here">
		</div>
		
		<!--Offer buat host popup-->
		<div id="simpleModal" class="modal" style="overflow: hidden">
    		<div class="modal-content">
      			<div class="modal-header">
          			<span class="closeBtn">&times;</span>
          			<h2>Getting started</h2>
      			</div>
      			<div class="modal-body">
        			We offer a service that connecting you to your customer
        			<p>We make your business easier to grow up</p>
        			<p>If you willing to join us</p>
        			<p>Click the register button
        			<button class="btn" style="float: right" onclick="window.location.href='register_host.php'">Register as host</button></p>
        			
      			</div>
    		</div>
  		</div>
  		
  		<br>
  		<br>  		
  		<br> 		
  		<br>
  		<form class="sort-group" action="home.php" method="post">
  			<strong class='label' style='font-size: 15px'>Sort by </strong>
  			<select class="sort" name="sort">
  				<option value="">Select one</option>
  				<option value="1">Name A-Z</option>
  				<option value="2">Cheaper</option>
  				<option value="3">Most Expensive</option>
  			</select>
  			<input type="submit" name="sortSubmit" value="Sort" style="margin: 5px; padding: 3px;">
  		</form>
  		<br>
  		<br>
		
		<?php
		
		//BAGIAN SEARCH
            
		if (isset($_POST['search_btn'])){
		    $searchq = $_POST['search'];
		    
		    if ($searchq != ""){
		        $query = "SELECT * FROM hosts WHERE hotel_name LIKE '%" . $searchq .  "%' OR country LIKE '%" . $searchq .  "%' ";
		        $result = $db->query($query);
		        $count = mysqli_num_rows($result);
		        
		        if($count == 0){
		            echo "<span style='color:grey' class='noHotel'>There is no result for '".$searchq."'</span>";
		        }else{
		            while($hotel_info = $result->fetch_assoc()){
		                $owner = $hotel_info['host_name'];
		                $hotel = $hotel_info['hotel_name'];
		                $country = $hotel_info['country'];
		                $price = $hotel_info['price'];
		                $file = "img/".$owner.".jpg";
		                
		                if (file_exists($file)){
		                    $output = "<div class='search_output'>
                               <img class='hotel_img' alt='hotel_img' src='".$file."'>
                               <a href='guest_view.php?hotelName=".$hotel."' id='link' class='h_name' style=''>".$hotel."</a>
                               <strong class='price' style='font-size: 15px'>RM ".$price."/Night</strong>
                               <div class='country'>".$country."</div>
                               </div>";
		                    echo $output;
		                }else {
		                    $output = "<div class='search_output'>
                               <img class='hotel_img' alt='hotel_img' src='no_image.jpg'>
                               <a href='guest_view.php?hotelName=".$hotel."' id='link' class='h_name'>".$hotel."</a>
                               <strong class='price' style='font-size: 15px'>RM ".$price."/Night</strong>
                               <div class='country'>".$country."</div>
                               </div>";
		                    echo $output;
		                }
		            }
		        }
		    }else {
		        echo "<span style='color:grey' class='noHotel'>Please enter search key</span>";
		    }
		}

			// BAGIAN SORT
			
			elseif (isset($_POST['sortSubmit'])) {
			// Capture that in a variable by that name
			$sortby = $_POST['sort'];
			// Now to change the SQL query based on the sorting the user chose (price high to low, low to high, alphabetical and latest first)
			if ($sortby == '3') {
				//mahal ke murah
				$price = "SELECT * FROM hosts ORDER BY price DESC";
				$price_result = $db->query($price);
				$count_price = mysqli_num_rows($price_result);
  		
  		    if ($count_price==0){
  		        echo "<span style='color:grey' class='noHotel'>There is no hostel yet</span>";
  		    }else {
  		        echo "<span style='color:grey' class='text'>Most Expensive List</span>";
  		        while ($hotel_info = $price_result->fetch_assoc()){
  		            $owner = $hotel_info['host_name'];
  		            $hotel = $hotel_info['hotel_name'];
  		            $country = $hotel_info['country'];
  		            $price = $hotel_info['price'];
  		            
  		            $file = "img/".$owner.".jpg";
  		            
  		            if (file_exists($file)){
  		                $output = "<div class='sort_output' id='hotel'>
                               <img class='hotel_img' alt='hotel_img' src='".$file."'>
                               <a href='guest_view.php?hotelName=".$hotel."' id='link' class='h_name' style=''>".$hotel."</a>
                               <strong class='price' style='font-size: 15px'>RM ".$price."/Night</strong>
                               <div class='country'>".$country."</div>
                               </div>";
  		                echo $output;
  		            }else {
  		                $output = "<div class='sort_output' id='hotel'>
                               <img class='hotel_img' alt='hotel_img' src='no_image.jpg'>
                               <a href='guest_view.php?hotelName=".$hotel."' id='link' class='h_name'>".$hotel."</a>
                               <strong class='price' style='font-size: 15px'>RM ".$price."/Night</strong>
                               <div class='country'>".$country."</div>
                               </div>";
  		                echo $output;
  		            }  		        
  		        }
  		    }
				
				
			}
			elseif ($sortby == '2') {
				//murah ke mahal
				$price = "SELECT * FROM hosts ORDER BY price ASC";
				$price_result = $db->query($price);
				$count_price = mysqli_num_rows($price_result);
  		
  		    if ($count_price==0){
  		        echo "<span style='color:grey' class='noHotel'>There is no hostel yet</span>";
  		    }else {
  		        echo "<span style='color:grey' class='text'>Cheaper List</span>";
  		        
  		        while ($hotel_info = $price_result->fetch_assoc()){
  		            $owner = $hotel_info['host_name'];
  		            $hotel = $hotel_info['hotel_name'];
  		            $country = $hotel_info['country'];
  		            $price = $hotel_info['price'];
  		            
  		            $file = "img/".$owner.".jpg";
  		            
  		            if (file_exists($file)){
  		                $output = "<div class='sort_output' id='hotel'>
                               <img class='hotel_img' alt='hotel_img' src='".$file."'>
                               <a href='guest_view.php?hotelName=".$hotel."' id='link' class='h_name' style=''>".$hotel."</a>
                               <strong class='price' style='font-size: 15px'>RM ".$price."/Night</strong>
                               <div class='country'>".$country."</div>
                               </div>";
  		                echo $output;
  		            }else {
  		                $output = "<div class='sort_output' id='hotel'>
                               <img class='hotel_img' alt='hotel_img' src='no_image.jpg'>
                               <a href='guest_view.php?hotelName=".$hotel."' id='link' class='h_name'>".$hotel."</a>
                               <strong class='price' style='font-size: 15px'>RM ".$price."/Night</strong>
                               <div class='country'>".$country."</div>
                               </div>";
  		                echo $output;
  		            }  		        
  		        }
  		    }
			}
			elseif ($sortby = '1') {
				//A to Z
				
				$name = "SELECT * FROM hosts ORDER BY hotel_name ASC";
				$name_result = $db->query($name);
				$count_name = mysqli_num_rows($name_result);
  		
  		    if ($count_name==0){
  		        echo "<span style='color:grey' class='noHotel'>There is no hostel yet</span>";
  		    }else {
  		        echo "<span style='color:grey' class='text'>Sort A-Z</span>";
  		        while ($hotel_info = $name_result->fetch_assoc()){
  		            $owner = $hotel_info['host_name'];
  		            $hotel = $hotel_info['hotel_name'];
  		            $country = $hotel_info['country'];
  		            $price = $hotel_info['price'];
  		            
  		            $file = "img/".$owner.".jpg";
  		            
  		            if (file_exists($file)){
  		                $output = "<div class='sort_output' id='hotel'>
                               <img class='hotel_img' alt='hotel_img' src='".$file."'>
                               <a href='guest_view.php?hotelName=".$hotel."' id='link' class='h_name' style=''>".$hotel."</a>
                               <strong class='price' style='font-size: 15px'>RM ".$price."/Night</strong>
                               <div class='country'>".$country."</div>
                               </div>";
  		                echo $output;
  		            }else {
  		                $output = "<div class='sort_output' id='hotel'>
                               <img class='hotel_img' alt='hotel_img' src='no_image.jpg'>
                               <a href='guest_view.php?hotelName=".$hotel."' id='link' class='h_name'>".$hotel."</a>
                               <strong class='price' style='font-size: 15px'>RM ".$price."/Night</strong>
                               <div class='country'>".$country."</div>
                               </div>";
  		                echo $output;
  		            }  		        
  		        }
  		    }
			}
			}
			
			//BAGIAN TAMPILIN DEFAULT
			
			else {
			    
			    $hotel_list = "SELECT * FROM hosts";
			    $hotel_result = $db->query($hotel_list);
			    $count_hotel = mysqli_num_rows($hotel_result);
			    
			    if ($count_hotel==0){
			        echo "<span style='color:grey' class='noHotel'>There is no hostel yet</span>";
			    }else {
			        while ($hotel_info = $hotel_result->fetch_assoc()){
			            $owner = $hotel_info['host_name'];
			            $hotel = $hotel_info['hotel_name'];
			            $country = $hotel_info['country'];
			            $price = $hotel_info['price'];
			            
			            $file = "img/".$owner.".jpg";
			            
			            if (file_exists($file)){
			                $output = "<div class='hotel_output' id='hotel'>
                               <img class='hotel_img' alt='hotel_img' src='".$file."'>
                               <a href='guest_view.php?hotelName=".$hotel."' id='link' class='h_name' style=''>".$hotel."</a>
                               <strong class='price' style='font-size: 15px'>RM ".$price."/Night</strong>
                               <div class='country'>".$country."</div>
                               </div>";
			                echo $output;
			            }else {
			                $output = "<div class='hotel_output' id='hotel'>
                               <img class='hotel_img' alt='hotel_img' src='no_image.jpg'>
                               <a href='guest_view.php?hotelName=".$hotel."' id='link' class='h_name'>".$hotel."</a>
                               <strong class='price' style='font-size: 15px'>RM ".$price."/Night</strong>
                               <div class='country'>".$country."</div>
                               </div>";
			                echo $output;
			            }
			        }
			    }  		
			}

		?>  		  		
		<script src="modal.js"></script>		
	</body>
	
</html>