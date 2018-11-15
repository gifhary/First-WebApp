<?php
include 'comment.php';

session_start();

if (isset($_GET['logout'])) {
    session_destroy();
    unset($_SESSION['guest_name']);
    header("location: home.php");
}

$guest_name = $_SESSION['guest_name'];

$db = mysqli_connect('localhost', 'root', '', 'registration');

//get hotel name dari url
$hotelName= $_GET['hotelName'];

$query = "SELECT * FROM hosts WHERE hotel_name='$hotelName'";
$result = mysqli_query($db, $query);
$info = mysqli_fetch_array($result);

$host_name = $info['host_name'];
$h_name = $info['hotel_name'];
$phone = $info['phone'];
$country = $info['country'];
$email = $info['email'];
$price = $info['price'];


date_default_timezone_set("Asia/Kuala_Lumpur");

?>

<!DOCTYPE html>
<html>
	<head>
		<title>Host Profile</title>
		<link rel="stylesheet" type="text/css" href="guest_view.css">
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
		</div>
		<br>
		<br>
		<br>
		<div class="top">
			<!--Cek kalo foto profilenya ada, kalau engga set default no_image.jpg-->
			<?php $filename = "img/$host_name.jpg" ?>
            <?php  if (file_exists($filename)) :?>
            	<img class="gambar" src="img/<?=$host_name ?>.jpg" alt="profile image" style="width: 700px; height: 400px; border: 1px solid gray;">
            <?php else : ?>
                <img class="gambar" src="no_image.jpg" alt="profile image" style="width: 700px; height: 400px; border: 1px solid gray;">
            <?php endif ?>
            
            <div class="fotter">
                <!--Nama hotel-->
				<div class="hotel">
					<strong style="font-size: 25px;"><?php echo $h_name?></strong>
				</div>
				<!-- tampilin harga -->
				<div class="price">
					<input type="hidden" name="host" value="<?= $host_name?>">
					<strong style="font-size: 18px;">RM <?php echo $price?>/Night</strong>
				</div>				
			</div>
		</div>
		
		<div class="host_info">
			<strong style="font-size: 20px;">Info</strong>
			<br>
			<br>
			<span style="color:blue">&#9990;</span> <?php echo $phone?>
			<br>
			<span style="color:blue">&#x2709;</span> <?php echo $email?>
			<br>
			<span style="color:blue">&#9751;</span> <?php echo $country?>
		</div>
		
		<div class="right_part"> 
		<form class="comment_sect" action="guest_view.php?hotelName=<?= $hotelName ?>" method="post">
			<strong style="padding: 5px">Comment</strong><br>
            <input type="hidden" name="commenter" value="<?= $guest_name?>">
            <input type="hidden" name="host" value="<?= $host_name?>">
			<input type="hidden" name="date" value="<?= date('d/m/Y H:i')?>">
			<textarea name="message" maxlength="255" style="font-family: calibri;"></textarea><br>
			<span style="margin-left: 5px">Rate this hotel</span>
			<input type="number" name="rating" min="1" max="5" style="width: 40px; margin: 5px;">
			<button type="submit" class="btn" name="submit_comment">Comment</button>
		</form>
		
		<?php 
		$comment = "SELECT * FROM comments WHERE host_name='$host_name' ORDER by id DESC";
		$com_result = $db->query($comment);
		$count = mysqli_num_rows($com_result);
		
		if ($count==0){
		    echo "<span style='color:grey' class='noComment'>There is no comment yet</span>";
		}else {
		    while ($com_info = $com_result->fetch_assoc()){
		        $commenter = $com_info['commenter'];
		        $date = $com_info['date'];
		        $rating = $com_info['rating'];
		        $message = $com_info['message'];
		        
		        if ($rating == "" && $commenter != ""){
		            $output = "<div class='comment_output'>
                        <strong style='font-size: 18px; margin: 5px;'>".$commenter."</strong>
                        <div class='date' style='font-size: 15px'>".$date."</div>
                        <div class='message'>".$message."</div>
                   </div>";
		            echo $output;
		        }elseif ($commenter == ""){ //nama commenter kosong, set default Anonymous
		            
		            if ($rating == ""){
		                $output = "<div class='comment_output'>
                        <strong style='font-size: 18px; margin: 5px;'>Anonymous</strong>
                        <div class='date' style='font-size: 15px'>".$date."</div>
                        <div class='message'>".$message."</div>
                        </div>";
		                echo $output;
		            }else {
		            $output = "<div class='comment_output'>
                        <strong style='font-size: 18px; margin: 5px;'>Anonymous</strong>
                        <div class='date' style='font-size: 15px'>".$date."</div><br>
                        <span style='margin: 5px; margin-left: 10px;'>Rating : ".$rating."/5</span>
                        <div class='message'>".$message."</div>
                   </div>";
		            echo $output;
		            }
		            
		        }else {
		            $output = "<div class='comment_output'>
                        <strong style='font-size: 18px; margin: 5px;'>".$commenter."</strong>
                        <div class='date' style='font-size: 15px'>".$date."</div><br>
                        <span style='margin: 5px; margin-left: 10px;'>Rating : ".$rating."/5</span>
                        <div class='message'>".$message."</div>
                   </div>";
		            echo $output;
		        }
		    }
		}
		?>
		</div>
	</body>
	
</html>