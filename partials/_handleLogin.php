<?php
    $showError = "false";
if(isset($_POST['submit'])){
  include "_dbconnect.php";
  $username = $_POST['username'];
  $password = $_POST['password'];
  $sql = "SELECT * FROM `users` WHERE `username` = '$username'";
  $result = mysqli_query($conn,$sql);
  $num = mysqli_num_rows($result);
  if($num==1){

    $row = mysqli_fetch_assoc($result);
    if($password == $row['password']){
        session_start();
        $_SESSION['loggedin'] = true;
        $_SESSION['username'] = $username;
        $_SESSION['sn'] = $row['Serial No.'] ;
        $_SESSION['photo'] = $row['photo'];
        header("location:/Forum/index.php?loginsuccess=true");
   
    }
    else{
           header("location:/Forum/index.php?loginsuccess=$showError");
           exit();
           
        }

  }
  else{
      header("location:/Forum/index.php?loginsuccess=$showError");
  }
//   while($row = mysqli_fetch_assoc($result)){
//       if($username == $row['username']){
//         if($password == $row['password']){
//             session_start();
//             $_SESSION['loggedin'] = true;
//             $_SESSION['username'] = $username;
//             header("location:/Forum/index.php?loginsuccess=true");
//             exit();
       
//         }
//         else{
//         //    echo "Password incorrect";
//            header("location:/Forum/index.php?loginsuccess=$showError");
//            exit();
           
//         }
//      }
     
     
//      else{
//          echo "Invalid Username";
//          header("location:/Forum/index.php?loginsuccess=$showError");
//      } 
//   }
  
    



}

?>