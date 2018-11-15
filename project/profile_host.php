<?php
clearstatcache();
include 'comment.php';

session_start();

if (!isset($_SESSION['host_name'])) {
    $_SESSION['msg'] = "You must log in first";
    header('location: login_host.php');
}

if (isset($_GET['logout'])) {
    session_destroy();
    unset($_SESSION['host_name']);
    header("location: login_host.php");
}

$db = mysqli_connect('localhost', 'root', '', 'registration');

$host_name= $_SESSION['host_name'];

$query = "SELECT * FROM hosts WHERE host_name='$host_name'";
$result = mysqli_query($db, $query);
$info = mysqli_fetch_array($result);

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
		<link rel="stylesheet" type="text/css" href="profile.css">
	</head>
	
	<body>
		<div class="nav">
			<?php  if (isset($_SESSION['host_name'])) : ?>
   				<a href="profile_host.php?logout='1'" style="color: red;">logout</a>
				<strong class="name"><?php echo $_SESSION['host_name']; ?></strong>					
    		<?php endif ?>
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
            
            <!-- update foto profile -->
            <form class="ganti_foto" action="profile_host.php" method="post" enctype="multipart/form-data">
            	<strong>Update Image</strong>
            	<input type="hidden" name="img_name" value="<?= $host_name?>">
            	<input type="file" name="profile_img" accept=".jpg">
            	<button name="upload_image" class="btn" type="submit" style="float: right">Save</button>      
            </form>
            
            <div class="fotter">
                <!--Nama hotel-->
				<div class="hotel">
					<strong style="font-size: 25px;"><?php echo $h_name?></strong>
				</div>
				<!-- tampilin harga -->
				<div class="price">
					<input type="hidden" name="host" value="<?= $host_name?>">
					<strong style="font-size: 18px;">RM <?php echo $price?>/Night</strong>
					<!-- tombol edit harga -->
					<button id="modalBtn" class="btn">Edit</button>
				</div>				
			</div>
		</div>
		
		<!-- edit harga pop up dari edit tombol -->
		<form id="simpleModal" class="edit_price" style="overflow: hidden" action="profile_host.php" method="post">
			<div class="edit_price_body">
				<strong>Price</strong>
				<span class="closeBtn" style="float: right; margin-right: 5px">&times;</span><br>
				<input type="hidden" name="host_harga" value="<?= $host_name?>">
				<input name="harga_baru" type="text" onkeypress="return validate(event)" value="<?php echo $price?>" style="width: 190px; margin-left: 30px; margin-top: 20px; text-align: right;"><br>
				<button type="submit" name="save_price" class="btn" style="float: right">Save</button>
			</div>
		</form>
		
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
		<form class="comment_sect" action="profile_host.php" method="post">
			<strong style="padding: 5px">Comment</strong><br>
            <input type="hidden" name="commenter" value="<?= $_SESSION['host_name']?>">
            <input type="hidden" name="host" value="<?= $host_name?>">
			<input type="hidden" name="date" value="<?= date('d/m/Y H:i')?>">
			<textarea name="message" maxlength="255" style="font-family: calibri;"></textarea><br>
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
		        }elseif ($commenter == ""){
		            
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
		
	<script src="modal.js"></script>
	</body>
	
</html>