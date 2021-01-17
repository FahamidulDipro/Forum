<?php
session_start();

echo'

<style>
   *{
    scroll-behavior: smooth;
   }
.navbar {
    background: #009c39;
}
.btn-success{
  background-color: #009c39;
}
</style>

<nav class="navbar navbar-expand-lg navbar-dark ">
<div class="container-fluid">
    <a class="navbar-brand" href="index.php"><strong><i>FORUMBEST</i></strong></a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="index.php">Home</a>
            </li>
            <li class="nav-item">
                <a class="nav-link active" href="about.php">About</a>
            </li>
            <li class="nav-item dropdown">
          <a class="nav-link active dropdown-toggle" href="catagories.php" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Top catagories
          </a>
          <ul class="dropdown-menu" aria-labelledby="navbarDropdown">';
          
          include "_dbconnect.php";
          $sql = "SELECT catagory_name,catagory_id FROM `catagories` LIMIT 3";
          $result = mysqli_query($conn,$sql);

          while($row = mysqli_fetch_assoc($result)){
              echo'
    
                <li><a class="dropdown-item" href="threadlist.php?catid='.$row['catagory_id'].'">'.$row['catagory_name'].'</a></li>
             ';
            
          }

          echo'  </ul> </li><li class="nav-item">
                <a class="nav-link active" href="contacts.php">Contact</a>
            </li>';

            if(isset($_SESSION['loggedin']) && $_SESSION['loggedin']==true){

                echo'  <li class="nav-item">
              <p class="my-1 mx-3 text-light">Welcome <img class="mx-1 my-0" src="partials/'.$_SESSION['photo'].'" style="height:40px;width:40px;border-radius:50%; object-fit:cover;"><strong>  '.$_SESSION['username'].'</strong></p>
              
            </li>
            <li class="nav-item">
            <a class="nav-link active" href="partials/_logout.php" >Logout</a>
            </li>';
            }
            else{
                
                    echo'  <li class="nav-item">
                    <a class="nav-link active" href="#" data-bs-toggle="modal" data-bs-target="#loginModal">Login</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="#" data-bs-toggle="modal" data-bs-target="#signupModal">Signup</a>
                </li>';

          
                            
            }
            echo'</div>
            </div>
            </nav>';



include"partials/_signupModal.php";
include"partials/_loginModal.php";
if(isset($_GET['signupsuccess'])){
    if($_GET['signupsuccess']=="true"){
        echo '<div class="alert alert-success alert-dismissible fade show my-0" role="alert">
    <strong>Your account has been created successfully!</strong> Please log in
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>';
    }
    else{
        echo'<div class="alert alert-danger alert-dismissible fade show my-0" role="alert">
        <strong>Sorry! account cannot be created.</strong> Choose a unique username or retype same password.
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>';
    }
    
}

if(isset($_GET['loginsuccess'])){
    if($_GET['loginsuccess']=="true"){
        echo '<div class="alert alert-success alert-dismissible fade show my-0" role="alert">
        <strong>Login successfull!</strong> You are logged in 
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>';
    }
    else{
        echo'<div class="alert alert-danger alert-dismissible fade show my-0" role="alert">
        <strong>Login failed!</strong> Please use correct username of password
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>';
    }
    
}


// if( isset($_GET['signupsuccess']) && $_GET['signupsuccess']=="true"){
//     echo '<div class="alert alert-success alert-dismissible fade show my-0" role="alert">
//     <strong>Your account has been created successfully!</strong> Please log in
//     <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
//   </div>';
// }
// else{
//     echo'<div class="alert alert-danger alert-dismissible fade show my-0" role="alert">
//     <strong>Sorry! account cannot be created.</strong> Choose a unique username or retype same password.
//     <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
//   </div>';
// }

// if( isset($_GET['loginsuccess']) && $_GET['loginsuccess']==true){
//     echo '<div class="alert alert-success alert-dismissible fade show my-0" role="alert">
//     <strong>Login successfull!</strong> You are logged in 
//     <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
//   </div>';
// }
// else{
//     echo'<div class="alert alert-danger alert-dismissible fade show my-0" role="alert">
//     <strong>Login failed!</strong> Please use correct username of password
//     <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
//   </div>';
// }
?>

