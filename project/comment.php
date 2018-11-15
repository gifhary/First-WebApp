<?php

$conn = mysqli_connect('localhost', 'root', '', 'registration');

//submit komen ke database
if (isset($_POST['submit_comment'])){
    if (!empty($_POST['message'])){
        $host_name = $_POST['host'];
        $commenter = $_POST['commenter'];
        $date = $_POST['date'];
        $message = $_POST['message'];
        $rating = $_POST['rating'];
            
        $insert = "INSERT INTO comments (commenter, host_name, date, rating, message)
                   VALUES ('$commenter', '$host_name', '$date', '$rating', '$message')";
        
        mysqli_query($conn, $insert);
        
    }
    else {
        
    }
    
}

//edit harga hotel per malam
if (isset($_POST['save_price'])){
    $price = $_POST['harga_baru'];
    $host = $_POST['host_harga'];
    
    $update = "UPDATE hosts SET price = '$price' WHERE host_name = '$host';";
    
    mysqli_query($conn, $update);
}


//update foto
if (isset($_POST['upload_image'])){
    
    $filename = $_FILES['profile_img']['name']; //nama file full
    $file_base = substr($filename, 0, strripos($filename, '.')); //file tanpa extensi
    $file_ext = substr($filename, strripos($filename, '.')); //get extensi file
    $allowed_ext = ".jpg";
    
    $filesize = $_FILES["profile_img"]["size"];
    if ($file_ext == $allowed_ext){
        $newfilename = $_POST['img_name'];
        move_uploaded_file($_FILES['profile_img']['tmp_name'], "img/".$newfilename.".jpg" ); //save file and rename, auto overwrite if exist
    }
    
    elseif ($filename == ''){
        
        echo "<div class='error'>
                  <strong style='color: red'>Please select an image</strong>
              </div>";
        
    }
    elseif ($file_ext != $allowed_ext) {
        
         echo "<div class='error'>
                  <strong style='color: red'>Only jpg file is accepted</strong>
              </div>";
         
    }
    elseif ($filesize>2000000){
        
        echo "<div class='error'>
                  <strong style='color: red'>The file is too large</strong>
              </div>";
        
    }
    else {
        echo "<br>¯\_(ツ)_/¯"; //kalau ada error2 lain yg ga d ketahui
    }
    
}

?>