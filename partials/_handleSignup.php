<?php
    $showError = "false";
    include "_dbconnect.php";
    
     // Image Upload
     if (isset($_POST['submit'])) {
        $file = $_FILES['file'];
        $tempFile = $file['tmp_name'];
        print_r($tempFile);
        echo "<br>";
        $fileName = $file['name'];
        print_r($fileName);
        $fileExt = explode('.', $fileName);
        $fileCheck = strtolower(end($fileExt));
        $store = array('jpg', 'jpeg', 'png', 'webp', 'svg', 'pdf');
        if (in_array($fileCheck, $store)) {
            $destFile = "Images/" . $fileName;
            move_uploaded_file($tempFile, $destFile);
        }
    } else {
        $target = null;
        echo"Problem inserting image";
        // echo "<br>No Image was uploaded";
    }
if($_SERVER['REQUEST_METHOD']=='POST'){

    $username = $_POST['username'];
    $password = $_POST['password'];
    $cpassword = $_POST['cpassword'];

 
    // Check whether this email exists
    $existSql = "SELECT * FROM `users` WHERE `username` = '$username'";
    $result = mysqli_query($conn,$existSql);
    $numRows = mysqli_num_rows($result);
    if($numRows > 0){
        $showError = "Username is already available";
    }
    else{
        if($password == $cpassword){
            $sql = "INSERT INTO `users` (`photo`,`username`,`password`,`timestamp`) VALUES ('$destFile','$username','$password',current_timestamp())";
            $result = mysqli_query($conn,$sql);
            $showAlert = true;
            header("location:/Forum/index.php?signupsuccess=true");
            exit();
        }
        else{
            $showError = "true";
            header("location:/Forum/index.php?signupsuccess=false&error=$showError");
        }
       
    }
    header("location:/Forum/index.php?signupsuccess=false&error=$showError");
    
}



?>